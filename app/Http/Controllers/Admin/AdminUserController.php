<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'buildings'])
        ->whereHas('roles', function($q){            
            $q->whereNotIn('name', ['student', 'guardian']);
        })
        ->whereHas('buildings', function($q){
            $q->where('building_id', '=', auth()->user()->buildings()->pluck('id')[0]);
        })
        ->get();      
        
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = DB::table('roles')
        ->whereNotIn('name', ['student', 'guardian'])
        ->get();
        $buildings = Building::orderBy('name')->get();        
        return view('admin.user.register')->with(['roles'=>$roles, 'buildings' => $buildings]);
    }

    public function store(Request $request)
    {        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'building' => ['required', 'exists:buildings,name'],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone,
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();
        $user->roles()->attach($role->id);

        $building = Building::where('name', $request->building)->firstOrFail();
        $user->buildings()->attach($building->id);

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

    public function edit(User $user)
    {
        $roles = DB::table('roles')
        ->whereNotIn('name', ['student', 'guardian'])
        ->get();
        $buildings = Building::orderBy('name')->get();        
        return view('admin.user.edit')->with(['user' => $user, 'roles'=>$roles, 'buildings' => $buildings]);
    }

    public function update(User $user, Request $request)
    {        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],            
            'role' => ['required', 'exists:roles,name'],
            'building' => ['required', 'exists:buildings,name'],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone;
        
        // Update User Role Pivot table
        $currentRoles = $user->roles()->get();                     
        if(!$currentRoles->contains('name', '=', $request->role)){
            $role = Role::where('name', $request->role)->firstOrFail();
            $user->roles()->updateExistingPivot($currentRoles[0]->id, ['role_id'=>$role->id]);
        }

        // Update User Building Pivot table
        $building = Building::where('name', $request->building)->firstOrFail();

        $currentBuilding = $user->buildings()->get();
        if(count($currentBuilding)==0){
            $user->buildings()->attach($building->id);
        }
        else if(!$currentBuilding->contains('name', '=', $request->role)){            
            $user->buildings()->updateExistingPivot($currentBuilding[0]->id, ['building_id'=>$building->id]);
        }

        if($request->email != $user->email){              
            Registered::dispatch($user);            
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