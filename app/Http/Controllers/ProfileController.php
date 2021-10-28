<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        if(auth()->user()->id != $user->id){
            return redirect()->route('home');
        }
        switch ($user->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.profile', ['user' => $user]);
            case 'student':
                return view('students.profile', ['user' => $user]);
        }

        return view('nopermission');
    }

    public function edit(Request $request)
    {
        
        if(auth()->user()->id != $request->user()->id){
            return redirect()->route('home');
        }
        switch ($request->user()->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.edit', ['user' => $request->user()]);
            case 'student':
                return view('students.edit', ['user' => $request->user()]);
        }

        return view('nopermission');
    }

    public function update(User $user, Request $request)
    {
        if(auth()->user()->id != $user->id){
            return redirect()->route('home');
        }
        switch ($user->roles()->pluck('name')[0]) {
            case 'admin':
                ProfileController::updateUserAdmin($user, $request);
                break;
            case 'student':
                ProfileController::updateUserStudent($user, $request);
                break;
            default:
                return view('nopermission');
        }

        return redirect()->route('profile.index', $user);
    }

    private function updateUserAdmin(User $user, Request $request)
    {
        if(auth()->user()->id != $user->id){
            return redirect()->route('home');
        }
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
        if(auth()->user()->id != $user->id){
            return redirect()->route('home');
        }

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
}