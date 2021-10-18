<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function student()
    {
        $students = Student::with('user')->get();

        return view('admin.student.index')->with(['students' => $students]);
    }
    public function createStudent()
    {
        return view('admin.student.register');
    }

    public function editStudent(Student $student, Request $request)
    {
        return view('admin.student.edit', ['student' => $student]);
    }

    public function updateStudent(Student $student, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email, ' . $student->user_id],
            'student_code' => ['required', 'string', 'max:10', 'unique:students,student_code, ' . $student->id],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);


        $student->student_code = $request->student_code;
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

        return redirect()->route('admin.student.index');
    }

    public function destroyStudent(Student $student, Request $request)
    {
        // $res = $student->deleteOrFail();
        $res = User::findOrFail($student->user_id)->deleteOrFail();
        if ($res) {
            $request->session()->flash('message', 'Student Data Deleted Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Data Deleted Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.student.index');
    }
}