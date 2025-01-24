@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Timetables</h1>
        <a href="{{ route('timetables.create') }}" class="btn btn-primary mb-3">Add Timetable</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Course</th>
                <th>Instructor</th>
                <th>Classroom</th>
                <th>Schedule</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($timetables as $timetable)
                <tr>
                    <td>{{ $timetable->timetable_id }}</td>
                    <td>{{ $timetable->course->course_name }}</td>
                    <td>{{ $timetable->instructor->expertise }}</td>
                    <td>{{ $timetable->classroom->room_name }}</td>
                    <td>{{ $timetable->schedule->day }} ({{ $timetable->schedule->start_time }} - {{ $timetable->schedule->end_time }})</td>
                    <td>{{ $timetable->semester }}</td>
                    <td>{{ $timetable->status }}</td>
                    <td>
                        <a href="{{ route('timetables.edit', $timetable) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('timetables.destroy', $timetable) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No timetables found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $timetables->links() }}
    </div>
@endsection
