<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\CustomPasswordRule;
use App\Http\Controllers\Controller;

//use App\Http\Controllers\Admin\UsersController;
use App\Providers\RouteServiceProvider;
use Illuminate\Facades\Support\Auth;
use Illuminate\Support\Facades\Hash;
use Illumninate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
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

   // use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
        ]);
    }

    public function checkOldPassword(Request $request) {
        $data = $request->all();
        $validator = $this->validator($data);
        //dd($data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput(); 
        }
        $user = User::where('email', $request->email)->first();

        $newPassword = $request->input('password');
        //$a = Hash::make($newPassword);
        $previousPasswords = json_decode($user->password_history, true);
        //dd($previousPasswords);
        $len = count($previousPasswords);
        //dd($len);
        for($i=0; $i<$len; $i++){
            if(Hash::check($newPassword, $previousPasswords[$i])){
                return redirect()->back()->withErrors(['password' => 'Password cannot be one of the old passwords']);
            }
        }

        $hashedPassword = Hash::make($newPassword);
        $user->password = $hashedPassword;
        $passwordHistory = array_slice($previousPasswords, -5); // Keep the last 4 passwords
        $passwordHistory[] = $hashedPassword;
        $user->password_history = json_encode($passwordHistory);

        $user->save();

        return redirect('/login')->with('status', 'Password changed successfully');
            //return $user;
    }    
    // protected function redirectTo(){
    //     return '/admin';
    // } 
}
