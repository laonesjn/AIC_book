@extends('layouts.masteradmin')

@section('title', isset($member) ? 'Edit Member' : 'Add New Member')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">{{ isset($member) ? 'Edit Member' : 'Add New Member' }}</h2>
        <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ isset($member) ? route('admin.committee.update', $member->id) : route('admin.committee.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($member))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    {{-- Full Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="full_name" 
                               class="form-control @error('full_name') is-invalid @enderror" 
                               value="{{ old('full_name', $member->full_name ?? '') }}" 
                               placeholder="e.g. John Doe"
                               required>
                    </div>

                    {{-- Position / Purpose --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Position/Role <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="purpose" 
                               class="form-control @error('purpose') is-invalid @enderror" 
                               value="{{ old('purpose', $member->purpose ?? '') }}" 
                               placeholder="e.g. Secretary / Web Developer"
                               required>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $member->email ?? '') }}" 
                               placeholder="e.g. john@example.com"
                               required>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" 
                               name="phone" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $member->phone ?? '') }}" 
                               placeholder="e.g. +94 77 123 4567">
                    </div>

                    {{-- NIC --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIC / ID Number</label>
                        <input type="text" 
                               name="nic" 
                               class="form-control @error('nic') is-invalid @enderror" 
                               value="{{ old('nic', $member->nic ?? '') }}" 
                               placeholder="e.g. 199012345678">
                    </div>

                    {{-- Member Type --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Member Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">-- Select Type --</option>
                            <option value="committee" {{ old('type', $member->type ?? '') == 'committee' ? 'selected' : '' }}>Committee Member</option>
                            <option value="technical" {{ old('type', $member->type ?? '') == 'technical' ? 'selected' : '' }}>Technical Team Member</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Active" {{ old('status', $member->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $member->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Address --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" 
                                  class="form-control @error('address') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="Enter complete address">{{ old('address', $member->address ?? '') }}</textarea>
                    </div>

                    {{-- Photo --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Profile Photo</label>
                        <input type="file" 
                               name="photo" 
                               class="form-control @error('photo') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewImage(this)">
                        <small class="text-muted text-uppercase smaller d-block mt-1">Recommended size: 300x300 (Max 2MB)</small>
                        
                        <div class="mt-3">
                            <div id="image-preview-container" class="{{ isset($member->photo_path) ? '' : 'd-none' }}">
                                <p class="small text-muted mb-1">Preview:</p>
                                <img id="image-preview" 
                                     src="{{ isset($member->photo_path) ? asset($member->photo_path) : '#' }}" 
                                     alt="Preview" 
                                     class="rounded-3 shadow-sm" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-5">
                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                        <i class="bi bi-check-circle"></i> {{ isset($member) ? 'Update Member' : 'Save Member' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const container = document.getElementById('image-preview-container');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
