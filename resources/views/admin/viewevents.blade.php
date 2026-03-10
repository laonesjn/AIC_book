@extends('layouts.masteradmin')

@section('title', 'All Events')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in">
        <h3 class="fw-bold">
            <i class="bi bi-calendar-event me-2 text-primary"></i>All Events
        </h3>
        <a href="" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Event
        </a>
    </div>

    {{-- FILTERS --}}
    <div class="card mb-4 shadow-sm animate-in delay-1">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.events.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            <option value="">All Years</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>🔴 Live</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>🟢 Upcoming</option>
                            <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>⚫ Past</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive shadow-sm rounded-3 animate-in delay-2">
        <table class="table align-middle table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        @if($event->title_image)
                            <img src="{{ asset($event->title_image) }}" 
                                 alt="{{ $event->event_title }}" 
                                 class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 40px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ Str::limit($event->event_title, 30) }}</td>
                    <td>
                        @if($event->category)
                            <span class="badge bg-info">{{ $event->category->name }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}<br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</small>
                    </td>
                    <td>{{ Str::limit($event->venue, 20) }}</td>
                    <td>
                        @if($event->is_live)
                            <span class="badge bg-danger animate-pulse">● Live</span>
                        @elseif($event->is_upcoming)
                            <span class="badge bg-success">Upcoming</span>
                        @else
                            <span class="badge bg-secondary">Past</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-info" 
                                    onclick="viewEvent({{ $event->id }})" title="View">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                    onclick="editEvent({{ $event->id }})" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteEvent({{ $event->id }})" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="bi bi-inbox display-4 text-muted d-block mb-3"></i>
                        <p class="text-muted">No events found</p>
                        <a href="" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-1"></i> Add First Event
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- VIEW EVENT MODAL --}}
<div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewEventBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- EDIT EVENT MODAL --}}
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEventForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_event_id" name="event_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                            <input type="text" name="event_title" id="edit_event_title" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="event_category_id" id="edit_category" class="form-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Or New Category</label>
                            <input type="text" name="new_category" id="edit_new_category" class="form-control" placeholder="Create new...">
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" id="edit_start_time" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" id="edit_end_time" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Venue <span class="text-danger">*</span></label>
                            <input type="text" name="venue" id="edit_venue" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" id="edit_address" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="edit_content" class="form-control" rows="4" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">YouTube URL</label>
                            <input type="url" name="youtube_url" id="edit_youtube" class="form-control" placeholder="https://youtube.com/watch?v=...">
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title Image</label>
                            <input type="file" name="title_image" id="edit_title_image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="text-muted d-block">Max size: 2MB. Leave empty to keep current.</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-12">
                            <div id="current_image_container">
                                <label class="form-label fw-semibold d-block">Current Image</label>
                                <div id="current_image"></div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Related Images</label>
                            
                            <div id="existing_related_images" class="mb-3"></div>
                            
                            <input type="file" name="related_images[]" id="edit_related_images" class="form-control" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="text-muted d-block">Max 2MB per image. Upload new images or keep existing ones.</small>
                            
                            <input type="hidden" name="delete_related_images" id="delete_related_images" value="">
                            
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateBtn">
                        <span id="updateBtnText"><i class="bi bi-save me-1"></i> Update Event</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DELETE CONFIRM MODAL --}}
<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteEventModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Are you sure you want to delete this event?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <span id="deleteBtnText">Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.animate-pulse { 
    animation: pulse 2s infinite; 
}

@keyframes pulse { 
    0%, 100% { opacity: 1; } 
    50% { opacity: 0.5; } 
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
}

.form-control.is-invalid ~ .invalid-feedback,
.form-select.is-invalid ~ .invalid-feedback {
    display: block;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

#editEventModal .modal-dialog {
    max-height: calc(100vh - 60px);
    margin: 30px auto;
}

#editEventModal .modal-content {
    max-height: calc(100vh - 60px);
    display: flex;
    flex-direction: column;
}

#editEventModal .modal-body {
    overflow-y: auto;
    max-height: calc(100vh - 200px);
    flex: 1 1 auto;
}

#editEventModal .modal-header,
#editEventModal .modal-footer {
    flex-shrink: 0;
}

.related-image-preview {
    position: relative;
    display: inline-block;
    margin: 5px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    transition: opacity 0.2s;
}

.related-image-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    display: block;
}

