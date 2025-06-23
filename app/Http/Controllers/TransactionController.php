<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Deb,Cre,Tf',
            'destination_account_id' => 'nullable|exists:accounts,id|different:account_id',
            'goal_id' => 'nullable|exists:goals,id',
            'is_recurring' => 'nullable|in:on,1,true',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $amount = $request->amount;
            $type = strtoupper($request->type);

            $account = $user->accounts()->where('id', $request->account_id)->first();
            if (!$account) {
                throw new \Exception('Akun sumber tidak ditemukan.');
            }

            // ============ Transfer ============
            if ($type === 'TF') {
                $destinationAccount = $user->accounts()->where('id', $request->destination_account_id)->first();
                if (!$destinationAccount) {
                    throw new \Exception('Akun tujuan tidak ditemukan.');
                }

                if ($account->current_balance < $amount) {
                    throw new \Exception('Saldo akun sumber tidak mencukupi.');
                }

                // Update saldo
                $account->decrement('current_balance', $amount);
                $destinationAccount->increment('current_balance', $amount);

                // Transaksi masuk di akun tujuan
                Transaction::create([
                    'account_id'       => $destinationAccount->id,
                    'category_id'      => $request->category_id,
                    'transaction_date' => $request->date,
                    'amount'           => $amount,
                    'description'      => 'Transfer Masuk dari ' . $account->account_name,
                    'transaction_type' => 'Transfer-In',
                    'is_recurring'     => false,
                ]);

                $transactionType = 'Transfer';
            }

            // ============ Pemasukan ============
            elseif ($type === 'DEB') {
                $account->increment('current_balance', $amount);
                $transactionType = 'Income';
            }

            // ============ Pengeluaran ============
            elseif ($type === 'CRE') {
                if ($account->current_balance < $amount) {
                    throw new \Exception('Saldo tidak mencukupi.');
                }

                $account->decrement('current_balance', $amount);
                $transactionType = 'Expense';

                // Jika ditujukan ke goal, tambahkan progres goal
                if ($request->filled('goal_id')) {
                    $goal = Goal::where('id', $request->goal_id)
                        ->where('user_id', $user->id)
                        ->first();

                    if ($goal) {
                        $goal->increment('current_amount', $amount);
                    }
                }
            }

            // ============ Simpan Transaksi ============
            Transaction::create([
                'account_id'       => $account->id,
                'category_id'      => $request->category_id,
                'goal_id'          => $request->goal_id ?? null,
                'transaction_date' => $request->date,
                'amount'           => $amount,
                'description'      => $request->description,
                'transaction_type' => $transactionType,
                'is_recurring'     => $request->has('is_recurring'),
            ]);

            DB::commit();
            return redirect()->route('transactions')->with('success', 'Transaksi berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan transaksi: ' . $e->getMessage());
            return back()->withInput()->withErrors([
                'error' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            ]);
        }
    }
}
