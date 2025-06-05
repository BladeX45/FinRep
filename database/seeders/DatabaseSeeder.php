<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\Goal;
use App\Models\RecurringTransaction;
use App\Models\Debt;
use App\Models\Investment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(3)->create()->each(function ($user) {
            // Accounts
            $account = Account::create([
                'user_id' => $user->id,
                'account_name' => 'Main Account',
                'account_type' => 'Checking',
                'current_balance' => 1000000,
                'currency' => 'IDR',
            ]);

            // Categories
            $incomeCategory = Category::create([
                'user_id' => $user->id,
                'category_name' => 'Gaji',
                'category_type' => 'Income',
                'is_custom' => false,
            ]);

            $expenseCategory = Category::create([
                'user_id' => $user->id,
                'category_name' => 'Makan',
                'category_type' => 'Expense',
                'is_custom' => false,
            ]);

            // Transactions
            Transaction::create([
                'account_id' => $account->id,
                'category_id' => $incomeCategory->id,
                'transaction_date' => now(),
                'amount' => 5000000,
                'description' => 'Gaji bulan ini',
                'transaction_type' => 'Income',
                'is_recurring' => true,
            ]);

            Transaction::create([
                'account_id' => $account->id,
                'category_id' => $expenseCategory->id,
                'transaction_date' => now(),
                'amount' => 75000,
                'description' => 'Makan siang',
                'transaction_type' => 'Expense',
            ]);

            // Budgets
            Budget::create([
                'user_id' => $user->id,
                'category_id' => $expenseCategory->id,
                'budget_period' => 'Monthly',
                'budget_amount' => 1000000,
                'current_spent' => 75000,
                'remaining_amount' => 925000,
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ]);

            // Goals
            Goal::create([
                'user_id' => $user->id,
                'goal_name' => 'Dana Darurat',
                'target_amount' => 15000000,
                'current_amount' => 3000000,
                'target_date' => now()->addMonths(6),
                'goal_type' => 'Savings',
            ]);

            // Recurring Transactions
            RecurringTransaction::create([
                'user_id' => $user->id,
                'category_id' => $incomeCategory->id,
                'description' => 'Gaji bulanan',
                'amount' => 5000000,
                'frequency' => 'Monthly',
                'next_due_date' => now()->addMonth(),
            ]);

            // Debts
            Debt::create([
                'user_id' => $user->id,
                'debt_name' => 'Kredit Motor',
                'lender' => 'Mandiri Finance',
                'current_balance' => 7000000,
                'interest_rate' => 5.5,
                'minimum_payment' => 1000000,
                'next_payment_date' => now()->addDays(20),
            ]);

            // Investments
            Investment::create([
                'user_id' => $user->id,
                'investment_name' => 'Saham Telkom',
                'investment_type' => 'Stock',
                'current_value' => 2000000,
                'purchase_date' => now()->subMonth(),
                'purchase_price' => 1800000,
            ]);
        });
    }
}
