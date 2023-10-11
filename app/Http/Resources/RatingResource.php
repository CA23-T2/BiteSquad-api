<?php

namespace App\Http\Resources;

use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user" => new UserResource(User::find($this->user_id)),
            "meal" => new MealResource(Meal::find($this->meal_id)),
            "rating" => $this->rating,
            "feedback_comments" => $this->feedback_comments,
            "created_at" => [
                Carbon::parse($this->created_at)->format("m-d-Y"),
                Carbon::parse($this->created_at)->shortRelativeToNowDiffForHumans()
            ]
        ];
    }
}
