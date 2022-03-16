<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SendSMS;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGuardianRequest;
use App\Models\Guardian;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredGuardianController extends Controller
{
    public function create()
    {
        return view('guardians.register');
    }

    public function store(CreateGuardianRequest $request)
    {
        $request->validated();
        
        do{
            $gatepass = random_int(1111111111, 9999999999);            
            $validator = Validator::make(array('gatepass' => $gatepass), [
                'gatepass'=> 'unique:guardians,gatepass',
                'gatepass'=> 'unique:students,student_code'
            ]);
            $validated = $validator->validated();            
        }while(!array_key_exists('gatepass', $validated));
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone,
        ]);

        $guardian = $user->guardian()->create([            
            'gatepass' => $validated['gatepass'],
        ]);
        
        $role = Role::where('name', 'guardian')->firstOrFail();
        $user->roles()->attach($role->id);

        $student = Student::where('student_code', $request->student_code)->firstOrFail();        
        // $guardian->students()->attach($student->id);
        $student->guardians()->attach($guardian->id);

        $message = 'Your Account was successfully created. This is your Gatepass Code '.$validated['gatepass']. '. Dont share it with other people.';
        SendSMS::sendSMS($message, $user->phone_number);

        event(new Registered($user));        
        
        return redirect()->route('home');
    }
}