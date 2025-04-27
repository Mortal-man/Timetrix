<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Institution extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'institution_id';

    protected $fillable = [
        'name',
        'abbreviation',
        'motto',
        'email',
        'phone',
        'website',
        'address',
        'logo'
    ];
}
