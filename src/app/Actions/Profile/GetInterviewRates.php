<?php

namespace App\Actions\Profile;

use App\Models\User;

class getInterviewRates
{
    public function handle(User $user)
    {
        $interviewsResults = $user->interviewsResults()->orderByDesc('created_at')->get();

        $result = [];

        foreach ($interviewsResults as $interviewsResult) {
            $interview = $interviewsResult->interview;

            array_push($result, [
                'title' => $interview->title,
                'rate' => $interviewsResult->rate,
                'timeEnded' => $interviewsResult->created_at,
            ]);
        }
        
        return $result;
    }
}