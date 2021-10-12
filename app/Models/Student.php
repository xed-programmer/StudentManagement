<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_code',
    ];


    public function users()
    {
        return $this->hasOne(User::class);
    }
    public function guardians()
    {
        return $this->belongsToMany(Guardian::class);
    }
}
