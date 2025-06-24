@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="text-success text-center text-bold" style="text-transform: uppercase!important;">
                        SYSTEM AUDIT TRAILS
                    </h1>
                    <hr>
                </div>
            </div>
        </section>

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="audits-reports-table" class="table table-striped table-bordered table-hover w-100">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>URL</th>
                        <th>Device IP</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($audits as $audit)
                        <tr>
                            <td>{{ $audit->id }}</td>
                            <td>
                                @if ($audit->event === 'created')
                                    <span class="badge badge-success">Created</span>
                                @elseif ($audit->event === 'updated')
                                    <span class="badge badge-warning">Updated</span>
                                @elseif ($audit->event === 'deleted')
                                    <span class="badge badge-danger">Deleted</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($audit->event) }}</span>
                                @endif
                            </td>
                            <td>{{ optional($audit->user)->name ?? 'System' }}</td>
                            <td>{{ $audit->created_at->format('d M Y, H:i A') }}</td>
                            <td>{{ $audit->url }}</td>
                            <td>{{ $audit->ip_address }}</td>
                            <td>
                                <a href="{{ route('audits.show', $audit->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-3">
                    {{ $audits->links() }} {{-- Laravel pagination --}}
                </div>
            </div>
        </div>
    </div>

    <style>
    .pagination { justify-content: center; }
    .page-item.active .page-link { background: #007bff; border-color: #007bff; }
    </style>

    <script>
        jQuery(document).ready(function($) {
            $('#audits-reports-table').DataTable({
                responsive: true,
                searching: true,
                paging: false, // Laravel handles pagination
                ordering: true,
                info: false,
            });
        });
    </script>
@endsection
