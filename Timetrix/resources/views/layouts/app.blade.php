@extends('adminlte::page')

@section('title', 'Timetrix')

@section('css')
    <!-- Global Custom Fonts and Styles -->
    <link href="{{ asset('css/custom_fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap">

    <style>
        /* Light Mode (default) */
        body {
            background-color: #f8f9fc;
            color: #212529;
        }

        .card-custom {
            background-color: #ffffff;
            color: #212529;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .card-footer {
            background-color: #f8f9fc;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #343a40;
            color: #f8f9fc;
        }

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

        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #f8f9fc;
        }

        body.dark-mode p, body.dark-mode span, body.dark-mode .card-text {
            color: #f8f9fc;
        }

        /* Toggle Switch */
        #themeToggle {
            background-color: transparent;
            border: none;
            color: #ffffff;
            font-size: 1rem;
        }

        body.dark-mode #themeToggle {
            color: #f8f9fc;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            border-radius: 50%;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #007bff;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider::after {
            content: "\f186";
            font-family: 'Font Awesome 5 Free';
            position: absolute;
            top: 50%;
            left: 4px;
            transform: translateY(-50%);
            font-size: 14px;
        }

        input:checked + .slider::after {
            content: "\f185";
            left: 30px;
        }
    </style>

    @stack('styles')
@endsection

@section('content')
    @php
        use App\Helpers\AcademicHelper;
        $academicSession = AcademicHelper::getCurrentAcademicSession();
    @endphp

        <!-- Academic Header -->
    <div class="container-fluid bg-dark text-white p-2 text-center">
        <h6>{{ $academicSession['semester'] }} - Academic Year {{ $academicSession['academic_year'] }}</h6>
    </div>

    <!-- Dark Mode Toggle -->
    <div class="container-fluid text-right p-2">
        <label class="switch">
            <input type="checkbox" id="themeToggle">
            <span class="slider"></span>
        </label>
    </div>

    <!-- Yielded Main Content -->
    <div class="container-fluid">
        @yield('main-content')
    </div>
@endsection

@section('footer')
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>&copy; 2025 <a href="#">Timetrix</a>.</strong> All rights reserved.
    </footer>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            const themeToggleCheckbox = $('#themeToggle');
            const body = $('body');

            const savedTheme = localStorage.getItem('theme') || 'light';

            if (savedTheme === 'dark') {
                body.addClass('dark-mode');
                themeToggleCheckbox.prop('checked', true);
            }

            themeToggleCheckbox.on('change', function () {
                if (themeToggleCheckbox.prop('checked')) {
                    body.addClass('dark-mode');
                    localStorage.setItem('theme', 'dark');
                } else {
                    body.removeClass('dark-mode');
                    localStorage.setItem('theme', 'light');
                }
            });
        });
    </script>

    @stack('scripts')
@endsection
