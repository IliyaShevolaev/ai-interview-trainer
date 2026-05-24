<?php

namespace App\Actions\Profile;

use App\Models\Interview\Answer;
use App\Services\Openrouter\OpenrouterService;

class FeedBackPromptAction
{
    public function handle(OpenrouterService $openrouterService, Answer $answer)
    {
        $prompt = strtr(config('aiprompts.profile.feedback'), [
            ':question' => (string) $answer->question->text,
            ':answer' => (string) $answer->answer,
        ]);

        $aiFeedback = $openrouterService->sendAiRequest($prompt);

        return [
            'question' => $answer->question->text,
            'answer' => $answer->answer,
            'feedback' => $aiFeedback,
        ];
    }
}
