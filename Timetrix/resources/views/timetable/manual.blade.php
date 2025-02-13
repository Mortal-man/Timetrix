@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Manual Scheduling</h1>

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @if ($unscheduledCourses->isEmpty())
            <div class="alert alert-success">All courses have been scheduled successfully!</div>
        @else
            <form action="{{ route('timetable.storeManual') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="course_id" class="form-label">Select Course</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        @foreach ($unscheduledCourses as $course)
                            <option value="{{ $course->course_id }}">{{ $course->course_name }} ({{ $course->course_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="day" class="form-label">Select Day</label>
                    <select name="day" id="day" class="form-control" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hour" class="form-label">Select Time Slot</label>
                    <select name="hour" id="hour" class="form-control" required>
                        @for ($i = 7; $i <= 17; $i++)
                            <option value="{{ $i }}">{{ $i }}:00 - {{ $i+1 }}:00</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="instructor_id" class="form-label">Select Instructor</label>
                    <select name="instructor_id" id="instructor_id" class="form-control" required>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->instructor_id }}">{{ $instructor->instructor_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="classroom_id" class="form-label">Select Classroom</label>
                    <select name="classroom_id" id="classroom_id" class="form-control" required>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->room_name }} (Capacity: {{ $classroom->capacity }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Schedule</button>
            </form>
        @endif
    </div>
@endsection
