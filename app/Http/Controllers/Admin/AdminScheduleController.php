<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Professor;
use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    
    public function getYearLevel()
    {
        return ['1ST', '2ND', '3RD', '4TH'];
    }
    
    public function getSections()
    {
        return ['A', 'B', 'C', 'D'];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDays(){
        return ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
    }
    
    public function index()
    {
        $limit = 15;
        $schedules = Schedule::with('professors.user', 'coursesubjects.courses')->latest()->get();        
        return view('admin.schedule.index', compact('schedules', 'limit'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $subjects = Subject::with('coursesubjects')->orderBy('code', 'ASC')->get();        
        $subjects = Subject::with('coursesubjects')
        ->join('course_subjects', 'course_subjects.subject_id', '=', 'subjects.id')
        ->whereIn('subjects.id', function($query){
            $query->select('course_subjects.subject_id')
            ->from('course_subjects');            
        })->get(['subjects.*']);
        $professors = Professor::with(['user' => function($q){
            $q->orderBy('name');
        }])->get();
        $courses = Course::orderBy('code', 'ASC')->get();
        $days = $this::getDays();
        return view('admin.schedule.add', compact(['subjects', 'professors', 'courses', 'days']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'professor' => ['required', 'exists:professors,id'],
            'subject' => ['required', 'exists:subjects,code'],
            'course' => ['required', 'exists:courses,code'],
            'year' => ['required'],            
            'section' => ['required'],            
            'start' => ['required'],            
            'end' => ['required']
        ]);

        // Get All days
        $days = $this::getDays();
        $validdays = [];
        foreach ($days as $day) {
            if($request->has($day)){
                $validdays[] = $day;
            }
        }        

        // Check in CourseSubject if the Course year Section and subject exists
        $coursesubjects = CourseSubject::with(['courses', 'subjects'])
        ->where('section', $request->section)
        ->where('year', $request->year)
        ->get();        

        $coursesubject = null;
        foreach ($coursesubjects as  $cs) {
            if($cs->courses->code == $request->course && $cs->subjects->code == $request->subject){    
                $coursesubject = $cs;
            }
        }
        
        // Check if there is no record
        if($coursesubject == null){
            return back()->withErrors(
                ['error' => 'The ' . $request->subject . ' is not enrolled for ' . $request->course . ' ' . $request->year . ' ' . $request->section]
            );
        }
              
                
        // Convert to timestamp
        $time_start = strtotime($request->start);                
        $time_end = strtotime($request->end);        
        
        // Convert Time to Carbon Datetime
        $dt_time_start = today()->setTimeFromTimeString($request->start);
        $dt_time_end = today()->setTimeFromTimeString($request->end);
        
        // Check if the the time interval from start to end is not equal to units of subjects
        if($dt_time_end->diffInHours($dt_time_start) != $coursesubject->units){
            return back()->withErrors(['time' => 'The time interval between class session does not match to units']);
        }

        $datas = [];
        $dataExists = [];
        // Loop through Days        
        foreach ($validdays as $day) {
            $data = [
                'course_subject_id' => $coursesubject->id,
                'professor_id' =>$request->professor,
                'day' => $day,
                'time_start' => $time_start,
                'time_end' => $time_end,
            ];

            // Check wether this data already exists
            $sched = Schedule::where('course_subject_id', $data['course_subject_id'])
            ->where('professor_id', $data['professor_id'])
            ->where('day', $data['day'])
            ->where('time_start', $data['time_start'])
            ->where('time_end', $data['time_end'])->get();

            if($sched->count() == 0){
                $datas[] = $data;
            }else{
                array_push($dataExists, $coursesubject->courses->code .'-'. $coursesubject->subjects->code .'-'. $data['year'] .'-'.$data['section']. '-' .$data['academic_year']);
            }
        }

        if(count($datas) == 0){
            $request->session()->flash('message', 'Course Not Added! ' . implode('-', $dataExists) .' Already Exists');
            $request->session()->flash('alert-class', 'alert-warning');
            return redirect()->route('admin.schedule.index');
        }        
        
        $sched = Schedule::upsert($datas, ['course_subject_id', 'professor_id', 'day', 'time_start', 'time_end']);
        if ($sched){
            if(count($dataExists)>0){
                $request->session()->flash('message', 'Schedule Added Successfully! Some Data alreay exists ' . implode('-', $dataExists));
            }else{
                $request->session()->flash('message', 'Schedule Added Successfully!');
            }            
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Schedule Added Unsuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        $yearLevels = $this::getYearLevel();
        $sections = $this::getSections();
        $subjects = Subject::with('coursesubjects')
        ->join('course_subjects', 'course_subjects.subject_id', '=', 'subjects.id')
        ->whereIn('subjects.id', function($query){
            $query->select('course_subjects.subject_id')
            ->from('course_subjects');            
        })->get(['subjects.*']);
        $professors = Professor::with(['user' => function($q){
            $q->orderBy('name');
        }])->get();
        $courses = Course::orderBy('code', 'ASC')->get();
        $days = $this::getDays();
        return view('admin.schedule.edit', compact(['schedule', 'yearLevels', 'sections', 'subjects', 'professors', 'courses', 'days']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'professor' => ['required', 'exists:professors,id'],
            'subject' => ['required', 'exists:subjects,code'],
            'course' => ['required', 'exists:courses,code'],
            'year' => ['required'],            
            'section' => ['required'],            
            'start' => ['required'],            
            'end' => ['required'],
            'day' => ['required'],            
        ]);

        // Get All days
        $days = $this::getDays();        
        $day = null;
        foreach ($days as $d) {
            if($request->day == $d){
                $day = $d;
            }
        }        

        // Check in CourseSubject if the Course year Section and subject exists
        $coursesubjects = CourseSubject::with(['courses', 'subjects'])
        ->where('section', $request->section)
        ->where('year', $request->year)
        ->get();        

        $coursesubject = null;
        foreach ($coursesubjects as  $cs) {
            if($cs->courses->code == $request->course && $cs->subjects->code == $request->subject){    
                $coursesubject = $cs;
            }
        }
        
        // Check if there is no record
        if($coursesubject == null){
            return back()->withErrors(
                ['error' => 'The ' . $request->subject . ' is not enrolled for ' . $request->course . ' ' . $request->year . ' ' . $request->section]
            );
        }
              
                
        // Convert to timestamp
        $time_start = strtotime($request->start);                
        $time_end = strtotime($request->end);        
        
        // Convert Time to Carbon Datetime
        $dt_time_start = today()->setTimeFromTimeString($request->start);
        $dt_time_end = today()->setTimeFromTimeString($request->end);
        
        // Check if the the time interval from start to end is not equal to units of subjects
        if($dt_time_end->diffInHours($dt_time_start) != $coursesubject->units){
            return back()->withErrors(['time' => 'The time interval between class session does not match to units']);
        }

        $datas = [];
        $dataExists = [];
        // Loop through Days
        $data = [
            'course_subject_id' => $coursesubject->id,
            'professor_id' =>$request->professor,
            'day' => $day,
            'time_start' => $time_start,
            'time_end' => $time_end,
        ];

        // Check wether this data already exists
        $sched = Schedule::where('course_subject_id', $data['course_subject_id'])
        ->where('professor_id', $data['professor_id'])
        ->where('day', $data['day'])
        ->where('time_start', $data['time_start'])
        ->where('time_end', $data['time_end'])->get();

        if($sched->count() > 0){      
            return back()->withErrors([
                'error' => $coursesubject->courses->code .'-'. $coursesubject->subjects->code .'-'. $data['year'] .'-'.$data['section']. '-' .$data['academic_year']
                . " Schedule already exists!"
            ]);
        }
        
        $res = Schedule::create($data);
        if ($res){
            $request->session()->flash('message', 'Schedule Added Successfully!');             
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Schedule Added Unsuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule, Request $request)
    {        
        if ($schedule->delete()){
            $request->session()->flash('message', 'Schedule Deleted Successfully!');             
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Schedule Deleted Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.schedule.index');
    }
}