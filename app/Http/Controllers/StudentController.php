<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Attendance;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $datas = Attendance::whereBelongsTo($student)->orderBy('created_at', 'DESC')->get()->groupBy('status');                        
        $time_in = ($datas->count() > 0)? PaginationHelper::paginate($datas['time-in'], 20) : [];
        $time_out = ($datas->count() > 0)? PaginationHelper::paginate($datas['time-out'], 20) : [];
        $present = ($datas->count() > 0)? PaginationHelper::paginate($datas['present'], 20) : [];
        $absent = ($datas->count() > 0)? PaginationHelper::paginate($datas['absent'], 20) : [];
        return view('students.index', ['student' => $student,'time_in' => $time_in, 'time_out' => $time_out, 'present' => $present, 'absent' => $absent]);
    }
}