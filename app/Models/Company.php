<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'company_id');
    }
}
