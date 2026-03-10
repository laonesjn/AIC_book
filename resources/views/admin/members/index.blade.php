@extends('layouts.masteradmin')

@section('title', 'Manage Members')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Membership Applications ({{ $members->total() }})</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
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
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td class="ps-4 text-muted">{{ ($members->currentPage()-1) * $members->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ route('admin.members.photo', $member->id) }}" alt="" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover; border: 1px solid #eee;">
                                    <span class="fw-semibold">{{ $member->full_name }}</span>
                                </div>
                            </td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                <span class="badge rounded-pill 
                                    @if($member->status == 'Approved') bg-success-subtle text-success 
                                    @elseif($member->status == 'Rejected') bg-danger-subtle text-danger 
                                    @else bg-warning-subtle text-warning @endif px-3">
                                    {{ $member->status }}
                                </span>
                            </td>
                            <td>{{ $member->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill me-2">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                No membership applications found.
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
