@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Instructor</h1>
        <form action="{{ route('instructors.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Instructor Name</label>
                <input type="text" name="instructor_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Availability</label><br>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <input type="checkbox" name="availability[]" value="{{ $day }}"> {{ $day }}<br>
                @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control" required>
                    <option value="">-- Select Department --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}"
                            {{ isset($instructor) && $instructor->department_id == $department->department_id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
