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
        Timetable::truncate();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = range(7, 17); // 7 AM to 5 PM
        $courses = Course::with('instructor')->get();
        $classrooms = Classroom::orderBy('capacity', 'asc')->get();

        $unscheduledCourses = [];

        foreach ($courses as $course) {
            $instructor = $course->instructor;
            if (!$instructor) {
                $unscheduledCourses[] = $course;
                continue;
            }

            $availability = json_decode($instructor->availability, true);
            $remainingHours = 3;
            $scheduled = false;

            $sessionOptions = [[3], [2, 1], [1, 1, 1]];
            shuffle($sessionOptions);

            foreach ($sessionOptions as $option) {
                foreach ($option as $session) {
                    foreach ($days as $day) {
                        if ($remainingHours <= 0) break;
                        if (!isset($availability[$day]) || empty($availability[$day])) continue;

                        foreach ($timeSlots as $hour) {
                            if ($remainingHours <= 0) break;
                            if (!in_array($hour, $availability[$day])) continue;

                            $validSlot = true;
                            for ($i = 0; $i < $session; $i++) {
                                if (!in_array($hour + $i, $availability[$day])) {
                                    $validSlot = false;
                                    break;
                                }
                            }

                            if (!$validSlot) continue;

                            $instructorBooked = Timetable::where('day', $day)
                                ->where('hour', $hour)
                                ->where('instructor_id', $instructor->instructor_id)
                                ->exists();

                            if ($instructorBooked) continue;

                            $classroom = $classrooms->firstWhere('capacity', '>=', $course->student_enrollment);
                            if (!$classroom) continue;

                            $slotTaken = Timetable::where('day', $day)
                                ->where('hour', $hour)
                                ->where('classroom_id', $classroom->id)
                                ->exists();

                            if ($slotTaken) continue;

                            for ($i = 0; $i < $session; $i++) {
                                Timetable::create([
                                    'day' => $day,
                                    'hour' => $hour + $i,
                                    'course_id' => $course->course_id,
                                    'instructor_id' => $instructor->instructor_id,
                                    'classroom_id' => $classroom->id,
                                ]);
                            }

                            $remainingHours -= $session;
                            $scheduled = true;
                        }
                    }
                }
            }

            if (!$scheduled) {
                $unscheduledCourses[] = $course;
            }
        }

        // Store unscheduled courses in the session
        session(['unscheduled_courses' => $unscheduledCourses]);

        if (count($unscheduledCourses) > 0) {
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
