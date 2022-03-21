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

        $student = Student::with(['attendances' => function($q){
            $q->where('created_at', '>', today())->latest();
        }, 'user'])        
        ->where('student_code', $request->student_code)->firstOrFail();
        
        //check if the student tap rfid within 60 seconds        
        if($student->attendances->count()>0){
            if(now()->diffInSeconds($student->attendances[0]->created_at) > 60){                                
                //if count is even, then it must be time in, else time out
                if($student->attendances->count()%2 == 0){
                    $student->attendances()->create(['status' => 'time-in']);
                }else{
                    $student->attendances()->create(['status' => 'time-out']);
                }                        
            }
        }    
        
        return view('gatepass.index')->with(['student'=> $student]);
    }
}