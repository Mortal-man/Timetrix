@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="text-info text-center text-bold" style="text-transform: uppercase!important;">
                        AUDIT DETAIL VIEW
                    </h1>
                    <hr>
                </div>
            </div>
        </section>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary">
                    Audit #{{ $audit->id }} —
                    <span class="badge
                    @if ($audit->event === 'created') badge-success
                    @elseif ($audit->event === 'updated') badge-warning
                    @elseif ($audit->event === 'deleted') badge-danger
                    @else badge-secondary
                    @endif">
                    {{ ucfirst($audit->event) }}
                </span>
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>User:</strong> {{ optional($audit->user)->name ?? 'System' }}</li>
                    <li class="list-group-item"><strong>Date:</strong> {{ $audit->created_at->format('d M Y, H:i A') }}</li>
                    <li class="list-group-item"><strong>IP Address:</strong> {{ $audit->ip_address }}</li>
                    <li class="list-group-item"><strong>User Agent:</strong> {{ $audit->user_agent }}</li>
                    <li class="list-group-item"><strong>URL:</strong> {{ $audit->url }}</li>
                    <li class="list-group-item"><strong>Tags:</strong> {{ implode(', ', $audit->tags ?? []) }}</li>
                </ul>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">Old Values</h6>
                        <pre class="bg-light p-3 border rounded">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger">New Values</h6>
                        <pre class="bg-light p-3 border rounded">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('audits.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Audit Logs
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
