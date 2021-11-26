<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Subject;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class AdminCourseSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursesubjects = CourseSubject::with('courses', 'subjects')->latest()->get();        
        return view('admin.coursesubject.index', compact(['coursesubjects']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acad_year = today()->format('Y') . '-' . today()->addYears(1)->format('Y'); 
        $courses = Course::orderBy('code')->get();   
        $subjects = Subject::orderBy('code')->get();    
        return view('admin.coursesubject.create', compact(['acad_year', 'courses', 'subjects']));
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
            'academic_year' => ['required', 'max:9'],     
            'units' => ['required', 'numeric'],
            'subject' => ['required'],
        ]);

        $courses = Course::orderBy('code')->get();
        
        $validcourses = [];
        foreach($courses as $c){
            if($request->has($c->code)){
                array_push($validcourses, $c);
            }
        }

        $subjects = Subject::all();
        
        $subject_id = null;

        foreach($subjects as $s){
            if($request->subject == $s->code){
                $subject_id = $s->id;
            }
        }        


        $reqyears = [$request->year1, $request->year2, $request->year3, $request->year4];
        $reqsections = [$request->section1, $request->section2, $request->section3, $request->section4];

        $years = ['1ST', '2ND', '3RD', '4TH'];        
        $sections = ['A', 'B', 'C', 'D'];
        $validyears = [];
        $validsections =[];
        foreach($reqyears as $i => $y){
            if($y != null){
                if($years[$i] != $y){
                    return back()->withErrors([
                        'year' => ['The year does not match to the system. Make sure the available years are 1ST, 2ND, 3RD, 4TH']
                    ]);
                }else{
                    array_push($validyears, $y);
                }
            }
        }

        foreach($reqsections as $i => $s){
            if($s != null){
                if($sections[$i] != $s){
                    return back()->withErrors([
                        'section' => ['The sections does not match to the system. Make sure the available sections are A, B, C, D']
                    ]);
                }else{
                    array_push($validsections, $s);
                }
            }
        }

        $datas = [];
        $dataExists = [];
        foreach($validcourses as $c){            
            foreach($validyears as $y){
                foreach($validsections as $s){
                    $data = [
                        'course_id' => $c->id,
                        'subject_id' => $subject_id,
                        'units' => $request->units,
                        'academic_year' => $request->academic_year,                        
                        'year' => $y,
                        'section' => $s,
                    ];

                    //Check wether this data is already exist in database
                    $cs = CourseSubject::with('courses', 'subjects')->where('course_id', $data['course_id'])
                                ->where('subject_id', $data['subject_id'])
                                ->where('academic_year', $data['academic_year'])
                                ->where('year', $data['year'])
                                ->where('section', $data['section'])->get(); 
                    if($cs->count() == 0){
                        array_push($datas, $data);
                    }else{
                        array_push($dataExists, $cs->courses->code .'-'. $cs->subjects->code .'-'. $data['year'] .'-'.$data['section']. '-' .$data['academic_year']);
                    }
                }
            }
        }
       
   
        if(count($datas) == 0){
            $request->session()->flash('message', 'Course Not Added! ' . implode('-', $dataExists) .' Already Exists');
            $request->session()->flash('alert-class', 'alert-warning');
            return redirect()->route('admin.course.index');
        }        
        
        $cs = CourseSubject::upsert($datas, ['course_id', 'subject_id', 'units', 'academic_year', 'year', 'section']);
        if ($cs){
            if(count($dataExists)>0){
                $request->session()->flash('message', 'Subject Added Successfully! Some Data alreay exists ' . implode('-', $dataExists));
            }else{
                $request->session()->flash('message', 'Subject Added Successfully!');
            }            
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Subject Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.coursesubject.index');
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}