<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BugReportRequest;
use App\Models\Admin\BugReport;

class BugReportController extends Controller
{
    public function store(BugReportRequest $bugReportRequest)
    {
        $data = $bugReportRequest->validated();

        BugReport::create([
            'question_id' => $data['question_id'],
            'answer' => $data['answer'],
            'ai_rate' => $data['aiRate'],
        ]);

        return response()->json([
            'message' => 'reported,'
        ], 200);
    }
}
