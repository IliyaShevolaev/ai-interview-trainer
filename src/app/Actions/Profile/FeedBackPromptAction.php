<?php

namespace App\Actions\Profile;

use App\Models\Interview\Answer;
use App\Services\Openrouter\OpenrouterService;

class FeedBackPromptAction
{
    public function handle(OpenrouterService $openrouterService, Answer $answer)
    {
        $prompt = 'Ты опытный IT-ментор. Твой ученик только что ответил на вопрос: "' . $answer->question->text . '" вот так: "' . $answer->answer . '". Объясни ему, как улучшить ответ, чтобы он был правильным и полным. Используй дружелюбный тон, обращайся к ученику на "ты", давай четкие рекомендации и примеры.';

        $aiFeedback = $openrouterService->sendAiRequest($prompt);

        return [
            'question' => $answer->question->text,
            'answer' => $answer->answer,
            'feedback' => $aiFeedback,
        ];
    }
}
