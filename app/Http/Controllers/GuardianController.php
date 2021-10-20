<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\Attendance;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('guardian')->findOrFail(auth()->user()->id);        
        //dd($user);
        $guardian = Guardian::with('students')->whereBelongsTo($user)->firstOrFail();
        // dd($guardian->students[0]->attendances);
        return view('guardians.index', ['guardian' => $guardian]);
    }

    public function showStudent(Student $student)
    {
        if(!$student->guardians->contains(auth()->user()->guardian->id)){
            return view('nopermission');
        }
        
        $datas = Attendance::with('student')->whereBelongsTo($student)->orderBy('created_at', 'DESC')->get()->groupBy('status');          
        $time_in = ($datas->count() > 0)? PaginationHelper::paginate($datas['time-in'], 100) : [];
        $time_out = ($datas->count() > 0)? PaginationHelper::paginate($datas['time-out'], 100) : [];
        $present = ($datas->count() > 0)? PaginationHelper::paginate($datas['present'], 100) : [];
        $absent = ($datas->count() > 0)? PaginationHelper::paginate($datas['absent'], 100) : [];
        return view('students.index', ['student' => $student,'time_in' => $time_in, 'time_out' => $time_out, 'present' => $present, 'absent' => $absent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guardians.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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