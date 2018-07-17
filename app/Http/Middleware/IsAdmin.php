<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Admin;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) 
    {

        if(Auth::check()){

            if ( Admin::where('user_id', Auth::user()->id)->first()  ) {
                return $next($request);
            }else{
                abort(403, 'Unauthorized action.');
            }

        }else{
            return redirect('/login');
        }

    }
}
