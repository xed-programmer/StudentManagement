<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceVisitor;
use Illuminate\Http\Request;

class AdminGatepassController extends Controller
{
    public function student()
    {
        $attendances = Attendance::with('student.user')->latest()->get();
        return view('admin.gatepass.student.index')->with(['attendances'=>$attendances]);
    }

    public function visitor()
    {
        $attendances = AttendanceVisitor::with('visitor')->latest()->get();
        return view('admin.gatepass.visitor.index')->with(['attendances'=>$attendances]);
    }
}