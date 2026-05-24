<?php

namespace App\Actions\Interview;

use App\Services\Openrouter\OpenrouterService;
use RuntimeException;

class GenerateInterviewQuestionsAction
{
    public function handle(OpenrouterService $openrouterService, array $data): array
    {
        $prompt = strtr(config('aiprompts.interview.generate_questions'), [
            ':topic' => (string) $data['topic'],
            ':questionsCount' => (string) $data['questionsCount'],
            ':level' => (string) $data['level'],
            ':wishes' => (string) ($data['wishes'] ?? 'нет'),
        ]);

        $response = $openrouterService->sendAiRequest($prompt);
        $questions = $openrouterService->parseJsonArrayResponse($response);

        if (count($questions) === 0) {
            throw new RuntimeException('Failed to generate interview questions.');
        }

        return array_slice($questions, 0, (int) $data['questionsCount']);
    }
}
