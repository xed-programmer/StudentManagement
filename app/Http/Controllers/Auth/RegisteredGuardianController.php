<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGuardianRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredGuardianController extends Controller
{
    public function create()
    {
        return view('guardian.register');
    }

    public function store(CreateGuardianRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->guardians()->create($request->only('student_code'));
        $role = Role::where('name', 'guardian')->firstOrFail();

        $user->roles()->attach($role->id);
        event(new Registered($user));
        // return redirect(RouteServiceProvider::HOME);
        Auth::login($user);
        return redirect()->route('home');
    }
}