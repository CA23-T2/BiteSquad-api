<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "username" => $this->username,
            "name" => $this->first_name . " " . $this->last_name,
            "email" => $this->email,
            "profile_picture" => $this->profile_picture,
            "role" => $this->role,
            "created_at" => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
