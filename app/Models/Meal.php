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
    ];
}
