<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseSubject extends Model
{
    use HasFactory;    

    protected $fillable = [
        'course_id', 'subject_id', 'units', 'year', 'section' , 'academic_year'
    ];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}