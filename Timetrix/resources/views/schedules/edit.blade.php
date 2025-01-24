@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Schedule</h1>
        <form action="{{ route('schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="day">Day</label>
                <input type="text" class="form-control" id="day" name="day" value="{{ $schedule->day }}" required>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $schedule->start_time }}" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $schedule->end_time }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Schedule</button>
        </form>
    </div>
@endsection
