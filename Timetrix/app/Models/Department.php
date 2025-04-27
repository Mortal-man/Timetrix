<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Department extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $primaryKey = 'department_id'; // Custom primary key

    protected $fillable = [
        'department_name',
        'department_code',
        'faculty_id',
        'head_of_department',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }
}
