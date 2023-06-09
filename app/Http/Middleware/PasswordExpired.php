<?php
namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        // if(Auth::check()){
            
        //     $passwordUpdatedAt = $user->updated_at;
        // }
        if($user && $user->updated_at){
            $passwordAgeInDays = $user->updated_at->diffInDays(now());

            $maxPasswordAge = 2;

            if($passwordAgeInDays >= $maxPasswordAge){
                return redirect()->route('expired');
            }
        }

        return $next($request);
    }
}
