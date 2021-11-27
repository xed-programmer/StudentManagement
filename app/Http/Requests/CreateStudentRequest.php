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
            'year' => ['required'],
            'section' => ['required'],
            'course' => ['required', 'exists:courses,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'student_code' => ['required', 'string', 'max:10', 'unique:students'],
            'phone' => ['required', 'regex:/(09)[0-9]{9}/'],
        ];
    }
}