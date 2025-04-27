<?php

namespace App\Http\Controllers;

use App\Helpers\AcademicHelper;
use App\Models\Faculty;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Department;
use App\Models\Classroom;
use App\Models\Institution;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Models\Timetable;

class ReportController extends Controller
{
    // Live‐HTML view (with preview & download buttons)
    public function instructorWorkload(Request $request)
    {
        $facultyId    = $request->get('faculty_id');
        $departmentId = $request->get('department_id');

        $faculties      = Faculty::all();
        $allDepartments = Department::all();

        // For the filters in the HTML page
        $instructors = Instructor::with(['timetable' => function ($q) use ($departmentId) {
            $q->join('courses','courses.course_id','=','timetables.course_id')
                ->when($departmentId, fn($q)=> $q->where('courses.department_id',$departmentId))
                ->select('timetables.*','courses.course_name','courses.course_code');
        }])
            ->when($departmentId, fn($q)=> $q->where('department_id',$departmentId))
            ->get();

        return view('reports.academic.instructor_workload', compact(
            'faculties','allDepartments','instructors'
        ));
    }

    // PDF generation (for both preview & download)
    public function instructorWorkloadPdf(Request $request)
    {
        $facultyId    = $request->get('faculty_id');
        $departmentId = $request->get('department_id');

        // institution info
        $institution = Institution::first();
        $sessionData = AcademicHelper::getCurrentAcademicSession();

        // resolve names
        $facultyName    = $facultyId    ? Faculty::find($facultyId)->faculty_name    : 'All Faculties';
        $departmentName = $departmentId ? Department::find($departmentId)->department_name : 'All Departments';

        // same data logic as HTML
        $instructors = Instructor::with(['timetable' => function ($q) use ($departmentId) {
            $q->join('courses','courses.course_id','=','timetables.course_id')
                ->when($departmentId, fn($q)=> $q->where('courses.department_id',$departmentId))
                ->select('timetables.*','courses.course_name','courses.course_code');
        }])
            ->when($departmentId, fn($q)=> $q->where('department_id',$departmentId))
            ->get();

        $pdf = Pdf::loadView('reports.academic.pdf.instructor_workload', [
            'institution'    => $institution,
            'semester'       => $sessionData['semester'],
            'academicYear'   => $sessionData['academic_year'],
            'facultyName'    => $facultyName,
            'departmentName' => $departmentName,
            'effectiveDate'  => Carbon::now()->format('F j, Y'),
            'instructors'    => $instructors,
        ])
            ->setPaper('A4','portrait');

        // for inline preview, return stream; for download, return download()
        if ($request->get('preview')) {
            return $pdf->stream('Instructor_Workload_Report.pdf');
        }

        return $pdf->download('Instructor_Workload_Report.pdf');
    }
  // Course Offering Summary Report
    public function courseOfferingSummary(Request $request)
    {
        $facultyId    = $request->get('faculty_id');
        $departmentId = $request->get('department_id');

        $faculties      = Faculty::all();
        $allDepartments = Department::all();

        $courses = Course::with(['instructor', 'department.faculty'])
            ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
            ->get();

        return view('reports.academic.course_offering_summary', compact(
            'courses', 'faculties', 'allDepartments', 'facultyId', 'departmentId'
        ));
    }

    public function courseOfferingSummaryPdf(Request $request)
    {
        $facultyId    = $request->get('faculty_id');
        $departmentId = $request->get('department_id');

        $institution = Institution::first();
        $session     = AcademicHelper::getCurrentAcademicSession();

        $facultyName    = $facultyId ? Faculty::find($facultyId)->faculty_name : 'All Faculties';
        $departmentName = $departmentId ? Department::find($departmentId)->department_name : 'All Departments';

        $courses = Course::with(['instructor', 'department.faculty'])
            ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
            ->get();

        $pdf = Pdf::loadView('reports.academic.pdf.course_offering_summary', [
            'courses'        => $courses,
            'institution'    => $institution,
            'semester'       => $session['semester'],
            'academicYear'   => $session['academic_year'],
            'facultyName'    => $facultyName,
            'departmentName' => $departmentName,
            'effectiveDate'  => now()->format('F j, Y'),
        ])->setPaper('A4', 'portrait');

        return $request->get('preview')
            ? $pdf->stream('Course_Offering_Summary.pdf')
            : $pdf->download('Course_Offering_Summary.pdf');
    }
    // Student Enrollment per Course
    public function enrollmentSummary(Request $request)
    {
        $search = $request->get('search');

        $departments = Department::with(['courses' => function ($q) {
            $q->select('department_id', 'student_enrollment');
        }])
            ->when($search, fn($q) => $q->where('department_name', 'like', "%{$search}%"))
            ->get();

        // If AJAX, return the minimal JSON payload
        if ($request->ajax()) {
            return $departments->map(fn($dept) => [
                'department_name'   => $dept->department_name,
                'faculty_name'      => $dept->faculty->faculty_name,
                'total_enrollment'  => $dept->courses->sum('student_enrollment'),
            ]);
        }

        // Otherwise, render full HTML view
        return view('reports.academic.enrollment_summary', [
            'departments'    => $departments,
        ]);
    }

