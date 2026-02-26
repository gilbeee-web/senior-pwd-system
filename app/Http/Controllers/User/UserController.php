<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function index(){

        $current_user = Auth::user();

        $users = User::join('barangays', 'users.barangay_id', '=', 'barangays.id')
        ->select('barangays.name AS barangay', 'users.*')
        ->where('users.id', '!=', $current_user->id)->get();

        $barangays = Barangay::all();

        return view('users/index', [
            'users'=> $users,
            'mode' => "create",
            'current_user' => $current_user,
            'barangays' => $barangays
        ]);

    }


    public function store(Request $request){

        // dd($request->all());


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
            'generated_credentials' => [
                'username' => $username,
                'password' => $tempPassword
            ]
        ]);

    }


    public function edit(User $user){

        $current_user = Auth::user();

        $barangays = Barangay::all();

        return view('users/edit_user', [
            'current_user' => $current_user, 
            'user' => $user,
            'mode' => 'edit',
            'barangays' => $barangays
        ]);
    }


    public function update(Request $request, $id){

        // dd($request->all());
        

        $current_user = Auth::user();
        $user = User::findOrFail($id);


        $validated = $request->validate([
            'name' => 'nullable|string',
            'role' => 'nullable|string',
            'username' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'barangay_id' => 'nullable|exists:barangays,id'
        ]);

        //check if the user is changing his own password
        if (!empty($validated['password']) && $current_user->id === $user->id) {

            // Require current password
            if (empty($validated['current_password'])) {
                return back()->withErrors([
                    'current_password' => 'Current password is required.'
                ]);
            }

            // Check if password matches
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The password you entered does not match to the old password.'
                ]);
            }
        }

        $updateUserData = [
            'username' => $validated['username'],
        ];

        if ($current_user->role === 'super_admin' && $current_user->id !== $user->id) {
            $updateUserData['name'] = $validated['name'];
            $updateUserData['role'] = $validated['role'] ?? $user->role;
            $updateUserData['barangay_id'] = $validated['barangay_id'] ?? null;
        }

        if (!empty($validated['password'])) {
            $updateUserData['password'] = Hash::make($validated['password']);
        }

        if($request->hasFile('profile_pic')){

            $file = $request->file('profile_pic');

            $fileName = Str::slug($validated['name']) . '_' . time() . '.' . $file->extension();

            $path = $file->storeAs('admin_profile', $fileName, 'public');

            $updateUserData['profile_pic'] = $path;
        }


        // dd("Ready to update");

        $user->update($updateUserData);

        if($current_user->role === 'super_admin'){
            return redirect()->route('user.index')->with(['success' => 'Updated successfully!']);
        }else{
            return redirect()->route('barangay_admin.dashboard')->with(['success' => 'Updated successfully!']);
        }
    }


    public function resetPassword(Request $request, $id){

        $user = User::findOrFail($id);

        $newPassword = Str::random(8);

        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->back()->with([
            'generated_credentials' => [
                'username' => $user->username,
                'password' => $newPassword
            ]
        ]);

    }


    


}
