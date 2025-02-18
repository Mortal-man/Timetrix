<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // Computer Science (Department 2)
            ['name' => 'Introduction to Programming', 'code' => 'CS101', 'instructor_id' => 53, 'enrollment' => 30, 'department_id' => 2, 'semester' => '1.1'],
            ['name' => 'Data Structures', 'code' => 'CS102', 'instructor_id' => 54, 'enrollment' => 25, 'department_id' => 2, 'semester' => '1.1'],
            ['name' => 'Algorithms', 'code' => 'CS201', 'instructor_id' => 55, 'enrollment' => 20, 'department_id' => 2, 'semester' => '2.1'],
            ['name' => 'Database Systems', 'code' => 'CS202', 'instructor_id' => 56, 'enrollment' => 22, 'department_id' => 2, 'semester' => '2.1'],
            ['name' => 'Web Development', 'code' => 'CS301', 'instructor_id' => 57, 'enrollment' => 28, 'department_id' => 2, 'semester' => '3.1'],
            ['name' => 'Software Engineering', 'code' => 'CS302', 'instructor_id' => 58, 'enrollment' => 18, 'department_id' => 2, 'semester' => '3.1'],
            ['name' => 'Operating Systems', 'code' => 'CS401', 'instructor_id' => 59, 'enrollment' => 15, 'department_id' => 2, 'semester' => '4.1'],
            ['name' => 'Computer Networks', 'code' => 'CS402', 'instructor_id' => 60, 'enrollment' => 10, 'department_id' => 2, 'semester' => '4.1'],
            ['name' => 'Mobile App Development', 'code' => 'CS403', 'instructor_id' => 61, 'enrollment' => 12, 'department_id' => 2, 'semester' => '1.1'],
            ['name' => 'Machine Learning', 'code' => 'CS404', 'instructor_id' => 62, 'enrollment' => 14, 'department_id' => 2, 'semester' => '1.1'],

            // Psychology (Department 6)
            ['name' => 'Introduction to Psychology', 'code' => 'PSY101', 'instructor_id' => 63, 'enrollment' => 35, 'department_id' => 6, 'semester' => '1.1'],
            ['name' => 'Cognitive Psychology', 'code' => 'PSY102', 'instructor_id' => 64, 'enrollment' => 30, 'department_id' => 6, 'semester' => '1.1'],
            ['name' => 'Developmental Psychology', 'code' => 'PSY201', 'instructor_id' => 65, 'enrollment' => 28, 'department_id' => 6, 'semester' => '2.1'],
            ['name' => 'Social Psychology', 'code' => 'PSY202', 'instructor_id' => 66, 'enrollment' => 25, 'department_id' => 6, 'semester' => '2.1'],
            ['name' => 'Abnormal Psychology', 'code' => 'PSY301', 'instructor_id' => 67, 'enrollment' => 20, 'department_id' => 6, 'semester' => '3.1'],
            ['name' => 'Research Methods', 'code' => 'PSY302', 'instructor_id' => 68, 'enrollment' => 22, 'department_id' => 6, 'semester' => '3.1'],
            ['name' => 'Clinical Psychology', 'code' => 'PSY401', 'instructor_id' => 69, 'enrollment' => 18, 'department_id' => 6, 'semester' => '4.1'],
            ['name' => 'Industrial Psychology', 'code' => 'PSY402', 'instructor_id' => 70, 'enrollment' => 15, 'department_id' => 6, 'semester' => '4.1'],

            // Sociology (Department 7)
            ['name' => 'Introduction to Sociology', 'code' => 'SOC101', 'instructor_id' => 73, 'enrollment' => 40, 'department_id' => 7, 'semester' => '1.1'],
            ['name' => 'Social Theory', 'code' => 'SOC102', 'instructor_id' => 74, 'enrollment' => 35, 'department_id' => 7, 'semester' => '1.1'],
            ['name' => 'Research Methods in Sociology', 'code' => 'SOC201', 'instructor_id' => 75, 'enrollment' => 30, 'department_id' => 7, 'semester' => '2.1'],
            ['name' => 'Urban Sociology', 'code' => 'SOC202', 'instructor_id' => 76, 'enrollment' => 28, 'department_id' => 7, 'semester' => '2.1'],
            ['name' => 'Rural Sociology', 'code' => 'SOC301', 'instructor_id' => 77, 'enrollment' => 25, 'department_id' => 7, 'semester' => '3.1'],
            ['name' => 'Sociology of Education', 'code' => 'SOC302', 'instructor_id' => 78, 'enrollment' => 22, 'department_id' => 7, 'semester' => '3.1'],
            ['name' => 'Sociology of Health', 'code' => 'SOC401', 'instructor_id' => 79, 'enrollment' => 20, 'department_id' => 7, 'semester' => '4.1'],
            ['name' => 'Political Sociology', 'code' => 'SOC402', 'instructor_id' => 80, 'enrollment' => 18, 'department_id' => 7, 'semester' => '4.1'],

            // Business (Department 8)
            ['name' => 'Introduction to Business', 'code' => 'BUS101', 'instructor_id' => 83, 'enrollment' => 50, 'department_id' => 8, 'semester' => '1.1'],
            ['name' => 'Marketing Principles', 'code' => 'BUS102', 'instructor_id' => 84, 'enrollment' => 45, 'department_id' => 8, 'semester' => '1.1'],
            ['name' => 'Financial Accounting', 'code' => 'BUS201', 'instructor_id' => 85, 'enrollment' => 40, 'department_id' => 8, 'semester' => '2.1'],
            ['name' => 'Managerial Accounting', 'code' => 'BUS202', 'instructor_id' => 86, 'enrollment' => 35, 'department_id' => 8, 'semester' => '2.1'],
            ['name' => 'Business Law', 'code' => 'BUS301', 'instructor_id' => 87, 'enrollment' => 30, 'department_id' => 8, 'semester' => '3.1'],
            ['name' => 'Organizational Behavior', 'code' => 'BUS302', 'instructor_id' => 88, 'enrollment' => 25, 'department_id' => 8, 'semester' => '3.1'],
        ];

        foreach ($courses as $course) {
            DB::table('courses')->insert([
                'course_name' => $course['name'],
                'course_code' => $course['code'],
                'instructor_id' => $course['instructor_id'],
                'student_enrollment' => $course['enrollment'],
                'department_id' => $course['department_id'],
                'semester' => $course['semester'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
