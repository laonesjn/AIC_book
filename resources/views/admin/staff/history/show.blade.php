@extends('layouts.masteradmin')

@section('content')
<div class="page-header animate-in">
    <div class="page-header-left">
        <h1><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>{{ $itemName }} History</h1>
        <p><i class="bi bi-house"></i> Dashboard / Staff Management / History / {{ $module['name'] }} / Details</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.staff.history.items', $moduleKey) }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row animate-in delay-1">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-4 d-flex align-items-center">
                <div class="icon-box me-3" style="width: 50px; height: 50px; background: rgba(var(--primary-rgb, 10, 102, 194), 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi {{ $module['icon'] }}" style="font-size: 1.5rem; color: var(--primary);"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $itemName }}</h5>
                    <p class="text-muted small mb-0">Module: {{ $module['name'] }} | Total Actions: {{ $logs->count() }}</p>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="timeline">
                    @forelse($logs as $log)
                    <div class="timeline-item pb-4 position-relative ps-4">
                        <div class="timeline-marker position-absolute rounded-circle" style="left: 0; width: 14px; height: 14px; border: 3px solid white; z-index: 1; top: 5px; background: {{ $log->action === 'created' ? '#28a745' : ($log->action === 'deleted' ? '#dc3545' : '#ffc107') }}; box-shadow: 0 0 0 3px {{ $log->action === 'created' ? 'rgba(40,167,69,0.2)' : ($log->action === 'deleted' ? 'rgba(220,53,69,0.2)' : 'rgba(255,193,7,0.2)') }};"></div>
                        
                        <div class="timeline-content p-3 rounded-4 bg-light border-0 shadow-none">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge rounded-pill bg-{{ $log->action === 'created' ? 'success' : ($log->action === 'deleted' ? 'danger' : 'warning') }} text-capitalize mb-2">
                                        {{ $log->action }}
                                    </span>
                                    <h6 class="mb-0 fw-bold">By: {{ $log->admin->name ?? 'Unknown Staff' }}</h6>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-medium small">{{ $log->created_at->format('M d, Y') }}</p>
                                    <p class="mb-0 text-muted small">{{ $log->created_at->format('h:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($log->action === 'updated' && $log->changes)
                            <div class="mt-3 bg-white p-3 rounded-3 border">
                                <p class="small fw-bold text-muted text-uppercase mb-2">Changes Summary:</p>
                                <ul class="list-unstyled mb-0 small">
                                    @php
                                        $before = $log->changes['before'] ?? [];
                                        $after = $log->changes['after'] ?? [];
                                    @endphp
                                    @foreach($after as $field => $newValue)
                                        @if($field !== 'updated_at' && $field !== 'created_at')
                                        <li class="mb-1 py-1 border-bottom-dashed">
                                            <span class="fw-bold text-dark">{{ ucwords(str_replace('_', ' ', $field)) }}:</span>
                                            <span class="text-muted text-decoration-line-through me-2">{{ is_scalar($before[$field] ?? '') ? $before[$field] : '...' }}</span>
                                            <i class="bi bi-arrow-right mx-1 text-primary"></i>
                                            <span class="text-primary fw-medium">{{ is_scalar($newValue) ? $newValue : '...' }}</span>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-clock-fill text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No activity logs found for this item.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline::before {
    content: '';
    position: absolute;
    left: 26px;
    height: calc(100% - 30px);
    width: 2px;
    background: #e9ecef;
    top: 30px;
}
.border-bottom-dashed {
    border-bottom: 1px dashed #dee2e6;
}
.border-bottom-dashed:last-child {
    border-bottom: none;
}
.timeline-item:last-child::after {
    content: none;
}
</style>
@endsection
