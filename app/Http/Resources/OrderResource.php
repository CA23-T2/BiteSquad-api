<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "meals" => OrderedMealResource::collection($this->meals),
            "status" => $this->status->name,
            "delivery_date" => [
                Carbon::parse($this->delivery_date)->shortRelativeToNowDiffForHumans(),
                Carbon::parse($this->delivery_date)->format('m/d/Y')
            ],
            "created_at" => Carbon::parse($this->created_at)->toDateTimeString()
        ];
    }
}
