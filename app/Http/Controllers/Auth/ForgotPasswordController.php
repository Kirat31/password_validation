<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBrokerManager;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    //insert in password_resets table
    public function index(){
      return view('auth.passwords.email');
    }

    public function sendPasswordResetLink(Request $request){
      $request->validate([
        'email'=> 'required|email|string|max:255',
      ]);
      $token = Str::random(64);
      $response = $this->broker()->sendResetLink(
        $request->only('email')
      );
      if($response === Password::RESET_LINK_SENT){
        return back()->with('status', 'We have emailed your password token link')->with('token', $token);
      }
    }

    // protected function validateEmail(Request $request){
      
    // }
//     public function insert(Request $request){
//     //dd($request->all());
      
// //
//         DB::table('password_resets')->insert([
//         'email' => $request->email, 
//         'token' => $token, 
//         'created_at' => Carbon::now()
//         ]);
        
//         return view('auth.passwords.reset')->with('token', $token);
//     }

    use SendsPasswordResetEmails;
}
