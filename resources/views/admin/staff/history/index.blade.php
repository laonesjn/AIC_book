@extends('layouts.masteradmin')

@section('content')
<div class="page-header animate-in">
    <div class="page-header-left">
        <h1><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Staff History</h1>
        <p><i class="bi bi-house"></i> Dashboard / Staff Management / History</p>
    </div>
</div>

<div class="row g-4 animate-in delay-1">
    @foreach($modules as $key => $module)
    <div class="col-md-4">
        <div class="card h-100 hover-lift shadow-sm border-0" style="transition: transform 0.2s;">
            <div class="card-body text-center py-4">
                <div class="icon-box mb-3 mx-auto" style="width: 70px; height: 70px; background: rgba(var(--primary-rgb, 10, 102, 194), 0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi {{ $module['icon'] }}" style="font-size: 2rem; color: var(--primary);"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">{{ $module['name'] }}</h4>
                <p class="text-muted small mb-4">View audit trail and history for all {{ strtolower($module['name']) }} items.</p>
                <a href="{{ route('admin.staff.history.items', $key) }}" class="btn btn-outline-primary rounded-pill px-4">
                    Explore History
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.icon-box {
    transition: all 0.3s ease;
}
.hover-lift:hover .icon-box {
    background: var(--primary) !important;
}
.hover-lift:hover .icon-box i {
    color: white !important;
}
</style>
@endsection
