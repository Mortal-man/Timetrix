@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Timetable</h1>
        <form action="{{ route('timetables.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" required>
                    <option value="">Select a Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="instructor_id">Instructor</label>
                <select class="form-control" id="instructor_id" name="instructor_id" required>
                    <option value="">Select an Instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->instructor_id }}">{{ $instructor->expertise }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="classroom_id">Classroom</label>
                <select class="form-control" id="classroom_id" name="classroom_id" required>
                    <option value="">Select a Classroom</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->classroom_id }}">{{ $classroom->room_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="schedule_id">Schedule</label>
                <select class="form-control" id="schedule_id" name="schedule_id" required>
                    <option value="">Select a Schedule</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->schedule_id }}">{{ $schedule->day }} ({{ $schedule->start_time }} - {{ $schedule->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" class="form-control" id="semester" name="semester" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Timetable</button>
        </form>
    </div>
@endsection
