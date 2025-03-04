<?php

namespace App\Http\Controllers\API\Profile;

use App\Actions\Profile\FeedBackPromptAction;
use App\Http\Controllers\Controller;
use App\Models\Interview\Answer;
use App\Services\Openrouter\OpenrouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetAIFeedbackController extends Controller
{
    public function get(OpenrouterService $openrouterService, FeedBackPromptAction $feedBackPromptAction, Answer $answer) 
    {
        $resultArray = $feedBackPromptAction->handle($openrouterService, $answer);

        return response()->json($resultArray, 200);
    }
}
