<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function meals() {
        return $this->hasMany(Meal::class, 'category_id');
    }
}
