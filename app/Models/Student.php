<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_code', 'phone',
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
        return $this->hasMany(Attendance::class)->sortByDesc('created_at');
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class);
    }
}