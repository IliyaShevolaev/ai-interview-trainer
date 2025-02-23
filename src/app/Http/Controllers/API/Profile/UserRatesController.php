<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\GetInterviewRate;
use App\Actions\Profile\GetInterviewRatesList;
use App\Http\Controllers\Controller;
use App\Models\Interview\InterviewResult;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRatesController extends Controller
{
    public function index(GetInterviewRatesList $getInterviewRates)
    {
        $resultArray = $getInterviewRates->handle(User::find(Auth::id()));

        return response()->json($resultArray, 200);
    }

    public function get(InterviewResult $interviewResult, GetInterviewRate $getInterviewRate)
    {
        $resultArray = $getInterviewRate->handle($interviewResult);

        return response()->json($resultArray, 200);
    }
}
