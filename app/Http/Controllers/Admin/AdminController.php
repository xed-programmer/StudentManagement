<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceVisitor;
use App\Models\Guardian;
use App\Models\Post;
use App\Models\Student;
use App\Models\User;
use App\Models\Visitor;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::count();        
        $student = Student::count();
        $guardian = Guardian::count();        
        $post = Post::count();
        $attendances = Attendance::with('student.user')->latest()->get();
        $visitorAttendances = AttendanceVisitor::with('visitor')->latest()->get();

        return view('admin.index', compact(['users', 'student', 'guardian', 'post', 'attendances', 'visitorAttendances']));
    }    
}