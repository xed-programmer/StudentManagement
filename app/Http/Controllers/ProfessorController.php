<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{

    private function getDays()
    {
        return ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
    }

    public function index()
    {        
        $schedule_count = Schedule::where('professor_id', auth()->user()->professor->id)->count();        
        return view('professors.index', compact(['schedule_count']));
    }

    public function showSchedule()
    {
        $schedules = Schedule::with(['coursesubjects.courses','coursesubjects.subjects', 'professors.user'])
        ->where('professor_id', auth()->user()->professor->id)
        ->get()->groupBy('day');
        $days = $this::getDays();        
        return view('professors.schedule.show', compact('schedules', 'days'));
    }

    public function showClass(Schedule $schedule)
    {
        // This query ASC the name in Users table
        $students = Student::with('user')
        ->join('users', 'students.user_id', '=', 'users.id')
        ->where('students.course_id', $schedule->coursesubjects->course_id)        
        ->where('students.year', $schedule->coursesubjects->year)        
        ->where('students.section', $schedule->coursesubjects->section)
        ->orderBy('users.name')
        ->get();
         
        return view('professors.class.index', compact('students', 'schedule'));
    }
}