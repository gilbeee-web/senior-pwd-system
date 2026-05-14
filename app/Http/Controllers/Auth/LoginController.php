<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //


    public function login(Request $request){

        // dd($request->all());

        try{
            $user = $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $remember = $request->has('remember');

            if(!Auth::attempt($user, $remember)){
                // dd("Error username or password");
                return redirect()->back()->with('error', 'Incorrect username or password');
            }

            $request->session()->regenerate();

            return $this->roleBasedAccess(Auth::user());

        }catch(ValidationException $e){
            // dd($e);
            return redirect()->back()->with('error', 'Error login: ' . $e);
        }
    }


    public function roleBasedAccess($user){

        // dd($user->role);
        switch($user->role){
            case 'super_admin':
                return redirect()->route('super_admin.dashboard');
            case 'barangay_pwd_admin':
                return redirect()->route('pwd_admin.dashboard');
            case 'pwd_admin':
                return redirect()->route('pwd_admin.dashboard');
            case 'senior_admin':
                return redirect()->route('senior_admin.dashboard');
            case 'barangay_senior_admin':
                return redirect()->route('senior_admin.dashboard');
            default:
                Auth::logout();
                return redirect()->route('index')->with('error', 'Unauthorized role');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('index');
        
    }


}
