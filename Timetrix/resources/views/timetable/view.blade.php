@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Weekly Timetable</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Time</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
            </thead>
            <tbody>
            @for ($hour = 7; $hour <= 17; $hour++)
                <tr>
                    <td>{{ $hour }}:00 - {{ $hour+1 }}:00</td>
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <td>
                            @php
                                $entry = $timetable->where('day', $day)->where('hour', $hour)->first();
                            @endphp

                            @if ($entry)
                                <strong>{{ optional($entry->course)->course_name ?? 'Course Not Found' }}</strong> <br>
                                <small>{{ optional($entry->instructor)->instructor_name ?? 'Instructor Not Found' }}</small> <br>
                                <small>Room: {{ optional($entry->classroom)->room_name ?? 'Room Not Found' }}</small>
                                <br>
                                <button class="btn btn-sm btn-primary edit-btn"
                                        data-id="{{ $entry->id }}"
                                        data-course="{{ $entry->course_id }}"
                                        data-instructor="{{ $entry->instructor_id }}"
                                        data-classroom="{{ $entry->classroom_id }}"
                                        data-day="{{ $entry->day }}"
                                        data-hour="{{ $entry->hour }}"
                                        data-toggle="modal" data-target="#editModal">
                                    Edit
                                </button>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('timetable.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="entry_id" id="entry_id">

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select name="course_id" id="course_id" class="form-control">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Instructor</label>
                            <select name="instructor_id" id="instructor_id" class="form-control">
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->instructor_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="classroom_id" class="form-label">Classroom</label>
                            <select name="classroom_id" id="classroom_id" class="form-control">
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->room_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="day" class="form-label">Day</label>
                            <select name="day" id="day" class="form-control">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="hour" class="form-label">Time Slot</label>
                            <select name="hour" id="hour" class="form-control">
                                @for ($i = 7; $i <= 17; $i++)
                                    <option value="{{ $i }}">{{ $i }}:00 - {{ $i+1 }}:00</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal Data Population -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let editButtons = document.querySelectorAll('.edit-btn');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('entry_id').value = this.getAttribute('data-id');
                    document.getElementById('course_id').value = this.getAttribute('data-course');
                    document.getElementById('instructor_id').value = this.getAttribute('data-instructor');
                    document.getElementById('classroom_id').value = this.getAttribute('data-classroom');
                    document.getElementById('day').value = this.getAttribute('data-day');
                    document.getElementById('hour').value = this.getAttribute('data-hour');
                });
            });
        });
    </script>
@endsection
