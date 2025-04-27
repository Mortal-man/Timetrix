<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin:0; padding:20px; }
        .header { text-align:center; margin-bottom:8px; }
        .header img { max-height:70px; }
        .header h1 { font-size:20px; text-transform:uppercase; margin:0; }
        .title { text-align:center; font-size:15px; font-weight:bold; margin-bottom:5px; }
        .meta { text-align:center; font-size:11px; margin-bottom:15px; }
        table { width:100%; border-collapse:collapse; font-size:10px; }
        th, td { border:1px solid #666; padding:6px; }
        th { background:#f7f7f7; }
    </style>
</head>
<body>
<div class="header">
    @if($institution && $institution->logo && file_exists(public_path($institution->logo)))
        <img src="{{ public_path($institution->logo) }}"><br>
    @endif
    @if($institution)
        <h1>{{ strtoupper($institution->name) }}</h1>
        <small>{{ $institution->motto }}</small>
    @endif
</div>

<div class="title">Instructor Timetable Report</div>

<div class="meta">
    <strong>Faculty:</strong>
    {{ str_replace(['Faculty of ', 'Faculty '], '', $facultyName) }} &nbsp;|&nbsp;
    <strong>Department:</strong>
    {{ str_replace(['Department of ', 'Department '], '', $departmentName) }}<br>
    <strong>Instructor:</strong> {{ $instructorName }} &nbsp;|&nbsp;
    <strong>Semester:</strong> {{ str_replace('Semester ', '', $semester) }} &nbsp;|&nbsp;
    <strong>Academic Year:</strong> {{ $academicYear }} &nbsp;|&nbsp;
    <strong>Date:</strong> {{ $effectiveDate }}
</div>

<table>
    <thead>
    <tr>
        <th>Day</th>
        @for($h = 7; $h <= 17; $h++)
            <th>{{ $h }}-{{ $h + 1 }}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
        <tr>
            <td><strong>{{ $day }}</strong></td>
            @php
                $entries = $timetableEntries->get($day, collect())
                                ->sortBy('hour')->values()->keyBy('hour');
                $hour = 7;
            @endphp

            @while($hour <= 17)
                @if(isset($entries[$hour]))
                    @php
                        $e     = $entries[$hour];
                        $code  = $e->course->course_code;
                        $room  = $e->classroom->classroom_name;
                        $span  = 1;
                        $nextH = $hour + 1;
                        while(isset($entries[$nextH]) && $entries[$nextH]->course->course_code === $code) {
                          $span++; $nextH++;
                        }
                    @endphp

                    <td colspan="{{ $span }}">
                        {{ $code }}<br>
                        <small>{{ $room }}</small>
                    </td>
                    @php $hour += $span; @endphp

                @else
                    <td></td>
                    @php $hour++; @endphp
                @endif
            @endwhile

        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
