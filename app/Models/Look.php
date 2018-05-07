<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Look extends Model
{
    protected $fillable = [
        'user_id', 'video_id', 'img_url', 'add_pipe_id'
    ];
}
