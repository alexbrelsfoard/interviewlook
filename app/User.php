<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'role', 'email_token', 'email_verified', 'account_status', 'facebook_id', 'linkedin_id', 'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function social()
    {
        return $this->hasOne('App\Models\Social');
    }

    public function privacy()
    {
        return $this->hasOne('App\Models\Privacy');
    }

    public function metrics()
    {
        return $this->hasMany('App\Models\Metric');
    }
}
