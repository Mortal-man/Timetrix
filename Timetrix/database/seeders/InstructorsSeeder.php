<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstructorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            ['id' => 53, 'name' => 'Dr. Alice Smith', 'availability' => "[\"Monday\",\"Wednesday\",\"Friday\"]", 'department_id' => 2],
            ['id' => 54, 'name' => 'Prof. John Lee', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 2],
            ['id' => 55, 'name' => 'Dr. Raj Patel', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 2],
            ['id' => 56, 'name' => 'Dr. Lisa Adams', 'availability' => "[\"Monday\",\"Wednesday\"]", 'department_id' => 2],
            ['id' => 57, 'name' => 'Prof. Mark Green', 'availability' => "[\"Tuesday\",\"Thursday\",\"Friday\"]", 'department_id' => 2],
            ['id' => 58, 'name' => 'Dr. Henry Kim', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\"]", 'department_id' => 2],
            ['id' => 59, 'name' => 'Prof. Sarah White', 'availability' => "[\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 2],
            ['id' => 60, 'name' => 'Dr. Tom Brown', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 2],
            ['id' => 61, 'name' => 'Prof. Emily Clark', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 2],
            ['id' => 62, 'name' => 'Dr. David Scott', 'availability' => "[\"Monday\",\"Wednesday\",\"Friday\"]", 'department_id' => 2],

            // Electrical Engineering (6)
            ['id' => 63, 'name' => 'Dr. Michael Jones', 'availability' => "[\"Monday\",\"Wednesday\",\"Friday\"]", 'department_id' => 6],
            ['id' => 64, 'name' => 'Prof. Susan Carter', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 6],
            ['id' => 65, 'name' => 'Dr. Kevin Wright', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 6],
            ['id' => 66, 'name' => 'Dr. Maria Lewis', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\"]", 'department_id' => 6],
            ['id' => 67, 'name' => 'Prof. Robert Hall', 'availability' => "[\"Tuesday\",\"Thursday\",\"Friday\"]", 'department_id' => 6],
            ['id' => 68, 'name' => 'Dr. Nancy Parker', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 6],
            ['id' => 69, 'name' => 'Prof. James White', 'availability' => "[\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 6],
            ['id' => 70, 'name' => 'Dr. Brian Wilson', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 6],
            ['id' => 71, 'name' => 'Prof. Linda Turner', 'availability' => "[\"Monday\",\"Wednesday\"]", 'department_id' => 6],
            ['id' => 72, 'name' => 'Dr. Richard Evans', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 6],

            // Mathematics (8)
            ['id' => 83, 'name' => 'Dr. George Miller', 'availability' => "[\"Monday\",\"Wednesday\",\"Friday\"]", 'department_id' => 8],
            ['id' => 84, 'name' => 'Prof. Olivia Evans', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 8],
            ['id' => 85, 'name' => 'Dr. Nathaniel Carter', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 8],
            ['id' => 86, 'name' => 'Dr. Hannah Scott', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\"]", 'department_id' => 8],
            ['id' => 87, 'name' => 'Prof. Christopher Turner', 'availability' => "[\"Tuesday\",\"Thursday\",\"Friday\"]", 'department_id' => 8],
            ['id' => 88, 'name' => 'Dr. Sophia Adams', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 8],
            ['id' => 89, 'name' => 'Prof. Liam White', 'availability' => "[\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 8],
            ['id' => 90, 'name' => 'Dr. Emma Green', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 8],
            ['id' => 91, 'name' => 'Prof. Noah Hall', 'availability' => "[\"Monday\",\"Wednesday\"]", 'department_id' => 8],
            ['id' => 92, 'name' => 'Dr. Ava Wright', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 8],

            // Social Sciences (9)
            ['id' => 93, 'name' => 'Dr. Charlotte Wilson', 'availability' => "[\"Monday\",\"Wednesday\",\"Friday\"]", 'department_id' => 9],
            ['id' => 94, 'name' => 'Prof. Lucas Reed', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 9],
            ['id' => 95, 'name' => 'Dr. Grace Mitchell', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 9],
            ['id' => 96, 'name' => 'Dr. Jacob Brown', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\"]", 'department_id' => 9],
            ['id' => 97, 'name' => 'Prof. Emily Foster', 'availability' => "[\"Tuesday\",\"Thursday\",\"Friday\"]", 'department_id' => 9],
            ['id' => 98, 'name' => 'Dr. Benjamin Adams', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 9],
            ['id' => 99, 'name' => 'Prof. Amelia Parker', 'availability' => "[\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 9],
            ['id' => 100, 'name' => 'Dr. William Hughes', 'availability' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]", 'department_id' => 9],
            ['id' => 101, 'name' => 'Prof. Henry Lewis', 'availability' => "[\"Monday\",\"Wednesday\"]", 'department_id' => 9],
            ['id' => 102, 'name' => 'Dr. Ella Thompson', 'availability' => "[\"Tuesday\",\"Thursday\"]", 'department_id' => 9],
        ];

        foreach ($instructors as $instructor) {
            DB::table('instructors')->insert([
                'id' => $instructor['id'],
                'instructor_name' => $instructor['name'],
                'availability' => $instructor['availability'],
                'department_id' => $instructor['department_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
