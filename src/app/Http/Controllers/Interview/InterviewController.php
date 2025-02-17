<?php

namespace App\Http\Controllers\Interview;

use App\Actions\Interview\StoreInterviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interview\CreateRequest;
use App\Models\Interview\Interview;

class InterviewController extends Controller
{
    public function index(Interview $interview)
    {
        return response()->json([
            'title' => $interview->title,
            'questions' => $interview->questions,
        ]);
    }

    public function store(CreateRequest $createRequest, StoreInterviewAction $storeInterviewAction)
    {
        $data = $createRequest->validated();

        if ($createRequest->hasFile('questions_file')) {
            $data['questions_file']  = $createRequest->file('questions_file');

            $interview = $storeInterviewAction->handle($data);

            return response()->json(['token' => $interview->token], 200);
        }
    }
}
