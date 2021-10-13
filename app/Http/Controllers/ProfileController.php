<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        switch (auth()->user()->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.profile', ['user' => auth()->user()]);
            case 'student':
                return view('students.profile', ['user' => auth()->user()]);
        }

        return view('nopermission');
    }

    public function edit(User $user,)
    {
        switch (auth()->user()->roles()->pluck('name')[0]) {
            case 'admin':
                return view('admin.edit', ['user' => auth()->user()]);
            case 'student':
                return view('students.edit', ['user' => auth()->user()]);
        }

        return view('nopermission');
    }
}
