<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class GatePassController extends Controller
{
    public function index()
    {
        return view('gatepass.index')->with(['student'=>null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_code' => ['required', 'max:10', 'exists:students,student_code'],
        ]);

        $student = Student::with(['attendances', 'user'])->where('student_code', $request->student_code)->firstOrFail();                
        
        //This is the equivalent syntax in Mysql
        //SELECT * FROM `attendances` WHERE `created_at` > '2021-10-25 00:00:00.0' AND (`status` = 'time-in' OR `status` = 'time-out');
        $attendances = $student->attendances()
        ->where('created_at', '>', today())
        ->where(function ($query){
            return $query->where('status', 'time-in')->orWhere('status', '=', 'time-out');
        })
        ->latest()->get();
        
        //check if the student tap rfid within 60 seconds
        
        if($attendances->count()>0){
            if(now()->diffInSeconds($attendances[0]->created_at) < 60){                
                return view('gatepass.index')->with('student', $student);
            }
        }
        //if count is even, then it must be time in, else time out
        if($attendances->count()%2 == 0){
            $student->attendances()->create(['status' => 'time-in']);
        }else{
            $student->attendances()->create(['status' => 'time-out']);
        }        
        return view('gatepass.index')->with(['student'=> $student]);
    }
}