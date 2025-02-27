<?php

namespace App\Actions\Interview;

use Illuminate\Support\Str;
use App\Models\Interview\Question;
use App\Models\Interview\Interview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreInterviewAction
{
    public function handle(array $data)
    {
        $questionsList = $data['questions'];

        Log::info('newnewnew');
        Log::info($data);

        $interview = Interview::create([
            'title' =>  $data['title'],
            'user_id' => Auth::id(),
            'token' => Str::random(12),
        ]);

        $questionsData = [];
        $createdTime = now();
        foreach ($questionsList as $questionText) {
            array_push($questionsData, [
                'text' => $questionText, 
                'interview_id' => $interview->id,
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ]);
        }

        Question::insert($questionsData);

        return $interview;
    }
}