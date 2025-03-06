<?php

namespace App\Http\Controllers\API\Profile;

use App\Models\User;
use App\Models\Interview\Answer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Interview\InterviewResult;
use App\Actions\Profile\GetInterviewRatesList;
use App\Http\Resources\Interview\AnswerResource;
use App\Http\Resources\Interview\InterviewResultResource;

class UserRatesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $interviewsResults = $user->interviewsResults()->with('interview')->orderByDesc('created_at')->get();
        
        return InterviewResultResource::collection($interviewsResults);
    }

    public function get(InterviewResult $interviewResult)
    {
        $answers = Answer::with('question')->where('interview_result_id', $interviewResult->id)->where('user_id', Auth::id())->get();

        return AnswerResource::collection($answers);
    }
}
