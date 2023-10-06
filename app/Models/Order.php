<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_id',
        'order_date',
        'quantity',
        'status',
        'delivery_date_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_order')
            ->withPivot('quantity');
    }
}
