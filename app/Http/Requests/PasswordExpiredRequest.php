<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class PasswordExpiredRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $dbuser = User::find($user->id);
        if(!Hash::check($request->current_password, $dbuser->password)){
            return redirect()->back()->withErrors(['current_password'=>'Incorrect password']);
        }
        //if (Carbon::now()->diffInDays($passwordUpdatedAt) >= config('auth.password_expires_days')) {
            return [
                'current_password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'confirmed'],
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'confirmed'],
            ];
        //}
    }
}
