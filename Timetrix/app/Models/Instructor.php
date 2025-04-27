<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Instructor extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $primaryKey = 'instructor_id'; // Set custom primary key

    protected $fillable = [
        'instructor_name',
        //'availability',
        'department_id',
    ];

    // protected $casts = [
    //     'availability' => 'array', // Store availability as JSON array
    // ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function timetable()
    {
        return $this->hasMany(Timetable::class, 'instructor_id', 'instructor_id');
    }
}
