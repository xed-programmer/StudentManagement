<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SendSMS;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGuardianRequest;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Auth\Events\Registered;
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
            'profile_pic' => 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'avatar1.png'
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

        // insert guardian to visitor table

        Visitor::create([
            'name' => $user->name,
            'email' => $user->email,            
            'phone_number' => $user->phone_number,
            'address' => $request->address
        ]);

        event(new Registered($user));
        
        return redirect()->route('home');
    }
}