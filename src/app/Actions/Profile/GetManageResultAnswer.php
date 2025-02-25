<?php 

namespace App\Actions\Profile;

use App\Models\Interview\InterviewResult;

class GetManageResultAnswer
{
    public function handle(InterviewResult $interviewResult)
    {
        $result = [];
        $answers = $interviewResult->answers;

        foreach($answers as $answer) {
            array_push($result, [
                'question' => $answer->question->text,
                'answer' => $answer->answer,
                'rate' => $answer->rate,
            ]);
        }

        return $result;
    }
}