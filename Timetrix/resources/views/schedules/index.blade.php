@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Schedules</h1>
        <a href="{{ route('schedules.create') }}" class="btn btn-primary mb-3">Add Schedule</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->schedule_id }}</td>
                    <td>{{ $schedule->day }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>
                        <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No schedules found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $schedules->links() }}
    </div>
@endsection