    public function enrollmentSummaryPdf(Request $request)
    {
        // Get faculty and department IDs from request
        $facultyId = $request->get('faculty_id');
        $departmentId = $request->get('department_id');

        // Get the institution details
        $institution = Institution::first();
        $session = AcademicHelper::getCurrentAcademicSession();

        // Get the faculty and department names, with defaults if not selected
        $facultyName = $facultyId ? Faculty::find($facultyId)->faculty_name : 'All Faculties';
        $departmentName = $departmentId ? Department::find($departmentId)->department_name : 'All Departments';

        // Fetch the departments with their courses' enrollment sums
        $departments = Department::with(['courses' => function ($q) {
            $q->select('department_id', 'student_enrollment');
        }])
            ->when($facultyId, fn($q) => $q->where('faculty_id', $facultyId))
            ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
            ->get();

        // Prepare the PDF view data
        $pdf = Pdf::loadView('reports.academic.pdf.enrollment_summary', [
            'departments'    => $departments,
            'institution'    => $institution,
            'semester'       => $session['semester'],
            'academicYear'   => $session['academic_year'],
            'facultyName'    => $facultyName,
            'departmentName' => $departmentName,
            'effectiveDate'  => now()->format('F j, Y'),
        ])->setPaper('A4', 'portrait');

        // Return the PDF preview or download based on the request
        return $request->get('preview')
            ? $pdf->stream('Student_Enrollment_Summary.pdf')
            : $pdf->download('Student_Enrollment_Summary.pdf');
    }
    public function instructorTimetable(Request $request)
    {
        $faculties      = Faculty::with('departments')->get();
        $allDepartments = Department::all();
        $allInstructors = Instructor::all();           // ← add this

        $instructorId   = $request->get('instructor_id');

        $timetableEntries = collect();
        if ($instructorId) {
            $entries = Timetable::with(['course', 'classroom'])
                ->where('instructor_id', $instructorId)
                ->whereBetween('hour', [7, 17])
                ->get();

            $timetableEntries = $entries->groupBy('day');
        }

        return view('reports.academic.instructor_timetable', compact(
            'faculties',
            'allDepartments',
            'allInstructors',     // ← and include it here
            'instructorId',
            'timetableEntries'
        ));
    }

    public function instructorTimetablePdf(Request $request)
    {
        $facultyId     = $request->get('faculty_id');
        $departmentId  = $request->get('department_id');
        $instructorId  = $request->get('instructor_id');

        $institution   = Institution::first();
        $session       = AcademicHelper::getCurrentAcademicSession();
        $facultyName   = $facultyId ? Faculty::find($facultyId)->faculty_name : 'All Faculties';
        $departmentName= $departmentId ? Department::find($departmentId)->department_name : 'All Departments';
        $instructor    = $instructorId ? Instructor::find($instructorId) : null;
        $instructorName= $instructor?->instructor_name ?? 'All Instructors';

        $entries = Timetable::with(['course', 'classroom'])
            ->when($instructorId, fn($q) => $q->where('instructor_id', $instructorId))
            ->whereBetween('hour', [7, 17])
            ->get();

        $timetableEntries = $entries->groupBy('day');

        $pdf = Pdf::loadView('reports.academic.pdf.instructor_timetable', [
            'timetableEntries' => $timetableEntries,
            'institution'      => $institution,
            'semester'         => $session['semester'],
            'academicYear'     => $session['academic_year'],
            'facultyName'      => $facultyName,
            'departmentName'   => $departmentName,
            'instructorName'   => $instructorName,
            'effectiveDate'    => now()->format('F j, Y'),
        ])->setPaper('A4', 'portrait');

        return $request->get('preview')
            ? $pdf->stream('Instructor_Timetable.pdf')
            : $pdf->download('Instructor_Timetable.pdf');
    }

    public function academicDashboard()
    {
        return view('reports.academic'); // resources/views/reports/academic.blade.php
    }
}
