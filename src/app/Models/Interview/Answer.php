<?php

namespace App\Models\Interview;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}
