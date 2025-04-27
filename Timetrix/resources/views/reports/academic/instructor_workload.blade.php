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
                Instructor Workload Report
            </h1>
            <div class="flex-shrink-0" style="width: 80px;">&nbsp;</div>
        </div>
        <hr class="border-success mb-4">

        {{-- Filters (Faculty → Department) --}}
        <form id="filterForm" method="GET" action="{{ route('reports.academic.instructorWorkload') }}" class="mb-4">
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
            <a href="{{ route('reports.academic.instructorWorkload.pdf', array_merge(request()->all(), ['preview'=>1])) }}"
               class="btn btn-sm btn-outline-primary me-2">
                <i class="fas fa-eye me-1"></i> Preview PDF
            </a>
            <a href="{{ route('reports.academic.instructorWorkload.pdf', array_merge(request()->all(), ['preview'=>0])) }}"
               class="btn btn-sm btn-outline-danger">
                <i class="fas fa-file-pdf me-1"></i> Download PDF
            </a>
        </div>

        {{-- Workload Table --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-light">
                <tr>
                    <th class="bg-light">Instructor</th>
                    <th class="bg-light">Courses Assigned</th>
                    <th class="bg-light text-center">Total Hours</th>
                </tr>
                </thead>
                <tbody>
                @forelse($instructors as $ins)
                    <tr>
                        <td class="fw-bold">{{ $ins->instructor_name }}</td>
                        <td>
                            @foreach($ins->timetable->groupBy('course_code') as $code => $entries)
                                @php $c = $entries->first(); @endphp
                                <div class="mb-1">
                                    <span class="badge bg-primary me-1">{{ $code }}</span>
                                    {{ $c->course_name }}
                                </div>
                            @endforeach
                        </td>
                        <td class="text-center fw-bold">{{ $ins->timetable->groupBy('course_code')->count() * 3 }} hrs</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">No instructors found matching your criteria.</td>
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
                window.location.href = "{{ route('reports.academic.instructorWorkload') }}";
            });
        });
    </script>
@endpush
