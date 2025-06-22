<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountController extends Controller
{
    use AuthorizesRequests;
   public function index(Request $request)
    {
        $filters = $request->only(['search', 'type', 'currency']);

        $accounts = Account::where('user_id', auth()->id())
            ->when($filters['search'] ?? null, fn($query, $search) =>
                $query->where('account_name', 'like', "%{$search}%")
            )
            ->when($filters['type'] ?? null, fn($query, $type) =>
                $query->where('account_type', $type)
            )
            ->when($filters['currency'] ?? null, fn($query, $currency) =>
                $query->where('currency', $currency)
            )
            ->latest()
            ->get();

        return view('pages.accounts.index', compact('accounts'));
    }


    // public function create()
    // {
    //     return view('account.form', ['account' => new Account()]);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:Checking,Savings,Credit Card,Investment,Cash,E-Wallet',
            'current_balance' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'bank_integration_id' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->user() ? auth()->user()->id : null;
        Account::create($validated);

        return redirect()->route('pages.accounts.index')->with('success', 'Account created!');
    }

    // public function edit(Account $account)
    // {
    //     $this->authorize('update', $account);
    //     return view('account.form', compact('account'));
    // }

    public function update(Request $request, Account $account)
    {

        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:Checking,Savings,Credit Card,Investment,Cash,E-Wallet',
            'current_balance' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'bank_integration_id' => 'nullable|string',
        ]);

        $account->update($validated);
        return redirect()->route('pages.accounts.index')->with('success', 'Account updated!');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('pages.accounts.index')->with('success', 'Account deleted!');
    }
}
