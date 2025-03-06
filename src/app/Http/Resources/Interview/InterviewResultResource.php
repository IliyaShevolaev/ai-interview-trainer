<?php

namespace App\Http\Resources\Interview;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'token' => $this->interview->token,
            'title' => $this->interview->title,
            'rate' => $this->rate,
            'timeEnded' => $this->created_at,
            'userName' => $this->user ? $this->user->name : 'Unnamed user',
        ];
    }
}
