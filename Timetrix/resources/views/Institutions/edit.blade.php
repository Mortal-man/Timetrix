@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center text-primary text-bold">EDIT INSTITUTION DETAILS</h2>
        <hr>

        <form action="{{ route('institution.update', $institution->institution_id) }}" method="POST" enctype="multipart/form-data" class="card shadow p-4">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Institution Name</label>
                <input type="text" name="name" value="{{ old('name', $institution->name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="abbreviation">Abbreviation</label>
                <input type="text" name="abbreviation" value="{{ old('abbreviation', $institution->abbreviation) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="motto">Motto</label>
                <input type="text" name="motto" value="{{ old('motto', $institution->motto) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email', $institution->email) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $institution->phone) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="text" name="website" value="{{ old('website', $institution->website) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" class="form-control">{{ old('address', $institution->address) }}</textarea>
            </div>

            <div class="form-group">
                <label for="logo">Institution Logo</label>
                <input type="file" name="logo" class="form-control-file">
                @if($institution->logo)
                    <br>
                    <img src="{{ asset($institution->logo) }}" alt="Logo" height="80">
                @endif
            </div>

            <button type="submit" class="btn btn-success btn-block">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
@endsection
