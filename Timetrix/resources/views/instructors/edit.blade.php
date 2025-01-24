@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Instructor</h1>
        <form action="{{ route('instructors.update', $instructor) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_id">User</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $instructor->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="expertise">Expertise</label>
                <input type="text" class="form-control" id="expertise" name="expertise" value="{{ $instructor->expertise }}" required>
            </div>

            <div class="form-group">
                <label for="availability">Availability</label>
                <textarea class="form-control" id="availability" name="availability" required>{{ json_encode($instructor->availability) }}</textarea>
            </div>

            <div class="form-group">
                <label for="department_id">Department</label>
                <select class="form-control" id="department_id" name="department_id" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->department_id }}" {{ $instructor->department_id == $department->department_id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Instructor</button>
        </form>
    </div>
@endsection
