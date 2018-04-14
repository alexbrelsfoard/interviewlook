<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobQuestion extends Model
{
    public function question()
    {
        return $this->hasOne('App\Models\Question', 'id', 'question_id');
    }
}
