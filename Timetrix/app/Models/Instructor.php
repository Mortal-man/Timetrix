<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $primaryKey = 'instructor_id'; // Set custom primary key

    protected $fillable = [
        'instructor_name',
        'availability',
        'department_id',
    ];

    protected $casts = [
        'availability' => 'array', // Store availability as JSON array
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
