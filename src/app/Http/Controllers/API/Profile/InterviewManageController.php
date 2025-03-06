<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Interview\InterviewResource;

class InterviewManageController extends Controller
{
    public function index()
    {
        $interviews = Auth::user()->interviews()->with(['questions', 'interviewResults', 'userCreator'])->get();

        return InterviewResource::collection($interviews);
    }
}
