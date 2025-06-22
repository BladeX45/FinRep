<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $budgets = Budget::where('user_id', $userId)
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->filled('budget_period'), function ($query) use ($request) {
                $query->where('budget_period', $request->budget_period);
            })
            ->with('category') // eager loading category name
            ->orderByDesc('start_date')
            ->get();

        $budgetPeriods = Budget::where('user_id', $userId)
        ->select('budget_period')
        ->distinct()
        ->pluck('budget_period')
        ->sort()
        ->values(); // urutkan nilai & reset key

        $categories = Category::where('user_id', $userId)->get();

        // dd($budgets, $categories, $budgetPeriods);


        return view('pages.budgets.index', compact('budgets', 'categories', 'budgetPeriods'));
    }



    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'category_id'    => ['required', 'exists:categories,id'],
                'budget_period'  => ['required', 'in:Daily,Weekly,Monthly,Annually'],
                'start_date'     => ['required', 'date'],
                'end_date'       => ['required', 'date', 'after_or_equal:start_date'],
                'budget_amount'  => ['required', 'numeric', 'min:0'],
            ]);

            // Parse tanggal
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            // Simpan ke database
            Budget::create([
                'user_id'         => auth()->id(),
                'category_id'     => $request->category_id,
                'budget_period'   => $request->budget_period,
                'start_date'      => $startDate,
                'end_date'        => $endDate,
                'budget_amount'   => $request->budget_amount,
            ]);

            return redirect()->route('pages.budgets.index')->with('success', 'Anggaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan anggaran', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan anggaran.')->withInput();
        }
    }


    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->route('pages.budgets.index')->with('success', 'Anggaran berhasil dihapus.');
    }
}
