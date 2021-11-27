<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name',
    ];

    public function coursesubjects()
    {
        return $this->belongsTo(CourseSubject::class, 'id', 'subject_id');
    }
}