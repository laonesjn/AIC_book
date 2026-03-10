@extends('layouts.masteradmin')

@section('title', 'Create Collection')

@section('content')
<div>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold mb-2">
                Create New Heritage Collection
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="" class="btn btn-secondary">
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

    <form action="{{ route('admin.heritagecollections.store') }}" method="POST" enctype="multipart/form-data" id="collectionForm">
        @csrf
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
                            <select class="form-select @error('master_main_category_id') is-invalid @enderror" 
                                name="master_main_category_id" id="mainCategorySelect" required>
                                <option value="">-- Select Main Category --</option>
                                @foreach($masterMainCategories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('master_main_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('master_main_category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Collection Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                name="title" value="{{ old('title') }}" required 
                                placeholder="Enter collection title" maxlength="255">
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Maximum 255 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Title Image</label>
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
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Images (Max 10)</label>
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
                                    {{ old('access_type', 'Public') == 'Public' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="accessPublic">
                                    <i class="fas fa-globe me-2"></i>Public
                                    <small class="d-block text-muted">Visible to everyone</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="access_type" 
                                    id="accessPrivate" value="Private"
                                    {{ old('access_type') == 'Private' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="accessPrivate">
                                    <i class="fas fa-lock me-2"></i>Private
                                    <small class="d-block text-muted">Only authorized users</small>
                                </label>
                            </div>
                        </div>
                        @error('access_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
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
                        <p class="small text-muted mb-3" id="pdfHelpText">
                            Upload a PDF for public collections
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
                
                <!-- OneDrive Links -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-link me-2"></i>OneDrive Links
                        </h5>
                        <button type="button" class="btn btn-sm btn-success" id="addLinkBtn">
                            <i class="fas fa-plus me-1"></i>Add
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="onedriveLinksContainer">
                            <!-- Link inputs will be added here -->
                        </div>
                        <small class="text-muted d-block mt-2">
                            Add multiple OneDrive links for this heritage collection.
                        </small>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Create Collection
                        </button>
                        <a href="" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mt-4" role="alert">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>Tips
                    </h6>
                    <small>
                        <ul class="mb-0 ps-3">
                            <li>Fill all required fields marked with *</li>
                            <li>Upload high-quality images for better display</li>
                            <li>PDF is optional for public collections</li>
                            <li>Use rich text editor to format description</li>
                        </ul>
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

    // OneDrive Links Logic
    document.getElementById('addLinkBtn').addEventListener('click', function() {
        const container = document.getElementById('onedriveLinksContainer');
        const index = Date.now();
        
        const linkRow = document.createElement('div');
        linkRow.className = 'row g-2 mb-2 link-row align-items-center';
        linkRow.innerHTML = `
            <div class="col-5">
                <input type="text" name="onedrive_links[${index}][title]" class="form-control form-control-sm" placeholder="Title (Optional)">
            </div>
            <div class="col-6">
                <input type="url" name="onedrive_links[${index}][url]" class="form-control form-control-sm" placeholder="OneDrive URL" required>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-link-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(linkRow);
    });

    document.getElementById('onedriveLinksContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-link-btn')) {
            e.target.closest('.link-row').remove();
        }
    });
</script>

@endsection