@extends('layouts.masteradmin')

@section('title', 'Manage Collection Categories')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ── Toast Container ── --}}
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index:1100"></div>

    {{-- ── Page Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Collection Categories</h4>
            <small class="text-muted">Manage master categories for your collections</small>
        </div>
        <button class="btn btn-primary" id="openAddModalBtn">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </button>
    </div>

    {{-- ── Flash Messages ── --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Error!</strong>
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Stats Row ── --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-grid-3x3-gap-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 mb-0">{{ $masterCategories->total() }}</div>
                        <small class="text-muted">Total Categories</small>
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
                        <div class="fw-bold fs-5 mb-0">{{ $masterCategories->count() }}</div>
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
                    value="{{ request('search') ?? '' }}">
                <button type="submit" class="btn btn-outline-secondary px-3">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.main.index') }}" class="btn btn-outline-danger px-3">
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
                <i class="bi bi-table me-2 text-primary"></i>All Categories
            </span>
            @if(request('search'))
                <small class="text-muted">Results for: <strong>{{ request('search') }}</strong></small>
            @endif
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width:60px">#</th>
                            <th>Category Name</th>
                            <th style="width:170px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($masterCategories as $category)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">
                                        {{ $masterCategories->firstItem() + $loop->index }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:34px;height:34px;">
                                            <i class="bi bi-tag text-secondary small"></i>
                                        </div>
                                        <span class="fw-medium">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1 edit-btn"
                                        data-id="{{ $category->id }}">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder2-open d-block mb-2" style="font-size:2.5rem;"></i>
                                    <p class="mb-2">
                                        No categories found
                                        {{ request('search') ? ' for "'.request('search').'"' : '' }}.
                                    </p>
                                    @if(!request('search'))
                                        <button class="btn btn-primary btn-sm mt-1" id="openAddModalBtnEmpty">
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

        {{-- Pagination --}}
        @if($masterCategories->hasPages())
            <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4">
                <small class="text-muted">
                    Showing {{ $masterCategories->firstItem() }}–{{ $masterCategories->lastItem() }}
                    of {{ $masterCategories->total() }} categories
                </small>
                {{ $masterCategories->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>


{{-- ══════════════════════════════════════════════════════════
     ADD / EDIT MODAL
══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi me-2" id="modalIcon"></i>
                    <span id="modalTitle">Add Category</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <div class="alert alert-danger d-none py-2" id="modalErrors" role="alert">
                    <ul class="mb-0 ps-3" id="modalErrorsList"></ul>
                </div>

                <div class="mb-1">
                    <label class="form-label fw-semibold" for="categoryNameInput">
                        Category Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="categoryNameInput" class="form-control"
                        placeholder="e.g. Furniture, Jewellery, Outerwear"
                        maxlength="255" autocomplete="off">
                    <div class="form-text">Must be unique. Max 255 characters.</div>
                </div>

            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveBtn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="saveSpinner"></span>
                    <i class="bi" id="saveBtnIcon"></i>
                    <span id="saveBtnLabel">Add Category</span>
                </button>
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
                <h5 class="fw-bold mb-2">Delete Category?</h5>
                <p class="text-muted mb-4">
                    You are about to permanently delete
                    <strong class="text-dark" id="deleteCategoryName"></strong>.
                    Any linked main categories will be unlinked.
                </p>
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

    const CSRF      = '{{ csrf_token() }}';
    const URL_STORE = '{{ route('admin.main.store') }}';
    const URL_BASE  = '{{ url('/admin/categories/main') }}';
    const URL_EDIT  = '{{ route('admin.main.edit', ':id') }}';

    const catModalEl = document.getElementById('categoryModal');
    const delModalEl = document.getElementById('deleteModal');
    const catModal   = new bootstrap.Modal(catModalEl);
    const delModal   = new bootstrap.Modal(delModalEl);

    let editingId  = null;
    let deletingId = null;

    // ── Toast ──────────────────────────────────────────────────
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

    // ── Modal Errors ───────────────────────────────────────────
    function showModalErrors(errors) {
        const list = document.getElementById('modalErrorsList');
        list.innerHTML = '';
        const msgs = typeof errors === 'string' ? [errors] : Object.values(errors).flat();
        msgs.forEach(m => list.innerHTML += `<li>${m}</li>`);
        document.getElementById('modalErrors').classList.remove('d-none');
        document.getElementById('categoryNameInput').classList.add('is-invalid');
    }

    function clearModalErrors() {
        document.getElementById('modalErrors').classList.add('d-none');
        document.getElementById('modalErrorsList').innerHTML = '';
        document.getElementById('categoryNameInput').classList.remove('is-invalid');
    }

    // ── Open Modal ─────────────────────────────────────────────
    function openCategoryModal({ id = null, name = '' } = {}) {
        editingId = id;
        clearModalErrors();
        document.getElementById('categoryNameInput').value = name;

        if (id) {
            document.getElementById('modalTitle').textContent   = 'Edit Category';
            document.getElementById('modalIcon').className      = 'bi bi-pencil-square me-2';
            document.getElementById('saveBtnLabel').textContent = 'Save Changes';
            document.getElementById('saveBtnIcon').className    = 'bi bi-check-lg';
        } else {
            document.getElementById('modalTitle').textContent   = 'Add Category';
            document.getElementById('modalIcon').className      = 'bi bi-plus-circle me-2';
            document.getElementById('saveBtnLabel').textContent = 'Add Category';
            document.getElementById('saveBtnIcon').className    = 'bi bi-plus-lg';
        }

        catModal.show();
        catModalEl.addEventListener('shown.bs.modal', () => {
            document.getElementById('categoryNameInput').focus();
        }, { once: true });
    }

    // ── Add triggers ───────────────────────────────────────────
    document.getElementById('openAddModalBtn')?.addEventListener('click', () => openCategoryModal());
    document.getElementById('openAddModalBtnEmpty')?.addEventListener('click', () => openCategoryModal());

    // ── Edit trigger ───────────────────────────────────────────
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.edit-btn');
        if (!btn) return;

        const id      = btn.dataset.id;
        const origHtml = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        btn.disabled  = true;

        fetch(URL_EDIT.replace(':id', id), {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        })
        .then(r => r.json())
        .then(data => {
            btn.innerHTML = origHtml;
            btn.disabled  = false;
            if (data.success) {
                openCategoryModal({ id: data.data.id, name: data.data.name });
            } else {
                showToast(data.message || 'Failed to load category.', 'error');
            }
        })
        .catch(() => {
            btn.innerHTML = origHtml;
            btn.disabled  = false;
            showToast('Network error. Please try again.', 'error');
        });
    });

    // ── Save ───────────────────────────────────────────────────
    document.getElementById('saveBtn').addEventListener('click', function () {
        const name    = document.getElementById('categoryNameInput').value.trim();
        const spinner = document.getElementById('saveSpinner');
        const icon    = document.getElementById('saveBtnIcon');
        const btn     = this;

        clearModalErrors();

        if (!name) {
            showModalErrors('Category name is required.');
            return;
        }

        btn.disabled = true;
        spinner.classList.remove('d-none');
        icon.classList.add('d-none');

        const url  = editingId ? `${URL_BASE}/${editingId}` : URL_STORE;
        const body = new FormData();
        body.append('name', name);
        if (editingId) body.append('_method', 'PUT');

        fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body
        })
        .then(r => r.json().then(d => ({ status: r.status, data: d })))
        .then(({ status, data }) => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            icon.classList.remove('d-none');

            if (status === 422 && data.errors) {
                showModalErrors(data.errors);
                return;
            }
            if (data.success) {
                catModal.hide();
                showToast(data.message || 'Category saved successfully!');
                setTimeout(() => location.reload(), 800);
            } else {
                showModalErrors(data.message || 'An unexpected error occurred.');
            }
        })
        .catch(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            icon.classList.remove('d-none');
            showModalErrors('Network error. Please try again.');
        });
    });

    // Enter key submits modal
    document.getElementById('categoryNameInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') document.getElementById('saveBtn').click();
    });

    // ── Delete trigger ─────────────────────────────────────────
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;
        deletingId = btn.dataset.id;
        document.getElementById('deleteCategoryName').textContent = btn.dataset.name;
        delModal.show();
    });

    // ── Confirm Delete ─────────────────────────────────────────
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deletingId) return;

        const btn     = this;
        const spinner = document.getElementById('deleteSpinner');
        btn.disabled  = true;
        spinner.classList.remove('d-none');

        fetch(`${URL_BASE}/${deletingId}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            delModal.hide();

            if (data.success) {
                showToast(data.message || 'Category deleted successfully.');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.message || 'Failed to delete category.', 'error');
            }
        })
        .catch(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            delModal.hide();
            showToast('Network error. Please try again.', 'error');
        });
    });

});
</script>

@endsection