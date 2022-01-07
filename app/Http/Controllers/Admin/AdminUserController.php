<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereHas('roles', function($q){
            $q->whereNotIn('name', ['student', 'guardian']);
        })
        ->with(['roles' => function($q){
            $q->whereNotIn('name', ['student', 'guardian']);
        }])
        ->get();

        // $users = User::join('role_user', 'role_user.user_id', '=', 'users.id')
        // ->join('roles', 'roles.id', '=', 'role_user.role_id')
        // ->whereIn('users.id', function($query){
        //     $query->select('user_id')
        //     ->from('role_user')
        //     ->where('roles.name', '!=', 'student');
        // })->get(['users.*','roles.name as role', 'role_user.role_id']);
        // dd($users);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = DB::table('roles')
        ->whereNotIn('name', ['student', 'guardian'])
        ->get();        
        return view('admin.user.register')->with(['roles'=>$roles]);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();

        $user->roles()->attach($role->id);

        event(new Registered($user));
        if ($role) {
            $request->session()->flash('message', 'User Created Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'User Created Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.user.index');
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
    public function edit(User $user)
    {
        $roles = DB::table('roles')
        ->whereNotIn('name', ['student', 'guardian'])
        ->get();        
        return view('admin.user.edit')->with(['user' => $user,'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],            
            'role' => ['required', 'exists:roles,name'],
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;

        if(!in_array($request->role ,$user->roles()->pluck('name')->ToArray())){
            $role = Role::where('name', $request->role)->firstOrFail();
            $user->roles()->attach($role->id);
        }

        if($request->email != $user->email){
            event(new Registered($user));
        }        
        
        if ($user->save()) {
            $request->session()->flash('message', 'User Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'User Updated Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {        
        if ($user->delete()) {
            $request->session()->flash('message', 'User Deleted Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'User Deleted Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }   
        return redirect()->route('admin.user.index');     
    }
}