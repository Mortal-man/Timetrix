@extends('layouts.app')

@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0" style="font-size: 1.2rem;">Welcome to Timetrix</h3>
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="lead text-muted mb-2" style="font-size: 0.9rem;">Navigate through the menu to manage Timetrix resources.</p>

                    <!-- Stats Cards Row 1 -->
                    <div class="row mb-2">
                        <!-- Faculties -->
                        <div class="col-md-4 mb-2">
                            <div class="card card-custom bg-white border-left-primary h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-university text-primary" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title text-secondary mb-0" style="font-size: 0.8rem;">Total Faculties</h5>
                                            <p class="card-text text-dark mb-0" style="font-size: 1.2rem; font-weight: 600;">{{ $totalFaculties }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Departments -->
                        <div class="col-md-4 mb-2">
                            <div class="card card-custom bg-white border-left-success h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-building text-success" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title text-secondary mb-0" style="font-size: 0.8rem;">Total Departments</h5>
                                            <p class="card-text text-dark mb-0" style="font-size: 1.2rem; font-weight: 600;">{{ $totalDepartments }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructors -->
                        <div class="col-md-4 mb-2">
                            <div class="card card-custom bg-white border-left-info h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-chalkboard-teacher text-info" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title text-secondary mb-0" style="font-size: 0.8rem;">Total Instructors</h5>
                                            <p class="card-text text-dark mb-0" style="font-size: 1.2rem; font-weight: 600;">{{ $totalInstructors }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards Row 2 -->
                    <div class="row mb-2">
                        <!-- Classrooms -->
                        <div class="col-md-4 mb-2">
                            <div class="card card-custom bg-white border-left-warning h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-door-open text-warning" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title text-secondary mb-0" style="font-size: 0.8rem;">Total Classrooms</h5>
                                            <p class="card-text text-dark mb-0" style="font-size: 1.2rem; font-weight: 600;">{{ $totalClassrooms }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Courses -->
                        <div class="col-md-4 mb-2">
                            <div class="card card-custom bg-white border-left-danger h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <i class="fas fa-book text-danger" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title text-secondary mb-0" style="font-size: 0.8rem;">Total Courses</h5>
                                            <p class="card-text text-dark mb-0" style="font-size: 1.2rem; font-weight: 600;">{{ $totalCourses }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($chartData) && !empty($chartData['labels']))
                        <!-- Chart -->
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card mb-0">
                                    <div class="card-header bg-light py-2">
                                        <h5 class="mb-0" style="font-size: 0.9rem;">Student Enrollment Per Department</h5>
                                    </div>
                                    <div class="card-body position-relative" style="height: 280px; padding: 5px;">
                                        <div class="d-flex justify-content-center align-items-center h-100 w-100 position-absolute">
                                            <div class="chart-container" style="width: 90%; max-width: 350px;">
                                                <canvas id="enrollmentChart" width="300" height="250"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center py-1">
                                        <button id="downloadBtn" class="btn btn-success btn-sm" style="font-size: 0.7rem;">Download as Image</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-2 py-1" style="font-size: 0.8rem;">
                            No enrollment data available to display.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<style>
    /* Light Mode (default) */
    body {
    background-color: #f8f9fc;
    color: #212529;
    }

    .card-custom {
    background-color: #ffffff;
    color: #212529;
    }

    .card-header {
    background-color: #007bff;
    color: white;
    }

    .card-footer {
    background-color: #f8f9fc;
    }

    /* Dark Mode Overrides */
    body.dark-mode {
    background-color: #343a40;
    color: #f8f9fc;
    }

    /* Override Bootstrap utility classes in dark mode */
    body.dark-mode .bg-white {
    background-color: #495057 !important;
    color: #f8f9fc !important;
    }

    /* Override for custom cards if needed */
    body.dark-mode .card-custom {
    background-color: #495057 !important;
    color: #f8f9fc !important;
    }

    body.dark-mode .card-header {
    background-color: #212529 !important;
    color: white !important;
    }

    body.dark-mode .card-footer {
    background-color: #495057 !important;
    color: #f8f9fc !important;
    }

    /* Button for dark mode toggle */
    #themeToggle {
    background-color: transparent;
    border: none;
    color: #ffffff;
    font-size: 1rem;
    }

    body.dark-mode #themeToggle {
    color: #f8f9fc;
    }
</style>
@endsection

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    const chartLabels = @json($chartData['labels']);
    const chartValues = @json($chartData['data']);

    function generateRandomColors(n) {
        const colors = [];
        for (let i = 0; i < n; i++) {
            colors.push(`hsl(${Math.random() * 360}, 85%, 65%)`);
        }
        return colors;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const themeToggleButton = document.getElementById('themeToggle');
        const body = document.body;

        if (typeof Chart === 'undefined') {
            alert('🚫 Chart.js NOT loaded!');
            return;
        }

        const ctx = document.getElementById('enrollmentChart').getContext('2d');

        document.getElementById('enrollmentChart').classList.add('chart-shadow');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Student Enrollment',
                    data: chartValues,
                    backgroundColor: generateRandomColors(chartValues.length),
                    borderWidth: 0,
                    weight: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 10
                },
                plugins: {
                    tooltip: {
                        bodyFont: {
                            size: 9
                        },
                        callbacks: {
                            label: function(tooltipItem) {
                                const percentage = ((tooltipItem.raw / chartValues.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
                                return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                            }
                        }
                    },
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 8,
                            font: {
                                size: 9
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuad'
                },
                cutout: '65%',
                elements: {
                    arc: {
                        borderWidth: 0,
                        hoverBorderWidth: 1,
                        hoverBorderColor: '#fff'
                    }
                }
            }
        });

        document.getElementById('downloadBtn').addEventListener('click', function () {
            const chart = Chart.getChart('enrollmentChart');
            const imageUrl = chart.toBase64Image();
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = 'enrollment-chart.png';
            link.click();
        });
    });
</script>
