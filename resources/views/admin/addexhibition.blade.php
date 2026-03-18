@extends('layouts.masteradmin')

@section('title', 'Add Exhibition')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
   
    body { background: var(--cream); font-family: 'DM Sans', sans-serif; color: var(--ink); }
    .ex-form-wrap { max-width: 860px; margin: 0 auto; padding: 40px 32px 80px; }
    .ex-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; margin-bottom: 28px; overflow: hidden; box-shadow: var(--shadow); }
    .ex-card-header { padding: 20px 28px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: linear-gradient(to right, #fdfcfa, var(--surface)); }
    .ex-card-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--gold-lt); display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
    .ex-card-title { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 600; color: var(--ink); }
    .ex-card-body { padding: 24px 28px; }
    .field-row { margin-bottom: 22px; }
    .field-row:last-child { margin-bottom: 0; }
    .field-row.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .field-row.three-col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
    @media(max-width:600px) { .field-row.two-col, .field-row.three-col { grid-template-columns: 1fr; } }
    label.field-label { display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 7px; }
    label.field-label span.req { color: var(--rust); margin-left: 2px; }
    .field-hint { font-size: 12px; color: var(--muted); margin-top: 5px; }
    input[type="text"], input[type="url"], textarea, select {
        width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: var(--radius);
        font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--ink); background: var(--surface);
        transition: border-color .18s, box-shadow .18s; box-sizing: border-box; outline: none; -webkit-appearance: none;
    }
    input:focus, textarea:focus, select:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.15); }
    textarea { resize: vertical; min-height: 96px; }
    select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237a7570' stroke-width='1.6' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
    .is-invalid { border-color: var(--rust) !important; }
    .invalid-feedback { font-size: 12px; color: var(--rust); margin-top: 5px; }
    .file-zone { border: 2px dashed var(--border); border-radius: var(--radius); padding: 28px 20px; text-align: center; cursor: pointer; transition: border-color .2s, background .2s; position: relative; background: #fdfcfa; }
    .file-zone:hover, .file-zone.drag-over { border-color: var(--gold); background: var(--gold-lt); }
    .file-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .file-zone-icon { font-size: 28px; margin-bottom: 8px; }
    .file-zone-text { font-size: 13px; color: var(--muted); }
    .file-zone-text strong { color: var(--ink); }
    .file-preview-strip { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px; }
    .file-preview-strip img { height: 70px; width: 70px; object-fit: cover; border-radius: 7px; border: 1.5px solid var(--border); }
    .cover-preview-wrap { margin-top: 12px; }
    .cover-preview-wrap img { width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px; border: 1.5px solid var(--border); }
    .artifact-cards { display: flex; flex-direction: column; gap: 16px; }
    .artifact-card { background: #fdfcfa; border: 1.5px solid var(--border); border-radius: 12px; padding: 22px; position: relative; transition: border-color .2s; animation: slideIn .25s ease; }
    .artifact-card:hover { border-color: var(--gold); }
    @keyframes slideIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
    .artifact-card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
    .artifact-badge { background: var(--ink); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
    .artifact-remove { margin-left: auto; background: none; border: 1.5px solid var(--border); color: var(--muted); border-radius: 7px; width: 30px; height: 30px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; transition: all .15s; }
    .artifact-remove:hover { background: var(--rust); border-color: var(--rust); color: #fff; }
    .artifact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media(max-width:600px) { .artifact-grid { grid-template-columns: 1fr; } }
    .artifact-image-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1.5px solid var(--border); margin-top: 10px; display: none; }
    .btn-add-artifact { display: inline-flex; align-items: center; gap: 8px; background: none; border: 2px dashed var(--gold); color: var(--gold); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; padding: 10px 20px; border-radius: var(--radius); cursor: pointer; transition: all .2s; margin-top: 4px; }
    .btn-add-artifact:hover { background: var(--gold-lt); }
    .btn-submit { display: inline-flex; align-items: center; gap: 10px; background: var(--ink); color: black; font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600; padding: 15px 40px; border: none; border-radius: var(--radius); cursor: pointer; transition: all .2s; box-shadow: 0 4px 18px rgba(15,15,15,.25); }
    .btn-submit:hover { background: #1c1c1c; color: white; transform: translateY(-1px); }
    .btn-submit .arrow { transition: transform .2s; }
    .btn-submit:hover .arrow { transform: translateX(4px); }
    .form-footer { display: flex; align-items: center; gap: 20px; padding: 28px 0; border-top: 1px solid var(--border); margin-top: 8px; }
    .form-footer-note { font-size: 12px; color: var(--muted); }
    .ex-alert { display: flex; align-items: center; gap: 10px; background: #fff8ee; border: 1.5px solid var(--gold); border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; }
</style>

@section('content')

<div class="ex-form-wrap">

    @if($errors->any())
    <div class="ex-alert">
        <span>⚠️</span>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul style="margin:4px 0 0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.exhibitions.store') }}" method="POST" enctype="multipart/form-data" id="exhibitionForm" novalidate>
        @csrf

        {{-- ── 1. Basic Info ── --}}
        <div class="ex-card">
            <div class="ex-card-header">
                <div class="ex-card-icon">🏛️</div>
                <div class="ex-card-title">Basic Information</div>
            </div>
            <div class="ex-card-body">

                <div class="field-row">
                    <label class="field-label" for="title">Exhibition Title <span class="req">*</span></label>
                    <input type="text" id="title" name="title"
                           class="@error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="e.g. Echoes of the Ancient World">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="field-row two-col">
                    <div>
                        <label class="field-label" for="category_id">Category <span class="req">*</span></label>
                        <select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="exhibition_location">Exhibition Location</label>
                        <input type="text" id="exhibition_location" name="exhibition_location"
                               class="@error('exhibition_location') is-invalid @enderror"
                               value="{{ old('exhibition_location') }}"
                               placeholder="e.g. Hall B, Floor 2">
                        @error('exhibition_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="field-hint">Physical location within the museum.</div>
                    </div>
                </div>

                <div class="field-row">
                    <label class="field-label" for="tour_link">Virtual Tour Link</label>
                    <input type="url" id="tour_link" name="tour_link"
                           value="{{ old('tour_link') }}"
                           placeholder="https://my360tour.com/...">
                    @error('tour_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="field-hint">Optional — Matterport, Kuula, etc.</div>
                </div>

                <div class="field-row">
                    <label class="field-label" for="description">Description <span class="req">*</span></label>
                    <textarea id="description" name="description"
                              class="@error('description') is-invalid @enderror"
                              rows="4"
                              placeholder="Tell visitors what makes this exhibition special…">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- ── 2. Media ── --}}
        <div class="ex-card">
            <div class="ex-card-header">
                <div class="ex-card-icon">🖼️</div>
                <div class="ex-card-title">Media</div>
            </div>
            <div class="ex-card-body">

                <div class="field-row">
                    <label class="field-label">Cover / Hero Image</label>
                    <div class="file-zone" id="coverZone">
                        <input type="file" name="cover_image" accept="image/*" id="coverInput" onchange="previewCover(event)">
                        <div class="file-zone-icon">📸</div>
                        <div class="file-zone-text"><strong>Click or drag</strong> to upload cover image</div>
                        <div class="file-zone-text" style="margin-top:4px">JPG, PNG, WEBP · Max 4MB · Recommended 1200×600px</div>
                    </div>
                    <div class="cover-preview-wrap" id="coverPreviewWrap" style="display:none">
                        <img id="coverPreviewImg" src="" alt="Cover preview">
                    </div>
                    @error('cover_image')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                </div>

                <div class="field-row">
                    <label class="field-label">Gallery Images</label>
                    <div class="file-zone" id="galleryZone">
                        <input type="file" name="gallery_images[]" accept="image/*" multiple id="galleryInput" onchange="previewGallery(event)">
                        <div class="file-zone-icon">🗂️</div>
                        <div class="file-zone-text"><strong>Click or drag</strong> to upload gallery images</div>
                        <div class="file-zone-text" style="margin-top:4px">Multiple files · JPG, PNG, WEBP · Max 4MB each</div>
                    </div>
                    <div class="file-preview-strip" id="galleryPreviewStrip"></div>
                    @error('gallery_images')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- ── 3. Artifacts ── --}}
        <div class="ex-card">
            <div class="ex-card-header">
                <div class="ex-card-icon">🏺</div>
                <div class="ex-card-title">Artifacts</div>
            </div>
            <div class="ex-card-body">
                <div class="artifact-cards" id="artifactsContainer"></div>

                <button type="button" class="btn-add-artifact" onclick="addArtifact()">
                    <span>＋</span> Add Artifact
                </button>
                <div class="field-hint" style="margin-top:8px">Each artifact represents an item in your exhibition.</div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="form-footer">
            <button type="submit" class="btn-submit">
                Publish Exhibition <span class="arrow">→</span>
            </button>
            <span class="form-footer-note">Fields marked <span style="color:var(--rust)">*</span> are required.</span>
        </div>

    </form>
</div>

<script>
let artifactIdx = 0;

function addArtifact() {
    artifactIdx++;
    const n  = artifactIdx;
    const id = 'artifact_card_' + n;
    const html = `
    <div class="artifact-card" id="${id}">
        <div class="artifact-card-header">
            <span class="artifact-badge">Artifact #${n}</span>
            <button type="button" class="artifact-remove" onclick="removeArtifact('${id}')" title="Remove">✕</button>
        </div>
        <div class="artifact-grid">
            <div>
                <div class="field-row">
                    <label class="field-label">Name <span class="req" style="color:#b34a2f">*</span></label>
                    <input type="text" name="artifacts[${n}][name]" placeholder="Artifact name" required>
                </div>
                <div class="field-row">
                    <label class="field-label">Description</label>
                    <textarea name="artifacts[${n}][description]" rows="3" placeholder="Brief description…"></textarea>
                </div>
                <div class="field-row">
                    <label class="field-label">File / Physical Location</label>
                    <input type="text" name="artifacts[${n}][file_location]" placeholder="e.g. Room A, Case 3">
                    <div style="font-size:12px;color:#7a7570;margin-top:5px">Where this artifact is physically stored or displayed.</div>
                </div>
            </div>
            <div>
                <div class="field-row">
                    <label class="field-label">Image</label>
                    <div class="file-zone" style="padding:16px">
                        <input type="file" name="artifacts[${n}][image]" accept="image/*"
                               onchange="previewArtifactImg(this, 'ap_${n}')">
                        <div class="file-zone-text" style="font-size:12px">Click to upload image</div>
                    </div>
                    <img class="artifact-image-preview" id="ap_${n}">
                </div>
            </div>
        </div>
    </div>`;
    document.getElementById('artifactsContainer').insertAdjacentHTML('beforeend', html);
}

function removeArtifact(id) {
    const el = document.getElementById(id);
    if (el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(-6px)';
        el.style.transition = 'all .2s';
        setTimeout(() => el.remove(), 200);
    }
}

function previewCover(event) {
    const file = event.target.files[0];
    if (!file) return;
    const wrap = document.getElementById('coverPreviewWrap');
    const img  = document.getElementById('coverPreviewImg');
    img.src = URL.createObjectURL(file);
    wrap.style.display = 'block';
    document.getElementById('coverZone').style.borderColor = 'var(--gold)';
}

function previewGallery(event) {
    const strip = document.getElementById('galleryPreviewStrip');
    strip.innerHTML = '';
    Array.from(event.target.files).forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        strip.appendChild(img);
    });
}

function previewArtifactImg(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const preview = document.getElementById(previewId);
    if (preview) { preview.src = URL.createObjectURL(file); preview.style.display = 'block'; }
}

/* Drag-over highlight */
document.querySelectorAll('.file-zone').forEach(zone => {
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop',     () => zone.classList.remove('drag-over'));
});
</script>

@endsection