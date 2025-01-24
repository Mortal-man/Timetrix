@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Instructor</h1>
        <form action="{{ route('instructors.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="expertise" class="form-label">Expertise</label>
                <input type="text" name="expertise" class="form-control" id="expertise" required>
            </div>
            <div class="mb-3">
                <label for="availability" class="form-label">Availability (JSON format)</label>
                <textarea name="availability" id="availability" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="department_id" class="form-label">Department</label>
                <select name="department_id" id="department_id" class="form-control" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
