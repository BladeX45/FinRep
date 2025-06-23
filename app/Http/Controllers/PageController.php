<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Goal;
use App\Models\Budget;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


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
        $userId = $user->id;

        $expensePie = Transaction::selectRaw('categories.category_name as category, SUM(amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->where('accounts.user_id', $userId)
            ->where('transaction_type', 'Expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->groupBy('categories.category_name')
            ->get();

        $incomePie = Transaction::selectRaw('categories.category_name as category, SUM(amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->where('accounts.user_id', $userId)
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

        $categories = Category::where('user_id', $userId)->get();
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
                    'category' => $category->category_name,
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
        $goals = Goal::where('user_id', $userId)->get()->map(function ($goal) {
            $progress = $goal->current_amount / $goal->target_amount * 100;
            return [
                'name' => $goal->goal_name,
                'progress_percent' => round($progress, 1),
                'current' => $goal->current_amount,
                'target' => $goal->target_amount,
                'due_date' => $goal->target_date,
            ];
        });

        // ------------------- Budget Summary -------------------
        $budgets = Budget::where('user_id', $userId)->get();

        // ------------------- Return View -------------------
        return view('pages.dashboard', [
            'accounts' => $accounts,
            'balances' => $balances,
            'expenseChart' => $expensePie,
            'incomeChart' => $incomePie,
            'insights' => $insights,
            'nextBills' => $nextBills,
            'goals' => $goals,
            'budgets' => $budgets,
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

        // goals
        if ($request->filled('goal')) {
            $transactions->where('goal_id', $request->goal);
        }


        return view('pages.transactions.index', [
            'transactions' => $transactions->latest()->get(), // menampilkan hasil akhir
            'categories' => Category::where('user_id', auth()->id())->get(),
            'accounts' => Account::where('user_id', auth()->id())->get(),
            'goals' => Goal::where('user_id', auth()->id())->get(),
        ]);
    }


    public function reports(Request $request)
    {
        $user = Auth::user();

        // Filter default
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end = $request->input('end_date', now()->endOfMonth()->toDateString());

        $query = Transaction::with(['category', 'account'])
            ->whereHas('account', fn($q) => $q->where('user_id', $user->id))
            ->whereBetween('transaction_date', [$start, $end]);

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        $transactions = $query->orderByDesc('transaction_date')->get();

        $summary = [
            'income' => $transactions->where('transaction_type', 'Income')->sum('amount'),
            'expense' => $transactions->where('transaction_type', 'Expense')->sum('amount'),
            'net' => $transactions->where('transaction_type', 'Income')->sum('amount') - $transactions->where('transaction_type', 'Expense')->sum('amount'),
        ];

        return view('pages.reports.index', [
            'transactions' => $transactions,
            'accounts' => $user->accounts,
            'categories' => Category::where('user_id', $user->id)->get(),
            'filters' => $request->all(),
            'summary' => $summary,
        ]);
    }

    public function report(Request $request)
    {
        $user = Auth::user();

        // Ambil filter dari query string
        $filters = [
            'start_date'       => $request->input('start_date'),
            'end_date'         => $request->input('end_date'),
            'account_id'       => $request->input('account_id'),
            'category_id'      => $request->input('category_id'),
            'transaction_type' => $request->input('transaction_type'),
        ];

        // Query dasar
        $query = Transaction::with(['account', 'category'])
            ->whereHas('account', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        // Filter tanggal
        if ($filters['start_date']) {
            $query->whereDate('transaction_date', '>=', $filters['start_date']);
        }
        if ($filters['end_date']) {
            $query->whereDate('transaction_date', '<=', $filters['end_date']);
        }

        // Filter akun
        if ($filters['account_id']) {
            $query->where('account_id', $filters['account_id']);
        }

        // Filter kategori
        if ($filters['category_id']) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter tipe transaksi
        if ($filters['transaction_type']) {
            $query->where('transaction_type', $filters['transaction_type']);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        // Hitung ringkasan
        $income = $transactions->where('transaction_type', 'Income')->sum('amount');
        $expense = $transactions->where('transaction_type', 'Expense')->sum('amount');
        $summary = [
            'income' => $income,
            'expense' => $expense,
            'net' => $income - $expense,
        ];

        return view('pages.reports.index', [
            'transactions' => $transactions,
            'filters' => $filters,
            'accounts' => $user->accounts,
            'categories' => Category::all(),
            'summary' => $summary,
        ]);
    }

    public function pdf(Request $request)
    {
        $view = $this->report($request);
        $data = $view->getData();

        $pdf = PDF::loadView('pages.reports.pdf', [
            'accounts' => $data['accounts'],
            'categories' => $data['categories'],
            'start_date' => $data['filters']['start_date'],
            'end_date' => $data['filters']['end_date'],
            'transaction_type' => $data['filters']['transaction_type'],
            'account_id' => $data['filters']['account_id'],
            'category_id' => $data['filters']['category_id'],
            'user' => Auth::user(),
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'title' => 'Laporan Keuangan',
            'subtitle' => 'Periode: ' . $data['filters']['start_date'] . ' - ' . $data['filters']['end_date'],
            'transactions' => $data['transactions'],
            'summary' => $data['summary'],
            'filters' => $data['filters'],
        ]);

        return $pdf->download('laporan_keuangan_' . now()->format('Ymd_His') . '.pdf');
    }


}
