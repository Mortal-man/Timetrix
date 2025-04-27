<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Course extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_name',
        'course_code',
        'instructor_id',
        'student_enrollment',
        'department_id',
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function timetable()
    {
        return $this->hasMany(Timetable::class, 'course_id', 'course_id');
    }
}
