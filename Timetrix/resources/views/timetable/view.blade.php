@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Weekly Timetable</h1>

        <!-- Academic Year & Semester -->
        <div class="alert alert-info text-center">
            <strong>{{ $academicSession['semester'] }} - Academic Year {{ $academicSession['academic_year'] }}</strong><br>
            @if (!empty($departmentName))
                <span class="text-white">{{ $departmentName }}</span>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th>Day</th>
                    @for ($hour = 7; $hour <= 17; $hour++)
                        <th>{{ $hour }}:00 - {{ $hour+1 }}:00</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @foreach ($timetableData as $day => $hours)
                    <tr>
                        <td><strong>{{ $day }}</strong></td>
                        @for ($hour = 7; $hour <= 17; $hour++)
                            <td>
                                @if (!empty($hours[$hour]))
                                    @foreach ($hours[$hour] as $entry)
                                        <strong>{{ $entry['course_code'] ?? 'N/A' }}</strong><br>
                                        <small>{{ $entry['instructor'] ?? 'N/A' }}</small><br>
                                        <small>Room: {{ $entry['classroom'] ?? 'N/A' }}</small><br>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
