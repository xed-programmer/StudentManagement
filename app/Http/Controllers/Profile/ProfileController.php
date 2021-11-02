<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // if(auth()->user()->id != $request->user()->id){
        //     return redirect()->route('home');
        // }
        switch ($request->user()->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.profile', ['user' => $request->user()]);
            case 'student':
                return view('students.profile', ['user' => $request->user()]);
            case 'guardian':
                // $user = User::with('guardian.students.user')->where('id', $request->user()->id)->firstOrFail();                
                return view('guardians.profile', ['user' => $request->user()]);
        }

        return view('nopermission');
    }
}