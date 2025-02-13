<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index()
    {
        $departments = Department::with('faculty')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        $faculties = Faculty::all(); // Retrieve all faculties for dropdown
        return view('departments.create', compact('faculties'));
    }

    /**
     * Store a newly created department in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255|unique:departments,department_name',
            'department_code' => 'required|string|max:255|unique:departments,department_code',
            'faculty_id' => 'required|exists:faculties,faculty_id', // Ensures faculty exists
            'head_of_department' => 'required|string|max:255',
        ]);

        Department::create([
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'faculty_id' => $request->faculty_id, // Faculty selected from dropdown
            'head_of_department' => $request->head_of_department,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department added successfully.');
    }
    /**
     * Show the form for editing the specified department.
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $faculties = Faculty::all(); // Retrieve all faculties for dropdown

        return view('departments.edit', compact('department', 'faculties'));
    }


    /**
     * Update the specified department in the database.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'department_code' => 'required|string|max:255|unique:departments,department_code,' . $department->department_id . ',department_id',
            'faculty_id' => 'required|exists:faculties,id',
            'head_of_department' => 'required|string|max:255',
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department from the database.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
