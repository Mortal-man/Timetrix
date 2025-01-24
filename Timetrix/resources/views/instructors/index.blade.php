@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Instructors</h1>
        <a href="{{ route('instructors.create') }}" class="btn btn-primary mb-3">Add Instructor</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Expertise</th>
                <th>Availability</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->instructor_id }}</td>
                    <td>{{ $instructor->user->name ?? 'N/A' }}</td>
                    <td>{{ $instructor->expertise }}</td>
                    <td>{{ implode(', ', $instructor->availability ?? []) }}</td>
                    <td>{{ $instructor->department->department_name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('instructors.edit', $instructor) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('instructors.destroy', $instructor) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No instructors found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $instructors->links() }}
    </div>
@endsection
