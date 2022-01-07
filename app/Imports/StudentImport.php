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
        $validated = [];
        foreach($rows->toArray() as $row){            
            $valids = Validator::make($row, [
                'name' => ['required', 'max:255'],
                'course' => ['required'],
                'year' => ['required'],
                'section' => ['required'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'student_code' => ['required', 'unique:students'],
                'phone' => ['required', 'digits:10'],
            ])->validate();
            array_push($validated, $valids);
        }
        
        $length = 10;

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
                'student_code' => substr(str_repeat(0, $length).$row["student_code"], - $length),
                'phone' => "0".$row["phone"],
                'course' => $row["course"],
                'year' => $row["year"],
                'section' => $row["section"] 
            ]);                         

            $user->roles()->attach($role->id);

            SendSMS::sendSMS("Student Account created successfully", $row['phone']);
            event(new Registered($user));
            $count++;
        }
        session()->flash('student_count', $count);        
    }
}