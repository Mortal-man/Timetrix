@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Instructors</h2>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('instructors.create') }}" class="btn btn-primary">Add Instructor</a>

            <form method="GET" action="{{ route('instructors.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search name or department" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->instructor_name }}</td>
                    <td>{{ $instructor->department->department_name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('instructors.edit', $instructor->instructor_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $instructor->instructor_id }}')">Delete</button>
                        <form id="deleteForm{{ $instructor->instructor_id }}" action="{{ route('instructors.destroy', $instructor->instructor_id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No instructors found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination links -->
        {{ $instructors->links() }}
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
