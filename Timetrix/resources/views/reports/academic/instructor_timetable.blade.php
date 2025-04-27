@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Header with Back Button and Centered Title --}}
        <div class="d-flex align-items-center mb-4 position-relative">
            <a href="{{ route('reports.academic.index') }}"
               class="btn btn-sm btn-outline-secondary btn-back position-absolute">
                <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
            <div class="w-100 text-center">
                <h1 class="text-primary text-bold text-uppercase m-0">Instructor Timetable Report</h1>
            </div>
        </div>
        <hr class="border-primary mb-4">

        {{-- Filters --}}
        <form id="filterForm" method="GET" action="{{ route('reports.academic.instructorTimetable') }}" class="mb-4">
            <div class="row gx-3 align-items-end">

                <div class="col-md-3 filter-col">
                    <label class="form-label">Faculty</label>
                    <select id="filterFaculty" name="faculty_id" class="form-control form-control-sm">
                        <option value="">All Faculties</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->faculty_id }}" {{ request('faculty_id') == $f->faculty_id ? 'selected' : '' }}>
                                {{ $f->faculty_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 filter-col">
                    <label class="form-label">Department</label>
                    <select id="filterDepartment" name="department_id" class="form-control form-control-sm">
                        {{-- Populated via JS --}}
                    </select>
                </div>

                <div class="col-md-3 filter-col">
                    <label class="form-label">Instructor</label>
                    <select id="instructor_id" name="instructor_id" class="form-control form-control-sm">
                        <option value="">Select Instructor</option>
                        @foreach($allInstructors as $ins)
                            <option value="{{ $ins->instructor_id }}" {{ request('instructor_id') == $ins->instructor_id ? 'selected' : '' }}>
                                {{ $ins->instructor_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex justify-content-end">
                    <button type="button" id="resetFilters" class="btn btn-reset btn-sm">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>
        </form>

        {{-- Preview & Download --}}
        @if($instructorId && $timetableEntries->isNotEmpty())
            <div class="mb-3 text-end">
                <a href="{{ route('reports.academic.instructorTimetable.pdf', array_merge(request()->all(), ['preview'=>1])) }}"
                   class="btn btn-sm btn-outline-primary me-2" target="_blank">
                    <i class="fas fa-eye"></i> Preview PDF
                </a>
                <a href="{{ route('reports.academic.instructorTimetable.pdf', array_merge(request()->all(), ['preview'=>0])) }}"
                   class="btn btn-sm btn-outline-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
            </div>
        @endif

        {{-- Timetable Grid --}}
        @if($instructorId)
            @if($timetableEntries->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered text-center mb-5 timetable-grid">
                        <thead class="table-light">
                        <tr>
                            <th style="width: 8%;" class="diagonal-header"></th>
                            @for($h = 7; $h <= 17; $h++)
                                <th style="width: 5%; font-size: 0.85rem;">{{ $h }}-{{ $h + 1 }}</th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(['MON','TUE','WED','THU','FRI'] as $dayShort)
                            @php
                                $dayFull = [
                                    'MON' => 'Monday',
                                    'TUE' => 'Tuesday',
                                    'WED' => 'Wednesday',
                                    'THU' => 'Thursday',
                                    'FRI' => 'Friday'
                                ][$dayShort];
                                $dayEntries = $timetableEntries->get($dayFull, collect())
                                    ->sortBy('hour')->values()->keyBy('hour');
                                $hour = 7;
                            @endphp
                            <tr>
                                <td class="diagonal-cell fw-bold">
                                    <div class="day-label">{{ $dayShort }}</div>
                                </td>

                                @while($hour <= 17)
                                    @if(isset($dayEntries[$hour]))
                                        @php
                                            $entry = $dayEntries[$hour];
                                            $code  = $entry->course->course_code;
                                            $room  = $entry->classroom->classroom_name;
                                            $span  = 1;
                                            $next  = $hour + 1;
                                            while(isset($dayEntries[$next]) && $dayEntries[$next]->course->course_code === $code) {
                                                $span++; $next++;
                                            }
                                        @endphp
                                        <td colspan="{{ $span }}" class="p-1" style="font-size: 0.8rem; min-width: 40px;">
                                            <div class="d-flex flex-column justify-content-center" style="height: 100%;">
                                                <div class="fw-bold">{{ $code }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $room }}</div>
                                            </div>
                                        </td>
                                        @php $hour += $span; @endphp
                                    @else
                                        <td class="p-1"></td>
                                        @php $hour++; @endphp
                                    @endif
                                @endwhile
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">No timetable found for selected instructor.</div>
            @endif
        @endif    </div>
@endsection

@push('styles')
    <style>
        .filter-col .form-control {
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .btn-back {
            color: #0056b3;
            font-weight: 600;
        }
        .btn-reset {
            background: #dc3545;
            color: #fff;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .btn-reset:hover {
            background: #c82333;
        }

    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const allDepts       = @json($allDepartments);
            const allInstructors = @json($allInstructors);
            const facSel         = document.getElementById('filterFaculty');
            const deptSel        = document.getElementById('filterDepartment');
            const instrSel       = document.getElementById('instructor_id');
            const selFac         = "{{ request('faculty_id') }}";
            const selDept        = "{{ request('department_id') }}";

            function populateDepts(facId) {
                deptSel.innerHTML = '<option value="">All Departments</option>';
                allDepts.forEach(d => {
                    if (!facId || String(d.faculty_id) === String(facId)) {
                        const o = document.createElement('option');
                        o.value = d.department_id;
                        o.textContent = d.department_name.replace(/Department of\s*/i, '');
                        if (String(d.department_id) === selDept) o.selected = true;
                        deptSel.appendChild(o);
                    }
                });
            }

            function populateInstructors(deptId) {
                instrSel.innerHTML = '<option value="">Select Instructor</option>';
                allInstructors.forEach(i => {
                    if (!deptId || String(i.department_id) === String(deptId)) {
                        const o = document.createElement('option');
                        o.value = i.instructor_id;
                        o.textContent = i.instructor_name;
                        if (String(i.instructor_id) === "{{ request('instructor_id') }}") o.selected = true;
                        instrSel.appendChild(o);
                    }
                });
            }

            // Initial
            facSel.value = selFac;
            populateDepts(selFac);
            populateInstructors(selDept);

            facSel.addEventListener('change', () => {
                populateDepts(facSel.value);
                deptSel.value = "";
                populateInstructors("");
            });

            deptSel.addEventListener('change', () => {
                populateInstructors(deptSel.value);
            });

            // Reset filters
            document.getElementById('resetFilters').addEventListener('click', () => {
                facSel.value = "";
                deptSel.value = "";
                instrSel.value = "";
                populateDepts("");
                populateInstructors("");
            });

            // Only submit when instructor changes
            instrSel.addEventListener('change', () => {
                if (instrSel.value) document.getElementById('filterForm').submit();
            });
        });
    </script>
@endpush
