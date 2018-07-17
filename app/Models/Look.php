<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Look extends Model
{
    protected $fillable = [
        'user_id', 'interview_id', 'video_id', 'img_url', 'title','order', 'status'
    ];

    public function interview()
    {
        return $this->hasOne('App\Models\Interview', 'id');
    }

    static function getVideoSize($url) {
    	if ( file_exists($url) ) {
    		$look = new Look;
	    	return $look->formatSizeUnits( filesize($url) );
    	} else {
    		return "Video not found";
    	}
    } 

    public function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}
}
