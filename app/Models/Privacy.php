<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $table = 'privacy';
    protected $fillable = [
        'user_id', 'current_position', 'current_company', 'current_location', 'preferred_location', 'years_experience', 'highest_degree', 'industry_summary', 'skills',
    ];
}
