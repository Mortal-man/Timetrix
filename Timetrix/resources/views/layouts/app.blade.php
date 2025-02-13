@extends('adminlte::page')

@section('title', 'Timetrix')

@section('css')
    <!-- Custom Fonts and Styles -->
    <link href="{{ asset('css/custom_fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap">
@endsection

@section('content')
    <!-- Main Content -->
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

@section('right-sidebar')
    <!-- Optional Right Sidebar Content -->
@endsection

@section('js')
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
