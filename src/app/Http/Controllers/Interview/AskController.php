<?php

namespace App\Http\Controllers\Interview;

use App\Http\Controllers\Controller;
use App\Services\Openrouter\OpenrouterService;
use Illuminate\Http\Request;

class AskController extends Controller
{
    public function ask(Request $request, OpenrouterService $openrouterService)
    {
        $data = $request->validate([
            'prompt' => 'required|string',
        ]);

        $answer = $openrouterService->sendAiRequest($data['prompt']);

        return response()->json(['answer' => $answer], 200);
    }
}
