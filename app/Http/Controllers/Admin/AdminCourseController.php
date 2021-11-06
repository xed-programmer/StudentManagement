<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('code')->orderBy('year')->orderBy('section')->get();
        return view('admin.course.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.create');
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
            'code' => ['required', 'max:10'],
            'name' => ['required', 'max:255'],
        ]);
        $reqyears = [$request->year1, $request->year2, $request->year3, $request->year4];
        $reqsections = [$request->section1, $request->section2, $request->section3, $request->section4];

        $years = ['1ST', '2ND', '3RD', '4TH'];        
        $sections = ['A', 'B', 'C', 'D'];
        foreach($reqyears as $i => $y){
            if($y != null){
                if($years[$i] != $y){
                    return back()->withErrors([
                        'year' => ['The year does not match to the system. Make sure the available years are 1ST, 2ND, 3RD, 4TH']
                    ]);
                }
            }
        }

        foreach($reqsections as $i => $s){
            if($s != null){
                if($sections[$i] != $s){
                    return back()->withErrors([
                        'section' => ['The sections does not match to the system. Make sure the available sections are A, B, C, D']
                    ]);
                }
            }
        }

        $datas = [];
        $dataExists = [];
        foreach($reqyears as $y){
            if($y != null){
                foreach($reqsections as $s){
                    if($s != null){
                        
                        $data = [
                            'code' => $request->code,
                            'name' => $request->name,
                            'year' => $y,
                            'section' => $s,
                        ];
                        $courses = Course::where('code', $data['code'])                        
                        ->where('year', $data['year'])
                        ->where('section', $data['section'])->get();                        
                        if($courses->count()==0){
                            array_push($datas, $data);
                        }else{
                            array_push($dataExists, $data['code'] .'-'.$data['year'] .'-'.$data['section']);
                        }
                    }
                }
            }
        }
        
        if(count($datas) == 0){
            $request->session()->flash('message', 'Course Not Added! ' . implode('-', $dataExists) .' Already Exists');
            $request->session()->flash('alert-class', 'alert-warning');
            return redirect()->route('admin.course.index');
        }        

        $courses = Course::upsert($datas, ['code', 'name', 'year', 'section']);
        if ($courses){
            if(count($dataExists)>0){
                $request->session()->flash('message', 'Course Added Successfully! Some Data alreay exists ' . implode('-', $dataExists));
            }else{
                $request->session()->flash('message', 'Course Added Successfully!');
            }            
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Course Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.course.index');
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