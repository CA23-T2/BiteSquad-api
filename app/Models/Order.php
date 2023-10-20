<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'status_id',
        'delivery_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_order')
            ->withPivot('quantity');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}
