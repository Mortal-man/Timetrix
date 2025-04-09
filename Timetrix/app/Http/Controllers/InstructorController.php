<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Department;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Display a listing of instructors.
     */
    public function index()
    {
        $instructors = Instructor::with('department')->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new instructor.
     */
    public function create()
    {
        $departments = Department::all();
        return view('instructors.create', compact('departments'));
    }

    /**
     * Store a newly created instructor in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'instructor_name' => 'required|string|max:255',
            //'availability' => 'required|array|min:1', // Must select at least one weekday
            //'availability.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday', // Restrict to weekdays
            'department_id' => 'required|exists:departments,department_id', // Ensure it exists
        ]);

        Instructor::create([
            'instructor_name' => $request->instructor_name,
            //'availability' => json_encode($request->availability), // Store as JSON
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('instructors.index')->with('success', 'Instructor added successfully.');
    }

    /**
     * Show the form for editing an instructor.
     */
    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        $departments = Department::all();
        return view('instructors.edit', compact('instructor', 'departments'));
    }

    /**
     * Update the specified instructor in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'instructor_name' => 'required|string|max:255',
            //'availability' => 'required|array|min:1',
            //'availability.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'department_id' => 'required|exists:departments,department_id',
        ]);

        $instructor = Instructor::findOrFail($id);
        $instructor->update([
            'instructor_name' => $request->instructor_name,
            //'availability' => json_encode($request->availability),
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully.');
    }

    /**
     * Remove the specified instructor from the database.
     */
    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();
        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully.');
    }
}
