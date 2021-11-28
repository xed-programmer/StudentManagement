<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Schedule;
use Illuminate\Http\Request;

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
        $professor = Professor::with(['schedules.coursesubjects.courses', 'schedules.coursesubjects.subjects'])
        ->whereBelongsTo(auth()->user())->get();
        dd($professor);
        return view('professors.schedule.show');
    }
}