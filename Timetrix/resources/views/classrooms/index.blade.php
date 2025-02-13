@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Classrooms</h1>
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary mb-3">Add Classroom</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Room Name</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($classrooms as $classroom)
                <tr>
                    <td>{{ $classroom->classroom_id }}</td>
                    <td>{{ $classroom->room_name }}</td>
                    <td>{{ $classroom->capacity }}</td>
                    <td>
                        <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No classrooms found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $classrooms->links() }}
    </div>
@endsection
