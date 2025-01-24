@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Course</h1>
    <form action="{{ route('courses.update', $course) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" id="course_name" value="{{ $course->course_name }}" required>
        </div>
        <div class="mb-3">
            <label for="course_code" class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" id="course_code" value="{{ $course->course_code }}" required>
        </div>
        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <select name="department_id" id="department_id" class="form-control" required>
                @foreach($departments as $department)
                <option value="{{ $department->department_id }}" {{ $course->department_id == $department->department_id ? 'selected' : '' }}>
                    {{ $department->department_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="credits" class="form-label">Credits</label>
            <input type="number" name="credits" class="form-control" id="credits" value="{{ $course->credits }}" required>
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <input type="text" name="semester" class="form-control" id="semester" value="{{ $course->semester }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
