<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_name',
        'description',
        'price',
        'image_url',
        'dietary_restrictions',
        'category_id'
    ];

    public function orders(){

        return $this->belongsToMany(Order::class, 'meal_order')
            ->withPivot('quantity');
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function category() {
        return $this->belongsTo(MealCategory::class);
    }
}
