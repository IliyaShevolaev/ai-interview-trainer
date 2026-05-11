<?php

namespace App\Actions\Interview;

use App\Services\Openrouter\OpenrouterService;
use RuntimeException;

class GenerateInterviewQuestionsAction
{
    public function handle(OpenrouterService $openrouterService, array $data): array
    {
        $prompt = 'Сгенерируй список вопросов для интервью.
Тема: "' . $data['topic'] . '".
Количество вопросов: ' . $data['questionsCount'] . '.
Уровень кандидата: "' . $data['level'] . '".
Дополнительные пожелания: "' . ($data['wishes'] ?? 'нет') . '".

Верни только JSON-массив строк без пояснений и без markdown.
Пример формата:
["Вопрос 1", "Вопрос 2"]';

        $response = $openrouterService->sendAiRequest($prompt);

        if (str_starts_with($response, 'Error code:')) {
            throw new RuntimeException($response);
        }

        $questions = $this->extractQuestions($response);

        if (count($questions) === 0) {
            throw new RuntimeException('Failed to generate interview questions.');
        }

        return array_slice($questions, 0, (int) $data['questionsCount']);
    }

    private function extractQuestions(string $response): array
    {
        $cleanResponse = trim($response);
        $cleanResponse = preg_replace('/^```(?:json)?\s*/i', '', $cleanResponse);
        $cleanResponse = preg_replace('/\s*```$/', '', $cleanResponse);

        $decoded = json_decode($cleanResponse, true);

        if (!is_array($decoded)) {
            preg_match('/\[[\s\S]*\]/', $cleanResponse, $matches);
            if (!empty($matches[0])) {
                $decoded = json_decode($matches[0], true);
            }
        }

        if (!is_array($decoded)) {
            return $this->extractFromLines($cleanResponse);
        }

        return array_values(array_filter(array_map(function ($item) {
            return is_string($item) ? trim($item) : '';
        }, $decoded), function ($item) {
            return $item !== '';
        }));
    }

    private function extractFromLines(string $response): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $response);
        $questions = [];

        foreach ($lines as $line) {
            $question = preg_replace('/^\s*(\d+[\).\s-]*|[-*•]\s*)/', '', trim($line));
            if ($question !== '') {
                $questions[] = $question;
            }
        }

        return array_values(array_filter($questions));
    }
}
