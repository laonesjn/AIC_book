@extends('layouts.masteradmin')

@section('title', 'Manage Master Categories')

@section('content')
<div>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-2">
                <i class="fas fa-sitemap me-2"></i>Manage Master Categories
            </h2>
            <p class="text-muted small">Organize your main heritage categories into master groups</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="openAddMasterCategoryModal()">
                <i class="fas fa-plus me-2"></i>Add Master Category
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading mb-3">Validation Errors:</h5>
            @foreach($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h5 class="alert-heading mb-2">Success!</h5>
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search master categories..." 
                    value="{{ request('search') ?? '' }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search me-2"></i>Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.heritage-master-categories.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times me-2"></i>Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Master Categories Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Master Categories
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;"></th>
                        <th style="width: 80px;">ID</th>
                        <th>Category Name</th>
                        <th>Linked Categories</th>
                        <th>Updated At</th>
                        <th class="text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($masterCategories as $category)
                        <!-- Master Category Row -->
                        <tr class="master-category-row" data-master-id="{{ $category->id }}">
                            <td>
                                <button class="btn btn-sm btn-outline-secondary expand-toggle" 
                                    type="button"
                                    data-master-id="{{ $category->id }}"
                                    title="Expand/Collapse">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $category->id }}</span>
                            </td>
                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info linked-count" data-master-id="{{ $category->id }}">
                                    <i class="fas fa-link me-1"></i>{{ $category->mainCategories->count() }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $category->updated_at->format('M d, Y') ?? 'N/A' }}</small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning edit-master-btn" 
                                    title="Edit" 
                                    data-master-id="{{ $category->id }}"
                                    data-master-name="{{ $category->name }}"
                                    data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Linked Main Categories Row (Hidden by Default) -->
                        <tr class="linked-categories-container" data-master-id="{{ $category->id }}" style="display: none;">
                            <td colspan="6">
                                <div class="ms-4 py-4">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h6 class="mb-3">
                                                <i class="fas fa-link me-2"></i>Link Main Categories for "{{ $category->name }}"
                                            </h6>

                                            <!-- Checkboxes Container -->
                                            <div class="categories-checkboxes-container" data-master-id="{{ $category->id }}" style="display: none;">
                                                <!-- Checkboxes will be loaded here -->
                                            </div>

                                            <!-- Linked Categories Display -->
                                            <div class="linked-categories-display" data-master-id="{{ $category->id }}">
                                                <div class="text-center py-4">
                                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <small class="text-muted ms-2">Loading categories...</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No master categories found</p>
                                <small class="text-muted">Click "Add Master Category" to create one</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($masterCategories->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing 
                        <strong>{{ $masterCategories->firstItem() }}</strong>
                        to
                        <strong>{{ $masterCategories->lastItem() }}</strong>
                        of
                        <strong>{{ $masterCategories->total() }}</strong> entries
                    </div>
                    <div>
                        {{ $masterCategories->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Add/Edit Master Category Modal -->
<div class="modal fade" id="masterCategoryModal" tabindex="-1" aria-labelledby="masterCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="masterCategoryModalLabel">
                    <i class="fas fa-plus-circle me-2"></i><span id="modalTitle">Add Master Category</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="masterCategoryErrors" role="alert"></div>
                <form id="masterCategoryForm">
                    <input type="hidden" id="masterCategoryId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="masterCategoryName" 
                            placeholder="e.g., Electronics, Fashion, Home & Garden" required>
                        <small class="text-muted">Enter a unique category name</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveMasterCategoryBtn">
                    <span class="spinner-border spinner-border-sm d-none me-2" id="masterCategorySpinner"></span>
                    <span id="saveButtonText">Add Category</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteMasterCategoryModal" tabindex="-1" aria-labelledby="deleteMasterCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteMasterCategoryModalLabel">
                    <i class="fas fa-trash me-2"></i>Delete Master Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this master category?</p>
                <p class="text-muted"><strong id="deleteCategoryName"></strong></p>
                <div class="alert alert-danger" role="alert">
                    <small><strong>Warning:</strong> This action cannot be undone.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Yes, Delete Permanently
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Expand/Collapse Animation */
    .expand-toggle i {
        transition: transform 0.3s ease;
    }

    .expand-toggle[aria-expanded="true"] i {
        transform: rotate(90deg);
    }

    /* Table Row Hover */
    .master-category-row:hover {
        background-color: #f8f9fa;
    }

    /* Badge Styling */
    .linked-count {
        font-size: 0.875rem;
        padding: 0.4rem 0.6rem;
    }

    /* Modal Styling */
    .modal-header {
        border-bottom: 2px solid rgba(0,0,0,.1);
    }

    /* Categories Container */
    .categories-checkboxes-container {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        background-color: #f8f9fa;
    }

    .form-check-input {
        margin-right: 0.5rem;
    }

    /* Statistics Cards */
    .card-body {
        padding: 1.5rem;
    }

    .opacity-25 {
        opacity: 0.25;
    }
    
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';
    let masterCategoryModal = new bootstrap.Modal(document.getElementById('masterCategoryModal'));
    let deleteMasterCategoryModal = new bootstrap.Modal(document.getElementById('deleteMasterCategoryModal'));
    let loadedMasterCategories = new Set();
    let masterToDelete = null;

    // Initialize tooltips
    initializeTooltips();

    // ============================================================================
    // EXPAND/COLLAPSE FUNCTIONALITY
    // ============================================================================

    document.addEventListener('click', function(e) {
        const expandBtn = e.target.closest('.expand-toggle');
        if (expandBtn) {
            const masterId = expandBtn.dataset.masterId;
            const container = document.querySelector(`.linked-categories-container[data-master-id="${masterId}"]`);
            const icon = expandBtn.querySelector('i');

            if (container.style.display === 'none') {
                container.style.display = 'table-row';
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-down');
                expandBtn.setAttribute('aria-expanded', 'true');
                
                if (!loadedMasterCategories.has(masterId)) {
                    loadMainCategories(masterId);
                    loadedMasterCategories.add(masterId);
                }
            } else {
                container.style.display = 'none';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-right');
                expandBtn.setAttribute('aria-expanded', 'false');
            }
        }
    });

    // ============================================================================
    // MASTER CATEGORY CRUD OPERATIONS
    // ============================================================================

    window.openAddMasterCategoryModal = function() {
        resetMasterCategoryForm();
        masterCategoryModal.show();
    };

    document.getElementById('saveMasterCategoryBtn').addEventListener('click', function() {
        saveMasterCategory();
    });

    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-master-btn');
        if (editBtn) {
            const masterId = editBtn.dataset.masterId;
            const masterName = editBtn.dataset.masterName;
            openEditMasterCategoryModal(masterId, masterName);
        }
    });

    // ============================================================================
    // DELETE CATEGORY FUNCTIONALITY
    // ============================================================================

    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-master-btn');
        if (deleteBtn) {
            const masterId = deleteBtn.dataset.masterId;
            const masterName = deleteBtn.dataset.masterName;
            masterToDelete = masterId;
            document.getElementById('deleteCategoryName').textContent = masterName;
            deleteMasterCategoryModal.show();
        }
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (masterToDelete) {
            deleteMasterCategory(masterToDelete);
        }
    });

    // ============================================================================
    // UNLINK CATEGORIES FUNCTIONALITY
    // ============================================================================

    document.addEventListener('click', function(e) {
        const unlinkBtn = e.target.closest('.unlink-category-btn');
        if (unlinkBtn) {
            const masterId = unlinkBtn.dataset.masterId;
            const categoryId = unlinkBtn.dataset.categoryId;
            const categoryName = unlinkBtn.dataset.categoryName;
            if (confirm(`Unlink "${categoryName}" from this master category?`)) {
                unlinkCategory(masterId, categoryId);
            }
        }
    });

    // ============================================================================
    // SAVE CATEGORIES FUNCTIONALITY
    // ============================================================================

    document.addEventListener('click', function(e) {
        const saveBtn = e.target.closest('.save-categories-btn');
        if (saveBtn) {
            const masterId = saveBtn.dataset.masterId;
            saveLinkedCategories(masterId);
        }
    });

    // ============================================================================
    // HELPER FUNCTIONS
    // ============================================================================

    function initializeTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    function resetMasterCategoryForm() {
        document.getElementById('masterCategoryForm').reset();
        document.getElementById('masterCategoryId').value = '';
        document.getElementById('masterCategoryErrors').classList.add('d-none');
        document.getElementById('modalTitle').textContent = 'Add Master Category';
        document.getElementById('saveButtonText').textContent = 'Add Category';
    }

    window.openEditMasterCategoryModal = function(masterId, masterName) {
        document.getElementById('masterCategoryId').value = masterId;
        document.getElementById('masterCategoryName').value = masterName;
        document.getElementById('modalTitle').textContent = 'Edit Master Category';
        document.getElementById('saveButtonText').textContent = 'Update Category';
        document.getElementById('masterCategoryErrors').classList.add('d-none');
        masterCategoryModal.show();
    };

    function showError(errorDiv, errors) {
        let html = '<strong>Please fix the following errors:</strong><ul class="mb-0 mt-2">';
        if (typeof errors === 'object') {
            Object.values(errors).forEach(errorArray => {
                if (Array.isArray(errorArray)) {
                    errorArray.forEach(msg => {
                        html += `<li>${msg}</li>`;
                    });
                }
            });
        } else {
            html += `<li>${errors}</li>`;
        }
        html += '</ul>';
        errorDiv.innerHTML = html;
        errorDiv.classList.remove('d-none');
    }

    function saveMasterCategory() {
        const masterId = document.getElementById('masterCategoryId').value;
        const name = document.getElementById('masterCategoryName').value.trim();
        const errDiv = document.getElementById('masterCategoryErrors');
        const btn = document.getElementById('saveMasterCategoryBtn');
        const spinner = document.getElementById('masterCategorySpinner');

        if (!name) {
            showError(errDiv, 'Master category name is required');
            return;
        }

        btn.disabled = true;
        spinner.classList.remove('d-none');

        const formData = new FormData();
        formData.append('name', name);

        let url = '{{ route("admin.heritage-master-categories.store") }}';
        let method = 'POST';
        
        if (masterId) {
            url = `{{ route('admin.heritage-master-categories.update', ':id') }}`.replace(':id', masterId);
            method = 'POST';
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json().then(data => ({ status: response.status, data: data })))
        .then(({ status, data }) => {
            if (status === 422 && data.errors) {
                showError(errDiv, data.errors);
                btn.disabled = false;
                spinner.classList.add('d-none');
                return;
            }

            if (data.success) {
                masterCategoryModal.hide();
                setTimeout(() => location.reload(), 500);
            } else {
                showError(errDiv, data.message || 'An error occurred');
                btn.disabled = false;
                spinner.classList.add('d-none');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError(errDiv, 'An error occurred. Please try again.');
            btn.disabled = false;
            spinner.classList.add('d-none');
        });
    }

    function loadMainCategories(masterId) {
        const checkboxContainer = document.querySelector(`.categories-checkboxes-container[data-master-id="${masterId}"]`);
        const displayContainer = document.querySelector(`.linked-categories-display[data-master-id="${masterId}"]`);
        
        const url = `{{ route('admin.heritage-master-categories.availableCategories', ':id') }}`.replace(':id', masterId);
        
        fetch(url, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data && data.data.length > 0) {
                // Build checkboxes HTML
                let checkboxesHtml = '<div class="alert alert-info small mb-3"><i class="fas fa-info-circle me-2"></i>Select categories to link:</div>';
                
                data.data.forEach(category => {
                    const isLinked = category.master_main_category_id == masterId;
                    const checkboxId = `category_${category.id}_${masterId}`;
                    
                    checkboxesHtml += `
                        <div class="form-check mb-2">
                            <input class="form-check-input main-category-checkbox" type="checkbox" 
                                id="${checkboxId}" 
                                value="${category.id}"
                                data-master-id="${masterId}"
                                ${isLinked ? 'checked' : ''}>
                            <label class="form-check-label" for="${checkboxId}">
                                ${category.name}
                            </label>
                        </div>
                    `;
                });
                
                checkboxesHtml += `<button type="button" class="btn btn-sm btn-success save-categories-btn mt-3" data-master-id="${masterId}"><i class="fas fa-save me-2"></i>Save</button>`;
                checkboxContainer.innerHTML = checkboxesHtml;
                checkboxContainer.style.display = 'block';

                // Build linked categories display
                const linkedCategories = data.data.filter(cat => cat.master_main_category_id == masterId);
                
                if (linkedCategories.length > 0) {
                    let displayHtml = '<div class="table-responsive"><table class="table table-sm table-bordered mb-0"><thead class="table-light"><tr><th>ID</th><th>Name</th><th class="text-center" style="width: 100px;">Action</th></tr></thead><tbody>';
                    
                    linkedCategories.forEach(category => {
                        displayHtml += `
                            <tr>
                                <td><span class="badge bg-secondary">${category.id}</span></td>
                                <td><strong>${category.name}</strong></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning unlink-category-btn" 
                                        data-master-id="${masterId}"
                                        data-category-id="${category.id}"
                                        data-category-name="${category.name}"
                                        title="Unlink">
                                        <i class="bi bi-x-circle"></i>   
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    displayHtml += '</tbody></table></div>';
                    displayContainer.innerHTML = displayHtml;
                } else {
                    displayContainer.innerHTML = '<div class="alert alert-info small"><i class="fas fa-info-circle me-2"></i>No categories linked yet. Select from above and click Save.</div>';
                }
            } else {
                checkboxContainer.innerHTML = '<p class="text-muted">No main categories available</p>';
                displayContainer.innerHTML = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            checkboxContainer.innerHTML = '<p class="text-danger">Error loading categories</p>';
            displayContainer.innerHTML = '';
        });
    }

    function saveLinkedCategories(masterId) {
        const checkboxes = document.querySelectorAll(`.main-category-checkbox[data-master-id="${masterId}"]:checked`);
        const selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));

        const url = `{{ route('admin.heritage-master-categories.link-categories', ':id') }}`.replace(':id', masterId);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ main_category_ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the count badge
                const countBadge = document.querySelector(`.linked-count[data-master-id="${masterId}"]`);
                if (countBadge) {
                    countBadge.innerHTML = `<i class="fas fa-link me-1"></i>${selectedIds.length}`;
                }
                // Reload the display
                loadMainCategories(masterId);
            } else {
                alert(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    function unlinkCategory(masterId, categoryId) {
        const url = `{{ route('admin.heritage-master-categories.unlink-category', ':id') }}`.replace(':id', masterId);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ main_category_id: categoryId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadMainCategories(masterId);
                // Update the count badge
                const countBadge = document.querySelector(`.linked-count[data-master-id="${masterId}"]`);
                if (countBadge) {
                    const currentCount = parseInt(countBadge.textContent) - 1;
                    countBadge.innerHTML = `<i class="fas fa-link me-1"></i>${currentCount}`;
                }
            } else {
                alert(data.message || 'Failed to unlink category');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
});
</script>

@endsection