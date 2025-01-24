@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Add Course</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Department</th>
                <th>Credits</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->course_id }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->department->department_name ?? 'N/A' }}</td>
                    <td>{{ $course->credits }}</td>
                    <td>{{ $course->semester }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No courses found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $courses->links() }}
    </div>
@endsection
