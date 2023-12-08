<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(){
        return view('bakend.profile');
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'profile' => 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);
        if($request->hasFile('profile')) {
            $profile_image_name = str(auth()->user()->name)->slug().time().'.'.$request->profile->extension();
            // $request->profile->extension();
            $request->profile->storeAs('users', $profile_image_name,'public');
        }

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile = isset($profile_image_name) ? $profile_image_name : auth()->user()->profile;
        $user->save();
        return back();

    }
        //  change profile password
    public function changePassword(Request $request){
        $request->validate([
            'current_password'=>'required|current_password',
            'password'=>'required|confirmed|min:8|different:current_password',
        ]);
        $user= User::find(auth()->id());
        $user->password = Hash::make($request->password);
        $user->save();
        // ->notify()->success('Laravel Notify is awesome!');
        return back();
    }
}
