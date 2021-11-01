<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileAdminController extends Controller
{
    
    public function edit(Request $request)
    {
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        return view('admin.edit', ['user' => $request->user()]);
    }

   //Update Personal Information
   public function updateUser(Request $request)
   {
       // if(auth()->user()->id != $user->id){
       //     return redirect()->route('home');
       // }
       $user = $request->user();
       $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users, email, ' . $user->id],
    ]);

    $user->name = $request->name;
    $user->email = $request->email;         

       if ($user->push()) {
           $request->session()->flash('message', 'Admin Data Updated Successfully!');
           $request->session()->flash('alert-class', 'alert-success');
       } else {
           $request->session()->flash('message', 'Admin Data Updated Unuccessfully!');
           $request->session()->flash('alert-class', 'alert-warning');
       }
       return redirect()->route('profile.index');
   }

   //Update User's Password
   public function updatePassword(Request $request)
   {
       // dd($request->user()->student);
       // if(auth()->user()->id != $user->id){
       //     return redirect()->route('home');
       // }
       $request->validate([
           'current_password' => ['required'],
           'password' => ['required', 'confirmed', Rules\Password::defaults()],
       ]);
       
       $user = $request->user();
               
       if(! Hash::check($request->current_password, $user->password)){            
           return back()->withErrors([
               'current_password' => ['The provided password does not match our records.']
           ]);
       }       
       
       $user->password = Hash::make($request->password);        

       if ($user->push()) {
           $request->session()->flash('message', 'Password Updated Successfully!');
           $request->session()->flash('alert-class', 'alert-success');
       } else {
           $request->session()->flash('message', 'Password Updated Unuccessfully!');
           $request->session()->flash('alert-class', 'alert-warning');
       }
           return redirect()->route('profile.index');
   }
}