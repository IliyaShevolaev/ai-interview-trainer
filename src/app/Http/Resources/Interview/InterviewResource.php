<?php

namespace App\Http\Resources\Interview;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Interview\Question;
use App\Models\Interview\InterviewResult;
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
            'username' => $this->userCreator->name,
            'questionsCount' => $this->questions()->where('is_available', true)->count(),
            'completedCount' => $this->interviewResults->count(),
            'created_at' => $this->created_at,
        ]);
    }
}
