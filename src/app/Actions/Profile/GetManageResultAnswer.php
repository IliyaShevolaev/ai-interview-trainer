<?php

namespace App\Actions\Profile;

use App\Models\Interview\InterviewResult;
use Illuminate\Support\Facades\Auth;

class GetManageResultAnswer
{
    public function handle(InterviewResult $interviewResult)
    {
        $result = [];

        if ($interviewResult->interview->user_id == Auth::id()) {
            $answers = $interviewResult->answers;

            foreach ($answers as $answer) {
                array_push($result, [
                    'question' => $answer->question->text,
                    'answer' => $answer->answer,
                    'rate' => $answer->rate,
                ]);
            }
        } 

        return $result;
    }
}
