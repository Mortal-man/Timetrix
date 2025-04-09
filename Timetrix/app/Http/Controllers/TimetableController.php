<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Classroom;
use App\Models\Timetable;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf; // Import DomPDF
use App\Helpers\AcademicHelper;


class TimetableController extends Controller
{
    /**
     * Generate an optimized timetable.
     */
    public function index()
    {
        $timetable = \App\Models\Timetable::with(['course.department', 'instructor', 'classroom'])->get();
        $instructors = \App\Models\Instructor::all();
        $faculties = \App\Models\Faculty::with('departments')->get();
        $departments = \App\Models\Department::all();

        return view('timetable.index', compact('timetable', 'instructors', 'faculties', 'departments'));
    }

    public function generate()
    {
        Timetable::truncate(); // Clear previous timetable data

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = range(7, 17); // 7 AM to 5 PM (1-hour slots)
        $courses = Course::with('instructor')->get();
        $classrooms = Classroom::orderBy('capacity', 'asc')->get(); // Sort classrooms by capacity

        $unscheduledCourses = [];
        $instructorNextAvailable = []; // Track the instructor's next available slot after scheduling

        foreach ($courses as $course) {
            $instructor = $course->instructor;
            if (!$instructor) {
                \Log::warning("Course ID: {$course->course_id} has no assigned instructor.");
                $unscheduledCourses[] = $course;
                continue;
            }

            $remainingHours = 3; // Assuming each course requires 3 hours per week
            $scheduled = false;
            $sessionOptions = [[3], [2, 1], [1, 1, 1]];
            shuffle($sessionOptions);

            foreach ($sessionOptions as $option) {
                foreach ($option as $session) {
                    foreach ($days as $day) { // Assume availability on all weekdays
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

    public function view(Request $request)
    {
        // Get academic session
        $academicSession = AcademicHelper::getCurrentAcademicSession();

        // Check if a department filter was applied
        $departmentId = $request->input('department_id');

        // Query timetable entries
        $query = Timetable::with(['course', 'instructor', 'classroom']);

        if ($departmentId) {
            $query->whereHas('course', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $timetableEntries = $query->get();

        // Prepare timetable data in grid format (Day → Hour → [entries])
        $timetableData = [];

        foreach ($timetableEntries as $entry) {
            $day = $entry->day;
            $hour = $entry->hour;

            $timetableData[$day][$hour][] = [
                'course_code' => optional($entry->course)->course_code ?? 'N/A',
                'instructor' => optional($entry->instructor)->instructor_name ?? 'N/A',
                'classroom' => optional($entry->classroom)->room_name ?? 'N/A',
            ];
        }

        // Optionally fetch department name for display
        $departmentName = null;
        if ($departmentId) {
            $department = \App\Models\Department::find($departmentId);
            $departmentName = $department ? $department->department_name : null;
        }

        return view('timetable.view', compact('timetableData', 'academicSession', 'departmentId', 'departmentName'));
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

    public function getTimetableStructure()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = range(7, 17); // 7 AM - 5 PM (Hourly slots)
        $timetableData = [];

        // Fetch all timetable entries with relationships
        $timetables = Timetable::with(['course', 'instructor', 'classroom'])->get();

        // Initialize empty structure
        foreach ($days as $day) {
            $timetableData[$day] = []; // No faculties/departments, just courses
        }

        foreach ($timetables as $entry) {
            $day = $entry->day;
            $hour = $entry->hour;

            if (!isset($timetableData[$day][$hour])) {
                $timetableData[$day][$hour] = []; // Initialize time slot
            }

            $timetableData[$day][$hour][] = [
                'course_code' => $entry->course->course_code ?? 'N/A',
                'instructor' => $entry->instructor->instructor_name ?? 'No Instructor',
                'classroom' => $entry->classroom->room_name ?? 'No Room',
            ];
        }

        return $timetableData;
    }


    public function getDepartments(Request $request)
    {
        $facultyId = $request->faculty_id;
        $departments = Department::where('faculty_id', $facultyId)->get();

        return response()->json($departments);
    }
    public function generatePdf(Request $request)
    {
        $academicSession = AcademicHelper::getCurrentAcademicSession();

        // Define available days and time slots
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = range(7, 17); // 7 AM to 5 PM

        // Check for department filter
        $departmentId = $request->input('department_id');

        $query = Timetable::with(['course', 'classroom']);

        if ($departmentId) {
            $query->whereHas('course', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $timetableEntries = $query->get();

        // Initialize timetable structure
        $timetableData = [];
        foreach ($days as $day) {
            foreach ($timeSlots as $hour) {
                $timetableData[$day][$hour] = []; // Empty by default
            }
        }

        // Fill with actual entries
        foreach ($timetableEntries as $entry) {
            $day = $entry->day;
            $hour = (int) $entry->hour;

            if (isset($timetableData[$day][$hour])) {
                $timetableData[$day][$hour][] = [
                    'course_code' => optional($entry->course)->course_code ?? 'N/A',
                    'classroom' => optional($entry->classroom)->room_name ?? 'N/A',
                ];
            }
        }

        // PDF metadata
        $institutionName = "Egerton University";
        $title = "Teaching Master Timetable";
        $semester = $academicSession['semester'];
        $academicYear = $academicSession['academic_year'];
        $effectiveDate = date('F j, Y');

        // Department name (optional)
        $departmentName = null;
        if ($departmentId) {
            $department = \App\Models\Department::find($departmentId);
            $departmentName = $department ? $department->department_name : null;
        }

        $pdf = Pdf::loadView('pdf', compact(
            'institutionName',
            'title',
            'semester',
            'academicYear',
            'effectiveDate',
            'timetableData',
            'timeSlots',
            'days',
            'departmentName'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('timetable.pdf');
    }

}
