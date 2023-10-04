<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_id',
        'rating',
        'feedback_comments',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'meal_id');
    }
}
