@extends('layouts.masteradmin')

@section('title', 'Manage Collections')
@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="h4 mb-0">
                <i class="fas fa-file-alt me-2"></i>Manage Collections
            </h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-secondary btn-sm me-2" onclick="openHistoryModal()">
                <i class="fas fa-history me-1"></i>History
            </button>
            <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create Collection
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search collections..." 
                    value="{{ request('search') }}">
                <select class="form-select" name="access_type" style="max-width: 150px;">
                    <option value="">All Types</option>
                    <option value="Public" {{ request('access_type') == 'Public' ? 'selected' : '' }}>Public</option>
                    <option value="Private" {{ request('access_type') == 'Private' ? 'selected' : '' }}>Private</option>
                </select>
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search') || request('access_type'))
                    <a href="{{ route('admin.collections.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Errors!</strong>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Collections Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Title</th>
                        <th width="15%">Category</th>
                        <th width="10%">Access Type</th>
                        <!-- <th width="10%">Views</th> -->
                        <th width="20%">Created</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collections as $collection)
                        <tr>
                            <td>{{ ($collections->currentPage() - 1) * $collections->perPage() + $loop->iteration }}</td>
                            <td>
                                <strong>{{ $collection->title }}</strong>
                            </td>
                            <td>
                                <small>
                                    <div>{{ $collection->masterMainCategory->name ?? 'N/A' }}</div>
                                </small>
                            </td>
                            <td>
                                @if($collection->isPublic())
                                    <span class="badge bg-success">
                                         Public
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        Private
                                    </span>
                                @endif
                            </td>
                            <!-- <td>
                                <span class="badge bg-info">
                                    <i class="fas fa-eye"></i> {{ $collection->view_count }}
                                </span>
                            </td> -->
                            <td>
                                <small>{{ $collection->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.collections.show', $collection->id) }}" 
                                    class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.collections.edit', $collection->id) }}" 
                                    class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                    onclick="deleteCollection({{ $collection->id }})">
                                     <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted mb-0">No collections found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($collections->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 admin-pagination">

            <!-- Left: Showing entries -->
            <div class="text-muted small">
                Showing 
                <strong>{{ $collections->firstItem() }}</strong>
                to
                <strong>{{ $collections->lastItem() }}</strong>
                of
                <strong>{{ $collections->total() }}</strong> entries
            </div>

            <!-- Right: Pagination -->
            <div>
                {{ $collections->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>

        </div>
    @endif
</div>

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-history me-2"></i>Collection History</h5>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Collection
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this collection?</p>
                <p class="text-danger small"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Yes, Delete
                </button>
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

        fetch('{{ route("admin.collections.history") }}')
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

    let collectionToDelete = null;

    function deleteCollection(collectionId) {
        collectionToDelete = collectionId;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (collectionToDelete) {
            const deleteUrl = "{{ route('admin.collections.destroy', ':id') }}".replace(':id', collectionToDelete);
            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to delete collection');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting');
            });
        }
    });
</script>
@endsection