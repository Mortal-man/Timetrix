<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::with(['user', 'department'])->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        $users = User::all();
        $departments = Department::all();
        return view('instructors.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'expertise' => 'required|string|max:255',
            'availability' => 'required|json',
            'department_id' => 'required|exists:departments,department_id',
        ]);

        Instructor::create($request->all());
        return redirect()->route('instructors.index')->with('success', 'Instructor created successfully.');
    }

    public function edit(Instructor $instructor)
    {
        $users = User::all();
        $departments = Department::all();
        return view('instructors.edit', compact('instructor', 'users', 'departments'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'expertise' => 'required|string|max:255',
            'availability' => 'required|json',
            'department_id' => 'required|exists:departments,department_id',
        ]);

        $instructor->update($request->all());
        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully.');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully.');
    }
}
