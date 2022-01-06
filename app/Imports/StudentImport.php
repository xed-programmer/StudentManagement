<?php

namespace App\Imports;

use App\Helpers\SendSMS;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Hash;

class StudentImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // dd($rows);
        // Validator::make($rows->toArray(), [

        //     '*.Student Code' => ['required', 'unique:students,student_code'],
        //     '*.Name' => 'required',
        //     '*.Course' => 'required',
        //     '*.Year' => 'required',
        //     '*.Section' => 'required',
        //     '*.Email' => ['required', 'email', 'unique:users'],
        //     '*.Phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        // ])->validate();        
        $validated = [];
        foreach($rows->toArray() as $row){            
            $valids = Validator::make($row, [
                'name' => ['required', 'max:255'],
                'course' => ['required'],
                'year' => ['required'],
                'section' => ['required'],            
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'student_code' => ['required', 'max:10', 'unique:students'],
                'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
            ])->validate();
            array_push($validated, $valids);
        }
        // $validator = Validator::make($rows->toArray(), [
        //     'name' => ['required', 'max:255'],
        //     'course' => ['required'],
        //     'year' => ['required'],
        //     'section' => ['required'],            
        //     'email' => ['required', 'email', 'max:255', 'unique:users'],
        //     'student_code' => ['required', 'max:10', 'unique:students'],
        //     'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        // ]);    

        $default_student_password = '123456789';    
        $role = Role::where('name', 'student')->firstOrFail();  
        $count = 0;      
        foreach($validated as $row){                    
            $user = User::create([
                'name' => $row["name"],
                'email' => $row["email"],
                'password' => Hash::make($default_student_password),
            ]);
    
            $user->student()->create([
                'student_code' => $row["student_code"],
                'phone' => $row["phone"],
                'course' => $row["course"],
                'year' => $row["year"],
                'section' => $row["section"] 
            ]);                         

            $user->roles()->attach($role->id);

            // SendSMS::sendSMS("Student Account created successfully", $res->phone);
            event(new Registered($user));
            $count++;
        }
        session()->flash('student_count', $count);        
    }
}