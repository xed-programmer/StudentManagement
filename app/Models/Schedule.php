<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_subject_id','professor_id', 'day', 'time_start', 'time_end',
    ];

    public function coursesubjects()
    {
        return $this->hasMany(CourseSubject::class);
    }

    public function professors()
    {
        return $this->hasMany(Professor::class);
    }

}