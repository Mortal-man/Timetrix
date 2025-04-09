@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Instructors</h1>
        <a href="{{ route('instructors.create') }}" class="btn btn-primary mb-3">Add Instructor</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->instructor_name }}</td>
                    <td>{{ $instructor->department->department_name }}</td>
                    <td>
                        <a href="{{ route('instructors.edit', $instructor) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('instructors.destroy', $instructor) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this instructor?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $instructors->links() }} <!-- Pagination -->
    </div>
@endsection
