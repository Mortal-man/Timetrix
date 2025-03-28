<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $primaryKey = 'classroom_id';

    protected $fillable = [
        'room_name',
        'capacity',
    ];

    public function timetable()
    {
        return $this->hasMany(Timetable::class, 'classroom_id', 'classroom_id');
    }
}
