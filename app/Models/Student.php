<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_code', 'phone', 'course_id', 'year', 'section', 'academic_year'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function addsubjects()
    {
        return $this->hasMany(StudentAddSubject::class);
    }
}