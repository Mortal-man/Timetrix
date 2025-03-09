@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Generated Timetable</h1>

        <!-- Buttons for Actions -->
        <div class="d-flex mb-3 ">
            <a href="{{ route('timetable.generate') }}" class="btn btn-primary me-2">Regenerate Timetable</a>
            <a href="{{ route('timetable.manual') }}" class="btn btn-warning me-2">Manual Scheduling</a>
            <a href="{{ route('timetable.view') }}" class="btn btn-success">View Timetable</a>
            <a href="{{ route('timetable.pdf') }}" class="btn btn-danger">Download PDF</a>

        </div>

        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="search" class="form-control" placeholder="Search by Course, Instructor, or Classroom">
            </div>
            <div class="col-md-3">
                <select id="filterDay" class="form-control">
                    <option value="">Filter by Day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterInstructor" class="form-control">
                    <option value="">Filter by Instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->instructor_name }}">{{ $instructor->instructor_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($timetable->isEmpty())
            <div class="alert alert-warning" role="alert">
                No timetable entries found. Please generate a timetable.
            </div>
        @else
            <table class="table table-bordered" id="timetableTable">
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
                        <td class="day">{{ $entry->day }}</td>
                        <td class="time">{{ $entry->hour }}:00 - {{ $entry->hour + 1 }}:00</td>
                        <td class="course">{{ optional($entry->course)->course_name ?? 'Course Not Found' }}</td>
                        <td class="instructor">{{ optional($entry->instructor)->instructor_name ?? 'Instructor Not Found' }}</td>
                        <td class="classroom">{{ optional($entry->classroom)->room_name ?? 'Classroom Not Found' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- JavaScript for Filtering and Searching -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('search');
            const filterDay = document.getElementById('filterDay');
            const filterInstructor = document.getElementById('filterInstructor');
            const tableRows = document.querySelectorAll("#timetableTable tbody tr");

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const selectedDay = filterDay.value;
                const selectedInstructor = filterInstructor.value;

                tableRows.forEach(row => {
                    const course = row.querySelector('.course').textContent.toLowerCase();
                    const instructor = row.querySelector('.instructor').textContent.toLowerCase();
                    const classroom = row.querySelector('.classroom').textContent.toLowerCase();
                    const day = row.querySelector('.day').textContent;

                    const matchesSearch = course.includes(searchText) || instructor.includes(searchText) || classroom.includes(searchText);
                    const matchesDay = selectedDay === "" || day === selectedDay;
                    const matchesInstructor = selectedInstructor === "" || instructor.includes(selectedInstructor.toLowerCase());

                    if (matchesSearch && matchesDay && matchesInstructor) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            searchInput.addEventListener("keyup", filterTable);
            filterDay.addEventListener("change", filterTable);
            filterInstructor.addEventListener("change", filterTable);
        });
    </script>
@endsection
