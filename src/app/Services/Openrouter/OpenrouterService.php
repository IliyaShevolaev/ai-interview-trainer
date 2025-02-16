<?php

namespace App\Services\Openrouter;

use Illuminate\Support\Facades\Http;

class OpenrouterService
{
    public function sendAiRequest(string $prompt)
    {
        $url = "https://openrouter.ai/api/v1/chat/completions";

        $headers = [
            "Authorization" => "Bearer " . config("services.ai_api_key"),
            "Content-Type" => "application/json",
        ];

        $data = [
            "model" => "google/gemini-2.0-flash-lite-preview-02-05:free",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt,
                ]
            ],
        ];

        $responce = Http::withHeaders($headers)->post($url, $data);

        if ($responce->status() != 200) {
            return "Error code: " . $responce->status();
        } else {
            $data = $responce->json();
            return $data['choices'][0]['message']['content'];
        }
    }
}
