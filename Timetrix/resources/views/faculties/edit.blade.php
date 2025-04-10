@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Faculty</h2>
        <form action="{{ route('faculties.update', $faculty->faculty_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="faculty_name">Faculty Name</label>
                <input type="text" class="form-control" name="faculty_name" value="{{ $faculty->faculty_name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('faculties.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
