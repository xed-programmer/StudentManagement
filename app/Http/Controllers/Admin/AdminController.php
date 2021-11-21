<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Guardian;
use App\Models\Post;
use App\Models\Professor;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::count();
        $prof = Professor::count();
        $student = Student::count();
        $guardian = Guardian::count();
        $course = Course::count();
        $subject = Subject::count();        
        $post = Post::count();

        return view('admin.index', compact(['users', 'prof', 'student', 'guardian', 'course', 
        'subject', 'post']));
    }    
}