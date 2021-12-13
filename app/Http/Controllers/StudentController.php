<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $attendances = $student->attendances()->orderBy('created_at', 'DESC')->paginate(100);                
        
        return view('students.index', ['student' => $student, 'attendances' => $attendances]);
    }
}