@extends('layouts.masteradmin')

@section('title', 'View Documentation Archives')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold">Archived Documentation Submissions ({{ $archives->total() }})</h2>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addressModal">
            <i class="bi bi-geo-alt"></i> Update Submission Address
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
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
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
                            <th>Donor Details</th>
                            <th>Author</th>
                            <th>Doc Type</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archives as $archive)
                        <tr style="cursor:pointer;" 
                            data-id="{{ $archive->id }}"
                            data-donor="{{ $archive->donor_name }}"
                            data-email="{{ $archive->donor_email }}"
                            data-phone="{{ $archive->donor_phone }}"
                            data-author="{{ $archive->author_name }}"
                            data-type="{{ strtoupper($archive->doc_type) }}"
                            data-description="{{ $archive->description }}"
                            data-date="{{ $archive->created_at->format('M d, Y H:i') }}"
                            data-status="{{ ucfirst($archive->status) }}"
                            data-has-file="{{ $archive->file_path ? 'true' : 'false' }}"
                            data-download-url="{{ $archive->file_path ? route('admin.archives.download', $archive->id) : '#' }}"
                        >
                            <td class="ps-4 text-muted">{{ ($archives->currentPage()-1) * $archives->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $archive->donor_name }}</span>
                                    <small class="text-muted">{{ $archive->donor_email }}</small>
                                </div>
                            </td>
                            <td>{{ $archive->author_name }}</td>
                            <td>
                                <span class="badge {{ $archive->doc_type == 'pdf' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning' }} px-3">
                                    {{ strtoupper($archive->doc_type) }}
                                </span>
                            </td>
                            <td>{{ $archive->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.archives.status', $archive->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle status" onclick="event.stopPropagation()">
                                        <span class="badge rounded-pill 
                                            @if($archive->status == 'pending') bg-info-subtle text-info 
                                            @elseif($archive->status == 'archived') bg-success-subtle text-success
                                            @else bg-secondary-subtle text-secondary @endif px-3">
                                            {{ $archive->status == 'archived' ? 'Accepted' : ucfirst($archive->status) }}
                                            <i class="bi bi-arrow-repeat ms-1 small"></i>
                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    @if($archive->doc_type == 'pdf' && $archive->file_path)
                                        <a href="{{ route('admin.archives.download', $archive->id) }}" 
                                           class="btn btn-sm btn-outline-success px-3 rounded-pill me-2"
                                           onclick="event.stopPropagation()">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    @endif
                                    <button class="btn btn-sm btn-outline-primary px-3 rounded-pill btn-view-archive">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-archive fs-2 d-block mb-2"></i>
                                No documentation submissions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($archives->hasPages())
        <div class="card-footer bg-white border-0 py-3 text-center">
            {{ $archives->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Archive Detail Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Submission Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-uppercase small fw-bold text-muted mb-3">Donor Information</h6>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Name</span>
                                <span id="modal-donor" class="fw-semibold"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Email</span>
                                <span id="modal-email" class="fw-semibold"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Phone</span>
                                <span id="modal-phone" class="fw-semibold"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase small fw-bold text-muted mb-3">Documentation Details</h6>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Author</span>
                                <span id="modal-author" class="fw-semibold"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Type</span>
                                <span id="modal-type" class="badge px-3"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                                <span>Date</span>
                                <span id="modal-date" class="fw-semibold text-muted"></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-uppercase small fw-bold text-muted mb-2">Description</h6>
                    <div id="modal-description" class="p-3 bg-light rounded-3" style="white-space: pre-wrap;"></div>
                </div>

                <div id="modal-file-info" class="alert alert-info d-flex align-items-center d-none">
                    <i class="bi bi-file-earmark-pdf fs-4 me-3"></i>
                    <div>
                        <h6 class="mb-0 fw-bold">PDF Attached</h6>
                        <small>You can download the digital copy using the button below.</small>
                    </div>
                </div>

                <div id="modal-book-info" class="alert alert-warning d-flex align-items-center d-none">
                    <i class="bi bi-box-seam fs-4 me-3"></i>
                    <div>
                        <h6 class="mb-0 fw-bold">Physical Submission</h6>
                        <small>This is a hard copy book. Please verify if it has been received at the office.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <a id="modal-download-btn" href="#" class="btn btn-success rounded-pill px-4 d-none">
                    <i class="bi bi-download"></i> Download PDF
                </a>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Address Update Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Update Submission Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="key" value="submission_address">
                <div class="modal-body pt-2">
                    <p class="text-muted small mb-3">This address will be shown to users who choose "Hard Copy Book" as their documentation type.</p>
                    <div class="form-group">
                        <label for="address_value" class="fw-bold mb-2">Office Address</label>
                        <textarea name="value" id="address_value" class="form-control" rows="5" required>{{ $address }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var archiveModal = new bootstrap.Modal(document.getElementById('archiveModal'));

    function openArchiveModal(row) {
        var d = row.dataset;

        document.getElementById('modal-donor').textContent = d.donor;
        document.getElementById('modal-email').textContent = d.email;
        document.getElementById('modal-phone').textContent = d.phone;
        document.getElementById('modal-author').textContent = d.author;
        document.getElementById('modal-date').textContent = d.date;
        document.getElementById('modal-description').textContent = d.description || 'No description provided.';

        var typeEl = document.getElementById('modal-type');
        typeEl.textContent = d.type;
        typeEl.className = 'badge px-3 ' + (d.type === 'PDF' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning');

        var downloadBtn = document.getElementById('modal-download-btn');
        var fileInfo = document.getElementById('modal-file-info');
        var bookInfo = document.getElementById('modal-book-info');

        if (d.type === 'PDF') {
            bookInfo.classList.add('d-none');
            if (d.hasFile === 'true') {
                downloadBtn.classList.remove('d-none');
                downloadBtn.href = d.downloadUrl;
                fileInfo.classList.remove('d-none');
            } else {
                downloadBtn.classList.add('d-none');
                fileInfo.classList.add('d-none');
            }
        } else {
            downloadBtn.classList.add('d-none');
            fileInfo.classList.add('d-none');
            bookInfo.classList.remove('d-none');
        }

        archiveModal.show();
    }

    document.querySelectorAll('tbody tr[data-id]').forEach(function (row) {
        row.addEventListener('click', function () {
            openArchiveModal(this);
        });
    });

    document.querySelectorAll('.btn-view-archive').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openArchiveModal(this.closest('tr'));
        });
    });
});
</script>
@endsection
