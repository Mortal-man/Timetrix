@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Timetable</h1>
        <form action="{{ route('timetables.update', $timetable) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->course_id }}" {{ $timetable->course_id == $course->course_id ? 'selected' : '' }}>{{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="instructor_id">Instructor</label>
                <select class="form-control" id="instructor_id" name="instructor_id" required>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->instructor_id }}" {{ $timetable->instructor_id == $instructor->instructor_id ? 'selected' : '' }}>{{ $instructor->expertise }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="classroom_id">Classroom</label>
                <select class="form-control" id="classroom_id" name="classroom_id" required>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->classroom_id }}" {{ $timetable->classroom_id == $classroom->classroom_id ? 'selected' : '' }}>{{ $classroom->room_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="schedule_id">Schedule</label>
                <select class="form-control" id="schedule_id" name="schedule_id" required>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->schedule_id }}" {{ $timetable->schedule_id == $schedule->schedule_id ? 'selected' : '' }}>{{ $schedule->day }} ({{ $schedule->start_time }} - {{ $schedule->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" class="form-control" id="semester" name="semester" value="{{ $timetable->semester }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Active" {{ $timetable->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Archived" {{ $timetable->status == 'Archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Timetable</button>
        </form>
    </div>
@endsection
