@extends('layouts.masteradmin')

@section('title', 'Manage Publication Categories')

@section('content')
<div>

    {{-- ── Toast Container ── --}}
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index:1100"></div>

    {{-- ── Page Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Publication Categories</h4>
            <small class="text-muted">Manage main categories and their subcategories</small>
        </div>
        <button class="btn btn-primary" id="openAddMainCategoryBtn">
            <i class="bi bi-plus-lg me-1"></i> Add Main Category
        </button>
    </div>

    {{-- ── Stats Row ── --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-grid-3x3-gap-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 mb-0">{{ $mainCategories->total() }}</div>
                        <small class="text-muted">Total Main Categories</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="bi bi-list-ul fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 mb-0">{{ $mainCategories->count() }}</div>
                        <small class="text-muted">Showing This Page</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Search ── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control"
                    placeholder="Search categories by name..."
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-secondary px-3">
                    <i class="bi bi-search"></i>
                </button>
                @if($search)
                    <a href="{{ route('admin.categories.main.index') }}" class="btn btn-outline-danger px-3">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
            <span class="fw-semibold text-dark">
                <i class="bi bi-table me-2 text-primary"></i>All Main Categories
            </span>
            @if($search)
                <small class="text-muted">Results for: <strong>{{ $search }}</strong></small>
            @endif
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width:60px">#</th>
                            <th>Category Name</th>
                            <th style="width:120px">Subcategories</th>
                            <th style="width:230px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mainCategories as $mainCategory)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">
                                        {{ $mainCategories->firstItem() + $loop->index }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:34px;height:34px;">
                                            <i class="bi bi-tag text-secondary small"></i>
                                        </div>
                                        <span class="fw-medium">{{ $mainCategory->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $mainCategory->subcategories->count() }} subcategories
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info me-1 view-subcategories-btn"
                                        data-id="{{ $mainCategory->id }}"
                                        data-name="{{ $mainCategory->name }}">
                                        <i class="bi bi-list-nested me-1"></i>Subcategories
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary me-1 edit-main-btn"
                                        data-id="{{ $mainCategory->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-main-btn"
                                        data-id="{{ $mainCategory->id }}"
                                        data-name="{{ $mainCategory->name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder2-open d-block mb-2" style="font-size:2.5rem;"></i>
                                    <p class="mb-2">No categories found{{ $search ? ' for "'.$search.'"' : '' }}.</p>
                                    @if(!$search)
                                        <button class="btn btn-primary btn-sm mt-1" id="openAddMainCategoryBtnEmpty">
                                            <i class="bi bi-plus-lg me-1"></i>Add First Category
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($mainCategories->hasPages())
            <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4">
                <small class="text-muted">
                    Showing {{ $mainCategories->firstItem() }}–{{ $mainCategories->lastItem() }}
                    of {{ $mainCategories->total() }} categories
                </small>
                {{ $mainCategories->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MAIN CATEGORY MODAL (Add / Edit)
══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="mainCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi me-2" id="mainModalIcon"></i>
                    <span id="mainModalTitle">Add Main Category</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger d-none py-2" id="mainModalErrors">
                    <ul class="mb-0 ps-3" id="mainModalErrorsList"></ul>
                </div>
                <div class="mb-1">
                    <label class="form-label fw-semibold" for="mainCategoryNameInput">
                        Category Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="mainCategoryNameInput" class="form-control"
                        placeholder="e.g. Science, History, Technology"
                        maxlength="255" autocomplete="off">
                    <div class="form-text">Must be unique. Max 255 characters.</div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveMainCategoryBtn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="mainSaveSpinner"></span>
                    <i class="bi" id="mainSaveBtnIcon"></i>
                    <span id="mainSaveBtnLabel">Add Category</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SUBCATEGORIES MANAGEMENT MODAL
══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="subcategoriesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-list-nested me-2"></i>
                    Subcategories of <span id="subcatMainCategoryName" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                {{-- Add Subcategory inline form --}}
                <div class="card border-0 bg-light mb-3">
                    <div class="card-body py-3">
                        <div class="alert alert-danger d-none py-2" id="subcatErrors">
                            <ul class="mb-0 ps-3" id="subcatErrorsList"></ul>
                        </div>
                        <div class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <label class="form-label fw-semibold mb-1 small" for="subcatNameInput">
                                    <span id="subcatFormLabel">Add New Subcategory</span>
                                </label>
                                <input type="text" id="subcatNameInput" class="form-control"
                                    placeholder="Subcategory name..." maxlength="255" autocomplete="off">
                            </div>
                            <button class="btn btn-primary" id="saveSubcatBtn" style="white-space:nowrap">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="subcatSpinner"></span>
                                <i class="bi" id="subcatBtnIcon"></i>
                                <span id="subcatBtnLabel">Add</span>
                            </button>
                            <button class="btn btn-secondary d-none" id="cancelEditSubcatBtn">Cancel</button>
                        </div>
                    </div>
                </div>

                {{-- Subcategory list --}}
                <div id="subcategoriesList">
                    <div class="text-center py-3 text-muted">
                        <div class="spinner-border spinner-border-sm me-2"></div>Loading subcategories...
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     DELETE CONFIRM MODAL
══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content shadow">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:60px;height:60px;">
                    <i class="bi bi-trash3-fill fs-4"></i>
                </div>
                <h5 class="fw-bold mb-2" id="deleteModalTitle">Delete Category?</h5>
                <p class="text-muted mb-4" id="deleteModalMessage"></p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i>Cancel
                    </button>
                    <button class="btn btn-danger" id="confirmDeleteBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="deleteSpinner"></span>
                        <i class="bi bi-trash3 me-1"></i>Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const CSRF = '{{ csrf_token() }}';
    const ROUTES = {
        mainIndex:  '{{ route('admin.categories.main.index') }}',
        mainStore:  '{{ route('admin.categories.main.store') }}',
        mainEdit:   (id) => `{{ url('/admin/categories/main') }}/${id}/edit/publication`,
        mainUpdate: (id) => `{{ url('/admin/categories/main') }}/${id}/publication`,
        mainDelete: (id) => `{{ url('/admin/categories/main') }}/${id}/publication`,
        subcatList:  (mainId) => `{{ url('/admin/categories/main') }}/${mainId}/subcategories/publication`,
        subcatStore: (mainId) => `{{ url('/admin/categories/main') }}/${mainId}/subcategories/publication`,
        subcatUpdate: (id) => `{{ url('/admin/categories/subcategories') }}/${id}/publication`,
        subcatDelete: (id) => `{{ url('/admin/categories/subcategories') }}/${id}/publication`,
    };

    // Bootstrap modals
    const mainCatModal  = new bootstrap.Modal(document.getElementById('mainCategoryModal'));
    const subcatModal   = new bootstrap.Modal(document.getElementById('subcategoriesModal'));
    const deleteModal   = new bootstrap.Modal(document.getElementById('deleteModal'));

    let editingMainId    = null;
    let editingSubcatId  = null;
    let currentMainCatId = null;
    let deletingType     = null; // 'main' | 'subcat'
    let deletingId       = null;

    // ── Toast ──────────────────────────────────────────────────────────────────
    function showToast(msg, type = 'success') {
        const id    = 'toast_' + Date.now();
        const icon  = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
        const color = type === 'success' ? 'text-success' : 'text-danger';
        document.getElementById('toastContainer').insertAdjacentHTML('beforeend', `
            <div id="${id}" class="toast align-items-center border-0 shadow" role="alert">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="bi ${icon} ${color}"></i> ${msg}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>`);
        const el = document.getElementById(id);
        new bootstrap.Toast(el, { delay: 3500 }).show();
        el.addEventListener('hidden.bs.toast', () => el.remove());
    }

    // ── Helpers ────────────────────────────────────────────────────────────────
    function setErrors(containerEl, listEl, errors) {
        listEl.innerHTML = '';
        const msgs = typeof errors === 'string' ? [errors] : Object.values(errors).flat();
        msgs.forEach(m => listEl.innerHTML += `<li>${m}</li>`);
        containerEl.classList.remove('d-none');
    }

    function clearErrors(containerEl, inputEl = null) {
        containerEl.classList.add('d-none');
        containerEl.querySelector('ul').innerHTML = '';
        if (inputEl) inputEl.classList.remove('is-invalid');
    }

    // ══════════════════════════════════════════════════════════════
    //  MAIN CATEGORY
    // ══════════════════════════════════════════════════════════════

    function openMainCategoryModal({ id = null, name = '' } = {}) {
        editingMainId = id;
        clearErrors(document.getElementById('mainModalErrors'), document.getElementById('mainCategoryNameInput'));
        document.getElementById('mainCategoryNameInput').value = name;

        if (id) {
            document.getElementById('mainModalTitle').textContent   = 'Edit Main Category';
            document.getElementById('mainModalIcon').className      = 'bi bi-pencil-square me-2';
            document.getElementById('mainSaveBtnLabel').textContent = 'Save Changes';
            document.getElementById('mainSaveBtnIcon').className    = 'bi bi-check-lg';
        } else {
            document.getElementById('mainModalTitle').textContent   = 'Add Main Category';
            document.getElementById('mainModalIcon').className      = 'bi bi-plus-circle me-2';
            document.getElementById('mainSaveBtnLabel').textContent = 'Add Category';
            document.getElementById('mainSaveBtnIcon').className    = 'bi bi-plus-lg';
        }

        mainCatModal.show();
        document.getElementById('mainCategoryModal').addEventListener('shown.bs.modal', () => {
            document.getElementById('mainCategoryNameInput').focus();
        }, { once: true });
    }

    document.getElementById('openAddMainCategoryBtn')?.addEventListener('click', () => openMainCategoryModal());
    document.getElementById('openAddMainCategoryBtnEmpty')?.addEventListener('click', () => openMainCategoryModal());

    // Edit main category
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.edit-main-btn');
        if (!btn) return;

        const id       = btn.dataset.id;
        const origHtml = btn.innerHTML;
        btn.innerHTML  = '<span class="spinner-border spinner-border-sm"></span>';
        btn.disabled   = true;

        fetch(ROUTES.mainEdit(id), { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(data => {
                btn.innerHTML = origHtml;
                btn.disabled  = false;
                if (data.success) openMainCategoryModal({ id: data.data.id, name: data.data.name });
                else showToast(data.message || 'Failed to load.', 'error');
            })
            .catch(() => { btn.innerHTML = origHtml; btn.disabled = false; showToast('Network error.', 'error'); });
    });

    // Save main category
    document.getElementById('saveMainCategoryBtn').addEventListener('click', function () {
        const name    = document.getElementById('mainCategoryNameInput').value.trim();
        const spinner = document.getElementById('mainSaveSpinner');
        const icon    = document.getElementById('mainSaveBtnIcon');
        const btn     = this;

        clearErrors(document.getElementById('mainModalErrors'), document.getElementById('mainCategoryNameInput'));
        if (!name) {
            setErrors(document.getElementById('mainModalErrors'), document.getElementById('mainModalErrorsList'), 'Category name is required.');
            document.getElementById('mainCategoryNameInput').classList.add('is-invalid');
            return;
        }

        btn.disabled = true;
        spinner.classList.remove('d-none');
        icon.classList.add('d-none');

        const url  = editingMainId ? ROUTES.mainUpdate(editingMainId) : ROUTES.mainStore;
        const body = new FormData();
        body.append('name', name);
        if (editingMainId) body.append('_method', 'PUT');

        fetch(url, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }, body })
            .then(r => r.json().then(d => ({ status: r.status, data: d })))
            .then(({ status, data }) => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                icon.classList.remove('d-none');

                if (status === 422 && data.errors) {
                    setErrors(document.getElementById('mainModalErrors'), document.getElementById('mainModalErrorsList'), data.errors);
                    document.getElementById('mainCategoryNameInput').classList.add('is-invalid');
                    return;
                }
                if (data.success) {
                    mainCatModal.hide();
                    showToast(data.message || 'Saved!');
                    setTimeout(() => location.reload(), 800);
                } else {
                    setErrors(document.getElementById('mainModalErrors'), document.getElementById('mainModalErrorsList'), data.message || 'An error occurred.');
                }
            })
            .catch(() => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                icon.classList.remove('d-none');
                setErrors(document.getElementById('mainModalErrors'), document.getElementById('mainModalErrorsList'), 'Network error.');
            });
    });

    document.getElementById('mainCategoryNameInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') document.getElementById('saveMainCategoryBtn').click();
    });

    // ══════════════════════════════════════════════════════════════
    //  SUBCATEGORIES
    // ══════════════════════════════════════════════════════════════

    function loadSubcategories(mainCategoryId) {
        const list = document.getElementById('subcategoriesList');
        list.innerHTML = `<div class="text-center py-3 text-muted">
            <div class="spinner-border spinner-border-sm me-2"></div>Loading...
        </div>`;

        fetch(ROUTES.subcatList(mainCategoryId), { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(data => {
                if (!data.success || !data.data.length) {
                    list.innerHTML = `<div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox d-block mb-2" style="font-size:2rem"></i>
                        No subcategories yet. Add one above.
                    </div>`;
                    return;
                }
                list.innerHTML = `
                    <table class="table table-hover align-middle mb-0 border rounded">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Name</th>
                                <th style="width:130px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.data.map((s, i) => `
                                <tr>
                                    <td class="ps-3"><span class="badge bg-secondary bg-opacity-10 text-secondary">${i + 1}</span></td>
                                    <td class="fw-medium">${escapeHtml(s.name)}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1 edit-subcat-btn"
                                            data-id="${s.id}" data-name="${escapeHtml(s.name)}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-subcat-btn"
                                            data-id="${s.id}" data-name="${escapeHtml(s.name)}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>`;
            })
            .catch(() => {
                list.innerHTML = `<div class="alert alert-danger">Failed to load subcategories.</div>`;
            });
    }

    // Open subcategories modal
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.view-subcategories-btn');
        if (!btn) return;

        currentMainCatId = btn.dataset.id;
        document.getElementById('subcatMainCategoryName').textContent = btn.dataset.name;
        resetSubcatForm();
        clearErrors(document.getElementById('subcatErrors'), document.getElementById('subcatNameInput'));
        loadSubcategories(currentMainCatId);
        subcatModal.show();
    });

    function resetSubcatForm() {
        editingSubcatId = null;
        document.getElementById('subcatNameInput').value = '';
        document.getElementById('subcatFormLabel').textContent = 'Add New Subcategory';
        document.getElementById('subcatBtnLabel').textContent  = 'Add';
        document.getElementById('subcatBtnIcon').className     = 'bi bi-plus-lg';
        document.getElementById('cancelEditSubcatBtn').classList.add('d-none');
    }

    // Edit subcategory
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.edit-subcat-btn');
        if (!btn) return;

        editingSubcatId = btn.dataset.id;
        document.getElementById('subcatNameInput').value          = btn.dataset.name;
        document.getElementById('subcatFormLabel').textContent    = 'Edit Subcategory';
        document.getElementById('subcatBtnLabel').textContent     = 'Save';
        document.getElementById('subcatBtnIcon').className        = 'bi bi-check-lg';
        document.getElementById('cancelEditSubcatBtn').classList.remove('d-none');
        document.getElementById('subcatNameInput').focus();
        clearErrors(document.getElementById('subcatErrors'), document.getElementById('subcatNameInput'));
    });

    document.getElementById('cancelEditSubcatBtn').addEventListener('click', resetSubcatForm);

    // Save subcategory (add or edit)
    document.getElementById('saveSubcatBtn').addEventListener('click', function () {
        const name    = document.getElementById('subcatNameInput').value.trim();
        const spinner = document.getElementById('subcatSpinner');
        const icon    = document.getElementById('subcatBtnIcon');
        const btn     = this;

        clearErrors(document.getElementById('subcatErrors'), document.getElementById('subcatNameInput'));
        if (!name) {
            setErrors(document.getElementById('subcatErrors'), document.getElementById('subcatErrorsList'), 'Subcategory name is required.');
            document.getElementById('subcatNameInput').classList.add('is-invalid');
            return;
        }

        btn.disabled = true;
        spinner.classList.remove('d-none');
        icon.classList.add('d-none');

        const url  = editingSubcatId ? ROUTES.subcatUpdate(editingSubcatId) : ROUTES.subcatStore(currentMainCatId);
        const body = new FormData();
        body.append('name', name);
        if (editingSubcatId) body.append('_method', 'PUT');

        fetch(url, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }, body })
            .then(r => r.json().then(d => ({ status: r.status, data: d })))
            .then(({ status, data }) => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                icon.classList.remove('d-none');

                if (status === 422 && data.errors) {
                    setErrors(document.getElementById('subcatErrors'), document.getElementById('subcatErrorsList'), data.errors);
                    document.getElementById('subcatNameInput').classList.add('is-invalid');
                    return;
                }
                if (data.success) {
                    showToast(data.message || 'Saved!');
                    resetSubcatForm();
                    loadSubcategories(currentMainCatId);
                } else {
                    setErrors(document.getElementById('subcatErrors'), document.getElementById('subcatErrorsList'), data.message || 'An error occurred.');
                }
            })
            .catch(() => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                icon.classList.remove('d-none');
                setErrors(document.getElementById('subcatErrors'), document.getElementById('subcatErrorsList'), 'Network error.');
            });
    });

    document.getElementById('subcatNameInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') document.getElementById('saveSubcatBtn').click();
    });

    // ══════════════════════════════════════════════════════════════
    //  DELETE (shared modal)
    // ══════════════════════════════════════════════════════════════

    // Delete main category
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-main-btn');
        if (!btn) return;

        deletingType = 'main';
        deletingId   = btn.dataset.id;
        document.getElementById('deleteModalTitle').textContent   = 'Delete Main Category?';
        document.getElementById('deleteModalMessage').innerHTML   =
            `You are about to permanently delete <strong>${escapeHtml(btn.dataset.name)}</strong>. All its subcategories will also be deleted.`;
        deleteModal.show();
    });

    // Delete subcategory
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-subcat-btn');
        if (!btn) return;

        deletingType = 'subcat';
        deletingId   = btn.dataset.id;
        document.getElementById('deleteModalTitle').textContent   = 'Delete Subcategory?';
        document.getElementById('deleteModalMessage').innerHTML   =
            `You are about to permanently delete the subcategory <strong>${escapeHtml(btn.dataset.name)}</strong>.`;
        deleteModal.show();
    });

    // Confirm delete
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deletingId || !deletingType) return;

        const btn     = this;
        const spinner = document.getElementById('deleteSpinner');
        btn.disabled  = true;
        spinner.classList.remove('d-none');

        const url = deletingType === 'main'
            ? ROUTES.mainDelete(deletingId)
            : ROUTES.subcatDelete(deletingId);

        fetch(url, { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                deleteModal.hide();

                if (data.success) {
                    showToast(data.message || 'Deleted successfully.');
                    if (deletingType === 'main') {
                        setTimeout(() => location.reload(), 800);
                    } else {
                        loadSubcategories(currentMainCatId);
                    }
                } else {
                    showToast(data.message || 'Failed to delete.', 'error');
                }
            })
            .catch(() => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                deleteModal.hide();
                showToast('Network error.', 'error');
            });
    });

    // ── Utility ────────────────────────────────────────────────────────────────
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
});
</script>
@endsection