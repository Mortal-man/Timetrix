<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Classroom;
use App\Models\Timetable;

class TimetableController extends Controller
{
    /**
     * Generate an optimized timetable.
     */
    public function index()
    {
        $timetable = \App\Models\Timetable::with(['course', 'instructor', 'classroom'])->get();
        return view('timetable.index', compact('timetable'));
    }
    public function generate()
    {
        Timetable::truncate(); // Clear previous timetable data

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = range(7, 17); // 7 AM to 5 PM (1-hour slots)
        $courses = Course::with('instructor')->get();
        $classrooms = Classroom::orderBy('capacity', 'asc')->get(); // Sort classrooms by capacity

        $unscheduledCourses = [];

        foreach ($courses as $course) {
            $instructor = $course->instructor;
            if (!$instructor) {
                \Log::warning("Course ID: {$course->course_id} has no assigned instructor.");
                $unscheduledCourses[] = $course;
                continue;
            }

            // Decode availability (stored as available days, not time slots)
            $availability = json_decode($instructor->availability, true);
            if (!$availability || empty($availability)) {
                \Log::warning("Instructor ID: {$instructor->instructor_id} has no availability set.");
                $unscheduledCourses[] = $course;
                continue;
            }

            $remainingHours = 3; // Each course requires 3 hours per week
            $scheduled = false;

            // Prioritize session splitting options (3hr, 2+1hr, 1+1+1hr)
            $sessionOptions = [[3], [2, 1], [1, 1, 1]];
            shuffle($sessionOptions);

            foreach ($sessionOptions as $option) {
                foreach ($option as $session) {
                    foreach ($days as $day) {
                        if ($remainingHours <= 0) break;
                        if (!in_array($day, $availability)) continue; // Check if instructor is available on this day

                        foreach ($timeSlots as $hour) {
                            if ($remainingHours <= 0) break;

                            // Ensure the instructor isn't already scheduled at this time
                            $instructorBooked = Timetable::where('day', $day)
                                ->where('hour', $hour)
                                ->where('instructor_id', $instructor->instructor_id)
                                ->exists();

                            if ($instructorBooked) continue;

                            // Find an available classroom with enough capacity
                            $classroom = $classrooms->firstWhere('capacity', '>=', $course->student_enrollment);

                            if (!$classroom) {
                                \Log::error("No classroom found for Course ID: {$course->course_id}. Required capacity: {$course->student_enrollment}. Available classrooms: " . $classrooms->pluck('capacity')->toJson());
                                continue; // Skip scheduling this session
                            } else {
                                \Log::info("Classroom found for Course ID: {$course->course_id}: Classroom ID: {$classroom->id}, Capacity: {$classroom->capacity}");
                            }

                            // Ensure the classroom isn't already booked at this time
                            $slotTaken = Timetable::where('day', $day)
                                ->where('hour', $hour)
                                ->where('classroom_id', $classroom->id)
                                ->exists();

                            if ($slotTaken) continue;

                            // Schedule the course in this time slot
                            for ($i = 0; $i < $session; $i++) {
                                Timetable::create([
                                    'day' => $day,
                                    'hour' => $hour + $i,
                                    'course_id' => $course->course_id,
                                    'instructor_id' => $instructor->instructor_id,
                                    'classroom_id' => $classroom->id, // Ensure classroom_id is not null
                                ]);
                            }

                            $remainingHours -= $session;
                            $scheduled = true;
                            break 2; // Move to the next session set
                        }
                    }
                }
            }

            if (!$scheduled) {
                \Log::warning("Course ID: {$course->course_id} could not be scheduled.");
                $unscheduledCourses[] = $course;
            }
        }

        // Store unscheduled courses in the session
        session(['unscheduled_courses' => $unscheduledCourses]);

        if (!empty($unscheduledCourses)) {
            return redirect()->route('timetable.manual')->with('warning', 'Some courses could not be scheduled. Please assign them manually.');
        }
    }
    public function manual()
    {
        $unscheduledCourses = session('unscheduled_courses', []);
        $instructors = Instructor::all();
        $classrooms = Classroom::orderBy('capacity', 'asc')->get();

        return view('timetable.manual', compact('unscheduledCourses', 'instructors', 'classrooms'));
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'hour' => 'required|integer|min:7|max:17',
            'instructor_id' => 'required|exists:instructors,instructor_id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        Timetable::create([
            'day' => $request->day,
            'hour' => $request->hour,
            'course_id' => $request->course_id,
            'instructor_id' => $request->instructor_id,
            'classroom_id' => $request->classroom_id,
        ]);

        return redirect()->route('timetable.manual')->with('success', 'Course manually scheduled successfully!');
    }
    public function view()
    {
        $timetable = Timetable::with(['course', 'instructor', 'classroom'])->get();
        $courses = Course::all();
        $instructors = Instructor::all();
        $classrooms = Classroom::orderBy('capacity', 'asc')->get();

        return view('timetable.view', compact('timetable', 'courses', 'instructors', 'classrooms'));
    }
    public function updateEntry(Request $request)
    {
        $request->validate([
            'entry_id' => 'required|exists:timetables,id',
            'course_id' => 'required|exists:courses,course_id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'hour' => 'required|integer|min:7|max:17',
            'instructor_id' => 'required|exists:instructors,instructor_id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $entry = Timetable::findOrFail($request->entry_id);
        $entry->update([
            'course_id' => $request->course_id,
            'day' => $request->day,
            'hour' => $request->hour,
            'instructor_id' => $request->instructor_id,
            'classroom_id' => $request->classroom_id,
        ]);

        return redirect()->route('timetable.view')->with('success', 'Timetable updated successfully!');
    }


}
