@extends('layouts.masteradmin')

@section('title', 'Manage Supporting Documents')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold">Manage Supporting Documents</h2>
        <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-file-earmark-plus"></i> Upload Document
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th class="ps-4">Title</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Link</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $doc->title }}</td>
                            <td>{{ $doc->description }}</td>
                            <td><span class="badge bg-secondary">{{ strtoupper($doc->file_type) }}</span></td>
                            <td><a href="{{ asset($doc->file_path) }}" target="_blank" class="text-decoration-none"><i class="bi bi-box-arrow-up-right"></i> View</a></td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-text fs-2 d-block mb-2"></i>
                                No documents found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Upload Supporting Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title *</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Volunteer Handbook">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Brief description of the document..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Document File (PDF, DOC, DOCX) *</label>
                        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Max file size: 10MB.</div>
                    </div>
                    <div class="text-end pt-3">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Upload Document</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection