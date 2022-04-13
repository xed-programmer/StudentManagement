<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Destination;
use Illuminate\Http\Request;

class AdminDestinationController extends Controller
{

    public function index()
    {
        $destinations = Destination::with('building')
        ->orderBy('name')->get();
        $buildings = Building::orderBy('name')->get();
        return view('admin.destination.index')->with(['destinations'=>$destinations, 'buildings'=>$buildings]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'building' => ['required', 'string', 'max:100', 'exists:buildings,name'],
        ]);

        $building = Building::where('name', $request->building)->firstOrFail();
        
        // Check for duplication of data
        $res = Destination::where('name', $request->name)
        ->where('name', $request->name)        
        ->where('building_id', $building->id)        
        ->count();

        if($res>0)
        {
            return redirect()->back()->withErrors(['error'=>'The Destination is already in Building']);
        }

        $destination = Destination::create([
            'name'=>$request->name,
            'building_id' => $building->id
        ]);

        if ($destination) {
            $request->session()->flash('message', 'Destination Created Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Destination Created Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.destination.index');
    }

    public function edit(Destination $destination)
    {
        $buildings = Building::orderBy('name')->get();        
        return view('admin.destination.edit')->with(['destination'=>$destination, 'buildings'=>$buildings]);
    }

    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'building' => ['required', 'string', 'max:100', 'exists:buildings,name'],
        ]);
        
        $building = Building::where('name', $request->building)->firstOrFail();
        
        // Check for duplication of data
        $res = Destination::where('name', $request->name)
        ->where('name', $request->name)        
        ->where('building_id', $building->id)        
        ->count();

        if($res>0)
        {
            return redirect()->back()->withErrors(['error'=>'DUPLICATE DATA: The Destination is already in Building']);
        }

        $destination->name = $request->name;        
        $destination->building_id = $building->id;      
        
        if ($destination->save()) {
            $request->session()->flash('message', 'Destination Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Destination Updated Unsuccessful!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->back();
    }

    public function destroy(Request $request, Destination $destination)
    {        
        if ($destination->delete()) {
            $request->session()->flash('message', 'Destination Data Deleted Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Destination Data Deleted Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->back();
    }
}