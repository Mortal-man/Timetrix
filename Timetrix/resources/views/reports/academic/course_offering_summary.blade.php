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
            <h1 class="text-success text-bold m-0 text-center flex-grow-1 px-3">
                Course Offering Summary
            </h1>
            <div class="flex-shrink-0" style="width: 80px;">&nbsp;</div>
        </div>
        <hr class="border-success mb-4">

        {{-- Filters (Faculty → Department) --}}
        <form id="filterForm" method="GET" action="{{ route('reports.academic.courseOfferingSummary') }}" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">FACULTY</label>
                    <select id="filterFaculty" name="faculty_id" class="form-select form-select-sm filter-control">
                        <option value="">All Faculties</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->faculty_id }}"
                                {{ request('faculty_id') == $f->faculty_id ? 'selected' : '' }}>
                                {{ $f->faculty_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">DEPARTMENT</label>
                    <select id="filterDepartment" name="department_id" class="form-select form-select-sm filter-control">
                        {{-- JS will populate --}}
                    </select>
                </div>
                <div class="col-md-4 d-flex">
                    <button type="button" id="resetFilters" class="btn btn-sm btn-reset w-100">
                        <i class="fas fa-redo me-1"></i> Reset Filters
                    </button>
                </div>
            </div>
        </form>

        {{-- PDF Preview & Download --}}
        <div class="mb-4 text-end">
            <a href="{{ route('reports.academic.courseOfferingSummaryPdf', array_merge(request()->all(), ['preview'=>1])) }}"
               class="btn btn-sm btn-outline-primary me-2">
                <i class="fas fa-eye me-1"></i> Preview PDF
            </a>
            <a href="{{ route('reports.academic.courseOfferingSummaryPdf', array_merge(request()->all(), ['preview'=>0])) }}"
               class="btn btn-sm btn-outline-danger">
                <i class="fas fa-file-pdf me-1"></i> Download PDF
            </a>
        </div>

        {{-- Course Offering Table --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-light">
                <tr>
                    <th class="bg-light">Course Code</th>
                    <th class="bg-light">Course Name</th>
                    <th class="bg-light">Instructor</th>
                    <th class="bg-light">Department</th>
                </tr>
                </thead>
                <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td class="fw-bold">{{ $course->course_code }}</td>
                        <td>{{ $course->course_name }}</td>
                        <td>
                            @if($course->instructor)
                                <span class="badge bg-primary me-1">{{ $course->instructor->short_name ?? '' }}</span>
                                {{ $course->instructor->instructor_name }}
                            @else
                                <span class="text-muted">Not Assigned</span>
                            @endif
                        </td>
                        <td>{{ $course->department->department_name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No courses found matching your criteria.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Filter Controls */
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

        /* Reset Button */
        .btn-reset {
            background: #dc3545;
            color: white;
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
            transition: all 0.2s;
        }

        .btn-reset:hover {
            background: #bb2d3b;
            color: white;
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

        .badge {
            font-size: 0.75em;
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const allDepts  = @json($allDepartments);
            const facSel    = document.getElementById('filterFaculty');
            const deptSel   = document.getElementById('filterDepartment');
            const form      = document.getElementById('filterForm');
            const resetBtn  = document.getElementById('resetFilters');
            const selFac    = "{{ request('faculty_id') }}";
            const selDept   = "{{ request('department_id') }}";

            function populateDepts(facId) {
                deptSel.innerHTML = '<option value="">All Departments</option>';
                allDepts.forEach(d => {
                    if (!facId || String(d.faculty_id) === String(facId)) {
                        const opt = document.createElement('option');
                        opt.value = d.department_id;
                        opt.textContent = d.department_name;
                        if (String(d.department_id) === selDept) opt.selected = true;
                        deptSel.appendChild(opt);
                    }
                });
            }

            facSel.value = selFac;
            populateDepts(selFac);

            facSel.addEventListener('change', () => {
                populateDepts(facSel.value);
                deptSel.value = "";
            });

            deptSel.addEventListener('change', () => form.submit());

            resetBtn.addEventListener('click', () => {
                window.location.href = "{{ route('reports.academic.courseOfferingSummary') }}";
            });
        });
    </script>
@endpush
