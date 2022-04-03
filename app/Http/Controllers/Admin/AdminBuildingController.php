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
    public function edit(Building $building)
    {
        return view('admin.building.edit')->with(['building'=>$building]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Building $building, Request $request)
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