<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStudentRequest;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredStudentController extends Controller
{
    public function create()
    {
        return view('admin.student.register');
    }

    public function store(CreateStudentRequest $request)
    {
        $default_student_password = '123456789';
        $academic_year = today()->format('Y') . '-' . today()->addYears(1)->format('Y');
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($default_student_password),
        ]);

        $res = $user->student()->create([
            'student_code' => $request->student_code,
            'phone' => $request->phone,
            'year' => $request->year,
            'section' => $request->section,
            'academic_year' => $academic_year
        ]);

        $role = Role::where('name', 'student')->firstOrFail();

        $user->roles()->attach($role->id);        
        
        if ($res) {
            $request->session()->flash('message', 'Student Added Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        // return redirect(RouteServiceProvider::HOME);
        return redirect()->back();
    }
}