{{-- resources/views/exhibitions/index.blade.php --}}
@extends('layouts.masteradmin')
@section('title', 'Exhibitions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="section-title mb-0">Virtual Exhibitions</h2>
    <div>
        <button class="btn btn-secondary btn-sm me-2" onclick="openHistoryModal()">
            <i class="fas fa-history me-1"></i>History
        </button>
        <a href="{{ route('admin.exhibitions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>New Exhibition
        </a>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control" placeholder="Search by title…"
               value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="category" class="form-select">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-outline-primary flex-fill">
            <i class="bi bi-search me-1"></i>Filter
        </button>
        <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg"></i>
        </a>
    </div>
</form>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($exhibitions as $exhibition)
    <div class="col">
        <div class="card h-100">
            @if($exhibition->cover_image)
                <img src="{{ asset('public/'.$exhibition->cover_image) }}"
                     class="card-img-top" style="height:190px;object-fit:cover" alt="{{ $exhibition->title }}">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center"
                     style="height:190px">
                    <i class="bi bi-image text-white" style="font-size:3rem"></i>
                </div>
            @endif

            <div class="card-body">
                <span class="badge bg-purple text-white mb-2">{{ $exhibition->category->name }}</span>
                <h5 class="card-title">{{ $exhibition->title }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($exhibition->description, 100) }}</p>
                <div class="d-flex gap-3 text-muted small">
                    <span><i class="bi bi-images me-1"></i>{{ $exhibition->gallery_images_count }}</span>
                    <span><i class="bi bi-box me-1"></i>{{ $exhibition->artifacts_count }} artifacts</span>
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $exhibition->schedule_count }} days</span>
                </div>
            </div>

            <div class="card-footer bg-transparent d-flex gap-2">
                <a href="{{ route('admin.exhibitions.show', $exhibition) }}"
                   class="btn btn-sm btn-primary">View</a>
                <a href="{{ route('admin.exhibitions.edit', $exhibition) }}"
                   class="btn btn-sm btn-outline-warning">Edit</a>
                <form action="{{ route('admin.exhibitions.destroy', $exhibition) }}" method="POST"
                      class="ms-auto" onsubmit="return confirm('Move to trash?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-collection" style="font-size:4rem"></i>
        <p class="mt-3">No exhibitions found.</p>
        <a href="{{ route('admin.exhibitions.create') }}" class="btn btn-primary">
            Create First Exhibition
        </a>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $exhibitions->links() }}</div>

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-history me-2"></i>Exhibition History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="historyLoading" class="text-center py-3">
                    <div class="spinner-border spinner-border-sm"></div> Loading...
                </div>
                <table class="table table-sm d-none" id="historyTable">
                    <thead class="table-light">
                        <tr>
                            <th>Action</th>
                            <th>Item Name</th>
                            <th>Changed By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="historyBody"></tbody>
                </table>
                <p class="text-muted text-center d-none" id="historyEmpty">No history found.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function openHistoryModal() {
        const modal = new bootstrap.Modal(document.getElementById('historyModal'));
        modal.show();

        document.getElementById('historyLoading').classList.remove('d-none');
        document.getElementById('historyTable').classList.add('d-none');
        document.getElementById('historyEmpty').classList.add('d-none');

        fetch('{{ route("admin.exhibitions.history") }}')
            .then(r => r.json())
            .then(data => {
                document.getElementById('historyLoading').classList.add('d-none');
                if (!data.length) {
                    document.getElementById('historyEmpty').classList.remove('d-none');
                    return;
                }
                const badge = a => a === 'deleted'
                    ? '<span class="badge bg-danger">Deleted</span>'
                    : '<span class="badge bg-warning text-dark">Edited</span>';
                document.getElementById('historyBody').innerHTML = data
                    .map(r => `<tr><td>${badge(r.action)}</td><td>${r.item_name}</td><td>${r.admin_name}</td><td>${r.date}</td></tr>`)
                    .join('');
                document.getElementById('historyTable').classList.remove('d-none');
            });
    }
</script>
@endsection