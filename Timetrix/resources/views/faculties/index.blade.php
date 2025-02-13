@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Faculties</h2>
        <a href="{{ route('faculties.create') }}" class="btn btn-primary mb-3">Add Faculty</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Faculty Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($faculties as $faculty)
                <tr>
                    <td>{{ $faculty->faculty_id }}</td>
                    <td>{{ $faculty->faculty_name }}</td>
                    <td>
                        <a href="{{ route('faculties.edit', $faculty->faculty_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('faculties.destroy', $faculty->faculty_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
