<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('department')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('courses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:10|unique:courses,course_code',
            'department_id' => 'required|exists:departments,department_id',
            'credits' => 'required|integer|min:1|max:10',
            'semester' => 'required|string|max:10',
        ]);

        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $departments = Department::all();
        return view('courses.edit', compact('course', 'departments'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => "required|string|max:10|unique:courses,course_code,{$course->course_id},course_id",
            'department_id' => 'required|exists:departments,department_id',
            'credits' => 'required|integer|min:1|max:10',
            'semester' => 'required|string|max:10',
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
