<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professors = Professor::with('user')->latest()->get();
        return view('admin.professor.index', compact('professors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.professor.register');
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
            'units' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email']
        ]);

        if($request->units <= 0){
            return back()->withErrors(['units' => 'Units must be greater than 0']);
        }

        $default_password = 'prof123456789';
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($default_password),
        ]);

        $prof = $user->professor()->create($request->only(['units']));

        $role = Role::where('name', 'professor')->firstOrFail();

        $user->roles()->attach($role->id);
        
        if ($prof) {
            $request->session()->flash('message', 'Professor Added Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Professor Added Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.professor.index');
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