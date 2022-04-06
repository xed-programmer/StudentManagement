<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class AdminBuildingController extends Controller
{

    public function index()
    {
        $buildings = Building::orderBy('name')->get();
        return view('admin.building.index',compact(['buildings']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100', 'unique:buildings,name']
        ]);

        $res = Building::create(['name'=>$request->name]);
               
        if ($res) {
            $request->session()->flash('message', 'Building Created Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Building Created Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.building.index');
    }

    public function edit(Building $building)
    {
        return view('admin.building.edit')->with(['building'=>$building]);
    }

    public function update(Building $building, Request $request)
    {
        $request->validate([
            'name'=>['required', 'unique:buildings,name,'.$building->id]
        ]);
    
        $building->name = $request->name;
        
        if ($building->save()) {
            $request->session()->flash('message', 'Building Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Building Updated Unsuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        
        return redirect()->route('admin.building.index');     
    }

    public function destroy(Building $building, Request $request)
    {
        if ($building->delete()) {
            $request->session()->flash('message', 'Building Data Deleted Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Building Data Deleted Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.building.index');
    }
}