<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Faculty extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $primaryKey = 'faculty_id'; // Custom primary key
    protected $fillable = ['faculty_name']; // Fillable fields

    public function departments()
    {
        return $this->hasMany(Department::class, 'faculty_id'); // Specify the correct foreign key
    }
}
