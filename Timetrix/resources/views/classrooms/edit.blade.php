@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Classroom</h1>
        <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_name" class="form-label">Room Name</label>
                <input type="text" name="room_name" class="form-control" id="room_name" value="{{ $classroom->room_name }}" required>
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control" id="capacity" value="{{ $classroom->capacity }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
