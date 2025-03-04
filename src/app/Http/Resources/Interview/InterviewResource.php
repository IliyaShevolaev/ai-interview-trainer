<?php

namespace App\Http\Resources\Interview;

use App\Models\Interview\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ([
            'id' => $this->id,
            'title' => $this->title,
            'token' => $this->token,
            'username' => User::find($this->user_id)->name,
            'questionsCount' => count($this->questions()->where('is_available', true)->get()),
        ]);
    }
}
