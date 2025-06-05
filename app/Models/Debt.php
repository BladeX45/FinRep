<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'debt_name', 'lender', 'current_balance',
        'interest_rate', 'minimum_payment', 'next_payment_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
