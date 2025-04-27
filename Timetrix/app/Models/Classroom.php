<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Classroom extends Model implements AuditableContract
{
    use HasFactory, Auditable;

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
