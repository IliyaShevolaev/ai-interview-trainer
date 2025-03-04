<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    protected $guarded = false;

    public function question()
    {
        return $this->hasOne('questions', 'id', 'question_id');
    }
}
