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
            "order_date" => $this->order_date,
            "status" => $this->status,
            "delivery_date_time" => $this->delivery_date_time,
            "created_at" => Carbon::parse($this->created_at)->toDateTimeString()
        ];
    }
}
