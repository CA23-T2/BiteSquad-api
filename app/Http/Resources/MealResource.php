<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            "meal_name" => $this->meal_name,
            "description" => $this->description,
            "price" => $this->price,
            "image_url" => $this->image_url,
            "dietary_restrictions" => $this->dietary_restrictions
        ];
    }
}
