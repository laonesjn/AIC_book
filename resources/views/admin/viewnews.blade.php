@extends('layouts.masteradmin')

@section('title', 'Manage News')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">All News ({{ $news->count() }})</h2>
        <a href="{{ route('admin.addnews') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New
        </a>
    </div>

    <!-- NEWS TABLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle border shadow-sm rounded-4 overflow-hidden">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Visibility</th>
                    <th>Views</th>
                    <th>Image</th>
                    <th>PDF</th>
                    <th>Links</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $item)
                <tr id="news-row-{{ $item->id }}">
                    <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                    <td>{{ Str::limit($item->title, 40) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $item->visibility == 'public' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($item->visibility) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $item->views }}</td>
                    <td class="text-center">
                        @if($item->title_image)
                            <img src="{{ filter_var($item->title_image, FILTER_VALIDATE_URL) 
                                ? $item->title_image 
                                : asset($item->title_image) }}" 
                                width="60" class="rounded">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->pdf_file)
                            <a href="{{ asset($item->pdf_file) }}" target="_blank" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->reference_links && count($item->reference_links) > 0)
                            <span class="badge bg-info">{{ count($item->reference_links) }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-info" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal{{ $item->id }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteNews({{ $item->id }})">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-pencil-square me-2"></i>Edit News
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form id="editForm{{ $item->id }}" class="edit-news-form" data-id="{{ $item->id }}">
                                    @csrf

                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" 
                                               value="{{ $item->title }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                        <textarea name="content" class="form-control" rows="5" required>{{ $item->content }}</textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <!-- Visibility -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Visibility <span class="text-danger">*</span></label>
                                        <select name="visibility" class="form-select" required>
                                            <option value="public" {{ $item->visibility == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ $item->visibility == 'private' ? 'selected' : '' }}>Private</option>
                                        </select>
                                    </div>

                                    <!-- Reference Links -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Reference Links</label>
                                        <div class="reference-links-edit" id="refLinks{{ $item->id }}">
                                            @if($item->reference_links && count($item->reference_links) > 0)
                                                @foreach($item->reference_links as $link)
                                                <div class="input-group mb-2 reference-link-item">
                                                    <input type="url" name="reference_links[]" class="form-control" 
                                                           value="{{ $link }}">
                                                    <button type="button" class="btn btn-danger" 
                                                            onclick="removeReferenceLinkEdit(this)">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2">
                                                    <input type="url" name="reference_links[]" class="form-control" 
                                                           placeholder="https://example.com">
                                                    <button type="button" class="btn btn-success" 
                                                            onclick="addReferenceLinkEdit({{ $item->id }})">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-success mt-2" 
                                                onclick="addReferenceLinkEdit({{ $item->id }})">
                                            <i class="bi bi-plus-lg"></i> Add Link
                                        </button>
                                    </div>

                                    <!-- Title Image -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Current Title Image</label><br>
                                        @if($item->title_image)
                                            <img src="{{ filter_var($item->title_image, FILTER_VALIDATE_URL) 
                                                ? $item->title_image
                                                : asset($item->title_image) }}" 
                                                width="200" class="rounded shadow-sm mb-2">
                                        @else
                                            <p>No image uploaded</p>
                                        @endif
                                        <input type="file" name="title_image" class="form-control mt-2" accept="image/*">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <!-- PDF File -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Current PDF File</label><br>
                                        @if($item->pdf_file)
                                            <a href="{{ asset($item->pdf_file) }}" target="_blank" 
                                               class="btn btn-outline-primary mb-2">
                                                <i class="bi bi-file-earmark-pdf me-2"></i> View Current PDF
                                            </a>
                                        @else
                                            <p>No PDF uploaded</p>
                                        @endif
                                        <input type="file" name="pdf_file" class="form-control mt-2" accept="application/pdf">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-success update-btn">
                                            <span class="btn-text">
                                                <i class="bi bi-check-circle"></i> Update News
                                            </span>
                                            <span class="btn-spinner d-none">
                                                <span class="spinner-border spinner-border-sm me-2"></span>
                                                Updating...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2">No news found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Styles -->
<style>
    .update-btn .btn-spinner {
        display: none;
    }
    
    .update-btn.loading .btn-text {
        display: none;
    }
    
    .update-btn.loading .btn-spinner {
        display: inline-block !important;
    }
    
    .update-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

<!-- Scripts -->
<script>
    // Add Reference Link in Edit Modal
    function addReferenceLinkEdit(newsId) {
        const container = document.getElementById('refLinks' + newsId);
        const newLink = document.createElement('div');
        newLink.className = 'input-group mb-2 reference-link-item';
        newLink.innerHTML = `
            <input type="url" name="reference_links[]" class="form-control" 
                   placeholder="https://example.com">
            <button type="button" class="btn btn-danger" onclick="removeReferenceLinkEdit(this)">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newLink);
    }

    // Remove Reference Link in Edit Modal
    function removeReferenceLinkEdit(btn) {
        btn.closest('.reference-link-item').remove();
    }

    // Update News via AJAX
    $(document).ready(function() {
        $('.edit-news-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const newsId = form.data('id');
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            // Clear previous errors
            form.find('.form-control').removeClass('is-invalid');
            form.find('.invalid-feedback').text('');
            
            // Show loading state
            const submitBtn = form.find('.update-btn');
            submitBtn.addClass('loading').prop('disabled', true);
            
            $.ajax({
                url: `/admin/news/update/${newsId}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    submitBtn.removeClass('loading').prop('disabled', false);
                    
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        
                        // Close modal
                        $('#editModal' + newsId).modal('hide');
                        
                        // Reload page after 1 second
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    submitBtn.removeClass('loading').prop('disabled', false);
                    
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        
                        $.each(errors, function(key, value) {
                            const input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(value[0]);
                        });
                        
                        toastr.error('Please fix the validation errors');
                    } else {
                        const message = xhr.responseJSON?.message || 'Failed to update news';
                        toastr.error(message);
                    }
                }
            });
        });
    });

    // Delete News via AJAX
    function deleteNews(newsId) {
        if (!confirm('Are you sure you want to delete this news?')) {
            return;
        }
        
        $.ajax({
            url: `/admin/news/delete/${newsId}`,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    
                    // Remove row with animation
                    $('#news-row-' + newsId).fadeOut(500, function() {
                        $(this).remove();
                    });
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Failed to delete news';
                toastr.error(message);
            }
        });
    }
</script>
@endsection