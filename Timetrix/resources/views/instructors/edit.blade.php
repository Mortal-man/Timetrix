@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Instructor</h1>
        <form action="{{ route('instructors.update', $instructor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Instructor Name</label>
                <input type="text" name="instructor_name" class="form-control" value="{{ $instructor->instructor_name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Availability</label><br>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <input type="checkbox" name="availability[]" value="{{ $day }}"
                        {{ in_array($day, json_decode($instructor->availability)) ? 'checked' : '' }}> {{ $day }}<br>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
