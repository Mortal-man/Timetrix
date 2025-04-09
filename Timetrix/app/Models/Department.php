<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

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
