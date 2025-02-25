<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\GetManageResultAnswer;
use App\Actions\Profile\GetManageResults;
use App\Http\Controllers\Controller;
use App\Models\Interview\Interview;
use App\Models\Interview\InterviewResult;

class InterviewManageResultController extends Controller
{
    public function index(Interview $interview, GetManageResults $getManageResults)
    {
        $resultArray = $getManageResults->handle($interview);

        return response()->json($resultArray, 200);
    }

    public function get(InterviewResult $interviewResult, GetManageResultAnswer $getManageResultAnswer)
    {
        $resultArray = $getManageResultAnswer->handle($interviewResult);

        return response()->json($resultArray, 200);
    }
}
