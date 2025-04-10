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
                <th>Faculty Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($faculties as $faculty)
                <tr>
                    <td>{{ $faculty->faculty_name }}</td>
                    <td>
                        <a href="{{ route('faculties.edit', $faculty->faculty_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $faculty->faculty_id }})">Delete</button>
                        <form id="deleteForm{{ $faculty->faculty_id }}" action="{{ route('faculties.destroy', $faculty->faculty_id) }}" method="POST" class="d-none">
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12" y2="17"></line>
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

    <script>
        let currentFacultyId = null;

        function confirmDelete(facultyId) {
            currentFacultyId = facultyId;
            const modal = document.getElementById("confirmDeleteModal");
            modal.classList.remove('closing');
            modal.style.display = "flex";
        }

        function closeModal() {
            const modal = document.getElementById("confirmDeleteModal");
            modal.classList.add('closing');
            setTimeout(() => {
                modal.style.display = "none";
                modal.classList.remove('closing');
            }, 300);
        }

        document.getElementById("cancelBtn").addEventListener("click", closeModal);
        document.getElementById("confirmBtn").addEventListener("click", function() {
            document.getElementById(`deleteForm${currentFacultyId}`).submit();
            closeModal();
        });

        window.onclick = function(event) {
            const modal = document.getElementById("confirmDeleteModal");
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>

    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            animation: fadeIn 0.3s forwards;
        }

        .modal.closing {
            animation: fadeOut 0.3s forwards;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            transform: translateY(-20px);
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-icon {
            color: #ef4444;
            margin-bottom: 1rem;
        }

        .modal-icon svg {
            width: 48px;
            height: 48px;
        }

        .modal-title {
            margin: 0 0 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-message {
            color: #6b7280;
            margin: 0 0 1.5rem;
        }

        .modal-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-confirm {
            background: #ef4444;
            color: white;
        }

        .btn-confirm:hover {
            background: #dc2626;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
@endsection
