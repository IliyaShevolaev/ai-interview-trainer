<?php

namespace App\Actions\Interview;

use App\Models\Interview\Interview;
use App\Models\Interview\Question;
use Illuminate\Support\Facades\Log;

class UpdateInterviewAction
{
    public function handle(array $newData)
    {
        $interviewToUpdate = Interview::findOrFail($newData['id']);

        $interviewToUpdate->update(['title' => $newData['title']]);
        $interviewToUpdate->questions()->update(['is_available' => false]);

        $questionsData = [];
        $createdTime = now();
        foreach ($newData['questions'] as $questionText) {
            array_push($questionsData, [
                'text' => $questionText, 
                'interview_id' => $interviewToUpdate->id,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ]);
        }

        Question::insert($questionsData);

        return $interviewToUpdate;
    }
}