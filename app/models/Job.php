<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public static $types = array('All', 'Full Time', 'Freelance', 'Part Time', 'Internship', 'Temporary');

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
    public function skills()
    {
        return $this->hasMany('App\Models\JobSkill', 'job_id');
    }
    public function questions()
    {
        return $this->hasMany('App\Models\JobQuestion', 'job_id');
    }

    public static function getDistinctTitles()
    {
        $result = [];
        $titles = self::select('title')->groupBy('title')->get();
        foreach ($titles as $title) {
            $result[] = $title->title;
        }

        return json_encode($result);
    }
}
