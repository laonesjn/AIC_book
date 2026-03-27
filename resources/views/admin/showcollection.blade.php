@extends('layouts.masteradmin')

@section('title', $collection->title)


@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="h4 mb-0">
                <i class="fas fa-file-alt me-2"></i>{{ $collection->title }}
            </h2>
            <small class="text-muted">
                Viewed {{ $collection->view_count }} times
            </small>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.collections.edit', $collection->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">

           @if($collection->title_image)
            <img src="{{ asset('public/'.$collection->title_image) }}"
     alt="Collection Cover"
     class="w-100 img-fluid rounded-3 collection-cover">
        @endif
            <!-- Description Card - DISPLAYS HTML CONTENT -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <!-- HTML content from rich text editor displays here -->
                    <div class="collection-description">
                        {!! $collection->description !!}
                    </div>
                </div>
            </div>

            <!-- Images Card -->
            @if($collection->images && count($collection->images) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Images ({{ count($collection->images) }} of 10)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($collection->images as $image)
                                <div class="col-md-4 col-lg-3">
                                    <img src="{{ asset('public/'.$image) }}" 
                                         class="img-thumbnail w-100" 
                                         alt="Collection Image"
                                         style="cursor: pointer; height: 200px; object-fit: cover;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#imageModal{{ $loop->index }}">
                                    
                                    <!-- Image Modal -->
                                    <div class="modal fade" id="imageModal{{ $loop->index }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Image Preview</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset($image) }}" 
                                                         class="w-100" 
                                                         alt="Collection Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- PDF Card -->
            @if($collection->pdf)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">PDF Document</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- <div>
                                <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                <span>{{ basename($collection->pdf) }}</span>
                            </div> -->
                            <a href="{{ asset($collection->pdf) }}" 
                               class="btn btn-primary" 
                               target="_blank">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- OneDrive Links Card -->
            @if($collection->oneDriveLinks && count($collection->oneDriveLinks) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">OneDrive Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($collection->oneDriveLinks as $link)
                                <a href="{{ $link->url }}" class="list-group-item list-group-item-action border-0 px-0" target="_blank">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="text-primary fw-medium">
                                            <i class="fas fa-link me-2 text-muted"></i>
                                            {{ $link->title ?: $link->url }}
                                        </div>
                                        <i class="fas fa-external-link-alt text-muted small"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Main Category:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-primary">
    {{ $collection->masterMainCategory->name ?? 'N/A' }}
</span>
                        </dd>

                       

                        <dt class="col-sm-5">Access Type:</dt>
                        <dd class="col-sm-7">
                            @if($collection->access_type === 'Public')
                                <span class="badge bg-success">
                                    <i class="fas fa-globe"></i> Public
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-lock"></i> Private
                                </span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Views:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-info">
                                <i class="fas fa-eye"></i> {{ $collection->view_count }}
                            </span>
                        </dd>

                        <dt class="col-sm-5">Images:</dt>
                        <dd class="col-sm-7">{{ count($collection->images ?? []) }}/10</dd>

                        <dt class="col-sm-5">PDF:</dt>
                        <dd class="col-sm-7">
                            @if($collection->pdf)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Created:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $collection->created_at->format('M d, Y H:i') }}</small>
                        </dd>

                        <dt class="col-sm-5">Updated:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $collection->updated_at->format('M d, Y H:i') }}</small>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.collections.edit', $collection->id) }}" 
                       class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Collection
                    </a>
                    <button type="button" 
                            class="btn btn-danger w-100"
                            onclick="deleteCollection({{ $collection->id }})">
                        <i class="fas fa-trash me-2"></i>Delete Collection
                    </button>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="mb-0">{{ count($collection->images ?? []) }}</h4>
                            <small class="text-muted">Images</small>
                        </div>
                        <div class="col-4">
                            <h4 class="mb-0">{{ $collection->view_count }}</h4>
                            <small class="text-muted">Views</small>
                        </div>
                        <div class="col-4">
                            <h4 class="mb-0">{{ $collection->pdf ? '1' : '0' }}</h4>
                            <small class="text-muted">PDF</small>
                        </div>
                    </div>
                </div>
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
                <p class="text-danger small"><strong>This action cannot be undone. All images and PDF will be permanently deleted.</strong></p>
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

<style>

    .collection-cover {
    height: 250px;
    object-fit: cover;
}

@media (max-width: 768px) {
    .collection-cover {
        height: 160px;
    }
}
    /* Rich Text Content Display Styling */
    .collection-description {
        font-size: 1rem;
        line-height: 1.6;
        color: #333;
    }

    .collection-description h1,
    .collection-description h2,
    .collection-description h3,
    .collection-description h4,
    .collection-description h5,
    .collection-description h6 {
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        color: #222;
        font-weight: 600;
    }

    .collection-description p {
        margin-bottom: 1rem;
    }

    .collection-description ul,
    .collection-description ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    .collection-description li {
        margin-bottom: 0.5rem;
    }

    .collection-description blockquote {
        border-left: 4px solid #007bff;
        padding-left: 1rem;
        margin: 1rem 0;
        color: #666;
        font-style: italic;
    }

    .collection-description code {
        background-color: #f5f5f5;
        padding: 0.2rem 0.4rem;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
        color: #d63384;
    }

    .collection-description pre {
        background-color: #f5f5f5;
        padding: 1rem;
        border-radius: 3px;
        overflow-x: auto;
        border-left: 4px solid #007bff;
    }

    .collection-description pre code {
        background-color: transparent;
        padding: 0;
        color: #333;
    }

    .collection-description strong {
        font-weight: 600;
        color: #222;
    }

    .collection-description em {
        font-style: italic;
    }

    .collection-description a {
        color: #007bff;
        text-decoration: none;
    }

    .collection-description a:hover {
        text-decoration: underline;
    }

    .collection-description img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin: 1rem 0;
    }

    .collection-description table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .collection-description table th,
    .collection-description table td {
        border: 1px solid #ddd;
        padding: 0.75rem;
        text-align: left;
    }

    .collection-description table th {
        background-color: #f5f5f5;
        font-weight: 600;
    }

    .collection-description hr {
        margin: 2rem 0;
        border: none;
        border-top: 2px solid #ddd;
    }
</style>

<script>
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
                    window.location.href = "{{ route('admin.collections.index') }}";
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