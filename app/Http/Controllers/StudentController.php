<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Attendance;
use App\Models\Schedule;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $datas = $student->attendances()->orderBy('created_at', 'DESC')->get()->groupBy('status');
        //$datas = Attendance::whereBelongsTo($student)->orderBy('created_at', 'DESC')->get()->groupBy('status');
        
        $time_in = ($datas->count() > 0 && $datas->has('time-in'))? PaginationHelper::paginate($datas['time-in'], 20) : [];
        $time_out = ($datas->count() > 0 && $datas->has('time-out'))? PaginationHelper::paginate($datas['time-out'], 20) : [];
        $present = ($datas->count() > 0 && $datas->has('present'))? PaginationHelper::paginate($datas['present'], 20) : [];
        $absent = ($datas->count() > 0 && $datas->has('absent'))? PaginationHelper::paginate($datas['absent'], 20) : [];
        
        // Get Class Schedules
        // $schedules = Schedule::with(['coursesubjects.courses', 'coursesubjects.subjects', 'professors.user'])
        // ->whereHas('coursesubjects.courses', function($query){
        //     return $query->where('id', auth()->user()->student->course_id);
        // })->get();
        $schedules = Schedule::with(['coursesubjects.courses', 'coursesubjects.subjects', 'professors.user'])
        ->whereRelation('coursesubjects', [
        ['section', '=', $student->section],
        ['year', '=', $student->year],
        ['course_id', '=', $student->course_id],
        ])->get();
        
        return view('students.index', ['student' => $student, 'time_in' => $time_in, 'time_out' => $time_out, 'present' => $present,
         'absent' => $absent, 'schedules' => $schedules]);
    }
}