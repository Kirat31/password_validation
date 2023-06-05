<?php

class PasswordExpiredRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (Carbon::now()->diffInDays($passwordUpdatedAt) >= config('auth.password_expires_days')) {
            return [
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ];
        }
    }
}
