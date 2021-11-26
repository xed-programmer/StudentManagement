<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id', 'course_id', 'section', 'year',
        'professor_id', 'day', 'time_start', 'time_end',
        'units', 'school_year'
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function professors()
    {
        return $this->hasMany(Professor::class);
    }

}