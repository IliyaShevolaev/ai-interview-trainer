<?php

namespace App\Services\Openrouter;

use Illuminate\Support\Facades\Auth;
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
            "model" => Auth::check() ? Auth::user()->selected_model : config('aimodels.default_model'),
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
