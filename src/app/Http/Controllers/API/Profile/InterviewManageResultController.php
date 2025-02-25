<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\GetManageResults;
use App\Http\Controllers\Controller;
use App\Models\Interview\Interview;

class InterviewManageResultController extends Controller
{
    public function index(Interview $interview, GetManageResults $getManageResults)
    {
        $resultArray = $getManageResults->handle($interview);

        return response()->json($resultArray, 200);
    }
}
