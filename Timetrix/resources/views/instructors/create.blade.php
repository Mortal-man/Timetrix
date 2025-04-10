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
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control" required>
                    <option value="">-- Select Department --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}">
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('instructors.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
