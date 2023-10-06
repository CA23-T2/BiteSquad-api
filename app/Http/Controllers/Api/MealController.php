<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MealController extends Controller
{

    public function index() {

        $meals = Meal::paginate(10);

        return new JsonResponse([
            "success" => false,
            "message" => "Successfuly fetched meal list.",
            "data" => [$meals]
        ]);
    }
}
