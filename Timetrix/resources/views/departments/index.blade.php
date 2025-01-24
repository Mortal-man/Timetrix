@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Departments</h1>
        <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Add Department</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Head of Department</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($departments as $department)
                <tr>
                    <td>{{ $department->department_id }}</td>
                    <td>{{ $department->department_name }}</td>
                    <td>{{ $department->head->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No departments found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $departments->links() }}
    </div>
@endsection
