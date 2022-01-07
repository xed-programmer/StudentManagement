<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_code', 'phone', 'gatepass'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }    
}