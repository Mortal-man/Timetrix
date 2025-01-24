@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Schedule</h1>
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="day" class="form-label">Day</label>
                <input type="text" name="day" class="form-control" id="day" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" class="form-control" id="start_time" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" class="form-control" id="end_time" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
