<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $datas = Attendance::with('student')->whereBelongsTo($student)->orderBy('created_at', 'DESC')->get()->groupBy('status');        
        //dd($datas->all());
        return view('students.index', ['datas' => $datas]);
    }
}