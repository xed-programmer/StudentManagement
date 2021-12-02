<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;

class GatePassController extends Controller
{
    public function index()
    {
        return view('gatepass.index');
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
                // $student->attendances()->create(['status' => $attendances[0]->status]);
                return redirect()->route('gatepass.index');
            }
        }
        //if count is even, then it must be time in, else time out
        if($attendances->count()%2 == 0){            
            $student->attendances()->create(['status' => 'time-in']);
            $phone = '63'. substr($student->phone, 1);
            $data = [
                'body' => $student->user->name . ' entered the school at ' . now()->format('h:i A'), 
                'to' => $phone               
            ];
        }else{
            $student->attendances()->create(['status' => 'time-out']);
            $phone = '63'. substr($student->phone, 1);
            $data = [
                'body' => $student->user->name . ' leave the school at ' . now()->format('h:i A'),  
                'to' => $phone              
            ];
        }
    
        // $student->notify(new SmsNotification($data));

        $smsCntr = new SmsController();
        $smsCntr->sendMessage($data);        
        
        return redirect()->route('gatepass.index');
    }
}