<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Goal;
use App\Models\User;
use Carbon\Carbon;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user admin
        $user = User::where('email', 'admin@admin.com')->first();

        if (!$user) {
            $this->command->warn('User admin@admin.com tidak ditemukan.');
            return;
        }

        // ======================
        // 1. Tambah Kategori
        // ======================
        $categories = [
            ['Makanan', 'Expense'],
            ['Transportasi', 'Expense'],
            ['Hiburan', 'Expense'],
            ['Belanja', 'Expense'],
            ['Langganan', 'Expense'],
            ['Gaji', 'Income'],
            ['Investasi', 'Income'],
        ];

        foreach ($categories as [$name, $type]) {
            Category::updateOrCreate([
                'user_id' => $user->id,
                'category_name' => $name,
            ], [
                'category_type' => $type,
                'is_custom' => false,
            ]);
        }

        $categoryIds = Category::where('user_id', $user->id)->pluck('id', 'category_name');

        // ======================
        // 2. Tambah Akun
        // ======================
        $rekening = Account::updateOrCreate([
            'user_id' => $user->id,
            'account_name' => 'Rekening Tabungan',
        ], [
            'account_type' => 'Savings',
            'current_balance' => 10000000,
            'currency' => 'IDR',
            'bank_integration_id' => null,
        ]);

        $kartu = Account::updateOrCreate([
            'user_id' => $user->id,
            'account_name' => 'Kartu Kredit',
        ], [
            'account_type' => 'Credit Card',
            'current_balance' => -2500000,
            'currency' => 'IDR',
            'bank_integration_id' => null,
        ]);

        // ======================
        // 3. Tambah Goals
        // ======================
        Goal::updateOrCreate([
            'user_id' => $user->id,
            'goal_name' => 'Dana Darurat',
        ], [
            'target_amount' => 10000000,
            'current_amount' => 7000000,
            'target_date' => now()->addMonths(3),
            'goal_type' => 'Saving',
        ]);

        Goal::updateOrCreate([
            'user_id' => $user->id,
            'goal_name' => 'Uang Muka Rumah',
        ], [
            'target_amount' => 50000000,
            'current_amount' => 15000000,
            'target_date' => now()->addYear(),
            'goal_type' => 'Saving',
        ]);

        // ======================
        // 4. Tambah Transactions - Expense
        // ======================
        foreach (['Makanan', 'Transportasi', 'Langganan'] as $catName) {
            for ($i = 0; $i < 3; $i++) {
                Transaction::create([
                    'account_id' => $rekening->id,
                    'category_id' => $categoryIds[$catName],
                    'transaction_date' => Carbon::now()->subDays(rand(1, 28)),
                    'amount' => rand(100000, 300000),
                    'description' => "Transaksi {$catName}",
                    'transaction_type' => 'Expense',
                    'is_recurring' => $catName === 'Langganan',
                    'receipt_url' => null,
                ]);
            }
        }

        // ======================
        // 5. Tambah Transactions - Income
        // ======================
        foreach (['Gaji', 'Investasi'] as $catName) {
            Transaction::create([
                'account_id' => $rekening->id,
                'category_id' => $categoryIds[$catName],
                'transaction_date' => now()->subDays(rand(1, 15)),
                'amount' => rand(5000000, 10000000),
                'description' => "Pemasukan {$catName}",
                'transaction_type' => 'Income',
                'is_recurring' => false,
                'receipt_url' => null,
            ]);
        }

        $this->command->info('✅ DashboardSeeder selesai dijalankan untuk admin@admin.com.');
    }
}
