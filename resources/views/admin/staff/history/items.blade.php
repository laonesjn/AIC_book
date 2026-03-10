@extends('layouts.masteradmin')

@section('content')
<div class="page-header animate-in">
    <div class="page-header-left">
        <h1><i class="bi {{ $module['icon'] }} me-2" style="color:var(--primary)"></i>{{ $module['name'] }} History</h1>
        <p><i class="bi bi-house"></i> Dashboard / Staff Management / History / {{ $module['name'] }}</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.staff.history.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Back to Modules
        </a>
    </div>
</div>

<div class="card animate-in delay-1">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Select Item to View Activity</h5>
        <form action="{{ route('admin.staff.history.items', $moduleKey) }}" method="GET" class="d-flex" style="max-width: 300px;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search {{ strtolower($module['name']) }}..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4"># ID</th>
                        <th>{{ $module['name'] }} Name / Title</th>
                        <th>Last Action</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td class="ps-4">#{{ $item->id }}</td>
                        <td class="fw-medium">{{ $item->{$module['title_field']} }}</td>
                        <td>
                            @php
                                $lastAudit = \App\Models\AuditLog::where('model_type', get_class($item))
                                    ->where('model_id', $item->id)
                                    ->latest()
                                    ->first();
                            @endphp
                            @if($lastAudit)
                                <span class="badge rounded-pill bg-{{ $lastAudit->action === 'created' ? 'success' : ($lastAudit->action === 'deleted' ? 'danger' : 'warning') }} text-capitalize">
                                    {{ $lastAudit->action }}
                                </span>
                                <span class="text-muted small ms-2">{{ $lastAudit->created_at->diffForHumans() }}</span>
                            @else
                                <span class="text-muted small">No history recorded</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.staff.history.show', [$moduleKey, $item->id]) }}" class="btn btn-sm btn-light rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> View Full History
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No {{ strtolower($module['name']) }} items found matching your criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($items->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $items->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
