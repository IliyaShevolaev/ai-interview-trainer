<?php

namespace App\Actions\Interview;

use Illuminate\Support\Str;
use App\Models\Interview\Question;
use App\Models\Interview\Interview;
use Illuminate\Support\Facades\Auth;

class StoreInterviewAction
{
    public function handle(array $data)
    {
        if (isset($data['questions_file'])) {
            $file = $data['questions_file'];
            $questionsList = file($file->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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
}