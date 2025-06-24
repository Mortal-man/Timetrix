@extends('layouts.app')

@section('content')
    <div class="dashboard p-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="text-uppercase text-primary">Academic Reports</h2>
        </div>

        <!-- Reports Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach([
                [
                    'icon' => 'chalkboard-teacher',
                    'color' => '#ff7f50',
                    'title' => 'Instructor Workload',
                    'route' => 'reports.academic.instructorWorkload'
                ],
                [
                    'icon' => 'book-open',
                    'color' => '#6a5acd',
                    'title' => 'Course Offering',
                    'route' => 'reports.academic.courseOfferingSummary'
                ],
                [
                    'icon' => 'building',
                    'color' => '#20b2aa',
                    'title' => 'Enrollment per Dept',
                    'route' => 'reports.academic.enrollmentSummary'
                ],
                [
                    'icon' => 'calendar-alt',
                    'color' => '#228b22',
                    'title' => 'Instructor Timetable',
                    'route' => 'reports.academic.instructorTimetable'
                ],
            ] as $report)
                <div class="col">
                    <div class="card report-card h-100 border-0 shadow-sm">
                        <div class="accent-bar" style="height: 4px; background: {{ $report['color'] }};"></div>
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-{{ $report['icon'] }} fa-3x"
                                   style="color: {{ $report['color'] }};"
                                   data-bs-toggle="tooltip"
                                   title="{{ $report['title'] }}"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">{{ $report['title'] }}</h5>
                            <a href="{{ route($report['route']) }}"
                               class="btn btn-outline-primary px-4">
                                View Report <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .report-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 8px;
            overflow: hidden;
        }
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize tooltips
            new bootstrap.Tooltip(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

            // Theme toggle functionality
            document.getElementById('themeToggle').addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', newTheme);

                // Update button icon
                const icon = document.querySelector('#themeToggle i');
                icon.classList.toggle('fa-moon');
                icon.classList.toggle('fa-sun');
            });
        });
    </script>
@endpush
