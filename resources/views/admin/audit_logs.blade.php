@extends('layouts.masteradmin')

@section('content')
<div class="page-header animate-in">
    <div class="page-header-left">
        <h1><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Audit Trail</h1>
        <p><i class="bi bi-house"></i> Dashboard / Audit Trail</p>
    </div>
</div>

<div class="card animate-in delay-1">
    <div class="card-body">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Model ID</th>
                        <th>Changes</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td><strong>{{ $log->admin->name ?? 'Unknown' }}</strong></td>
                        <td>
                            <span class="badge @if($log->action === 'created') bg-success @elseif($log->action === 'updated') bg-warning text-dark @else bg-danger @endif">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>
                        <td>{{ class_basename($log->model_type) }}</td>
                        <td>{{ $log->model_id }}</td>
                        <td>
                            @if($log->changes)
                                <button class="btn btn-sm btn-outline-info" onclick="showChanges({{ $log->id }})">View Changes</button>
                                <div id="changes-{{ $log->id }}" class="d-none">
                                    <pre class="bg-light p-2 mt-2 rounded" style="font-size: 0.8rem;">{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            @else
                                <span class="text-muted">No details</span>
                            @endif
                        </td>
                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No audit logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<script>
function showChanges(id) {
    const el = document.getElementById('changes-' + id);
    el.classList.toggle('d-none');
}
</script>
@endsection
