@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Generated Timetable</h1>
        <a href="{{ route('timetable.generate') }}" class="btn btn-primary mb-3">Regenerate Timetable</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Course</th>
                <th>Instructor</th>
                <th>Classroom</th>
            </tr>
            </thead>
            <tbody>
            @foreach($timetable as $entry)
                <tr>
                    <td>{{ $entry->day }}</td>
                    <td>{{ $entry->hour }}:00 - {{ $entry->hour + 1 }}:00</td>
                    <td>{{ $entry->course->course_name }}</td>
                    <td>{{ $entry->instructor->instructor_name }}</td>
                    <td>{{ $entry->classroom->room_name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
