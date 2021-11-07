<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}