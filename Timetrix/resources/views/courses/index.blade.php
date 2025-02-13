@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Courses</h1>

        <a href="{{ route('courses.create') }}" class="btn btn-success mb-3">Add Course</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Department</th>
                <th>Instructor</th>
                <th>Enrollment</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->course_id }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->department->department_name ?? 'N/A' }}</td>
                    <td>{{ $course->instructor->instructor_name ?? 'N/A' }}</td>
                    <td>{{ $course->student_enrollment }}</td>
                    <td>{{ $course->semester }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course->course_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('courses.destroy', $course->course_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $courses->links() }}
    </div>
@endsection
