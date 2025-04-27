@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center text-success text-bold">INSTITUTION PROFILE</h2>
        <hr>

        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if($institution)
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $institution->name }}</td>
                        </tr>
                        <tr>
                            <th>Abbreviation:</th>
                            <td>{{ $institution->abbreviation }}</td>
                        </tr>
                        <tr>
                            <th>Motto:</th>
                            <td>{{ $institution->motto }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $institution->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $institution->phone }}</td>
                        </tr>
                        <tr>
                            <th>Website:</th>
                            <td><a href="{{ $institution->website }}" target="_blank">{{ $institution->website }}</a></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $institution->address }}</td>
                        </tr>
                        <tr>
                            <th>Logo:</th>
                            <td>
                                @if($institution->logo)
                                    <img src="{{ asset($institution->logo) }}" alt="Logo" height="80">
                                @else
                                    <em>No logo uploaded</em>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a href="{{ route('institution.edit', $institution->institution_id) }}" class="btn btn-primary float-right">
                        <i class="fas fa-edit"></i> Edit Details
                    </a>
                </div>
            </div>
        @else
            <p class="text-center text-danger">No institution details found.</p>
        @endif
    </div>
@endsection
