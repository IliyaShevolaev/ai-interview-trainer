<?php

namespace App\Actions\Interview;

use App\Services\Openrouter\OpenrouterService;

class RateInterviewAnswer
{
    public function handle(OpenrouterService $openrouterService, array $data)
    {
        $prompt = 'Ты – опытный HR-специалист, оценивающий ответы кандидата на собеседовании на позицию "' . $data['interviewTitle'] . '".  
        Вот вопрос: "' . $data['question'] . '"  
        Ответ кандидата: "' . $data['answer'] . '"  

        Твоя задача:  
        1. **Дай честную оценку от 0 до 10** на основе полноты, точности и релевантности ответа.  
        2. **Объясни, что в ответе плохо или чего не хватает**, но только **одним коротким предложением**.  
        3. **Если ответ не содержит полезной информации или "я не знаю" – ставь не выше 1/10.**  
        4. **Если ответ отличный, четкий и раскрывает вопрос – ставь 10/10.**  
        5. **Не используй одинаковые оценки для разных ответов, если их качество явно разное.**  

        Формат ответа строго: **X/10. Краткий комментарий.**';


        $aiRate = $openrouterService->sendAiRequest($prompt);

        return $aiRate;
    }
}
