<?php

namespace App\Services\Openrouter;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenrouterService
{
    public function sendAiRequest(string $prompt): string
    {
        $url = "https://openrouter.ai/api/v1/chat/completions";

        $headers = [
            "Authorization" => "Bearer " . config("services.ai_api_key"),
            "Content-Type" => "application/json",
        ];

        $data = [
            "model" => Auth::check() ? Auth::user()->selected_model : config('aimodels.default_model'),
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt,
                ]
            ],
        ];

        $response = Http::withHeaders($headers)->post($url, $data);

        if ($response->status() !== 200) {
            throw new RuntimeException("AI request failed with status: " . $response->status());
        }

        return $response->json()['choices'][0]['message']['content'];
    }

    public function parseJsonArrayResponse(string $response): array
    {
        $clean = trim($response);
        $clean = preg_replace('/^```(?:json)?\s*/i', '', $clean);
        $clean = preg_replace('/\s*```$/', '', $clean);

        $decoded = json_decode($clean, true);

        if (!is_array($decoded)) {
            preg_match('/\[[\s\S]*\]/', $clean, $matches);
            if (!empty($matches[0])) {
                $decoded = json_decode($matches[0], true);
            }
        }

        if (!is_array($decoded)) {
            return $this->extractFromLines($clean);
        }

        return array_values(array_filter(array_map(
            fn($item) => is_string($item) ? trim($item) : '',
            $decoded
        ), fn($item) => $item !== ''));
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
