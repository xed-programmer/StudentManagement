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
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // $users = User::count();
        $users = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')        
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('users.id')
        ->where('roles.name', 'admin')         
        ->count();        
        $student = Student::count();
        $guardian = Guardian::count();        
        $post = Post::count();
        $attendances = Attendance::with('student.user')->latest()->get();
        $visitorAttendances = AttendanceVisitor::with('visitor')->latest()->get();

        return view('admin.index', compact(['users', 'student', 'guardian', 'post', 'attendances', 'visitorAttendances']));
    }    
}