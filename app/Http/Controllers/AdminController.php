<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function student()
    {
        $students = Student::with('users')->get();

        return view('admin.student.index')->with(['students' => $students]);
    }
    public function createStudent()
    {
        return view('admin.student.register');
    }

    public function editStudent(Request $request)
    {
        return view('admin.student.edit', compact($request));
    }

    public function updateStudent(Request $request)
    {
    }
}
