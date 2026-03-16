@extends('layouts.masteradmin')

@section('title', 'Manage Command & Technical Team')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold">Command & Technical Team ({{ $members->total() }})</h2>
        <a href="{{ route('admin.committee.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle"></i> Add New Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Photo</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td class="ps-4 text-muted">{{ ($members->currentPage()-1) * $members->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($member->photo_path)
                                    <img 
                                        src="{{ asset($member->photo_path) }}" 
                                        alt="{{ $member->full_name }}" 
                                        class="rounded-circle" 
                                        style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #eee;"
                                    >
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; background: #f0f0f0; border: 2px solid #eee;">
                                        <i class="bi bi-person text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $member->full_name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info px-3">{{ $member->purpose }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $member->type == 'committee' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning' }} px-3">
                                    {{ ucfirst($member->type) }}
                                </span>
                            </td>
                            <td>
                                <a href="mailto:{{ $member->email }}" class="text-decoration-none">
                                    {{ $member->email }}
                                </a>
                            </td>
                            <td>
                                <a href="tel:{{ $member->phone }}" class="text-decoration-none">
                                    {{ $member->phone }}
                                </a>
                            </td>
                            <td>
                                <span class="badge rounded-pill 
                                    @if($member->status == 'Active') bg-success-subtle text-success 
                                    @else bg-secondary-subtle text-secondary @endif px-3">
                                    {{ $member->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.committee.edit', $member->id) }}" 
                                       class="btn btn-sm btn-outline-primary px-3 rounded-pill me-2">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.committee.destroy', $member->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this member?')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                No committee members found. <a href="{{ route('admin.committee.create') }}">Add one now</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($members->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
