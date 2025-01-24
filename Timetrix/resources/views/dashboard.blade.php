@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Timetrix Dashboard</h1>
        <div class="row">
            <!-- Departments -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Departments</h5>
                        <p class="card-text">Manage all departments.</p>
                        <a href="{{ route('departments.index') }}" class="btn btn-primary">Go to Departments</a>
                    </div>
                </div>
            </div>

            <!-- Courses -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Courses</h5>
                        <p class="card-text">Manage all courses.</p>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary">Go to Courses</a>
                    </div>
                </div>
            </div>

            <!-- Instructors -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Instructors</h5>
                        <p class="card-text">Manage instructors.</p>
                        <a href="{{ route('instructors.index') }}" class="btn btn-primary">Go to Instructors</a>
                    </div>
                </div>
            </div>

            <!-- Classrooms -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Classrooms</h5>
                        <p class="card-text">Manage classrooms.</p>
                        <a href="{{ route('classrooms.index') }}" class="btn btn-primary">Go to Classrooms</a>
                    </div>
                </div>
            </div>

            <!-- Schedules -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Schedules</h5>
                        <p class="card-text">Manage schedules.</p>
                        <a href="{{ route('schedules.index') }}" class="btn btn-primary">Go to Schedules</a>
                    </div>
                </div>
            </div>

            <!-- Timetables -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Timetables</h5>
                        <p class="card-text">Manage timetables.</p>
                        <a href="{{ route('timetables.index') }}" class="btn btn-primary">Go to Timetables</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
