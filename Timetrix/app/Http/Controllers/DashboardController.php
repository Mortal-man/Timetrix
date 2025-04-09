<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Instructor;
use App\Models\Classroom;
use App\Models\Course;
use App\Helpers\AcademicHelper;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data for the cards
        $totalFaculties = Faculty::count();
        $totalDepartments = Department::count();
        $totalInstructors = Instructor::count();
        $totalClassrooms = Classroom::count();
        $totalCourses = Course::count();

        // Get the current semester using the AcademicHelper
        $currentSemester = AcademicHelper::getCurrentAcademicSession();

        // Fetch departments with their courses' enrollment sums
        $departments = Department::with(['courses' => function($query) {
            $query->select('department_id', 'student_enrollment');
        }])->get();

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($departments as $department) {
            $totalEnrollment = $department->courses->sum('student_enrollment');

            if ($totalEnrollment > 0) { // Only include departments with enrollment
                // Remove the prefix "Department of" from the department name
                $label = str_replace('Department of ', '', $department->department_name);

                // Add the modified department name and its enrollment data
                $chartData['labels'][] = $label;
                $chartData['data'][] = $totalEnrollment;
            }
        }

        // Return the view with the data
        return view('dashboard', compact(
            'totalFaculties',
            'totalDepartments',
            'totalInstructors',
            'totalClassrooms',
            'totalCourses',
            'chartData',
            'currentSemester'
        ));
    }
}
