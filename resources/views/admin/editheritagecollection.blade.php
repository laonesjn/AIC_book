@extends('layouts.masteradmin')

@section('title', 'Edit Collection')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="h4 mb-0">
                <i class="fas fa-file-alt me-2"></i>Edit Collection
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Collections
            </a>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.heritagecollections.update', $collection->id) }}" method="POST" enctype="multipart/form-data" id="collectionForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Main Category -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Main Category *</label>
                            <select class="form-select" 
        name="master_main_category_id" 
        id="mainCategorySelect" required>
    <option value="">-- Select Main Category --</option>
    @foreach($masterMainCategories as $category)
       <option value="{{ $category->id }}" 
               {{ old('master_main_category_id', $collection->master_main_category_id) == $category->id ? 'selected' : '' }}>
           {{ $category->name }}
       </option>
    @endforeach
</select>
                            @error('main_category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Collection Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                name="title" value="{{ old('title', $collection->title) }}" required 
                                placeholder="Enter collection title" maxlength="255">
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Maximum 255 characters</small>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-bold">Title Image</label>

                            {{-- Current title image preview --}}
                           @if(!empty($collection->title_image))
                                <div class="mb-2 position-relative" id="title-image-wrapper">
                                    <img src="{{ asset('public/'.$collection->title_image) }}"
                                        alt="Current Title Image"
                                        class="img-thumbnail shadow-sm"
                                        style="max-height: 150px; object-fit: cover;">

                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                        onclick="deleteTitleImage({{ $collection->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            @endif

                            <input type="file" 
                                class="form-control @error('title_image') is-invalid @enderror"
                                name="title_image" 
                                accept="image/*">

                            @error('title_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-1">
                                Upload a cover image for this collection (JPG, PNG, WEBP – max 5MB)
                            </small>
                        </div>

                        <!-- Description with Rich Text Editor -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            
                            <!-- Rich Text Editor Container -->
                            <div class="rte-container" id="richTextEditor">
                                <div class="rte-toolbar">
                                    <!-- Text Formatting Group -->
                                    <div class="rte-toolbar-group">
                                        <button type="button" class="rte-btn" data-command="bold" title="Bold (Ctrl+B)">
                                            <i class="bi bi-type-bold"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="italic" title="Italic (Ctrl+I)">
                                            <i class="bi bi-type-italic"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="underline" title="Underline (Ctrl+U)">
                                            <i class="bi bi-type-underline"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="strikeThrough" title="Strikethrough">
                                            <i class="bi bi-type-strikethrough"></i>
                                        </button>
                                    </div>

                                    <!-- Font Size Group -->
                                    <div class="rte-toolbar-group">
                                        <select class="rte-select" data-command="fontSize" title="Font Size">
                                            <option value="2">Small</option>
                                            <option value="3" selected>Normal</option>
                                            <option value="5">Large</option>
                                            <option value="6">Huge</option>
                                        </select>
                                    </div>

                                    <!-- Color Group -->
                                    <div class="rte-toolbar-group">
                                        <input type="color" class="rte-color-input" data-command="foreColor" value="#000000" title="Text Color">
                                        <input type="color" class="rte-color-input" data-command="hiliteColor" value="#ffff00" title="Highlight">
                                    </div>

                                    <!-- Alignment Group -->
                                    <div class="rte-toolbar-group">
                                        <button type="button" class="rte-btn" data-command="justifyLeft" title="Align Left">
                                            <i class="bi bi-text-left"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="justifyCenter" title="Align Center">
                                            <i class="bi bi-text-center"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="justifyRight" title="Align Right">
                                            <i class="bi bi-text-right"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="justifyFull" title="Justify">
                                            <i class="bi bi-justify"></i>
                                        </button>
                                    </div>

                                    <!-- List Group -->
                                    <div class="rte-toolbar-group">
                                        <button type="button" class="rte-btn" data-command="insertUnorderedList" title="Bullet List">
                                            <i class="bi bi-list-ul"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="insertOrderedList" title="Numbered List">
                                            <i class="bi bi-list-ol"></i>
                                        </button>
                                    </div>

                                    <!-- Link Group -->
                                    <div class="rte-toolbar-group">
                                        <button type="button" class="rte-btn" id="insertLinkBtn" title="Insert Link">
                                            <i class="bi bi-link-45deg"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="unlink" title="Remove Link">
                                            <i class="bi bi-link-45deg" style="text-decoration: line-through;"></i>
                                        </button>
                                    </div>

                                    <!-- Edit Group -->
                                    <div class="rte-toolbar-group">
                                        <button type="button" class="rte-btn" data-command="undo" title="Undo (Ctrl+Z)">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                        <button type="button" class="rte-btn" data-command="redo" title="Redo (Ctrl+Y)">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>

                                    <!-- Clear Formatting Group -->
                                    <div class="rte-toolbar-group">
                                        <button type="button" class="rte-btn" data-command="removeFormat" title="Clear Formatting">
                                            <i class="bi bi-eraser"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="rte-content" contenteditable="true" data-placeholder="Start typing your description here..."></div>
                            </div>
                            
                            <!-- Hidden input to store content for form submission -->
                            <input type="hidden" name="description" id="description" required>
                            @error('description')
                                <div class="invalid-feedback d-block" id="description-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Collection Images</h5>
                    </div>
                    <div class="card-body">
                        <!-- Existing Images -->
                        @if($collection->images && count($collection->images) > 0)
                            <div class="mb-4">
                                <h6>Current Images</h6>
                                <div class="row g-2">
                                    @foreach($collection->images as $index => $image)
                                        <div class="col-md-3" id="image-{{ $index }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('public/'.$image) }}" 
                                                    class="img-thumbnail w-100" style="height: 120px; object-fit: cover;">
                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                                    onclick="deleteExistingImage({{ $collection->id }}, {{ $index }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                            </div>
                        @endif

                        <!-- Upload New Images -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload New Images (Max 10 total)</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                    name="images[]" id="imagesInput" multiple accept="image/*">
                                <small class="form-text text-muted d-block mt-2">
                                    Allowed formats: JPEG, PNG, JPG, GIF, WebP. Max size: 5MB each
                                </small>
                            </div>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="imagePreviewContainer" class="row g-2">
                            <!-- Image previews will appear here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Access Type -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Access Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Access Type *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="access_type" 
                                    id="accessPublic" value="Public" 
                                    {{ $collection->access_type == 'Public' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="accessPublic">
                                    <i class="fas fa-globe me-2"></i>Public
                                    <small class="d-block text-muted">Visible to everyone</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="access_type" 
                                    id="accessPrivate" value="Private"
                                    {{ $collection->access_type == 'Private' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="accessPrivate">
                                    <i class="fas fa-lock me-2"></i>Private
                                    <small class="d-block text-muted">Only authorized users</small>
                                </label>
                            </div>
                        </div>
                        @error('access_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <!-- View Count -->
                        <div class="pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-eye me-2"></i>Views: <strong>{{ $collection->view_count }}</strong>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- PDF Upload (Conditional) -->
                <div class="card shadow-sm mb-4" id="pdfSection">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-file-pdf me-2"></i>PDF Document
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Current PDF -->
                        @if($collection->pdf)
                            <div class="alert alert-info mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-pdf me-2"></i>
                                        <a href="{{ asset($collection->pdf) }}" target="_blank">
                                            {{ basename($collection->pdf) }}
                                        </a>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deletePdf()">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <p class="small text-muted mb-3" id="pdfHelpText">
                            Upload a new PDF to replace the current one
                        </p>
                        <input type="file" class="form-control @error('pdf') is-invalid @enderror" 
                            name="pdf" id="pdfInput" accept=".pdf">
                        <small class="form-text text-muted d-block mt-2">
                            Max size: 50MB. Optional for public collections
                        </small>
                        @error('pdf')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div id="pdfPreview"></div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Update Collection
                        </button>
                        <a href="{{ route('admin.collections.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mt-4" role="alert">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>Created
                    </h6>
                    <small>
                        {{ $collection->created_at->format('F d, Y H:i') }}<br>
                        Last updated: {{ $collection->updated_at->format('F d, Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Link Modal -->
<div id="linkModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeLinkModal()">&times;</span>
        <h2>Insert Link</h2>
        <input type="text" id="linkText" placeholder="Link text (optional)" class="form-control mb-2">
        <input type="url" id="linkUrl" placeholder="URL (required)" class="form-control mb-2">
        <label>
            <input type="checkbox" id="linkNewTab"> Open in new tab
        </label>
        <button onclick="insertLink()" class="btn btn-primary mt-3">Insert Link</button>
    </div>
</div>

<style>
    /* Rich Text Editor Styles */
    .rte-container {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background: white;
    }

    .rte-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .rte-toolbar-group {
        display: flex;
        gap: 0.25rem;
        border-right: 1px solid #dee2e6;
        padding-right: 0.5rem;
        margin-right: 0.5rem;
    }

    .rte-toolbar-group:last-child {
        border-right: none;
        padding-right: 0;
        margin-right: 0;
    }

    .rte-btn {
        background: white;
        border: 1px solid #dee2e6;
        padding: 0.375rem 0.75rem;
        cursor: pointer;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .rte-btn:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    .rte-btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .rte-select,
    .rte-color-input {
        padding: 0.375rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }

    .rte-color-input {
        width: 40px;
        height: 38px;
        cursor: pointer;
    }

    .rte-content {
        min-height: 300px;
        padding: 1rem;
        outline: none;
        font-family: inherit;
        font-size: 1rem;
        line-height: 1.5;
    }

    .rte-content[data-placeholder]:empty:before {
        content: attr(data-placeholder);
        color: #6c757d;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 0.5rem;
        width: 90%;
        max-width: 400px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
    }
</style>

<script>
 /**
     * Rich Text Editor Class
     */
    class RichTextEditor {
        constructor(containerId) {
            this.container = document.getElementById(containerId);
            this.toolbar = this.container.querySelector('.rte-toolbar');
            this.content = this.container.querySelector('.rte-content');
            this.savedSelection = null;
            
            this.init();
        }

        init() {
            this.attachToolbarEvents();
            this.attachKeyboardShortcuts();
            this.updateToolbarState();
            this.setupLinkButton();
        }

        setupLinkButton() {
            const linkBtn = document.getElementById('insertLinkBtn');
            if (linkBtn) {
                linkBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.openLinkModal();
                });
            }
        }

        saveSelection() {
            if (window.getSelection) {
                const sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    this.savedSelection = sel.getRangeAt(0);
                }
            }
        }

        restoreSelection() {
            if (this.savedSelection) {
                if (window.getSelection) {
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(this.savedSelection);
                }
            }
        }

        openLinkModal() {
            this.saveSelection();
            
            const selectedText = window.getSelection().toString();
            document.getElementById('linkText').value = selectedText;
            document.getElementById('linkUrl').value = '';
            document.getElementById('linkNewTab').checked = true;
            
            document.getElementById('linkModal').style.display = 'block';
            document.getElementById('linkUrl').focus();
        }

        attachToolbarEvents() {
            // Button clicks
            this.toolbar.querySelectorAll('.rte-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const command = btn.getAttribute('data-command');
                    this.executeCommand(command);
                    this.content.focus();
                });
            });

            // Font size select
            this.toolbar.querySelectorAll('.rte-select').forEach(select => {
                select.addEventListener('change', (e) => {
                    const command = select.getAttribute('data-command');
                    this.executeCommand(command, e.target.value);
                    this.content.focus();
                });
            });

            // Color inputs
            this.toolbar.querySelectorAll('.rte-color-input').forEach(input => {
                input.addEventListener('change', (e) => {
                    const command = input.getAttribute('data-command');
                    this.executeCommand(command, e.target.value);
                    this.content.focus();
                });
            });

            // Update toolbar state on selection change
            this.content.addEventListener('mouseup', () => this.updateToolbarState());
            this.content.addEventListener('keyup', () => this.updateToolbarState());
        }

        attachKeyboardShortcuts() {
            this.content.addEventListener('keydown', (e) => {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key.toLowerCase()) {
                        case 'b':
                            e.preventDefault();
                            this.executeCommand('bold');
                            break;
                        case 'i':
                            e.preventDefault();
                            this.executeCommand('italic');
                            break;
                        case 'u':
                            e.preventDefault();
                            this.executeCommand('underline');
                            break;
                        case 'z':
                            if (!e.shiftKey) {
                                e.preventDefault();
                                this.executeCommand('undo');
                            }
                            break;
                        case 'y':
                            e.preventDefault();
                            this.executeCommand('redo');
                            break;
                    }
                }
            });
        }

        executeCommand(command, value = null) {
            document.execCommand(command, false, value);
        }

        updateToolbarState() {
            const commands = ['bold', 'italic', 'underline', 'strikeThrough', 
                            'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull',
                            'insertUnorderedList', 'insertOrderedList'];

            commands.forEach(command => {
                const btn = this.toolbar.querySelector(`[data-command="${command}"]`);
                if (btn) {
                    if (document.queryCommandState(command)) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                }
            });
        }

        getContent() {
            return this.content.innerHTML;
        }

        setContent(html) {
            this.content.innerHTML = html;
        }

        clear() {
            this.content.innerHTML = '';
        }
    }

    // Initialize Rich Text Editor
    let editor;
    document.addEventListener('DOMContentLoaded', function() {
        editor = new RichTextEditor('richTextEditor');
        
        // Load existing description if available
        @if($collection->description)
            editor.setContent({!! json_encode($collection->description) !!});
        @endif
    });

    // Form Submission
    document.getElementById('collectionForm').addEventListener('submit', function(e) {
        // Get content from rich text editor and set it to hidden input
        const content = editor.getContent();
        document.getElementById('description').value = content;
        
        // Validate content is not empty
        if (!content || content.trim() === '') {
            e.preventDefault();
            alert('Description is required');
            return;
        }
    });

    // Close link modal
    function closeLinkModal() {
        document.getElementById('linkModal').style.display = 'none';
    }

    // Insert link into editor
    function insertLink() {
        const linkText = document.getElementById('linkText').value;
        const linkUrl = document.getElementById('linkUrl').value;
        const newTab = document.getElementById('linkNewTab').checked;

        if (!linkUrl) {
            alert('Please enter a URL');
            return;
        }

        // Restore selection
        editor.restoreSelection();
        
        // Create link HTML
        const target = newTab ? ' target="_blank"' : '';
        const linkHtml = `<a href="${linkUrl}"${target}>${linkText || linkUrl}</a>`;
        
        // Insert link
        document.execCommand('insertHTML', false, linkHtml);
        
        // Close modal
        closeLinkModal();
        editor.content.focus();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('linkModal');
        if (event.target == modal) {
            closeLinkModal();
        }
    }

    // Allow Enter key to submit link
    document.addEventListener('DOMContentLoaded', function() {
        const linkUrl = document.getElementById('linkUrl');
        if (linkUrl) {
            linkUrl.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    insertLink();
                }
            });
        }
    });

    // Image preview
    document.getElementById('imagesInput').addEventListener('change', function() {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';

        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-12';
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail w-100" style="height: 120px; object-fit: cover;">
                        <small class="d-block mt-1 text-muted">${file.name}</small>
                    </div>
                `;
                container.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });

    // Delete existing image
    function deleteExistingImage(collectionId, index) {
        if (confirm('Are you sure you want to delete this image?')) {
            fetch(`/admin/heritagecollections/${collectionId}/images/${index}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`image-${index}`).remove();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete image');
            });
        }
    }

    // Delete PDF
    function deletePdf() {
        if (confirm('Are you sure you want to delete the PDF?')) {
            // Create a hidden input to mark PDF for deletion
            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_pdf';
            deleteInput.value = '1';
            document.getElementById('collectionForm').appendChild(deleteInput);
            
            // Clear the file input and submit
            document.getElementById('pdfInput').value = '';
            alert('PDF will be deleted on update');
        }
    }

    // Show/hide PDF section based on access type
    function updatePdfSection() {
        const isPublic = document.getElementById('accessPublic').checked;
        const pdfSection = document.getElementById('pdfSection');

        if (isPublic) {
            pdfSection.style.display = 'block';
            document.getElementById('pdfHelpText').textContent = 'Upload a new PDF to replace the current one';
        } else {
            document.getElementById('pdfHelpText').textContent = 'PDF is not required for private collections';
        }
    }

    document.getElementById('accessPublic').addEventListener('change', updatePdfSection);
    document.getElementById('accessPrivate').addEventListener('change', updatePdfSection);

    // PDF file preview
    document.getElementById('pdfInput').addEventListener('change', function() {
        const preview = document.getElementById('pdfPreview');
        if (this.files && this.files[0]) {
            preview.innerHTML = `
                <div class="alert alert-success mt-2 mb-0">
                    <i class="fas fa-file-pdf me-2"></i>${this.files[0].name}
                </div>
            `;
        }
    });

    // Initialize
    updatePdfSection();

    function deleteTitleImage(collectionId) {
    if (!confirm('Are you sure you want to delete the title image?')) return;

    fetch(`/admin/heritagecollections/${collectionId}/title-image`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('title-image-wrapper').remove();
            alert(data.message);
        } else {
            alert(data.message || 'Failed to delete title image');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Something went wrong while deleting title image');
    });
}
</script>

@endsection