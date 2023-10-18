<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MealController extends Controller
{

    public function index() {

        $meals = Meal::paginate(10);

        return new JsonResponse([
            "success" => true,
            "message" => "Successfuly fetched meal list.",
            "data" => [$meals]
        ]);
    }

    public function show($id) {

        $meal = Meal::find($id);

        return new JsonResponse([
            "success" => true,
            "message" => "Successfuly fetched the meal.",
            "data" => [new MealResource($meal)]
        ]);
    }
}
