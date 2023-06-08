<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use App\Http\Controllers\Auth\Validator;
//use App\Http\Requests\PasswordExpiredRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Facades\Support\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Foundation\Auth\ResetsPasswords;
use Illumninate\Validation\Rules;

class ExpiredPasswordController extends Controller
{
    //use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;
    
    
    
    public function index(Request $request){
        return view('auth.passwords.expired');
    }

    public function post_expired(Request $request){

        // Checking current password
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
        }

        $rules = array(
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'different:current_password' ]
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator -> fails()){
            return redirect()->back()->withErrors($validator);
        }

        $request->user()->update([
            'password' => bcrypt($request->password),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        //$request->validated();
        return redirect()->back()->with(['status' => 'Password changed successfully']);
    
    }
    
}
