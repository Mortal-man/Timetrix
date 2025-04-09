<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: "Times New Roman", serif; margin: 3px; padding-top: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 7px; }
        th, td { border: 0.5px solid black; text-align: center; padding: 1px; vertical-align: top; line-height: 1; }
        th { background: #f4f4f4; font-size: 7px; }
        h1, h3, h4 { text-align: center; margin: 2px; font-size: 9px; }
        .entry { display: block; padding: 1px 0; }
        .separator { border-top: 0.5px solid black; margin: 0px; }
        .footer { text-align: center; font-size: 8px; margin-top: 5px; }
        .signature-line { margin-top: 10px; display: flex; justify-content: center; align-items: center; }
        .signature-line span { border-top: 1px solid black; width: 150px; display: inline-block; margin-left: 10px; }
    </style>
</head>
<body>

<!-- Header Section (Moved Closer to Top) -->
<h1 style="font-size: 10px; margin-top: 5px;">{{ $institutionName }}</h1>
<h3 style="font-size: 9px;">{{ $title }}</h3>
<h4 style="font-size: 8px;">{{ $semester }} - Academic Year {{ $academicYear }}</h4>
<h4 style="font-size: 7px;">Effective Date: {{ $effectiveDate }}</h4>

@if (!empty($departmentName))
    <h4 style="font-size: 7px;">Department: {{ $departmentName }}</h4>
@endif

<!-- Timetable Table -->
<table>
    <thead>
    <tr>
        <th style="width: 6%;">Day</th>
        @foreach ($timeSlots as $hour)
            <th style="width: 7%;">{{ $hour }}-{{ $hour+1 }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($days as $day)
        <tr>
            <td><strong>{{ $day }}</strong></td>
            @foreach ($timeSlots as $hour)
                <td>
                    @if (!empty($timetableData[$day][$hour]))
                        @foreach ($timetableData[$day][$hour] as $entry)
                            <div class="entry">
                                <strong>{{ $entry['course_code'] ?? 'N/A' }}</strong> <br>
                                <small>Rm: {{ $entry['classroom'] ?? 'N/A' }}</small>
                            </div>
                            @if (!$loop->last)
                                <div class="separator"></div>
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Footer for Approval -->
<div class="footer">
    <div class="signature-line">
        <strong>DIRECTOR, EXAMINATIONS & TIMETABLING</strong>
        <span></span> <!-- Space for signature -->
    </div>
</div>

</body>
</html>
