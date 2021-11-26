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

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}