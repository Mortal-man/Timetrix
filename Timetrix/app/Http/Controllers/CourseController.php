<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Faculty;
class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'department']);

        // Department filter
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('course_name', 'like', "%$search%")
                    ->orWhere('course_code', 'like', "%$search%")
                    ->orWhereHas('instructor', function($q) use ($search) {
                        $q->where('instructor_name', 'like', "%$search%");
                    });
            });
        }

        $courses = $query->paginate(10);
        $departments = Department::all();
        $faculties = Faculty::with('departments')->get();

        return view('courses.index', compact('courses', 'departments', 'faculties'));
    }
    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $departments = Department::all();
        $instructors = Instructor::all();
        return view('courses.create', compact('departments', 'instructors'));
    }

    /**
     * Store a newly created course in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255|unique:courses,course_code',
            'instructor_id' => 'required|exists:instructors,instructor_id', // Ensure instructor exists
            'student_enrollment' => 'required|integer|min:1|max:400',
            'department_id' => 'required|exists:departments,department_id', // Ensure department exists
        ]);

        Course::create([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
            'instructor_id' => $request->instructor_id,
            'student_enrollment' => $request->student_enrollment,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $departments = Department::all();
        $instructors = Instructor::all();
        return view('courses.edit', compact('course', 'departments', 'instructors'));
    }

    /**
     * Update the specified course in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255|unique:courses,course_code,' . $id . ',course_id',
            'instructor_id' => 'required|exists:instructors,instructor_id',
            'student_enrollment' => 'required|integer|min:1',
            'department_id' => 'required|exists:departments,department_id',
        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code,
            'instructor_id' => $request->instructor_id,
            'student_enrollment' => $request->student_enrollment,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from the database.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
    public function getInstructorsByDepartment($department_id)
    {
        $instructors = Instructor::where('department_id', $department_id)->get(['instructor_id', 'instructor_name']);
        return response()->json($instructors);
    }

}
