@extends('layouts.masteradmin')

@section('title', 'Member Details')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.members.index') }}" class="btn btn-link text-decoration-none p-0 text-muted">
            <i class="bi bi-arrow-left"></i> Back to Members
        </a>
    </div>

    <div class="row g-4">
        <!-- Sidebar: Photo & Status -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                <div class="mb-4">
                    <img src="{{ route('admin.members.photo', $member->id) }}" alt="{{ $member->full_name }}" class="rounded-4 shadow-sm img-fluid" style="max-height: 300px; width: 100%; object-fit: cover;">
                </div>
                <h3 class="fw-bold mb-1">{{ $member->full_name }}</h3>
                <p class="text-muted mb-4">{{ $member->email }}</p>

                <div class="d-grid gap-2">
                    @if($member->status !== 'Approved')
                    <form action="{{ route('admin.members.status', $member->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Approved">
                        <button type="submit" class="btn btn-success w-100 rounded-pill">Approve Membership</button>
                    </form>
                    @endif

                    @if($member->status !== 'Rejected')
                    <form action="{{ route('admin.members.status', $member->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Rejected">
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">Reject Membership</button>
                    </form>
                    @endif
                </div>

                <hr class="my-4 opacity-50">

                <div class="text-start">
                    <p class="mb-1 text-muted small text-uppercase fw-bold">Current Status</p>
                    <span class="badge rounded-pill 
                        @if($member->status == 'Approved') bg-success-subtle text-success 
                        @elseif($member->status == 'Rejected') bg-danger-subtle text-danger 
                        @else bg-warning-subtle text-warning @endif px-3 fs-6">
                        {{ $member->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content: Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-4 border-bottom pb-2">Information Details</h4>
                
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase d-block mb-1">NIC Number</label>
                        <p class="fw-semibold fs-5">{{ $member->nic }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase d-block mb-1">Phone Number</label>
                        <p class="fw-semibold fs-5">{{ $member->phone }}</p>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small text-uppercase d-block mb-1">Address</label>
                        <p class="fw-semibold fs-5">{{ $member->address }}</p>
                    </div>
                </div>

                <h4 class="fw-bold mb-4 border-bottom pb-2">Application Purpose</h4>
                <div class="bg-light p-3 rounded-4 mb-5">
                    <p class="mb-0 fs-5 line-height-lg">{{ $member->purpose }}</p>
                </div>

                <h4 class="fw-bold mb-4 border-bottom pb-2">Verification Document</h4>
                <div class="d-flex align-items-center bg-info-subtle p-3 rounded-4">
                    <div class="flex-shrink-0">
                        <i class="bi bi-file-earmark-pdf fs-1 text-info"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0 fw-bold">Identity Verification Document</h6>
                        <small class="text-muted">PDF Document (Confidential)</small>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.members.document', $member->id) }}" class="btn btn-info text-white rounded-pill px-4">
                            <i class="bi bi-download"></i> Download / Preview
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-height-lg { line-height: 1.8; }
.bg-success-subtle { background-color: #d1e7dd; }
.bg-danger-subtle { background-color: #f8d7da; }
.bg-warning-subtle { background-color: #fff3cd; }
.bg-info-subtle { background-color: #cff4fc; }
</style>
@endsection
