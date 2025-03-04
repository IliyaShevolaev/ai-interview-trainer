<?php

namespace App\Actions\Profile;

use App\Models\Interview\Answer;
use App\Models\Interview\InterviewResult;
use Illuminate\Support\Facades\Auth;

class GetInterviewRate
{
    public function handle(InterviewResult $interviewResult)
    {
        $result = [];
        $answers = Answer::where('interview_result_id', $interviewResult->id)->where('user_id', Auth::id())->get();

        foreach ($answers as $answer) {
            array_push($result, [
                'answer_id' => $answer->id,
                'question' => $answer->question->text,
                'answer' => $answer->answer,
                'rate' => $answer->rate,
            ]);
        }

        return $result;
    }
}