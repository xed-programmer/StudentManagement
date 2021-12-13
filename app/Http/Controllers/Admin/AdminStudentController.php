<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{

    private function getYearLevel(){
        return ['1ST', '2ND', '3RD', '4TH'];
    }

    private function getSections()
    {
        return ['A', 'B', 'C', 'D'];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with(['user'])->get();
        return view('admin.student.index')->with(['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yearlevels = $this::getYearLevel();
        $sections = $this::getSections();        
        return view('admin.student.register', compact(['yearlevels', 'sections']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $yearlevels = $this::getYearLevel();
        $sections = $this::getSections();        
        return view('admin.student.edit', compact(['student','yearlevels', 'sections']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Student $student, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],            
            'year' => ['required'],
            'section' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email, ' . $student->user_id],
            'student_code' => ['required', 'string', 'max:10', 'unique:students,student_code, ' . $student->id],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);

        

        $student->student_code = $request->student_code;
        $student->phone = $request->phone;
        $student->year = $request->year;
        $student->section = $request->section;        

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, Request $request)
    {
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