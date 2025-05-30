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
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control" required>
                    <option value="">-- Select Department --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}"
                            {{ $instructor->department_id == $department->department_id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('instructors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
