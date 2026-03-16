@extends('layouts.masteradmin')

@section('title', isset($member) ? 'Edit Committee Member' : 'Add Committee Member')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h3 class="fw-bold mb-2">
            {{ isset($member) ? 'Edit Committee Member' : 'Add New Committee Member' }}
        </h3>
        <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-eye-fill"></i> View Committee Members
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

            <form action="{{ isset($member) ? route('admin.committee.update', $member->id) : route('admin.committee.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($member))
                    @method('PUT')
                @endif

                <!-- Full Name -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="full_name" 
                        class="form-control form-control-lg @error('full_name') is-invalid @enderror" 
                        placeholder="Enter full name" 
                        value="{{ old('full_name', $member->full_name ?? '') }}" 
                        required
                    >
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Position/Purpose -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Position/Role <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="purpose" 
                        class="form-control form-control-lg @error('purpose') is-invalid @enderror" 
                        placeholder="e.g., Chairperson, Vice Chair, Secretary, Treasurer" 
                        value="{{ old('purpose', $member->purpose ?? '') }}" 
                        required
                    >
                    @error('purpose')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control form-control-lg @error('email') is-invalid @enderror" 
                        placeholder="Enter email address" 
                        value="{{ old('email', $member->email ?? '') }}" 
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                    <input 
                        type="tel" 
                        name="phone" 
                        class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                        placeholder="Enter phone number" 
                        value="{{ old('phone', $member->phone ?? '') }}" 
                        required
                    >
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                    <textarea 
                        name="address" 
                        class="form-control @error('address') is-invalid @enderror" 
                        rows="3" 
                        placeholder="Enter address" 
                        required
                    >{{ old('address', $member->address ?? '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NIC (Optional) -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">NIC/ID Number <span class="text-muted">(Optional)</span></label>
                    <input 
                        type="text" 
                        name="nic" 
                        class="form-control form-control-lg @error('nic') is-invalid @enderror" 
                        placeholder="Enter NIC or ID number" 
                        value="{{ old('nic', $member->nic ?? '') }}"
                    >
                    @error('nic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Photo 
                        @if(!isset($member))
                            <span class="text-danger">*</span>
                        @else
                            <span class="text-muted">(Leave empty to keep current photo)</span>
                        @endif
                    </label>
                    <input 
                        type="file" 
                        name="photo_path" 
                        class="form-control @error('photo_path') is-invalid @enderror" 
                        id="photoInput" 
                        accept="image/*"
                        {{ !isset($member) ? 'required' : '' }}
                    >
                    <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)</small>
                    @error('photo_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Current Photo Preview -->
                    @if(isset($member) && $member->photo_path)
                        <div class="mt-3">
                            <label class="text-muted small">Current Photo:</label>
                            <div>
                                <img 
                                    src="{{ asset($member->photo_path) }}" 
                                    alt="{{ $member->full_name }}" 
                                    class="img-fluid rounded shadow-sm" 
                                    style="max-height: 150px; object-fit: cover;"
                                >
                            </div>
                        </div>
                    @endif

                    <!-- New Photo Preview -->
                    <div class="mt-3">
                        <img 
                            id="photoPreview" 
                            src="#" 
                            alt="Preview" 
                            class="img-fluid rounded shadow-sm d-none" 
                            style="max-height: 150px; object-fit: cover;"
                        >
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select 
                        name="status" 
                        class="form-select form-select-lg @error('status') is-invalid @enderror" 
                        required
                    >
                        <option value="">-- Select Status --</option>
                        <option value="Active" {{ old('status', $member->status ?? '') == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="Inactive" {{ old('status', $member->status ?? '') == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="bi bi-{{ isset($member) ? 'pencil-square' : 'plus-circle' }}"></i> 
                        {{ isset($member) ? 'Update Member' : 'Add Member' }}
                    </button>
                    <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-secondary btn-lg px-5 ms-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo Preview
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const preview = document.getElementById('photoPreview');
        if (e.target.files[0]) {
            preview.src = URL.createObjectURL(e.target.files[0]);
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });
});
</script>

@endsection
