<?php

namespace App\Actions\Profile;

use App\Models\Interview\Interview;
use App\Models\Interview\InterviewResult;

class GetManageResults
{
    public function handle(Interview $interview) 
    {
        $interviewResults = InterviewResult::where('interview_id', $interview->id)->get();

        return $interviewResults;
    }
}