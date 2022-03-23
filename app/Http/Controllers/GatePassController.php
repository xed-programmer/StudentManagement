<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Visitor;
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

    public function visitor()
    {
        return view('gatepass.visitor')->with(['visitor'=>null]);
    }

    public function store_visitor(Request $request)
    {
        $request->validate([
            'email' => ['required', 'exists:visitors,email'],
            'destination' => ['required'],
        ]);

        $visitor = Visitor::with(['attendances'=> function($q){
            $q->where('created_at', '>', today())->latest();
        }])
        ->where('email', $request->email)
        ->firstOrFail();
        
        //check if the student tap rfid within 60 seconds        
        if($visitor->attendances->count()>0){
            if(now()->diffInSeconds($visitor->attendances[0]->created_at) > 60){                                
                //if count is even, then it must be time in, else time out
                $status = '';
                if($visitor->attendances->count()%2 == 0){
                    $status = 'time-in';
                }else{
                    $status = 'time-out';
                }   
                $visitor->attendances()->create(['status' => $status, 'destination' => $request->destination]);
            }
        }else{
            $visitor->attendances()->create(['status' => 'time-in', 'destination' => $request->destination]);
        }
        
        return view('gatepass.visitor')->with(['visitor'=> $visitor, 'destination' => $request->destination]);
    }

    public function add_visitor(Request $request){        
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:visitors'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);

        Visitor::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone
        ]);
    }
}