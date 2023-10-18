<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MealCategory;
use Illuminate\Http\JsonResponse;

class MealCategoryController extends Controller
{
    public function index() {
        $categories = MealCategory::all();

        return new JsonResponse([
            'success' => true,
            'data' => $categories,
            'message' => 'Fetched categories successfully!'
        ]);
    }

    public function show($id) {
        $category = MealCategory::find($id);
        $meals = $category->meals;

        return new JsonResponse([
            'success' => true,
            'data' => $meals,
            'message' => 'Fetched categories successfully!'
        ]);
    }
}
