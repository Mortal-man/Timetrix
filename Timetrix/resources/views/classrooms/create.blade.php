@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Classroom</h1>
        <form action="{{ route('classrooms.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="room_name" class="form-label">Room Name</label>
                <input type="text" name="room_name" class="form-control" id="room_name" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control" id="capacity" required>
            </div>
            <div class="mb-3">
                <label for="equipment" class="form-label">Equipment</label>
                <input type="text" name="equipment" class="form-control" id="equipment">
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control" id="location" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
