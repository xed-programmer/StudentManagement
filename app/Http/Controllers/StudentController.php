<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

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
        // ->whereRelation('coursesubjects', [
        // ['section', '=', $student->section],
        // ['year', '=', $student->year],
        // ['course_id', '=', $student->course_id],
        // ])->get();
        $schedules = Schedule::with(['coursesubjects.courses', 'coursesubjects.subjects', 'professors.user'])
        ->join('course_subjects', 'course_subjects.id', '=', 'schedules.course_subject_id')
        ->where(function($query) use ($student){
            $query->where('course_subjects.section', $student->section)
            ->where('course_subjects.year', $student->year)
            ->where('course_subjects.course_id', $student->course_id);
        })
        ->orWhereIn('schedules.id', function($query) use ($student){
            $query->from('student_add_subjects')
            ->where('student_add_subjects.student_id', $student->id)
            ->select('student_add_subjects.schedule_id');
        })
        ->get(['schedules.*']);
        
        return view('students.index', ['student' => $student, 'time_in' => $time_in, 'time_out' => $time_out, 'present' => $present,
         'absent' => $absent, 'schedules' => $schedules]);
    }
}