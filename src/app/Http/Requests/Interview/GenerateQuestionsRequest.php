<?php

namespace App\Http\Requests\Interview;

use Illuminate\Foundation\Http\FormRequest;

class GenerateQuestionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic' => 'required|string|min:2|max:255',
            'questionsCount' => 'required|integer|min:1|max:20',
            'level' => 'required|string|min:2|max:100',
            'wishes' => 'nullable|string|max:1000',
        ];
    }
}
