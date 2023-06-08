<?php

namespace App\Http\Controllers\Auth;

use App\Rules\CustomPasswordRule;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Facades\Support\Auth;
use Illumninate\Validation\Rules;
//use Illuminate\Facades\Support\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // public function updatePassword(Request $request)
    // {
    //     $request->validate([
    //         'password' => ['required', 'string', new CustomPasswordRule],
    //     ]);
    
    //     $dbUser = User::find($user->id);
    //     return Hash::check($request->password, $dbUser->password);
    //     // Password is valid, proceed with further actions

    //     // ...
    // }

    use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    protected function rules(){
        //$dbUser = User::find($user->id);
        return [
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/']
        ];
    }
    public function validator(array $data)
    {
        $dbUser = User::find($user->id);
        if(Hash::check($request->password, $dbUser->password)){
            return redirect()->back()->withErrors(['password'=>'No previous passwords']);
        }

        return Validator::make($data, [
            
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
        ]);
    }

    // public function checkOldPassword(Request $request) {
        
    // }

    
}
