<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $start_time = 7; // 7 AM
        $end_time = 18; // 6 PM

        $schedules = [];

        foreach ($days as $day) {
            for ($hour = $start_time; $hour < $end_time; $hour++) {
                $schedules[] = [
                    'day' => $day,
                    'start_time' => sprintf('%02d:00:00', $hour), // Format to 24-hour format
                    'end_time' => sprintf('%02d:00:00', $hour + 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('schedules')->insert($schedules);
    }
}
