@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Header with Back Button and Centered Title --}}
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="flex-shrink-0">
                <a href="{{ route('reports.academic.index') }}" class="btn btn-sm btn-outline-secondary btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Back to Reports
                </a>
            </div>
            <h1 class="text-primary text-bold m-0 text-center flex-grow-1 px-3">
                Student Enrollment per Department
            </h1>
            <div class="flex-shrink-0" style="width: 80px;">&nbsp;</div>
        </div>
        <hr class="border-primary mb-4">

        {{-- Search Box --}}
        <div class="row mb-4">
            <div class="col-md-6 col-lg-5">
                <label for="searchInput" class="form-label small text-muted mb-1">SEARCH DEPARTMENT</label>
                <div class="input-group input-group-sm">
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control filter-control"
                        placeholder="Type department name..."
                        value="{{ request('search') }}"
                    >
                    <button
                        id="clearSearch"
                        class="btn btn-outline-secondary"
                        type="button"
                        title="Clear search"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- PDF Preview & Download --}}
        <div class="mb-4 text-end">
            <a href="{{ route('reports.academic.enrollmentSummaryPdf', array_merge(request()->only('search'), ['preview'=>1])) }}"
               class="btn btn-sm btn-outline-primary me-2"
               target="_blank">
                <i class="fas fa-eye me-1"></i> Preview PDF
            </a>
            <a href="{{ route('reports.academic.enrollmentSummaryPdf', array_merge(request()->only('search'), ['preview'=>0])) }}"
               class="btn btn-sm btn-outline-danger"
               target="_blank">
                <i class="fas fa-file-pdf me-1"></i> Download PDF
            </a>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-light">
                <tr>
                    <th class="bg-light">Department</th>
                    <th class="bg-light">Faculty</th>
                    <th class="bg-light text-end">Total Enrollment</th>
                </tr>
                </thead>
                <tbody id="enrollmentBody">
                @forelse($departments as $dept)
                    <tr>
                        <td>{{ preg_replace('/^Department of\s*/i', '', $dept->department_name) }}</td>
                        <td>{{ preg_replace('/^Faculty of\s*/i', '', $dept->faculty->faculty_name) }}</td>
                        <td class="text-end fw-bold">{{ number_format($dept->courses->sum('student_enrollment')) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">No departments found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Search Box */
        .filter-control {
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid #dee2e6;
            transition: all 0.2s;
        }

        .filter-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
        }

        /* Back Button */
        .btn-back {
            color: #0056b3;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
        }

        .btn-back:hover {
            background-color: #e9ecef;
        }

        /* Table Styling */
        table {
            font-size: 0.9rem;
        }

        th {
            white-space: nowrap;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }

        /* Clear Search Button */
        #clearSearch {
            border-top-right-radius: 0.5rem !important;
            border-bottom-right-radius: 0.5rem !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const input = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearSearch');
            const tbody = document.getElementById('enrollmentBody');
            let timeout;

            const endpoint = @json(route('reports.academic.enrollmentSummary'));

            function fetchResults(query = '') {
                fetch(`${endpoint}?search=${encodeURIComponent(query)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(depts => {
                        if (!Array.isArray(depts)) return;
                        tbody.innerHTML = depts.length
                            ? depts.map(d => `
                    <tr>
                           <td>${d.department_name.replace(/^Department of\s*/i, '')}</td>
                           <td>${d.faculty_name.replace(/^Faculty of\s*/i, '')}</td>
                           <td>${d.total_enrollment}</td>
                        </tr>`).join('')
                            : `<tr><td colspan="3" class="text-center">No data found.</td></tr>`;
                    })
                    .catch(() => {
                        tbody.innerHTML = `<tr><td colspan="3" class="text-center text-danger">Error loading data.</td></tr>`;
                    });
            }

            input.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => fetchResults(input.value.trim()), 500);
            });

            clearBtn.addEventListener('click', () => {
                input.value = '';
                fetchResults('');
                input.focus();
            });

            // Initial focus on search input
            input.focus();
        });
    </script>
@endpush
