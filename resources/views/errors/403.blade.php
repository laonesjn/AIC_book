@extends('layouts.masteradmin')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center animate-in">
        <h1 class="display-1 fw-bold" style="color: var(--primary);">403</h1>
        <h2 class="mb-4">Unauthorized Access</h2>
        <p class="text-muted mb-4">You do not have permission to access this resource.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn-primary-custom">
            <i class="bi bi-house-door me-2"></i>Return to Dashboard
        </a>
    </div>
</div>
@endsection
