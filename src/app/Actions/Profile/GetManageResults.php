<?php

namespace App\Actions\Profile;

use App\Models\Interview\Interview;
use App\Models\User;

class GetManageResults
{
    public function handle(Interview $interview) 
    {
        $result = [];
        //$interviewResults = InterviewResult::where('interview_id', $interview->id)->get();
        $interviewResults = $interview->interviewResults;

        foreach($interviewResults as $interviewResult) {
            array_push($result, [
                'id' => $interviewResult->id,
                'userName' => $this->getUserName($interviewResult->user_id),
                'rate' => $interviewResult->rate,
                'date' => $interviewResult->created_at,
            ]);
        }

        return $result;
    }

    private function getUserName(int $id) {
        if ($id == -1) {
            return 'unnamed user';
        }

        return User::find($id)->name;
    }
}