@extends('layouts.masteradmin')

@section('title', 'Add New Event')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-calendar-event"></i> Add New Event
        </h3>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4 animate-in delay-1">
        <div class="card-body p-4">
            <form id="addEventForm" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                        <input type="text" name="event_title" id="event_title" class="form-control form-control-lg" 
                               placeholder="Enter event title" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="event_category_id" id="event_category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2">
                            <input type="text" name="new_category" id="new_category" class="form-control form-control-sm" 
                                   placeholder="Or create new category...">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Title Image</label>
                    <input type="file" name="title_image" class="form-control" id="titleImageInput" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Max size: 2MB. Formats: jpg, jpeg, png, webp</small>
                    <div class="mt-2">
                        <img id="titleImagePreview" src="#" alt="Preview" class="img-fluid rounded d-none" style="max-height: 200px;">
                    </div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="5" class="form-control" 
                              placeholder="Write event description..." required></textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <input type="text" name="address" id="address" class="form-control" 
                               placeholder="Event address">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Venue <span class="text-danger">*</span></label>
                        <input type="text" name="venue" id="venue" class="form-control" 
                               placeholder="Venue name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Start Time <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">YouTube URL</label>
                    <input type="url" name="youtube_url" id="youtube_url" class="form-control" 
                           placeholder="https://youtube.com/watch?v=...">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Related Images (multiple)</label>
                    <input type="file" name="related_images[]" id="relatedImagesInput" 
                           class="form-control" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Max size per image: 2MB</small>
                    <div id="relatedImagesPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="text-end">
                    <button type="submit" id="submitBtn" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-save me-1"></i> <span id="btnText">Save Event</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.form-control.is-invalid ~ .invalid-feedback,
.form-select.is-invalid ~ .invalid-feedback {
    display: block;
}
</style>

<script>
// Wait for document to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').setAttribute('min', today);

    // Title Image Preview
    document.getElementById('titleImageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('titleImagePreview');
        const file = e.target.files[0];
        
        if (file) {
            // Validate file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                toastr.error('Image size must be less than 2MB');
                this.value = '';
                preview.classList.add('d-none');
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                toastr.error('Please select a valid image file (JPG, PNG, WEBP)');
                this.value = '';
                preview.classList.add('d-none');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });

    // Related Images Preview
    document.getElementById('relatedImagesInput').addEventListener('change', function(e) {
        const container = document.getElementById('relatedImagesPreview');
        container.innerHTML = '';
        
        const files = Array.from(e.target.files);
        
        // Validate each file
        files.forEach(file => {
            if (file.size > 2097152) {
                toastr.warning(`${file.name} is too large (max 2MB)`);
                return;
            }
            
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                toastr.warning(`${file.name} is not a valid image type`);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded';
                img.style.cssText = 'height:80px;width:80px;object-fit:cover;';
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });

    // Form Submit with AJAX
    document.getElementById('addEventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('.form-control, .form-select').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.textContent = '';
        });
        
        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        
        // Disable button and show loading
        submitBtn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Adding...';
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('{{ route("admin.events.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw data;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                toastr.success(data.message);
                
                // Reset form
                document.getElementById('addEventForm').reset();
                document.getElementById('titleImagePreview').classList.add('d-none');
                document.getElementById('relatedImagesPreview').innerHTML = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            if (error.errors) {
                // Validation errors
                Object.keys(error.errors).forEach(key => {
                    const input = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentElement.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = error.errors[key][0];
                        }
                    }
                });
                
                toastr.error(error.message || 'Please fix the errors and try again.');
            } else if (error.message) {
                toastr.error(error.message);
            } else {
                toastr.error('An unexpected error occurred. Please try again.');
            }
        })
        .finally(() => {
            // Re-enable button
            submitBtn.disabled = false;
            btnText.innerHTML = '<i class="bi bi-save me-1"></i> Save Event';
        });
    });
});
</script>
@endsection