.related-image-preview .btn-remove-image {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 24px;
    height: 24px;
    padding: 0;
    border-radius: 50%;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: 2px solid white;
    font-size: 14px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.related-image-preview .btn-remove-image:hover {
    background: #dc3545;
    transform: scale(1.1);
}

#existing_related_images:empty::before {
    content: 'No existing images';
    color: #6c757d;
    font-size: 0.875rem;
    font-style: italic;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteEventId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // View Event Function
    window.viewEvent = function(id) {
        const modal = new bootstrap.Modal(document.getElementById('viewEventModal'));
        const modalBody = document.getElementById('viewEventBody');
        
        modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        modal.show();

        fetch(`/admin/events/${id}/get`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const e = data.event;
                let statusBadge = '';
                
                if (e.is_live) {
                    statusBadge = '<span class="badge bg-danger">● Live</span>';
                } else if (e.is_upcoming) {
                    statusBadge = '<span class="badge bg-success">Upcoming</span>';
                } else {
                    statusBadge = '<span class="badge bg-secondary">Past</span>';
                }

                let relatedImagesHtml = '';
                if (data.related_images_urls && data.related_images_urls.length > 0) {
                    relatedImagesHtml = '<hr><h6 class="mb-3">Related Images</h6><div class="d-flex flex-wrap gap-2">';
                    data.related_images_urls.forEach(url => {
                        relatedImagesHtml += `<img src="${url}" class="rounded" style="width:100px;height:100px;object-fit:cover;">`;
                    });
                    relatedImagesHtml += '</div>';
                }

                const eventDate = new Date(e.date);
                const formattedDate = eventDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            ${data.title_image_url 
                                ? `<img src="${data.title_image_url}" class="img-fluid rounded mb-3" alt="${e.event_title}">` 
                                : '<div class="bg-light p-5 text-center rounded mb-3"><i class="bi bi-image display-4 text-muted"></i></div>'}
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <h4 class="mb-0">${e.event_title}</h4>
                                ${statusBadge}
                            </div>
                            ${e.category ? `<span class="badge bg-info mb-3">${e.category.name}</span>` : ''}
                            <div class="mb-3">
                                <p class="mb-1"><i class="bi bi-calendar me-2 text-primary"></i><strong>Date:</strong> ${formattedDate}</p>
                                <p class="mb-1"><i class="bi bi-clock me-2 text-primary"></i><strong>Time:</strong> ${e.start_time} - ${e.end_time}</p>
                                <p class="mb-1"><i class="bi bi-geo-alt me-2 text-primary"></i><strong>Venue:</strong> ${e.venue}</p>
                                ${e.address ? `<p class="mb-1"><i class="bi bi-pin-map me-2 text-primary"></i><strong>Address:</strong> ${e.address}</p>` : ''}
                            </div>
                            ${e.youtube_url ? `<a href="${e.youtube_url}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-youtube me-1"></i> Watch Video</a>` : ''}
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <h6 class="mb-2">Description</h6>
                        <p class="text-muted">${e.content}</p>
                    </div>
                    ${relatedImagesHtml}
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to load event details');
            } else {
                alert('Failed to load event details');
            }
            bootstrap.Modal.getInstance(document.getElementById('viewEventModal')).hide();
        });
    };

    // Edit Event Function
    window.editEvent = function(id) {
        console.log('Edit event called for ID:', id);
        
        fetch(`/admin/events/${id}/get`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Event data received:', data);
            
            if (data.success) {
                const e = data.event;
                
                document.getElementById('edit_event_id').value = id;
                document.getElementById('edit_event_title').value = e.event_title || '';
                document.getElementById('edit_category').value = e.event_category_id || '';
                document.getElementById('edit_new_category').value = '';
                
                if (e.date) {
                    const dateObj = new Date(e.date);
                    const year = dateObj.getFullYear();
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    document.getElementById('edit_date').value = `${year}-${month}-${day}`;
                }
                
                document.getElementById('edit_start_time').value = e.start_time || '';
                document.getElementById('edit_end_time').value = e.end_time || '';
                document.getElementById('edit_venue').value = e.venue || '';
                document.getElementById('edit_address').value = e.address || '';
                document.getElementById('edit_content').value = e.content || '';
                document.getElementById('edit_youtube').value = e.youtube_url || '';
                
                const currentImageDiv = document.getElementById('current_image');
                if (data.title_image_url) {
                    currentImageDiv.innerHTML = `
                        <img src="${data.title_image_url}" class="img-thumbnail" style="max-height:120px; max-width:200px;" alt="Current image">
                        <p class="text-muted small mt-1 mb-0">Upload new image to replace</p>
                    `;
                } else {
                    currentImageDiv.innerHTML = '<span class="text-muted small">No current image</span>';
                }

                const existingImagesDiv = document.getElementById('existing_related_images');
                existingImagesDiv.innerHTML = '';
                
                if (data.related_images_urls && data.related_images_urls.length > 0) {
                    data.related_images_urls.forEach((url, index) => {
                        const imagePath = e.related_images[index];
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'related-image-preview';
                        previewDiv.dataset.imagePath = imagePath;
                        previewDiv.innerHTML = `
                            <img src="${url}" alt="Related image ${index + 1}">
                            <button type="button" class="btn-remove-image" onclick="removeRelatedImage(this, '${imagePath}')">
                                ×
                            </button>
                        `;
                        existingImagesDiv.appendChild(previewDiv);
                    });
                }

                document.getElementById('delete_related_images').value = '';

                document.querySelectorAll('#editEventModal .form-control, #editEventModal .form-select').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                document.querySelectorAll('#editEventModal .invalid-feedback').forEach(el => {
                    el.textContent = '';
                });

                document.getElementById('edit_title_image').value = '';
                document.getElementById('edit_related_images').value = '';

                const modal = new bootstrap.Modal(document.getElementById('editEventModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error loading event:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to load event data');
            } else {
                alert('Failed to load event data');
            }
        });
    };

    // Function to remove related image
    window.removeRelatedImage = function(button, imagePath) {
        const previewDiv = button.closest('.related-image-preview');
        previewDiv.style.opacity = '0.5';
        previewDiv.style.pointerEvents = 'none';
        
        setTimeout(() => {
            previewDiv.remove();
        }, 200);
        
        const deleteInput = document.getElementById('delete_related_images');
        const currentDeletes = deleteInput.value ? deleteInput.value.split(',') : [];
        currentDeletes.push(imagePath);
        deleteInput.value = currentDeletes.join(',');
        
        console.log('Marked for deletion:', imagePath);
    };

    // Edit Form Submit Handler - FIXED
    document.getElementById('editEventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Edit form submitted');
        
        document.querySelectorAll('#editEventModal .form-control, #editEventModal .form-select').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('#editEventModal .invalid-feedback').forEach(el => {
            el.textContent = '';
        });
        
        const formData = new FormData(this);
        const eventId = document.getElementById('edit_event_id').value;
        const updateBtn = document.getElementById('updateBtn');
        const btnText = document.getElementById('updateBtnText');
        
        console.log('Updating event ID:', eventId);
        
        updateBtn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
        
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        fetch(`/admin/events/${eventId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json().then(data => {
                if (!response.ok) {
                    throw data;
                }
                return data;
            });
        })
        .then(data => {
            console.log('Success response:', data);
            
            if (data.status === 'success') {
                if (typeof toastr !== 'undefined') {
                    toastr.success(data.message);
                } else {
                    alert(data.message);
                }
                
                const modalElement = document.getElementById('editEventModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
    
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error caught:', error);
            
            if (error.errors) {
                console.log('Validation errors:', error.errors);
                
                Object.keys(error.errors).forEach(key => {
                    let input = document.getElementById(`edit_${key}`);
                    if (!input) {
                        input = document.querySelector(`#editEventModal [name="${key}"]`);
                    }
                    
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentElement.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = error.errors[key][0];
                        }
                    } else {
                        console.warn('Input not found for field:', key);
                    }
                });
                
                if (typeof toastr !== 'undefined') {
                    toastr.error(error.message || 'Please fix the errors and try again.');
                } else {
                    alert(error.message || 'Please fix the errors and try again.');
                }
            } else if (error.message) {
                if (typeof toastr !== 'undefined') {
                    toastr.error(error.message);
                } else {
                    alert(error.message);
                }
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error('An unexpected error occurred. Please try again.');
                } else {
                    alert('An unexpected error occurred. Please try again.');
                }
            }
        })
        .finally(() => {
            console.log("Request completed");
            updateBtn.disabled = false;
            btnText.innerHTML = '<i class="bi bi-save me-1"></i> Update Event';
        });
    });

    // Delete Event Function
    window.deleteEvent = function(id) {
        deleteEventId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteEventModal'));
        modal.show();
    };

    // Confirm Delete Button
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (!deleteEventId) return;
        
        const btn = this;
        const btnText = document.getElementById('deleteBtnText');
        
        btn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
        
        fetch(`/admin/events/${deleteEventId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw data;
                }
                return data;
            });
        })
        .then(data => {
            if (data.status === 'success') {
                if (typeof toastr !== 'undefined') {
                    toastr.success(data.message);
                } else {
                    alert(data.message);
                }
                
                bootstrap.Modal.getInstance(document.getElementById('deleteEventModal')).hide();
                
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error(error.message || 'Failed to delete event');
            } else {
                alert(error.message || 'Failed to delete event');
            }
        })
        .finally(() => {
            btn.disabled = false;
            btnText.textContent = 'Delete';
        });
    });
});
</script>
@endsection