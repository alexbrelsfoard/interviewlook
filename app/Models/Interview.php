<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interview;

class Interview extends Model
{
    public function looks()
    {
        return $this->hasMany('App\Models\Look', 'interview_id');
    }

    static function interviewTitle($id){
    	return Interview::find($id)->title;
    }
}
