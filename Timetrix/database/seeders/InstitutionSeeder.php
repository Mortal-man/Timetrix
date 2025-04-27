<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        Institution::create([
            'name' => 'Egerton University',
            'abbreviation' => 'EU',
            'motto' => 'Transforming Lives Through Quality Education',
            'email' => 'info@egerton.ac.ke',
            'phone' => '+254712345678',
            'website' => 'https://www.egerton.ac.ke',
            'address' => 'Njoro, Nakuru County, Kenya',
            'logo' => 'images/logos/egerton-logo.png', // Make sure this path exists or update accordingly
        ]);
    }
}
