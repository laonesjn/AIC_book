{{-- FILE: resources/views/admin/addpublications.blade.php (UPDATED) --}}
@extends('layouts.masteradmin')

@section('title', 'Add Publication')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h3 class="fw-bold mb-2">
            Add New Publication
        </h3>
        <a href="{{ route('admin.publications.view') }}" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-eye-fill"></i> View Publications
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-circle"></i> Validation Errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.publications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Publication Title <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-control form-control-lg @error('title') is-invalid @enderror" 
                        placeholder="Enter publication title" 
                        value="{{ old('title') }}" 
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Title Image --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title Image <span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        name="title_image" 
                        class="form-control @error('title_image') is-invalid @enderror" 
                        id="titleImageInput" 
                        accept="image/*" 
                        required
                    >
                    <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG (Max 2MB)</small>
                    @error('title_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-3">
                        <img 
                            id="titleImagePreview" 
                            src="#" 
                            alt="Preview" 
                            class="img-fluid rounded shadow-sm d-none" 
                            style="max-height: 200px; object-fit: cover;"
                        >
                    </div>
                </div>

                {{-- Content --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                    <textarea 
                        name="content" 
                        class="form-control @error('content') is-invalid @enderror" 
                        rows="6" 
                        placeholder="Enter publication content..." 
                        required
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Main Category --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Main Category <span class="text-danger">*</span></label>
                    <select 
                        name="main_category_id" 
                        id="mainCategorySelect" 
                        class="form-select form-select-lg @error('main_category_id') is-invalid @enderror" 
                        required
                    >
                        <option value="">-- Select Main Category --</option>
                        @foreach($mainCategories as $mainCategory)
                            <option 
                                value="{{ $mainCategory->id }}" 
                                {{ old('main_category_id') == $mainCategory->id ? 'selected' : '' }}
                            >
                                {{ $mainCategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('main_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subcategory --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subcategory <span class="text-danger">*</span></label>
                    <select 
                        name="subcategory_id" 
                        id="subcategorySelect" 
                        class="form-select form-select-lg @error('subcategory_id') is-invalid @enderror" 
                        required
                        disabled
                    >
                        <option value="">-- Select Subcategory --</option>
                    </select>
                    <small id="subcategoryHint" class="text-muted">Select a main category first to load subcategories.</small>
                    @error('subcategory_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pricing Type --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Pricing Type <span class="text-danger">*</span></label>
                        <select 
                            name="type" 
                            id="typeSelect" 
                            class="form-select form-select-lg @error('type') is-invalid @enderror" 
                            required
                        >
                            <option value="Free" {{ old('type') == 'Free' ? 'selected' : '' }}>Free</option>
                            <option value="Price" {{ old('type') == 'Price' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3" id="priceField" style="display: none;">
                        <label class="form-label fw-semibold">Price <span class="text-danger" id="priceRequired">*</span></label>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="price" 
                            class="form-control @error('price') is-invalid @enderror" 
                            placeholder="Enter price (e.g. 10.00)" 
                            value="{{ old('price') }}"
                        >
                        <small class="text-muted">Enter the price</small>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Access Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Access Type <span class="text-danger">*</span>
                    </label>
                    <select 
                        name="visibleType"
                        class="form-select form-select-lg @error('visibleType') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Select Access Type --</option>
                        <option value="public" {{ old('visibleType') == 'public' ? 'selected' : '' }}>
                            Public
                        </option>
                        <option value="private" {{ old('visibleType') == 'private' ? 'selected' : '' }}>
                            Private
                        </option>
                    </select>

                    @error('visibleType')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted">
                        Public = anyone can view • Private = only authorized users
                    </small>
                </div>


                {{-- PDF Upload --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">PDF File <span class="text-muted">(Optional)</span></label>
                    <input 
                        type="file" 
                        name="pdf" 
                        class="form-control @error('pdf') is-invalid @enderror" 
                        accept="application/pdf"
                    >
                    <small class="text-muted">Max file size: 10MB</small>
                    @error('pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="bi bi-plus-circle"></i> Add Publication
                    </button>
                    <a href="{{ route('admin.publications.view') }}" class="btn btn-outline-secondary btn-lg px-5 ms-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainCategorySelect = document.getElementById('mainCategorySelect');
    const subcategorySelect = document.getElementById('subcategorySelect');
    const subcategoryHint = document.getElementById('subcategoryHint');
    const priceField = document.getElementById('priceField');
    const typeSelect = document.getElementById('typeSelect');

    // Store categories data from server
    const categoriesData = {!! json_encode($mainCategories->mapWithKeys(fn($t) => [$t->id => $t->subcategories])) !!};

    // Title Image Preview
    document.getElementById('titleImageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('titleImagePreview');
        if (e.target.files[0]) {
            preview.src = URL.createObjectURL(e.target.files[0]);
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });

    // Toggle Price Field based on pricing type
    function togglePrice() {
        const priceInput = priceField.querySelector('input');
        if (typeSelect.value === 'Price') {
            priceField.style.display = 'block';
            priceInput.required = true;
        } else {
            priceField.style.display = 'none';
            priceInput.required = false;
            priceInput.value = '';
        }
    }
    typeSelect.addEventListener('change', togglePrice);
    togglePrice();

    // Load subcategories when main category changes
    function loadSubcategories(mainCategoryId, selectedSubcategoryId = null) {
        subcategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
        
        if (!mainCategoryId) {
            subcategorySelect.disabled = true;
            subcategoryHint.style.display = 'block';
            return;
        }

        subcategoryHint.style.display = 'none';
        subcategorySelect.disabled = false;

        const subs = categoriesData[mainCategoryId] || [];
        if (subs.length === 0) {
            subcategorySelect.innerHTML = '<option value="">-- No subcategories available --</option>';
        } else {
            subs.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.name;
                if (selectedSubcategoryId && sub.id == selectedSubcategoryId) {
                    opt.selected = true;
                }
                subcategorySelect.appendChild(opt);
            });
        }
    }

    mainCategorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });

    // Initial load if category is pre-selected (e.g., from old input)
    if (mainCategorySelect.value) {
        loadSubcategories(mainCategorySelect.value, '{{ old("subcategory_id") }}');
    }
});
</script>
@endsection