<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BugReportRequest;
use App\Models\Admin\BugReport;
use Illuminate\Support\Facades\Auth;

class BugReportController extends Controller
{
    public function store(BugReportRequest $bugReportRequest)
    {
        $data = $bugReportRequest->validated();

        BugReport::create([
            'question_id' => $data['question_id'],
            'answer' => $data['answer'],
            'model_name' => Auth::check() ? Auth::user()->selected_model : config('aimodels.default_model'),
            'ai_rate' => $data['aiRate'],
        ]);

        return response()->json([
            'message' => 'reported',
        ], 200);
    }
}
