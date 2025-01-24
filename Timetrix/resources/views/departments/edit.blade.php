@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Department</h1>
        <form action="{{ route('departments.update', $department) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="department_name" class="form-label">Department Name</label>
                <input type="text" name="department_name" class="form-control" id="department_name" value="{{ $department->department_name }}" required>
            </div>
            <div class="mb-3">
                <label for="head_of_department" class="form-label">Head of Department</label>
                <select name="head_of_department" id="head_of_department" class="form-control">
                    <option value="">None</option>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}" {{ $department->head_of_department == $user->user_id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
