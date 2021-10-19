<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $datas = Attendance::with('student')->whereBelongsTo($student)->orderBy('created_at', 'DESC')->get()->groupBy('status');                
        // dd($datas[0]);
        $time_in = ($datas->count() > 0)? PaginationHelper::paginate($datas[0], 100) : [];
        $time_out = ($datas->count() > 0)? PaginationHelper::paginate($datas[1], 100) : [];
        $present = ($datas->count() > 0)? PaginationHelper::paginate($datas[2], 100) : [];
        $absent = ($datas->count() > 0)? PaginationHelper::paginate($datas[3], 100) : [];
        return view('students.index', ['time_in' => $time_in, 'time_out' => $time_out, 'present' => $present, 'absent' => $absent]);
    }
}