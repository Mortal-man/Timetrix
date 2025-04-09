@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Courses</h1>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap mb-3 gap-2">
            <a href="{{ route('courses.create') }}" class="btn btn-success">Add Course</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                <form id="filterForm" method="GET" action="{{ route('courses.index') }}">
                    <select name="department_id" id="filterDepartment" class="form-control">
                        <option value="">Filter by Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->department_id }}"
                                    @if(request('department_id') == $department->department_id) selected @endif>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="col-md-3 d-flex align-items-start">
                <button id="resetFilters" class="btn btn-secondary">Reset Filters</button>
            </div>
            <div class="col-md-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search courses..."
                       value="{{ request('search') }}">
            </div>
        </div>

        <!-- Courses Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Department</th>
                    <th>Instructor</th>
                    <th>Enrollment</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->course_name }}</td>
                        <td>{{ $course->course_code }}</td>
                        <td>{{ $course->department->department_name ?? 'N/A' }}</td>
                        <td>{{ $course->instructor->instructor_name ?? 'N/A' }}</td>
                        <td>{{ $course->student_enrollment }}</td>
                        <td>
                            <a href="{{ route('courses.edit', $course->course_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('courses.destroy', $course->course_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No courses found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $courses->appends(request()->query())->links() }}
    </div>

    <!-- JavaScript for Filters -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterFaculty = document.getElementById('filterFaculty');
            const filterDepartment = document.getElementById('filterDepartment');
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            const departments = @json($departments);

            // Faculty-Department relationship
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
            });

            // Auto-submit department filter
            filterDepartment.addEventListener('change', function () {
                filterForm.submit();
            });

            // Search functionality
            searchInput.addEventListener("keyup", function (e) {
                if (e.key === 'Enter') {
                    const searchValue = this.value;
                    const url = new URL(window.location.href);
                    if (searchValue) {
                        url.searchParams.set('search', searchValue);
                    } else {
                        url.searchParams.delete('search');
                    }
                    window.location.href = url.toString();
                }
            });

            // Reset filters
            document.getElementById('resetFilters').addEventListener('click', function () {
                window.location.href = "{{ route('courses.index') }}";
            });
        });
    </script>
@endsection
