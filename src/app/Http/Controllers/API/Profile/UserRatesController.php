<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\GetInterviewRates;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRatesController extends Controller
{
    public function index(GetInterviewRates $getInterviewRates)
    {
        $resultArray = $getInterviewRates->handle(User::find(Auth::id()));

        return response()->json($resultArray, 200);
    }
}
