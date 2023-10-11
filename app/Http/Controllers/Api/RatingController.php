<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\Meal;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

        $meal = Meal::find($id);
        $ratings = $meal->ratings;

        return response()->json([
            'success' => true,
            'data' => RatingResource::collection($ratings),
            'message' => 'Fetched ratings successfully.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'feedback_comments' => 'nullable|string|max:255',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Validation error.'
            ], 422);
        }

        $user = $request->user();
        $meal = Meal::find($id);

        if(!$meal) {
            return response()->json(["message" => "Meal not found."], 404);
        }

        $hasRated = $user->ratings->contains(function ($rating) use ($meal) {
            return $rating->meal_id === $meal->id;
        });

        if($hasRated){
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'You already rated.'
            ]);
        }

        $rating = new Rating([
            'rating' => $request->rating,
            'feedback_comments' => $request->feedback_comments,
        ]);

        $rating->user()->associate($user->id);
        $rating->meal()->associate($meal->id);

        $rating->save();

        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'Added rating successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $rating = Rating::find($id);

        if(!$rating) {
            return response()->json(["message" => "Rating not found."], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new RatingResource($rating),
            'message' => 'Fetched the rating successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'feedback_comments' => 'nullable|string|max:255',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Validation error.'
            ], 422);
        }

        $user = $request->user();
        $rating = Rating::find($id);

        if(!$rating) {
            return response()->json(["message" => "Rating not found."], 404);
        }

        if($user->id !== $rating->id) {

            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'The rating doesnt belong to you.'
            ], 403);

        } else {
            $rating->update($request->all());
        }

        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'Updated rating successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {

        $user = $request->user();
        $rating = Rating::find($id);

        if(!$rating) {
            return response()->json(["message" => "Rating not found."], 404);
        }

        if($user->id !== $rating->id) {

            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'The rating doesnt belong to you.'
            ], 403);

        } else {
            $rating->delete();
        }

        return response()->json(["message" => "Rating deleted successfully."]);
    }
}
