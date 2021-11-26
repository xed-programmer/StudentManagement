<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'subject_id', 'units', 'year', 'section' , 'academic_year'
    ];
}