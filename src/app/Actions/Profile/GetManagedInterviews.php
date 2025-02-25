<?php

namespace App\Actions\Profile;

use App\Models\Interview\Interview;
use App\Models\Interview\InterviewResult;
use App\Models\User;

class GetManagedInterviews
{
    public function handle(User $user)
    {
        $userInterviews = Interview::where('user_id', $user->id)->get();

        $result = [];
        foreach($userInterviews as $interview) {
            array_push($result, [
                'id' => $interview->id,
                'title' => $interview->title,
                'token' => $interview->token,
                'completedCount' => InterviewResult::where('interview_id', $interview->id)->count(),
                'created_at' => $interview->created_at,
            ]);
        }

        return $result;
    }
}