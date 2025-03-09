<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timetable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .faculty {
            background-color: #444;
            color: white;
            font-size: 14px;
            text-align: left;
            font-weight: bold;
        }
        .department {
            background-color: #666;
            color: white;
            font-size: 13px;
            text-align: left;
            font-weight: bold;
        }
        .course {
            background-color: #eee;
            font-weight: bold;
        }
        .time-slot {
            min-width: 100px;
            height: 40px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center; margin-bottom: 5px;">Institution Name</h2>
<h3 style="text-align: center; margin-top: 0;">Master Timetable</h3>

<table>
    <thead>
    <tr>
        <th rowspan="2">Day</th>
        <th rowspan="2">Faculty</th>
        <th rowspan="2">Department</th>
        <th rowspan="2">Course</th>
        @foreach($timeSlots as $hour)
            <th class="time-slot">{{ $hour }}:00</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($days as $day)
        <tr>
            <td rowspan="{{ count($timetable[$day] ?? []) + 1 }}" class="faculty">{{ $day }}</td>
        </tr>

        @foreach($timetable[$day] ?? [] as $faculty => $facultyData)
            <tr class="faculty">
                <td colspan="{{ count($timeSlots) + 3 }}">{{ $faculty }}</td>
            </tr>

            @foreach($facultyData as $department => $departmentData)
                <tr class="department">
                    <td colspan="{{ count($timeSlots) + 2 }}">{{ $department }}</td>
                </tr>

                @foreach($departmentData as $entry)
                    <tr class="course">
                        <td>{{ $entry->course->course_name }}</td>
                        @foreach($timeSlots as $hour)
                            @php
                                $schedule = $entry->where('hour', $hour)->first();
                            @endphp
                            <td class="time-slot">
                                @if($schedule)
                                    <strong>{{ $schedule->instructor->instructor_name }}</strong><br>
                                    <small>Room: {{ $schedule->classroom->room_name }}</small>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>

</body>
</html>
