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
        // $acad_year = today()->format('Y') . '-' . today()->addYears(1)->format('Y'); 
        // $courses = Course::latest()->get()->groupBy('code');
        $courses = Course::orderBy('code')->get();        
        return view('admin.subject.create')->with(['courses' => $courses]);
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
    public function edit(Subject $subject)
    {
        return view('admin.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'code' => ['required', 'unique:subjects,code, ' . $subject->id],
            'name' => ['required', 'max:255'],
        ]);

        $subject->code = $request->code;
        $subject->name = $request->name;

        if ($subject->push()) {
            $request->session()->flash('message', 'Subject Data Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Subject Data Updated Unsuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }

        return redirect()->route('admin.subject.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject, Request $request)
    {
        if ($subject->delete()) {
            $request->session()->flash('message', 'Subject Deleted Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Subject Deleted Updated Unsuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }

        return redirect()->route('admin.subject.index');
    }
}