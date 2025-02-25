<?php

namespace App\Models\Interview;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $guarded = false;

    public function questions()
    {
        return $this->hasMany(Question::class, 'interview_id', 'id');
    }

    public function interviewResults()
    {
        return $this->hasMany(InterviewResult::class, 'interview_id', 'id');
    }
}
