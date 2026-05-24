<?php

namespace App\Actions\Interview;

use App\Services\Openrouter\OpenrouterService;

class RateInterviewAnswerAction
{
    public function handle(OpenrouterService $openrouterService, array $data)
    {
        $prompt = strtr(config('aiprompts.interview.rate_answer'), [
            ':interviewTitle' => (string) $data['interviewTitle'],
            ':question' => (string) $data['question'],
            ':answer' => (string) $data['answer'],
        ]);

        $aiRate = $openrouterService->sendAiRequest($prompt);

        return $aiRate;
    }
}
