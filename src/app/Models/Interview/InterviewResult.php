<?php

namespace App\Models\Interview;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InterviewResult extends Model
{
    protected $guarded = false;

    public  function interview()
    {
        return $this->hasOne(Interview::class, 'id', 'interview_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'interview_result_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
