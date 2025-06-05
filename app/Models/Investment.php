<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'investment_name', 'investment_type',
        'current_value', 'purchase_date', 'purchase_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
