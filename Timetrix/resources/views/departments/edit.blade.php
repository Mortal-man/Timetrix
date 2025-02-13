@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Department</h1>
        <form action="{{ route('departments.update', $department->department_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Department Name</label>
                <input type="text" name="department_name" class="form-control" value="{{ $department->department_name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department Code</label>
                <input type="text" name="department_code" class="form-control" value="{{ $department->department_code }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Faculty</label>
                <select name="faculty_id" class="form-control" required>
                    <option value="">-- Select Faculty --</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->faculty_id }}"
                            {{ $department->faculty_id == $faculty->faculty_id ? 'selected' : '' }}>
                            {{ $faculty->faculty_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Head of Department</label>
                <input type="text" name="head_of_department" class="form-control" value="{{ $department->head_of_department }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
