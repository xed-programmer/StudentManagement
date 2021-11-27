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
        return $this->belongsTo(CourseSubject::class, 'course_subject_id', 'id');
    }

    public function professors()
    {
        return $this->belongsTo(Professor::class, 'professor_id', 'id');
    }

    public function timestampToTime($time){
        return date('h:i A', $time);
    }

}