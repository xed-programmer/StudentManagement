<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'address', 'phone_number'
    ];

    public function user()
    {        
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(AttendanceVisitor::class);
    }
}