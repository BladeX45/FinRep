<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())->orderBy('target_date')->get();
        return view('pages.goals.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'target_date' => 'required|date|after:today',
            'goal_type' => 'required|string|max:50',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_amount'] = 0;

        Goal::create($validated);

        return redirect()->route('goals.index')->with('success', 'Goal berhasil ditambahkan!');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Goal berhasil dihapus!');
    }
}
