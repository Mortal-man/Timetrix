@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Department</h1>
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Department Name</label>
                <input type="text" name="department_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department Code</label>
                <input type="text" name="department_code" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Faculty</label>
                <select name="faculty_id" class="form-control" required>
                    <option value="">-- Select Faculty --</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->faculty_id }}">{{ $faculty->faculty_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Head of Department</label>
                <input type="text" name="head_of_department" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
