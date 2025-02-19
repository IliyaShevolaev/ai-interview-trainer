<?php

namespace App\Http\Controllers\Interview;

use App\Actions\Interview\FinishInterviewAction;
use App\Actions\Interview\RateInterviewAnswerAction;
use App\Actions\Interview\StoreInterviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interview\CreateRequest;
use App\Http\Requests\Interview\FinishRequest;
use App\Http\Requests\Interview\RateRequest;
use App\Models\Interview\Interview;
use App\Services\Openrouter\OpenrouterService;
use Illuminate\Support\Facades\Log;

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

            return response()->json([
                'token' => $interview->token
            ], 200);
        }
    }

    public function rate(RateRequest $rateRequest, RateInterviewAnswerAction $rateInterviewAnswerAction, OpenrouterService $openrouterService)
    {
        $data = $rateRequest->validated();

        $aiRate = $rateInterviewAnswerAction->handle($openrouterService, $data);

        return response()->json([
            'rate' => $aiRate,
        ], 200);
    }

    public function finish(FinishRequest $finishRequest, FinishInterviewAction $finishInterviewAction) 
    {
        $data = $finishRequest->validated();

        $avgRate = $finishInterviewAction->handle($data);

        return response()->json([
            'rate' => $avgRate
        ], 200);
    }
}
