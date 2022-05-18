<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentListLayoutExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminStudentController extends Controller
{

    private function getYearLevel(){
        return ['1ST', '2ND', '3RD', '4TH'];
    }

    private function getSections()
    {
        return ['A', 'B', 'C', 'D'];
    }

    public function getExcelStudentListLayout()
    {
        return Excel::download(new StudentListLayoutExport(), 'studentlist.xlsx');        
    }
    
    public function index()
    {
        // $students = Student::with(['user'])->get();
        $students = Student::with(['user', 'user.buildings'])
        ->whereHas('user.buildings', function($q){
            $q->where('building_id', '=', auth()->user()->buildings()->pluck('id')[0]);
        })
        ->get();
        return view('admin.student.index')->with(['students' => $students]);
    }

    public function importStudent(Request $request)
    {        
        if($request->has('file')){
            $request->validate([
                'file' => ['required', 'mimes:xls,xlsx']
            ]);
            // $file = request()->file('file')->getRealPath();     
            // $file1 = request()->file('file')->store('temp');                        
            // $file = storage_path('app') . '/' . $file1;            
            // Excel::import(new StudentImport, $file);            
            Excel::import(new StudentImport, request()->file('file'));

            if(session()->has('student_count')){                
                $request->session()->flash('message', 'Student Import Successfully. Count ' . session()->get('student_count'));
                $request->session()->flash('alert-class', 'alert-success');
            }
        }else{
            $request->session()->flash('message', 'Student Import Unsuccessfully.');
            $request->session()->flash('alert-class', 'alert-danger');
        }
        return redirect()->route('admin.student.index');   
    }

    public function create()
    {
        $yearlevels = $this::getYearLevel();
        $sections = $this::getSections();        
        return view('admin.student.register', compact(['yearlevels', 'sections']));
    }

    public function edit(Student $student)
    {
        $yearlevels = $this::getYearLevel();
        $sections = $this::getSections();        
        return view('admin.student.edit', compact(['student','yearlevels', 'sections']));
    }

    public function update(Student $student, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],            
            'course' => ['required'],
            'year' => ['required'],
            'section' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email, ' . $student->user_id],
            'student_code' => ['required', 'string', 'max:10', 'unique:students,student_code, ' . $student->id],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);

        

        $student->student_code = $request->student_code;        
        $student->course = $request->course;
        $student->year = $request->year;
        $student->section = $request->section;        

        $student->user->name = $request->name;
        $student->user->email = $request->email;
        $student->user->phone_number = $request->phone;

        if ($student->push()) {
            $request->session()->flash('message', 'Student Data Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Data Updated Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }

        return redirect()->route('admin.student.index');
    }

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