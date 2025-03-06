<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\GetManageResults;
use App\Http\Controllers\Controller;
use App\Http\Resources\Interview\AnswerResource;
use App\Http\Resources\Interview\InterviewResultResource;
use App\Models\Interview\Interview;
use App\Models\Interview\InterviewResult;

class InterviewManageResultController extends Controller
{
    public function index(Interview $interview)
    {
        return InterviewResultResource::collection($interview->interviewResults()->with(['interview', 'user'])->get());
    }

    public function get(InterviewResult $interviewResult)
    {
        return AnswerResource::collection($interviewResult->answers()->with('question')->get());
    }
}
