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
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($default_student_password),
        ]);

        $user->students()->create($request->only(['student_code', 'phone']));

        $role = Role::where('name', 'student')->firstOrFail();

        $user->roles()->attach($role->id);

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->back();
    }
}
