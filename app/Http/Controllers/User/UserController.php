<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function index(){

        $users = User::all();

        $barangays = Barangay::all();

        return view('users/index', [
            'users'=> $users,
            'barangays' => $barangays
        ]);

    }


    public function store(Request $request){

        $validated = $request->validate(([
            'name' => 'required|string',
            'role' => 'required|string',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'barangay_id' => 'nullable|exists:barangays,id'
        ]));

        $username = Str::slug($validated['name']) . rand(100,999);
        $tempPassword = Str::random(8);

        $validated['username'] = $username;
        $validated['password'] = Hash::make($tempPassword);

        if($request->hasFile('profile_pic')){

            $file = $request->file('profile_pic');

            $fileName = Str::slug($validated['name']) . '_' . time() . '.' . $file->extension();

            $path = $file->storeAs('admin_profile', $fileName, 'public');

            $validated['profile_pic'] = $path;
        }

        $new_user = User::create($validated);

        return redirect()->back()->with([
            'success' => "User added successfully!",
            'user' => $new_user,
            'credentials' => [
                'username' => $username,
                'password' => $tempPassword
            ]
        ]);

    }


}
