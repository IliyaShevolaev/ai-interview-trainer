<?php

namespace App\Models\Interview;

use Illuminate\Database\Eloquent\Model;

class InterviewResult extends Model
{
    protected $guarded = false;

    public  function interview()
    {
        return $this->hasOne(Interview::class, 'id', 'interview_id');
    }
}
