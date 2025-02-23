<?php

namespace App\Actions\Profile;

use App\Models\User;

class GetInterviewRatesList
{
    public function handle(User $user)
    {
        $interviewsResults = $user->interviewsResults()->orderByDesc('created_at')->get();

        $result = [];

        foreach ($interviewsResults as $interviewsResult) {
            $interview = $interviewsResult->interview;

            array_push($result, [
                'id' => $interviewsResult->id,
                'title' => $interview->title,
                'rate' => $interviewsResult->rate,
                'timeEnded' => $interviewsResult->created_at,
            ]);
        }
        
        return $result;
    }
}