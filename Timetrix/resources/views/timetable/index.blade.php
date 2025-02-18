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
                    <td>{{ optional($entry->course)->course_name ?? 'Course Not Found' }}</td>
                    <td>{{ optional($entry->instructor)->instructor_name ?? 'Instructor Not Found' }}</td>
                    <td>{{ optional($entry->classroom)->room_name ?? 'Classroom Not Found' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
