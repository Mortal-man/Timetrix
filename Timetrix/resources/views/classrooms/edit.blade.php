@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Classroom</h1>

        <!-- Display validation errors (if any) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to update the classroom -->
        <form action="{{ route('classrooms.update', $classroom) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_name" class="form-label">Room Name</label>
                <input type="text" name="room_name" class="form-control" id="room_name" value="{{ old('room_name', $classroom->room_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control" id="capacity" value="{{ old('capacity', $classroom->capacity) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
