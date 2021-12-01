<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentAddSubject;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{

    private function getYearLevel(){
        return ['1ST', '2ND', '3RD', '4TH'];
    }

    private function getSections()
    {
        return ['A', 'B', 'C', 'D'];
    }
    
    private function getDays()
    {
        return ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
    }

    public function index()
    {        
        $schedule_count = Schedule::where('professor_id', auth()->user()->professor->id)->count();        
        return view('professors.index', compact(['schedule_count']));
    }

    public function showSchedule()
    {
        $schedules = Schedule::with(['coursesubjects.courses','coursesubjects.subjects', 'professors.user'])
        ->where('professor_id', auth()->user()->professor->id)
        ->get()->groupBy('day');
        $days = $this::getDays();        
        return view('professors.schedule.show', compact('schedules', 'days'));
    }

    public function showClass(Schedule $schedule)
    {
        // Fetch all students that has a particular schedule
        // This query ASC the name in Users table
        // it also gets the irreg students from student_add_subjects table
        $students = Student::with(['user'])
        ->join('users', 'students.user_id', '=', 'users.id')        
        ->where(function($query) use ($schedule){
            // this is for reg students
            $query->where('students.course_id', $schedule->coursesubjects->course_id)        
            ->where('students.year', $schedule->coursesubjects->year)        
            ->where('students.section', $schedule->coursesubjects->section);
        })  
        ->orWhereIn('students.id', function($query) use ($schedule){
            //This is for irreg students that has a same schedule
            $query->from('student_add_subjects')
            ->where('student_add_subjects.schedule_id', $schedule->id)
            ->select(['student_add_subjects.student_id']);
        })
        ->orderBy('users.name')
        ->get(['students.*']);        

        session(['students' => $students]);
            
        return view('professors.class.index', compact('students', 'schedule'));
    }

    public function addStudent(Schedule $schedule)
    {
        $yearlevels = $this::getYearLevel();
        $sections = $this::getSections();
        $courses = Course::orderby('code')->get();
        return view('professors.student.add', compact(['yearlevels', 'sections', 'courses', 'schedule']));
    }

    public function storeStudent(Schedule $schedule, Request $request)
    {
        $request->validate([
            'student' => ['required', 'exists:students,id'],
        ]);

        $res = StudentAddSubject::where('student_id', $request->student)
        ->where('schedule_id', $schedule->id)->get();
        if($res->count()>0){
            $request->session()->flash('message', 'Student Not Added! Maybe the student has been enrolled to this class');
            $request->session()->flash('alert-class', 'alert-danger');
            return back();
        }
        
        $res = StudentAddSubject::create([
            'student_id' => $request->student,
            'schedule_id' => $schedule->id,
        ]);
        if ($res) {
            $request->session()->flash('message', 'Student Added Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return back();
    }

    public function getStudentData(Request $request)
    {        
        $students = Student::with('user')
        ->where('course_id', $request->course)        
        ->where('year', $request->year)
        ->where('section', $request->section)
        ->get();
        
        return $students;
    }

    public function createAttendance(Schedule $schedule, Request $request)
    {
        $students = $request->session()->get('students');
        return view('professors.student.attendance', compact('students', 'schedule'));
    }

    public function storeAttendance(Request $request, Schedule $schedule)
    {
        // Validate if students exists
        $students = $request->session()->get('students');
        $presentStudents = [];
        $absentStudents = [];        
        foreach ($students as $student) {
            if($request->has($student->student_code)){                
                $presentStudents[] = [
                    'student_id' => $student->id,
                    'status' => 'present',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }else{
                $absentStudents[] = [
                    'student_id' => $student->id,
                    'status' => 'absent',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // dd(array_merge($presentStudents, $absentStudents));        

        $results = array_merge($presentStudents, $absentStudents);
        
        $res = DB::table('attendances')->insert($results);

        if ($res) {
            $request->session()->flash('message', 'Student Attendance Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Attendance Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }

        return redirect()->route('professor.class.show', compact('schedule'));
    }
}