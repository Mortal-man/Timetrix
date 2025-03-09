@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Weekly Timetable</h1>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th>Day</th>
                    <th>Faculty</th>
                    <th>Department</th>
                    <th>Course</th>
                    @for ($hour = 7; $hour <= 17; $hour++)
                        <th>{{ $hour }}:00 - {{ $hour+1 }}:00</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @foreach ($timetableData as $day => $faculties)
                    @foreach ($faculties as $faculty => $departments)
                        @foreach ($departments as $department => $courses)
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $day }}</td>
                                    <td>{{ $faculty }}</td>
                                    <td>{{ $department }}</td>
                                    <td>{{ $course['course_name'] }}</td>
                                    @for ($hour = 7; $hour <= 17; $hour++)
                                        <td>
                                            @php
                                                $entry = collect($course['entries'])->firstWhere('hour', $hour);
                                            @endphp
                                            @if ($entry)
                                                <strong>{{ $entry['course_code'] }}</strong><br>
                                                <small>{{ $entry['instructor'] }}</small><br>
                                                <small>Room: {{ $entry['classroom'] }}</small>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
