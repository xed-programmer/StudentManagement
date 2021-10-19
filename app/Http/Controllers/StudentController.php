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
        // dd($datas);
        $time_in = ($datas->count() > 0)? PaginationHelper::paginate($datas['time-in'], 100) : [];
        $time_out = ($datas->count() > 0)? PaginationHelper::paginate($datas['time-out'], 100) : [];
        $present = ($datas->count() > 0)? PaginationHelper::paginate($datas['present'], 100) : [];
        $absent = ($datas->count() > 0)? PaginationHelper::paginate($datas['absent'], 100) : [];
        return view('students.index', ['time_in' => $time_in, 'time_out' => $time_out, 'present' => $present, 'absent' => $absent]);
    }
}