<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\GetManagedInterviews;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InterviewManageController extends Controller
{
    public function index(GetManagedInterviews $getManagedInterviews)
    {
        $resultArray = $getManagedInterviews->handle(User::find(Auth::id()));

        return response()->json($resultArray, 200);
    }
}
