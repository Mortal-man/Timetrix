<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $primaryKey = 'faculty_id'; // Custom primary key
    protected $fillable = ['faculty_name']; // Fillable fields

    public function departments()
    {
        return $this->hasMany(Department::class, 'faculty_id'); // Specify the correct foreign key
    }

}
