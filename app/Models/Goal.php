<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'goal_name', 'target_amount',
        'current_amount', 'target_date', 'goal_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
