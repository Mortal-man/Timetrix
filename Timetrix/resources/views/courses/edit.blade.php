@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Course</h1>

        <form action="{{ route('courses.update', $course->course_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="course_name" class="form-control" value="{{ old('course_name', $course->course_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Course Code</label>
                <input type="text" name="course_code" class="form-control" value="{{ old('course_code', $course->course_code) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_id" id="departmentSelect" class="form-control" required>
                    <option value="">-- Select Department --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}" {{ $course->department_id == $department->department_id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Instructor</label>
                <select name="instructor_id" id="instructorSelect" class="form-control" required>
                    <option value="">-- Select Instructor --</option>
                    <option value="{{ $course->instructor->instructor_id }}" selected>
                        {{ $course->instructor->instructor_name }}
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Student Enrollment</label>
                <input type="number" name="student_enrollment" class="form-control" value="{{ old('student_enrollment', $course->student_enrollment) }}" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let departmentSelect = document.getElementById("departmentSelect");
            let instructorSelect = document.getElementById("instructorSelect");

            departmentSelect.addEventListener("change", function () {
                let departmentId = this.value;
                instructorSelect.innerHTML = '<option value="">-- Select Instructor --</option>';

                if (departmentId) {
                    fetch(`/instructors-by-department/${departmentId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(instructor => {
                                let option = document.createElement("option");
                                option.value = instructor.instructor_id;
                                option.textContent = instructor.instructor_name;
                                instructorSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error("Error fetching instructors:", error));
                }
            });
        });
    </script>
@endsection
