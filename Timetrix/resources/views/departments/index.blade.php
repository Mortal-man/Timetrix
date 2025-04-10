@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Departments</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Add Department</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Faculty</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->department_id }}</td>
                    <td>{{ $department->department_name }}</td>
                    <td>{{ $department->faculty->faculty_name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('departments.edit', $department->department_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $department->department_id }}')">Delete</button>
                        <form id="deleteForm{{ $department->department_id }}" action="{{ route('departments.destroy', $department->department_id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="confirmDeleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12" y2="17"/>
                </svg>
            </div>
            <h3 class="modal-title">Are you sure?</h3>
            <p class="modal-message">This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="btn btn-cancel" id="cancelBtn">Cancel</button>
                <button class="btn btn-confirm" id="confirmBtn">Delete</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/delete.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/delete.js') }}"></script>
@endpush
