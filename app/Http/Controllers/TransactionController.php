<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Deb,Cre,Tf',
            'destination_account_id' => 'nullable|exists:accounts,id|different:account_id',
            'is_recurring' => 'nullable|in:on,1,true',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $amount = $request->amount;
            $type = strtoupper($request->type);

            // Validasi akun sumber
            $account = $user->accounts()->where('id', $request->account_id)->first();
            if (!$account) {
                throw new \Exception('Akun sumber tidak ditemukan.');
            }

            // Cek jika Transfer
            if ($type === 'TF') {
                // Validasi akun tujuan
                $destinationAccount = $user->accounts()->where('id', $request->destination_account_id)->first();
                if (!$destinationAccount) {
                    throw new \Exception('Akun tujuan tidak ditemukan.');
                }

                if ($account->current_balance < $amount) {
                    throw new \Exception('Saldo akun sumber tidak mencukupi.');
                }

                // Update saldo
                $account->current_balance -= $amount;
                $destinationAccount->current_balance += $amount;

                $account->save();
                $destinationAccount->save();

                // Simpan transaksi masuk di akun tujuan
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

            // Jika Pemasukan atau Pengeluaran
            if ($type === 'DEB') {
                $account->current_balance += $amount;
                $account->save();
                $transactionType = 'Income';

            } elseif ($type === 'CRE') {
                if ($account->current_balance < $amount) {
                    throw new \Exception('Saldo tidak mencukupi.');
                }
                $account->current_balance -= $amount;
                $account->save();
                $transactionType = 'Expense';
            }

            // Simpan transaksi utama
            Transaction::create([
                'account_id'       => $account->id,
                'category_id'      => $request->category_id,
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
