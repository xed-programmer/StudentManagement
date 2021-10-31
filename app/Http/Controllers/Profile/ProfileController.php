<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        switch ($request->user()->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.profile', ['user' => $request->user()]);
            case 'student':
                return view('students.profile', ['user' => $request->user()]);
        }

        return view('nopermission');
    }

    public function edit(Request $request)
    {
        
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        switch ($request->user()->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.edit', ['user' => $request->user()]);
            case 'student':
                return view('students.edit', ['user' => $request->user()]);
        }

        return view('nopermission');
    }

    public function update(Request $request)
    {
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        switch ($request->user()->roles()->pluck('name')[0]) {
            case 'admin':
                ProfileController::updateUserAdmin($request->user(), $request);
                break;
            case 'student':
                ProfileController::updateUserStudent($request->user(), $request);
                break;
            default:
                return view('nopermission');
        }

        return redirect()->route('profile.index');
    }

    private function updateUserAdmin(User $user, Request $request)
    {
        // if(auth()->user()->id != $user->id){
        //     return redirect()->route('home');
        // }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users, email, ' . $user->id],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->push();
    }

    private function updateUserStudent(User $user, Request $request)
    {
        // if(auth()->user()->id != $user->id){
        //     return redirect()->route('home');
        // }

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
    }

    public function updatePassword(Request $request)
    {
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        switch ($request->user()->roles()->pluck('name')[0]) {
            case 'admin':
                ProfileController::updatePasswordAdmin($request);
                break;
            case 'student':
                ProfileController::updatePasswordStudent($request);
                break;
            default:
                return view('nopermission');
        }

        // return redirect()->route('profile.index');
    }

    private function updatePasswordAdmin(Request $request)
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
        $user->push();
    }

    private function updatePasswordStudent(Request $request)
    {
        // if(auth()->user()->id != $user->id){
        //     return redirect()->route('home');
        // }
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = $request->user();
                
        if(! Hash::check($request->current_password, $user->password)){            
            return redirect()->route('profile.edit')->withErrors([
                'current_password' => ['The provided password does not match our records.']
            ]);
        }
        $student = Student::with('user')->findOrFail($user->student()->id);
        
        $student->user->password = Hash::make($request->password);        

        if ($student->push()) {
            $request->session()->flash('message', 'Student Data Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Data Updated Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
    }


}