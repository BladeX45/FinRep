<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Budget extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::saving(function ($budget) {
            $budget->remaining_amount = $budget->budget_amount - $budget->current_spent;
        });
    }


    protected $fillable = [
        'user_id', 'category_id', 'budget_period',
        'budget_amount', 'current_spent', 'remaining_amount',
        'start_date', 'end_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
