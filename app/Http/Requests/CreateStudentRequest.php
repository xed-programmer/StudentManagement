<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class CreateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'course' => ['required'],
            'year' => ['required'],
            'section' => ['required'],            
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'student_code' => ['required', 'string', 'max:10', 'unique:students'],            
        ];
    }
}