<?php

namespace App\Http\Resources\Interview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'answer_id' => $this->id,
            'question' => $this->question->text,
            'answer' => $this->answer,
            'rate' => $this->rate,
        ];
    }
}
