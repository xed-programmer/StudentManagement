<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id', 'status', 'destination', 'destination_id'
    ];

    public function visitor(){
        return $this->belongsTo(Visitor::class);
    }    
}