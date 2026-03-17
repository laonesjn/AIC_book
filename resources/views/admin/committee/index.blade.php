@extends('layouts.masteradmin')

@section('title', 'Manage Committee and Technical team members')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold">Committee and Technical team members ({{ $members->total() }})</h2>
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
                        <tr style="cursor:pointer;" 
                            data-bs-toggle="modal" data-bs-target="#memberModal"
                            data-id="{{ $member->id }}"
                            data-name="{{ $member->full_name }}"
                            data-purpose="{{ $member->purpose }}"
                            data-type="{{ ucfirst($member->type) }}"
                            data-email="{{ $member->email }}"
                            data-phone="{{ $member->phone }}"
                            data-address="{{ $member->address }}"
                            data-nic="{{ $member->nic }}"
                            data-status="{{ $member->status }}"
                            data-photo="{{ $member->photo_path ? asset($member->photo_path) : '' }}"
                        >
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
                                       class="btn btn-sm btn-outline-primary px-3 rounded-pill me-2"
                                       onclick="event.stopPropagation()">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.committee.destroy', $member->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this member?')"
                                          style="display: inline;"
                                          onclick="event.stopPropagation()">
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
<!-- Member Detail Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Member Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="text-center mb-3">
                    <img id="modal-photo" src="" alt="" class="rounded-circle d-none" style="width:90px;height:90px;object-fit:cover;border:3px solid #eee;">
                    <div id="modal-photo-placeholder" class="rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:90px;height:90px;background:#f0f0f0;border:3px solid #eee;">
                        <i class="bi bi-person fs-2 text-muted"></i>
                    </div>
                    <h5 class="fw-bold mt-2 mb-0" id="modal-name"></h5>
                    <span id="modal-purpose" class="badge bg-info-subtle text-info px-3 mt-1"></span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Type</span>
                        <span id="modal-type" class="fw-semibold"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Email</span>
                        <a id="modal-email" href="#" class="fw-semibold text-decoration-none"></a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Phone</span>
                        <a id="modal-phone" href="#" class="fw-semibold text-decoration-none"></a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">NIC</span>
                        <span id="modal-nic" class="fw-semibold"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Address</span>
                        <span id="modal-address" class="fw-semibold text-end" style="max-width:60%"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Status</span>
                        <span id="modal-status" class="badge rounded-pill px-3"></span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer border-0 pt-0">
                <a id="modal-edit-btn" href="#" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('memberModal').addEventListener('show.bs.modal', function (e) {
    const row = e.relatedTarget;
    const d = row.dataset;

    document.getElementById('modal-name').textContent = d.name;
    document.getElementById('modal-purpose').textContent = d.purpose;
    document.getElementById('modal-type').textContent = d.type;

    const emailEl = document.getElementById('modal-email');
    emailEl.textContent = d.email;
    emailEl.href = 'mailto:' + d.email;

    const phoneEl = document.getElementById('modal-phone');
    phoneEl.textContent = d.phone || '—';
    phoneEl.href = 'tel:' + d.phone;

    document.getElementById('modal-nic').textContent = d.nic || '—';
    document.getElementById('modal-address').textContent = d.address || '—';

    const statusEl = document.getElementById('modal-status');
    statusEl.textContent = d.status;
    statusEl.className = 'badge rounded-pill px-3 ' + (d.status === 'Active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary');

    const photo = document.getElementById('modal-photo');
    const placeholder = document.getElementById('modal-photo-placeholder');
    if (d.photo) {
        photo.src = d.photo;
        photo.classList.remove('d-none');
        placeholder.classList.add('d-none');
    } else {
        photo.classList.add('d-none');
        placeholder.classList.remove('d-none');
    }

    document.getElementById('modal-edit-btn').href = '{{ url('admin/committee') }}/' + d.id + '/edit';
});
</script>

@endsection
