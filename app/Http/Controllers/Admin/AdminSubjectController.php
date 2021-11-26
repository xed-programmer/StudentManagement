<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::latest()->get();        
        return view('admin.subject.index')->with(['subjects' => $subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acad_year = today()->format('Y') . '-' . today()->addYears(1)->format('Y'); 
        // $courses = Course::latest()->get()->groupBy('code');
        $courses = Course::orderBy('code')->get();        
        return view('admin.subject.create')->with(['acad_year' => $acad_year, 'courses' => $courses]);
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
            //'academic_year' => ['required', 'max:9'],
            'code' => ['required', 'unique:subjects,code'],
            'name' => ['required', 'max:255'],
            //'units' => ['required', 'numeric'],            
        ]);

        $res = Subject::create($request->only(['code', 'name']));
    
        if($res){
            $request->session()->flash('message', 'Subject Added Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        }else{
            $request->session()->flash('message', 'Subject Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.subject.index');

        // $courses = Course::orderBy('code')->get();

        // $validcourses = [];
        // foreach($courses as $c){
        //     if($request->has($c->code)){
        //         array_push($validcourses, $c->code);
        //     }
        // }

        // $reqyears = [$request->year1, $request->year2, $request->year3, $request->year4];
        // $reqsections = [$request->section1, $request->section2, $request->section3, $request->section4];

        // $years = ['1ST', '2ND', '3RD', '4TH'];        
        // $sections = ['A', 'B', 'C', 'D'];
        // $validyears = [];
        // $validsections =[];
        // foreach($reqyears as $i => $y){
        //     if($y != null){
        //         if($years[$i] != $y){
        //             return back()->withErrors([
        //                 'year' => ['The year does not match to the system. Make sure the available years are 1ST, 2ND, 3RD, 4TH']
        //             ]);
        //         }else{
        //             array_push($validyears, $y);
        //         }
        //     }
        // }

        // foreach($reqsections as $i => $s){
        //     if($s != null){
        //         if($sections[$i] != $s){
        //             return back()->withErrors([
        //                 'section' => ['The sections does not match to the system. Make sure the available sections are A, B, C, D']
        //             ]);
        //         }else{
        //             array_push($validsections, $s);
        //         }
        //     }
        // }

        // $datas = [];
        // $dataExists = [];
        // foreach($validcourses as $c){
        //     foreach($validyears as $y){
        //         foreach($validsections as $s){
        //             $data = [
        //                 'code' => $request->code,
        //                 'name' => $request->name,
        //                 'units' => $request->units,
        //                 'academic_year' => $request->academic_year,
        //                 'course_code' => $c,
        //                 'year' => $y,
        //                 'section' => $s,
        //             ];
        //             $subject = Subject::where('code', $data['code'])
        //             ->where('course_code', $data['course_code'])
        //             ->where('academic_year', $data['academic_year'])
        //             ->where('year', $data['year'])
        //             ->where('section', $data['section'])->get();                        
        //             if($subject->count()==0){
        //                 array_push($datas, $data);
        //             }else{
        //                 array_push($dataExists, $data['code'] .'-'. $data['course_code'] .'-'. $data['year'] .'-'.$data['section']. '-' .$data['academic_year']);
        //             }
        //         }
        //     }
        // }
       
   
        // if(count($datas) == 0){
        //     $request->session()->flash('message', 'Course Not Added! ' . implode('-', $dataExists) .' Already Exists');
        //     $request->session()->flash('alert-class', 'alert-warning');
        //     return redirect()->route('admin.course.index');
        // }        
        
        // $subject = Subject::upsert($datas, ['code', 'name', 'units', 'academic_year', 'year', 'section']);
        // if ($subject){
        //     if(count($dataExists)>0){
        //         $request->session()->flash('message', 'Subject Added Successfully! Some Data alreay exists ' . implode('-', $dataExists));
        //     }else{
        //         $request->session()->flash('message', 'Subject Added Successfully!');
        //     }            
        //     $request->session()->flash('alert-class', 'alert-success');
        // } else {
        //     $request->session()->flash('message', 'Subject Added Unuccessfully!');
        //     $request->session()->flash('alert-class', 'alert-warning');
        // }
        // return redirect()->route('admin.subject.index');
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