<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }
        .header img {
            max-height: 70px;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header small {
            font-style: italic;
            display: block;
            margin-top: 2px;
            margin-bottom: 2px;
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .report-meta {
            text-align: center;
            font-size: 11px;
            margin-bottom: 15px;
            color: #333;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #666;
            padding: 6px;
        }
        th {
            background: #f7f7f7;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="header">
    @if($institution && $institution->logo && file_exists(public_path($institution->logo)))
        <img src="{{ public_path($institution->logo) }}" alt="Institution Logo"><br>
    @endif
    @if($institution)
        <h1>{{ strtoupper($institution->name) }}</h1>
        <small>{{ $institution->motto ?? '' }}</small>
    @endif
</div>

<div class="title">Course Offering Summary</div>

<div class="report-meta">
    <strong>Faculty:</strong> {{ str_replace(['Faculty of ', 'Faculty '], '', $facultyName) }} &nbsp; | &nbsp;
    <strong>Department:</strong> {{ str_replace(['Department of ', 'Department '], '', $departmentName) }}<br>
    <strong>Semester:</strong> {{ str_replace('Semester ', '', $semester) }} &nbsp; | &nbsp;
    <strong>Academic Year:</strong> {{ $academicYear }} &nbsp; | &nbsp;
    <strong>Date:</strong> {{ $effectiveDate }}
</div>

<table>
    <thead>
    <tr>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Instructor</th>
    </tr>
    </thead>
    <tbody>
    @forelse($courses as $course)
        <tr>
            <td>{{ $course->course_code }}</td>
            <td>{{ $course->course_name }}</td>
            <td>{{ $course->instructor->instructor_name ?? 'Not Assigned' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align:center;">No data for selected filters.</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
