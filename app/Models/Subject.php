<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'description', 'units', 'course_code', 'year', 'section' , 'academic_year'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class);
    }
}