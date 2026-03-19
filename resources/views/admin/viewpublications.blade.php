{{-- FILE: resources/views/admin/viewpublications.blade.php (CORRECTED) --}}
@extends('layouts.masteradmin')

@section('title', 'Publications')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="fw-bold mb-2">All Publications</h2>
        <div>
            <button class="btn btn-secondary btn-sm me-2" onclick="openHistoryModal()">
                <i class="fas fa-history me-1"></i>History
            </button>
            <a href="{{ route('admin.publications.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Add Publication
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>MainCategory</th>
                        <th>Subcategory</th>
                        <th>Price</th>
                        <th>Visible</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publications as $pub)
                    <tr id="pubRow{{ $pub->id }}" class="publication-row">
                        <td><span class="badge bg-secondary">{{ $pub->id }}</span></td>
                        <td class="fw-semibold pubTitle">
                            {{ Str::limit($pub->title, 40) }}
                        </td>
                        <td>
                            <img 
                                src="{{ $pub->title_image 
                                        ? (Str::startsWith($pub->title_image, ['http://','https://']) 
                                            ? $pub->title_image 
                                            : asset('public/'. $pub->title_image)) 
                                        : 'https://picsum.photos/60/60?random=' . $pub->id }}" 
                                width="50" 
                                height="50"
                                class="rounded shadow-sm pubImage" 
                                alt="{{ $pub->title }}"
                                style="object-fit: cover;">

                        </td>
                        <td class="pubMainCategoryName">
                            <small class="text-muted">
                                {{ $pub->mainCategory->name ?? '❌ N/A' }}
                            </small>
                        </td>
                        <td class="pubSubcategoryName">
                            <small class="text-muted">
                                {{ $pub->subcategory->name ?? '❌ N/A' }}
                            </small>
                        </td>
                        <td class="pubPrice {{ $pub->price == 0 ? 'text-success fw-semibold' : 'text-warning fw-semibold' }}">
                            {{ $pub->price_label }}
                        </td>
                        <td>
                            <span class="badge {{ $pub->visibleType === 'public' ? 'bg-info' : 'bg-warning' }} pubVisible">
                                {{ ucfirst($pub->visibleType) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary view-edit-btn"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewEditModal"
                                    data-id="{{ $pub->id }}"
                                    data-title="{{ $pub->title }}"
                                    data-title-image="{{ asset('public/'.$pub->title_image) }}"
                                    data-content="{{ $pub->content }}"
                                    data-main-category-id="{{ $pub->main_category_id }}"
                                    data-subcategory-id="{{ $pub->subcategory_id }}"
                                    data-price="{{ $pub->price }}"
                                    data-visible="{{ $pub->visibleType }}"
                                    data-pdf="{{ $pub->pdf ? asset($pub->pdf) : '' }}"
                                    title="View and Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn"
                                    type="button"
                                    data-id="{{ $pub->id }}"
                                    data-title="{{ $pub->title }}"
                                    title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-3">No publications found.</p>
                                <a href="{{ route('admin.publications.create') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Create First Publication
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <!-- @if($publications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $publications->links() }}
        </div>
    @endif -->

    <!-- @if ($publications->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 admin-pagination">
            
            <div class="text-muted small">
                Showing 
                <strong>{{ $publications->firstItem() }}</strong> 
                to 
                <strong>{{ $publications->lastItem() }}</strong> 
                of 
                <strong>{{ $publications->total() }}</strong> entries
            </div>

            <div>
                {{ $publications->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>

        </div>
    @endif -->

    @if ($publications->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4 admin-pagination">

        <!-- Left: Showing entries -->
        <div class="text-muted small">
            Showing 
            <strong>{{ $publications->firstItem() }}</strong>
            to
            <strong>{{ $publications->lastItem() }}</strong>
            of
            <strong>{{ $publications->total() }}</strong> entries
        </div>

        <!-- Right: Pagination -->
        <div>
            {{ $publications->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>

    </div>
    @endif


</div>

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-history me-2"></i>Publication History</h5>
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

{{-- View/Edit Modal --}}
<div class="modal fade" id="viewEditModal" tabindex="-1" aria-labelledby="viewEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewEditModalLabel">
                    <i class="bi bi-pencil-square"></i> Edit Publication
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="modalMessage" class="mb-3"></div>

                <form id="editPublicationForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="pubId" name="id">

                    <div class="row g-3">
                        {{-- Title --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" id="modalTitle" name="title" class="form-control" required>
                        </div>

                        {{-- Main Category --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Main Category <span class="text-danger">*</span></label>
                            <select id="modalMainCategory" name="main_category_id" class="form-select" required>
                                <option value="">-- Select Main Category --</option>
                                @foreach($mainCategories as $mainCat)
                                    <option value="{{ $mainCat->id }}">{{ $mainCat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Subcategory --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Subcategory <span class="text-danger">*</span></label>
                            <select id="modalSubcategory" name="subcategory_id" class="form-select" required>
                                <option value="">-- Select Subcategory --</option>
                            </select>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Price</label>
                            <input type="number" step="0.01" id="modalPrice" name="price" class="form-control" placeholder="0 for Free" min="0">
                            <small class="text-muted">Leave 0 for free publication</small>
                        </div>

                        {{-- Visible Type --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Visibility <span class="text-danger">*</span></label>
                            <select id="modalVisible" name="visibleType" class="form-select" required>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>

                        {{-- Content --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea id="modalContent" name="content" class="form-control" rows="5" required></textarea>
                        </div>

                        {{-- Title Image --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title Image</label>
                            <input type="file" id="modalImageInput" name="title_image" class="form-control mb-2" accept="image/*">
                            <img id="modalImage" src="" alt="Current Image" class="img-fluid rounded shadow-sm" style="max-height: 150px; display: none;">
                        </div>

                        {{-- PDF Upload --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">PDF File</label>
                            <input type="file" id="modalPdf" name="pdf" class="form-control mb-2" accept="application/pdf">
                            <a id="modalPdfLink" href="#" target="_blank" class="btn btn-outline-secondary btn-sm w-100" style="display: none;">
                                <i class="bi bi-file-pdf"></i> View Current PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deletePublicationBtn">
                    <i class="bi bi-trash"></i> Delete
                </button>
                <button type="button" class="btn btn-success" id="saveChangesBtn">
                    <span class="spinner-border spinner-border-sm d-none me-2" id="saveSpinner"></span>
                    <i class="bi bi-check-lg"></i> Save Changes
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    fetch('{{ route("admin.publications.history") }}')
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

document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';
    const modalMessage = document.getElementById('modalMessage');
    const modalMainCategorySelect = document.getElementById('modalMainCategory');
    const modalSubcategorySelect = document.getElementById('modalSubcategory');

    // Categories data from server
    const categoriesData = @json($mainCategories->mapWithKeys(fn($t) => [$t->id => $t->subcategories]));

    // ====================================================================
    // HELPER FUNCTIONS
    // ====================================================================

    function showModalMessage(msg, type = 'success') {
        modalMessage.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${msg}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function loadSubcategories(mainCategoryId, selectedSubcategoryId = null) {
        modalSubcategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
        
        if (!mainCategoryId) {
            return;
        }

        const subs = categoriesData[mainCategoryId] || [];
        if (subs.length === 0) {
            modalSubcategorySelect.innerHTML = '<option value="">-- No subcategories available --</option>';
        } else {
            subs.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.name;
                if (selectedSubcategoryId && sub.id == selectedSubcategoryId) {
                    opt.selected = true;
                }
                modalSubcategorySelect.appendChild(opt);
            });
        }
    }

    // ====================================================================
    // MODAL EVENTS
    // ====================================================================

    // When main category changes, reload subcategories
    modalMainCategorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });

    // Populate modal when edit button is clicked
    document.querySelectorAll('.view-edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const mainCategoryId = this.dataset.mainCategoryId;
            const subcategoryId = this.dataset.subcategoryId;

            document.getElementById('pubId').value = id;
            document.getElementById('modalTitle').value = this.dataset.title;
            document.getElementById('modalContent').value = this.dataset.content;
            document.getElementById('modalPrice').value = this.dataset.price;
            document.getElementById('modalVisible').value = this.dataset.visible.toLowerCase();
            
            // Set image
            const imgElement = document.getElementById('modalImage');
            if (this.dataset.titleImage) {
                imgElement.src = this.dataset.titleImage;
                imgElement.style.display = 'block';
            } else {
                imgElement.style.display = 'none';
            }

            // Handle PDF link
            const pdfLink = document.getElementById('modalPdfLink');
            if (this.dataset.pdf) {
                pdfLink.href = this.dataset.pdf;
                pdfLink.style.display = 'block';
            } else {
                pdfLink.style.display = 'none';
            }

            // Set main category and load subcategories
            modalMainCategorySelect.value = mainCategoryId;
            loadSubcategories(mainCategoryId, subcategoryId);

            // Clear any previous messages
            modalMessage.innerHTML = '';
        });
    });

    // Image preview in modal
    document.getElementById('modalImageInput').addEventListener('change', function(e) {
        const imgElement = document.getElementById('modalImage');
        if (e.target.files[0]) {
            imgElement.src = URL.createObjectURL(e.target.files[0]);
            imgElement.style.display = 'block';
        }
    });

    document.getElementById('modalPrice').addEventListener('input', function() {
    const price = parseFloat(this.value) || 0;
    const visibleSelect = document.getElementById('modalVisible');
    
    if (price > 0) {
        visibleSelect.value = 'private';
    } else {
        visibleSelect.value = 'public';
    }
   });

    // ====================================================================
    // SAVE CHANGES VIA AJAX
    // ====================================================================

    document.getElementById('saveChangesBtn').addEventListener('click', function() {
        const btn = this;
        const spinner = document.getElementById('saveSpinner');
        const id = document.getElementById('pubId').value;
        const url = '{{ route("admin.publications.update", ":id") }}'.replace(':id', id);
        const formData = new FormData(document.getElementById('editPublicationForm'));

        btn.disabled = true;
        spinner.classList.remove('d-none');

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            spinner.classList.add('d-none');

            if (data.success) {
                showModalMessage('Publication updated successfully!', 'success');
                
                // Update the table row
                const row = document.getElementById(`pubRow${id}`);
                if (row) {
                    row.querySelector('.pubTitle').innerText = data.publication.title;
                    row.querySelector('.pubMainCategoryName').innerText = data.publication.main_category_name || '❌ N/A';
                    row.querySelector('.pubSubcategoryName').innerText = data.publication.subcategory_name || '❌ N/A';
                    row.querySelector('.pubPrice').innerText = data.publication.price_label;
                    row.querySelector('.pubVisible').innerText = data.publication.visibleType;
                    row.querySelector('.pubImage').src = data.publication.title_image;

                    // Update price styling
                    const priceCell = row.querySelector('.pubPrice');
                    priceCell.className = data.publication.price == 0 
                        ? 'pubPrice text-success fw-semibold' 
                        : 'pubPrice text-warning fw-semibold';
                }
                
                // Close modal after 1 second
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('viewEditModal')).hide();
                }, 1500);
            } else {
                showModalMessage('Update failed. ' + (data.message || 'Please try again.'), 'danger');
            }
        })
        .catch(error => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            showModalMessage('❌ Error updating publication. Please try again.', 'danger');
            console.error('Error:', error);
        });
    });

    // ====================================================================
    // DELETE PUBLICATION VIA AJAX
    // ====================================================================

    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.dataset.id;
            const title = btn.dataset.title;

            if (!confirm(`Are you sure you want to delete "${title}"?`)) return;

            const url = '{{ route("admin.publications.destroy", ":id") }}'.replace(':id', id);

            fetch(url, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById(`pubRow${id}`);
                    if (row) {
                        row.style.animation = 'fadeOut 0.3s ease-out';
                        setTimeout(() => row.remove(), 300);
                    }
                    // Close modal if open
                    const modal = bootstrap.Modal.getInstance(document.getElementById('viewEditModal'));
                    if (modal) modal.hide();
                } else {
                    alert('Failed to delete publication: ' + (data.message || ''));
                }
            })
            .catch(error => {
                alert('Error deleting publication.');
                console.error('Error:', error);
            });
        }
    });
});
</script>

<style>
@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(-10px);
    }
}
</style>
@endsection