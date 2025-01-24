<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Classroom;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $timetables = Timetable::with(['course', 'instructor', 'classroom', 'schedule'])->paginate(10);
        return view('timetables.index', compact('timetables'));
    }

    public function create()
    {
        $courses = Course::all();
        $instructors = Instructor::all();
        $classrooms = Classroom::all();
        $schedules = Schedule::all();

        return view('timetables.create', compact('courses', 'instructors', 'classrooms', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'instructor_id' => 'required|exists:instructors,instructor_id',
            'classroom_id' => 'required|exists:classrooms,classroom_id',
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'semester' => 'required|string|max:255',
            'status' => 'required|in:Active,Archived',
        ]);

        Timetable::create($request->all());
        return redirect()->route('timetables.index')->with('success', 'Timetable created successfully.');
    }

    public function edit(Timetable $timetable)
    {
        $courses = Course::all();
        $instructors = Instructor::all();
        $classrooms = Classroom::all();
        $schedules = Schedule::all();

        return view('timetables.edit', compact('timetable', 'courses', 'instructors', 'classrooms', 'schedules'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'instructor_id' => 'required|exists:instructors,instructor_id',
            'classroom_id' => 'required|exists:classrooms,classroom_id',
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'semester' => 'required|string|max:255',
            'status' => 'required|in:Active,Archived',
        ]);

        $timetable->update($request->all());
        return redirect()->route('timetables.index')->with('success', 'Timetable updated successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('timetables.index')->with('success', 'Timetable deleted successfully.');
    }
}
