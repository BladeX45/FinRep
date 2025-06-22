<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'account_name', 'account_type',
        'current_balance', 'currency', 'bank_integration_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // public function currencyData()
    // {
    //     return $this->belongsTo(Currency::class, 'currency', 'code');
    // }

    /**
     * Scope: Total balance untuk akun dengan mata uang tertentu.
     */
    public function scopeTotalBalanceByCurrency($query, $currencyCode)
    {
        return $query->where('currency', $currencyCode)->sum('current_balance');
    }

    /**
     * Fungsi: Mengembalikan nilai current_balance dikonversi ke IDR jika perlu.
     */
    // public function getConvertedBalanceToIDRAttribute()
    // {
    //     if ($this->currency === 'IDR') {
    //         return $this->current_balance;
    //     }

    //     if ($this->currencyData && $this->currencyData->rate_to_idr) {
    //         return $this->current_balance * $this->currencyData->rate_to_idr;
    //     }

    //     return 0; // atau null jika ingin nilai default
    // }
}
