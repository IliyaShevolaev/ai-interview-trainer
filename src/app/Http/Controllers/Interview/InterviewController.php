<?php

namespace App\Http\Controllers\Interview;

use App\Actions\Interview\RateInterviewAnswer;
use App\Actions\Interview\StoreInterviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interview\CreateRequest;
use App\Http\Requests\Interview\RateRequest;
use App\Models\Interview\Interview;
use App\Services\Openrouter\OpenrouterService;

class InterviewController extends Controller
{
    public function index(Interview $interview)
    {
        return response()->json([
            'id' => $interview->id,
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

    public function rate(RateRequest $rateRequest, RateInterviewAnswer $rateInterviewAnswer, OpenrouterService $openrouterService)
    {
        $data = $rateRequest->validated();

        $aiRate = $rateInterviewAnswer->handle($openrouterService, $data);

        return response()->json([
            'rate' => $aiRate,
        ]);
    }
}
