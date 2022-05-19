<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SendSMS;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStudentRequest;
use App\Jobs\SendEmailVerificationJob;
use App\Jobs\SendSMSJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisteredStudentController extends Controller
{
    public function create()
    {
        return view('admin.student.register');
    }

    public function store(CreateStudentRequest $request)
    {
        $default_student_password = '123456789';        
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($default_student_password),
            'phone_number' => $request->phone,
            'profile_pic' => 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'avatar1.png'
        ]);

        $res = $user->student()->create([
            'student_code' => $request->student_code,            
            'course' => $request->course,
            'year' => $request->year,
            'section' => $request->section,            
        ]);

        // Add Role to user

        $role = Role::where('name', 'student')->firstOrFail();

        $user->roles()->attach($role->id);        

        $user->buildings()->attach(auth()->user()->buildings()->pluck('id')[0]);

        // Send SMS
        // SendSMS::sendSMS("Student Account created successfully", $user->phone_number);
        SendSMSJob::dispatch(['message'=>"Student Account created successfully",
            'phone'=> $user->phone_number]);
        
        if ($res) {
            $request->session()->flash('message', 'Student Added Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }

        // Send gmail
        // event(new Registered($user));
        SendEmailVerificationJob::dispatch(new Registered($user));
        
        // return redirect(RouteServiceProvider::HOME); 
        return redirect()->back();
    }
}