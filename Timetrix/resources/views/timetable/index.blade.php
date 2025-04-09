@extends('layouts.app')

@section('content')
    @php
        use App\Helpers\AcademicHelper;
        $academicSession = AcademicHelper::getCurrentAcademicSession();
    @endphp

    <div class="container">
        <h1>Generated Timetable</h1>

        <!-- Academic Info -->
        <div class="alert alert-info text-center">
            <strong>{{ $academicSession['semester'] }} - Academic Year {{ $academicSession['academic_year'] }}</strong>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap mb-3 gap-2">
            <a href="{{ route('timetable.generate') }}" class="btn btn-primary">Regenerate Timetable</a>
            <a href="{{ route('timetable.manual') }}" class="btn btn-warning">Manual Scheduling</a>

            <form id="viewTimetableForm" action="{{ route('timetable.view') }}" method="GET" class="d-inline-block">
                <input type="hidden" name="department_id" id="departmentInput">
                <button type="submit" class="btn btn-success">View Departmental Timetable</button>
            </form>

            <form id="downloadPdfForm" action="{{ route('timetable.pdf') }}" method="GET" class="d-inline-block">
                <input type="hidden" name="department_id" id="pdfDepartmentInput">
                <button type="submit" class="btn btn-danger">Download PDF</button>
            </form>
        </div>

        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="filterFaculty" class="form-control">
                    <option value="">Filter by Faculty</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->faculty_id }}">{{ $faculty->faculty_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterDepartment" class="form-control">
                    <option value="">Filter by Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-start">
                <button id="resetFilters" class="btn btn-secondary">Reset Filters</button>
            </div>
            <div class="col-md-3">
                <!-- Search Bar -->
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Course/Instructor">
            </div>
        </div>

        <!-- Timetable Table -->
        @if($timetable->isEmpty())
            <div class="alert alert-warning" role="alert">
                No timetable entries found. Please generate a timetable.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered" id="timetableTable">
                    <thead>
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Course Code</th>
                        <th>Instructor</th>
                        <th>Classroom</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timetable as $entry)
                        @php
                            $courseDepartment = optional($entry->course)->department_id;
                        @endphp
                        <tr data-department="{{ $courseDepartment }}">
                            <td>{{ $entry->day }}</td>
                            <td>{{ $entry->hour }}:00 - {{ $entry->hour + 1 }}:00</td>
                            <td class="course">{{ optional($entry->course)->course_code ?? 'N/A' }}</td>
                            <td class="instructor">{{ optional($entry->instructor)->instructor_name ?? 'N/A' }}</td>
                            <td class="classroom">{{ optional($entry->classroom)->room_name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- JS for Filters and Search -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterFaculty = document.getElementById('filterFaculty');
            const filterDepartment = document.getElementById('filterDepartment');
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll("#timetableTable tbody tr");

            const departments = @json($departments);

            filterFaculty.addEventListener("change", function () {
                const selectedFaculty = this.value;
                filterDepartment.innerHTML = '<option value="">Filter by Department</option>';

                departments.forEach(dept => {
                    if (String(dept.faculty_id) === selectedFaculty) {
                        const option = document.createElement("option");
                        option.value = dept.department_id;
                        option.textContent = dept.department_name;
                        filterDepartment.appendChild(option);
                    }
                });

                filterTable(); // In case department was already selected
            });

            filterDepartment.addEventListener('change', function () {
                const selectedDeptId = this.value;

                document.getElementById('departmentInput').value = selectedDeptId;
                document.getElementById('pdfDepartmentInput').value = selectedDeptId;

                filterTable();
            });

            // Filter table rows based on department
            function filterTable() {
                const selectedDepartment = filterDepartment.value;
                tableRows.forEach(row => {
                    const rowDepartment = row.getAttribute('data-department');
                    row.style.display = !selectedDepartment || rowDepartment === selectedDepartment ? '' : 'none';
                });
            }

            // Search functionality for course/instructor
            searchInput.addEventListener("keyup", function () {
                const searchTerm = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const courseText = row.querySelector(".course").textContent.toLowerCase();
                    const instructorText = row.querySelector(".instructor").textContent.toLowerCase();
                    if (courseText.includes(searchTerm) || instructorText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            document.getElementById('resetFilters').addEventListener('click', function () {
                filterFaculty.value = '';
                filterDepartment.innerHTML = '<option value="">Filter by Department</option>';
                document.getElementById('departmentInput').value = '';
                document.getElementById('pdfDepartmentInput').value = '';
                searchInput.value = '';
                tableRows.forEach(row => row.style.display = '');
            });
        });
    </script>
@endsection
