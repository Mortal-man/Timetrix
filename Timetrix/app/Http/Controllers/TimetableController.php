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
// Track the instructor's next available slot after scheduling
        $instructorNextAvailable = [];

        foreach ($courses as $course) {
            $instructor = $course->instructor;
            if (!$instructor) {
                \Log::warning("Course ID: {$course->course_id} has no assigned instructor.");
                $unscheduledCourses[] = $course;
                continue;
            }

            $availability = json_decode($instructor->availability, true);
            if (!$availability || empty($availability)) {
                \Log::warning("Instructor ID: {$instructor->instructor_id} has no availability set for Course ID: {$course->course_id}.");
                $unscheduledCourses[] = $course;
                continue;
            }

            $remainingHours = 3;
            $scheduled = false;
            $sessionOptions = [[3], [2, 1], [1, 1, 1]];
            shuffle($sessionOptions);

            foreach ($sessionOptions as $option) {
                foreach ($option as $session) {
                    foreach ($availability as $day) { // Prioritize instructor's available days
                        if ($remainingHours <= 0) break;

                        $nextAvailableHour = $instructorNextAvailable[$instructor->instructor_id][$day] ?? 7; // Default to 7 AM

                        foreach ($timeSlots as $hour) {
                            if ($hour < $nextAvailableHour) continue; // Skip slots before the instructor's next availability
                            if ($remainingHours <= 0 || ($hour + $session - 1) > 17) break; // Prevent overflow past 5 PM

                            foreach ($classrooms as $classroom) {
                                if ($classroom->capacity < $course->student_enrollment) continue;

                                $instructorBooked = Timetable::where('day', $day)
                                    ->whereBetween('hour', [$hour, $hour + $session - 1])
                                    ->where('instructor_id', $instructor->instructor_id)
                                    ->exists();

                                if ($instructorBooked) continue;

                                $slotTaken = Timetable::where('day', $day)
                                    ->whereBetween('hour', [$hour, $hour + $session - 1])
                                    ->where('classroom_id', $classroom->classroom_id)
                                    ->exists();

                                if ($slotTaken) continue;

                                // Schedule the course
                                for ($i = 0; $i < $session; $i++) {
                                    Timetable::create([
                                        'day' => $day,
                                        'hour' => $hour + $i,
                                        'course_id' => $course->course_id,
                                        'instructor_id' => $instructor->instructor_id,
                                        'classroom_id' => $classroom->classroom_id,
                                    ]);
                                }

                                // Update instructor’s next availability
                                $instructorNextAvailable[$instructor->instructor_id][$day] = $hour + $session;

                                $remainingHours -= $session;
                                $scheduled = true;
                                break 3;
                            }
                        }
                    }
                }
            }

            if (!$scheduled) {
                \Log::warning("Course ID: {$course->course_id} could not be scheduled.");
                $unscheduledCourses[] = $course;
            }
        }


        session(['unscheduled_courses' => $unscheduledCourses]);

        if (!empty($unscheduledCourses)) {
            return redirect()->route('timetable.manual')->with('warning', 'Some courses could not be scheduled. Please assign them manually.');
        }

        return redirect()->route('timetable.index')->with('success', 'Timetable generated successfully!');
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
            'course_id' => 'required |exists:courses,course_id',
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
