<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileStudentController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        return view('students.edit', ['user' => $request->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Update Personal Information
    public function updateUser(Request $request)
    {
        // if(auth()->user()->id != $user->id){
        //     return redirect()->route('home');
        // }
        $user = $request->user();
        $student = Student::findOrFail($user->student()->pluck('id')[0]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email, ' . $user->id],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);

        $student->phone = $request->phone;
        $student->user->name = $request->name;
        $student->user->email = $request->email;        

        if ($student->push()) {
            $request->session()->flash('message', 'Student Data Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Data Updated Unuccessfully!');
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
        $student = Student::with('user')->findOrFail($user->student->id);
        
        $student->user->password = Hash::make($request->password);        

        if ($student->push()) {
            $request->session()->flash('message', 'Student Data Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Data Updated Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
            return redirect()->route('profile.index');
    }
}