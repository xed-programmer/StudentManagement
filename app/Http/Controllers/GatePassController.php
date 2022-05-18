<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Student;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatePassController extends Controller
{
    private function getDestination()
    {        
        $destinations = DB::table('destinations')
        ->join('buildings', 'destinations.building_id', '=', 'buildings.id')
        ->join('building_user', 'destinations.building_id', '=', 'building_user.building_id')
        ->join('users', 'building_user.user_id', '=', 'users.id')
        ->where('users.id', '=', auth()->user()->id)
        ->select('destinations.name')
        ->get();
        return $destinations;
    }

    public function index()
    {
        $destinations = $this::getDestination();
        $_SESSION['destinations'] = $destinations;
        return view('gatepass.index')->with(['student'=>null, 'visitor'=>null, 'destinations' => $destinations]);
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
        $status = '';
        if($student->attendances->count()>0){
            if(now()->diffInSeconds($student->attendances[0]->created_at) > 60){                                
                //if count is even, then it must be time in, else time out
                if($student->attendances->count()%2 == 0){  
                    $status = 'time-in';
                }else{
                    $status = 'time-out';
                }                        
            }            
        }else{
            $status = 'time-in';
        }
        $student->attendances()->create(['status' => $status]);

        if(isset($_SESSION['destinations'])){
            $destinations = $_SESSION('destinations');
        }else{
            $destinations = $this::getDestination();
        }
        return view('gatepass.index')->with(['student'=> $student, 'visitor'=> null, 'status' => $status, 'destinations' => $destinations]);
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

        $destination = Destination::where('name', $request->desination)->get();

        $visitor = Visitor::with(['attendances'=> function($q){
            $q->where('created_at', '>', today())->latest();
        }])
        ->where('email', $request->email)
        ->firstOrFail();
        
        //check if the student tap rfid within 60 seconds        
        $status = '';
        if($visitor->attendances->count()>0){
            if(now()->diffInSeconds($visitor->attendances[0]->created_at) > 60){                                
                //if count is even, then it must be time in, else time out
                if($visitor->attendances->count()%2 == 0){
                    $status = 'time-in';
                }else{
                    $status = 'time-out';
                }                   
            }
        }else{
            $status = 'time-in';
        }
        $visitor->attendances()->create(['status' => $status, 'destination' => $request->destination, 'destination_id' => $destination->id]);

        if(isset($_SESSION['destinations'])){
            $destinations = $_SESSION('destinations');
        }else{
            $destinations = $this::getDestination();
        }
        return view('gatepass.index')->with(['student' => null,'visitor'=> $visitor, 'destinations' => $destinations, 'destination' => $request->destination, 'status' => $status]);
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