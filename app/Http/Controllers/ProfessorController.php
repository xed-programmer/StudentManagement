<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {        
        $schedule_count = Schedule::where('professor_id', auth()->user()->professor->id)->count();        
        return view('professors.index', compact(['schedule_count']));
    }

    public function showSchedule()
    {                       
        return view('professors.schedule.show');
    }
}