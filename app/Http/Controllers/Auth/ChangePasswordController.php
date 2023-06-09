<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
//use App\Http\Requests\UpdatePasswordRequest;
//use App\Http\Requests\UpdateProfileRequest;
//use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Facades\Support\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use Symfony\Component\HttpFoundation\Response;
use Illumninate\Validation\Rules;

class ChangePasswordController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(){
        $this->middleware('auth');
    }

    public function updateAllowed($user){
        $minimumTime = Carbon::now()->subDays(1);
        $lastUpdate = Carbon::parse($user->updated_at);
        return $lastUpdate->lt($minimumTime);
    }

    public function index(Request $request){
        $user = $request->user();
        if (!$this->updateAllowed($user)) {
            return redirect()->route('admin.home')->with('error', 'Password can only be changed after atleast 24 hours.');
        }
        return view('auth.passwords.change');
    }
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed' , 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'different:current_password'],
        ]);
    }
    public function store(Request $request){
        
        
        $data = $request->all();
        $validator = $this->validator($data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput(); 
        }
        if (!Hash::check($request->current_password, $request->user()->password)) {
            //dd('ad');
            return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
        }
        
        $user = $request->user();
        $newPassword = $request->input('password');
        $passwordHistory = json_decode($user->password_history, true);
        if (in_array(Hash::make($newPassword), $password_history)) {
            return redirect()->back()->withErrors(['password' => 'Password cannot be one of the old passwords']);
        }

        $hashedPassword = Hash::make($newPassword);
        $user->password = $hashedPassword;
        $passwordHistory = array_slice($previousPasswords, -4); // Keep the last 4 passwords
        $passwordHistory[] = $hashedPassword;
        $user->password_history = json_encode($passwordHistory);

        $user->save();
        $request->user()->update([
            'password' => bcrypt($request->password),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        return redirect()->route('admin.home')->with('status', 'Password changed successfully');
    }
        
        // public function updateProfile(UpdateProfileRequest $request)
    // {
    //     $user = auth()->user();

    //     $user->update($request->validated());

    //     return redirect()->route('profile.password.edit')->with('message', __('global.update_profile_success'));
    // }

    // public function destroy()
    // {
    //     $user = auth()->user();

    //     $user->update([
    //         'email' => time() . '_' . $user->email,
    //     ]);

    //     $user->delete();

    //     return redirect()->route('login')->with('message', __('global.delete_account_success'));
}
