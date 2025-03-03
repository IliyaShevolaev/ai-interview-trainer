<?php

namespace App\Http\Controllers\Interview;

use App\Models\Interview\Interview;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Interview\RateRequest;
use App\Http\Requests\Interview\CreateRequest;
use App\Http\Requests\Interview\FinishRequest;
use App\Services\Openrouter\OpenrouterService;
use App\Actions\Interview\StoreInterviewAction;
use App\Actions\Interview\FinishInterviewAction;
use App\Actions\Interview\UpdateInterviewAction;
use App\Actions\Interview\RateInterviewAnswerAction;
use App\Http\Requests\Interview\UpdateRequest;

class InterviewController extends Controller
{
    public function index(Interview $interview)
    {
        return response()->json([
            'id' => $interview->id,
            'title' => $interview->title,
            'questions' => $interview->questions()->where('is_available', true)->get(),
        ]);
    }

    public function store(CreateRequest $createRequest, StoreInterviewAction $storeInterviewAction)
    {
        $data = $createRequest->validated();

        $interview = $storeInterviewAction->handle($data);

        return response()->json([
            'token' => $interview->token
        ], 200);
    }

    public function update(UpdateRequest $updateRequest, UpdateInterviewAction $updateInterviewAction) 
    {
        $data = $updateRequest->validated();

        $interview = $updateInterviewAction->handle($data);

        return response()->json([
            'token' => $interview->token,
        ], 200);
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
