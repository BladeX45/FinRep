<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Goal;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // ------------------- Get All Accounts -------------------
        $accounts = $user->accounts()->with('transactions')->get();

        // ------------------- Sum of Balance per Currency -------------------
        $balances = $accounts->groupBy('currency')->map(function ($accs) {
            return $accs->sum('current_balance');
        });

        // ------------------- Pie Chart of EXPENSES per Category (This Month) -------------------
        $userId = auth()->id(); // atau pakai $user->id jika sudah pasti benar

        $expensePie = Transaction::selectRaw('categories.category_name as category, SUM(amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->where('accounts.user_id', $user->id)
            ->where('transaction_type', 'Expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->groupBy('categories.category_name')
            ->get();

        $incomePie = Transaction::selectRaw('categories.category_name as category, SUM(amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->where('accounts.user_id', $user->id)
            ->where('transaction_type', 'Income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->groupBy('categories.category_name')
            ->get();

        // ------------------- Insight -------------------
        $accountIds = $accounts->pluck('id');
        $insights = [];

        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $categories = Category::all();
        $categoryInsights = collect();

        foreach ($categories as $category) {
            $lastMonthTotal = Transaction::whereIn('account_id', $accountIds)
                ->where('category_id', $category->id)
                ->where('transaction_type', 'Expense')
                ->whereBetween('transaction_date', [$lastMonthStart, $lastMonthEnd])
                ->sum('amount');

            $thisMonthTotal = Transaction::whereIn('account_id', $accountIds)
                ->where('category_id', $category->id)
                ->where('transaction_type', 'Expense')
                ->where('transaction_date', '>=', $thisMonth)
                ->sum('amount');

            if ($lastMonthTotal > 0 && $thisMonthTotal > $lastMonthTotal) {
                $percent = (($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100;

                $categoryInsights->push([
                    'category' => $category->name,
                    'percent' => round($percent, 1),
                ]);
            }
        }

        $sorted = $categoryInsights->sortByDesc('percent')->take(3);

        foreach ($sorted as $item) {
            $insights[] = "Pengeluaran untuk kategori <strong>{$item['category']}</strong> naik {$item['percent']}% dibanding bulan lalu.";
        }

        // ------------------- Langganan tidak terpakai -------------------
        $langgananCategoryId = 2;

        $langganan = Transaction::selectRaw('description, amount, COUNT(*) as total')
            ->whereIn('account_id', $accountIds)
            ->where('category_id', $langgananCategoryId)
            ->where('transaction_type', 'Expense')
            ->groupBy('description', 'amount')
            ->having('total', '>=', 2)
            ->get();

        foreach ($langganan as $item) {
            $insights[] = "Potensi penghematan Rp " . number_format($item->amount, 0, ',', '.') . " dari langganan *{$item->description}*.";
        }

        // ------------------- Next Bill -------------------
        $nextBills = Transaction::whereIn('account_id', $accountIds)
            ->where('is_recurring', true)
            ->whereMonth('transaction_date', '<', now()->month)
            ->orderBy('transaction_date', 'desc')
            ->get();

        // ------------------- Progress Financial Goals -------------------
        $goals = Goal::where('user_id', $user->id)->get()->map(function ($goal) {
            $progress = $goal->current_amount / $goal->target_amount * 100;
            return [
                'name' => $goal->goal_name,
                'progress_percent' => round($progress, 1),
                'current' => $goal->current_amount,
                'target' => $goal->target_amount,
                'due_date' => $goal->target_date,
            ];
        });

        // ------------------- Return View -------------------
        return view('pages.dashboard', [
            'accounts' => $accounts,
            'balances' => $balances,
            'expenseChart' => $expensePie,
            'incomeChart' => $incomePie,
            'insights' => $insights,
            'nextBills' => $nextBills,
            'goals' => $goals,
        ]);
    }

    public function transactions(Request $request)
    {
        // Ambil semua transaksi milik user login
        $transactions = Transaction::with(['account', 'category'])
            ->whereHas('account', function ($query) {
                $query->where('user_id', auth()->id());
            });

        // Filter berdasarkan pencarian deskripsi
        if ($request->filled('search')) {
            $transactions->where('description', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $transactions->whereDate('transaction_date', $request->date);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $transactions->where('category_id', $request->category);
        }

        return view('pages.transactions.index', [
            'transactions' => $transactions->latest()->get(), // menampilkan hasil akhir
            'categories' => Category::where('user_id', auth()->id())->get(),
            'accounts' => Account::where('user_id', auth()->id())->get(),
        ]);
    }

    // accounts

}
