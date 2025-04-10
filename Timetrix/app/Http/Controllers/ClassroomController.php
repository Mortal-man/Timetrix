<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the classrooms.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve classrooms with pagination
        $classrooms = Classroom::paginate(10);
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new classroom.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('classrooms.create');
    }

    /**
     * Store a newly created classroom in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'room_name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        // Create a new classroom record
        Classroom::create([
            'room_name' => $request->room_name,
            'capacity' => $request->capacity,
        ]);

        // Redirect with success message
        return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully.');
    }

    /**
     * Show the form for editing the specified classroom.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\View\View
     */
    public function edit(Classroom $classroom)
    {
        return view('classrooms.edit', compact('classroom'));
    }

    /**
     * Update the specified classroom in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Classroom $classroom)
    {
        // Validate the incoming request
        $request->validate([
            'room_name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        // Update the classroom record
        $classroom->update([
            'room_name' => $request->room_name,
            'capacity' => $request->capacity,
        ]);

        // Redirect with success message
        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    /**
     * Remove the specified classroom from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Classroom $classroom)
    {
        // Delete the classroom record
        $classroom->delete();

        // Redirect with success message
        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted successfully.');
    }
}
