@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Faculty</h2>
        <form action="{{ route('faculties.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="faculty_name">Faculty Name</label>
                <input type="text" class="form-control" name="faculty_name" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
