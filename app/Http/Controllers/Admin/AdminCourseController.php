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
        $courses = Course::orderBy('code')->get();
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
            'code' => ['required', 'max:10', 'unique:courses,code'],
            'name' => ['required', 'max:255'],
        ]);

        $course = Course::create($request->only(['code', 'name']));
        
        if ($course){    
            $request->session()->flash('message', 'Course Added Successfully!');                  
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
    public function edit(Course $course)
    {        
        return view('admin.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code' => ['required', 'unique:courses,code, ' . $course->id],
            'name' => ['required', 'max:255'],
        ]);

        $course->code = $request->code;
        $course->name = $request->name;

        if ($course->push()) {
            $request->session()->flash('message', 'Course Data Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Course Data Updated Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }

        return redirect()->route('admin.course.index');
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