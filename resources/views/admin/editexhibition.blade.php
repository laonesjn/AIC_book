@extends('layouts.masteradmin')
@section('title', 'Edit — ' . $exhibition->title)

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root{--ink:#0f0f0f;--cream:#faf8f4;--gold:#c9a84c;--gold-lt:#f0e6c8;--rust:#b34a2f;--muted:#7a7570;--border:#e2ddd6;--surface:#ffffff;--radius:10px;--shadow:0 4px 24px rgba(15,15,15,.08);}
    body{background:var(--cream);font-family:'DM Sans',sans-serif;color:var(--ink);}
    .ex-header{background:var(--ink);color:#fff;padding:52px 0 40px;position:relative;overflow:hidden;}
    .ex-header::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(-45deg,transparent,transparent 40px,rgba(201,168,76,.06) 40px,rgba(201,168,76,.06) 41px);}
    .ex-header-inner{max-width:900px;margin:0 auto;padding:0 32px;position:relative;display:flex;align-items:center;justify-content:space-between;}
    .ex-header-label{font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--gold);font-weight:600;margin-bottom:12px;}
    .ex-header h1{font-family:'Playfair Display',serif;font-size:clamp(22px,3.5vw,36px);font-weight:700;margin:0;line-height:1.15;}
    .ex-form-wrap{max-width:900px;margin:0 auto;padding:40px 32px 80px;}
    .ex-card{background:var(--surface);border:1px solid var(--border);border-radius:14px;margin-bottom:28px;overflow:hidden;box-shadow:var(--shadow);}
    .ex-card-header{padding:20px 28px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;background:linear-gradient(to right,#fdfcfa,var(--surface));}
    .ex-card-icon{width:36px;height:36px;border-radius:8px;background:var(--gold-lt);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;}
    .ex-card-title{font-family:'Playfair Display',serif;font-size:17px;font-weight:600;}
    .ex-card-body{padding:24px 28px;}
    .field-row{margin-bottom:22px;}.field-row:last-child{margin-bottom:0;}
    .field-row.two-col{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
    @media(max-width:600px){.field-row.two-col{grid-template-columns:1fr;}}
    label.field-label{display:block;font-size:13px;font-weight:600;color:var(--ink);margin-bottom:7px;}
    label.field-label span.req{color:var(--rust);}
    .field-hint{font-size:12px;color:var(--muted);margin-top:5px;}
    input[type="text"],input[type="url"],textarea,select{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:var(--radius);font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--surface);transition:border-color .18s,box-shadow .18s;box-sizing:border-box;outline:none;-webkit-appearance:none;}
    input:focus,textarea:focus,select:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.15);}
    textarea{resize:vertical;min-height:96px;}
    select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237a7570' stroke-width='1.6' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:36px;}
    .is-invalid{border-color:var(--rust)!important;}
    .invalid-feedback{font-size:12px;color:var(--rust);margin-top:5px;}
    /* File zones */
    .file-zone{border:2px dashed var(--border);border-radius:var(--radius);padding:22px 20px;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;position:relative;background:#fdfcfa;}
    .file-zone:hover,.file-zone.drag-over{border-color:var(--gold);background:var(--gold-lt);}
    .file-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .file-zone-text{font-size:13px;color:var(--muted);}
    .file-zone-icon{font-size:24px;margin-bottom:6px;}
    .file-preview-strip{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px;}
    .file-preview-strip img,.gallery-new-thumb{height:70px;width:70px;object-fit:cover;border-radius:7px;border:1.5px solid var(--border);}
    .cover-preview-wrap{margin-top:12px;}
    .cover-preview-wrap img{width:100%;max-height:200px;object-fit:cover;border-radius:8px;border:1.5px solid var(--border);}
    /* Existing gallery */
    .existing-gallery{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:14px;}
    .existing-thumb{position:relative;}
    .existing-thumb img{height:70px;width:70px;object-fit:cover;border-radius:7px;border:1.5px solid var(--border);}
    .del-btn{position:absolute;top:3px;right:3px;background:rgba(179,74,47,.85);border:none;border-radius:4px;color:#fff;width:20px;height:20px;font-size:11px;font-weight:700;cursor:pointer;line-height:20px;padding:0;text-align:center;}
    .del-btn.marked{background:var(--rust);outline:2px solid var(--rust);}
    /* Artifacts */
    .artifact-cards{display:flex;flex-direction:column;gap:16px;}
    .artifact-card{background:#fdfcfa;border:1.5px solid var(--border);border-radius:12px;padding:22px;position:relative;transition:border-color .2s;}
    .artifact-card:hover{border-color:var(--gold);}
    .artifact-card-header{display:flex;align-items:center;gap:10px;margin-bottom:16px;}
    .artifact-badge{background:var(--ink);color:#fff;font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;}
    .artifact-badge.new{background:var(--gold);color:var(--ink);}
    .artifact-remove{margin-left:auto;background:none;border:1.5px solid var(--border);color:var(--muted);border-radius:7px;width:30px;height:30px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:all .15s;}
    .artifact-remove:hover{background:var(--rust);border-color:var(--rust);color:#fff;}
    .artifact-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    @media(max-width:600px){.artifact-grid{grid-template-columns:1fr;}}
    .artifact-image-preview{width:80px;height:80px;object-fit:cover;border-radius:8px;border:1.5px solid var(--border);margin-top:10px;display:none;}
    .btn-add-artifact{display:inline-flex;align-items:center;gap:8px;background:none;border:2px dashed var(--gold);color:var(--gold);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;padding:10px 20px;border-radius:var(--radius);cursor:pointer;transition:all .2s;margin-top:4px;}
    .btn-add-artifact:hover{background:var(--gold-lt);}
    /* Submit */
    .btn-save{display:inline-flex;align-items:center;gap:10px;background:var(--gold);color:#fff;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;padding:14px 36px;border:none;border-radius:var(--radius);cursor:pointer;transition:all .2s;box-shadow:0 4px 18px rgba(201,168,76,.35);}
    .btn-save:hover{background:#b8962e;transform:translateY(-1px);}
    .btn-cancel{display:inline-flex;align-items:center;background:none;border:1.5px solid var(--border);color:var(--muted);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;padding:14px 26px;border-radius:var(--radius);cursor:pointer;text-decoration:none;transition:all .2s;}
    .btn-cancel:hover{border-color:var(--ink);color:var(--ink);}
    .form-footer{display:flex;align-items:center;gap:16px;padding:28px 0;border-top:1px solid var(--border);margin-top:8px;flex-wrap:wrap;}
    .ex-alert{display:flex;align-items:flex-start;gap:10px;background:#fff8ee;border:1.5px solid var(--gold);border-radius:10px;padding:14px 18px;margin-bottom:24px;font-size:13px;}
    @keyframes slideIn{from{opacity:0;transform:translateY(-8px);}to{opacity:1;transform:translateY(0);}}
    .slide-in{animation:slideIn .25s ease;}
</style>

<div class="ex-header">
    <div class="ex-header-inner">
        <div>
            <div class="ex-header-label">Exhibitions</div>
            <h1>Edit Exhibition</h1>
            <p style="color:rgba(255,255,255,.5);margin:8px 0 0;font-size:13px">{{ $exhibition->title }}</p>
        </div>
        <a href="{{ route('admin.exhibitions.show', $exhibition) }}"
           style="color:rgba(255,255,255,.7);text-decoration:none;font-size:13px;border:1.5px solid rgba(255,255,255,.25);padding:9px 18px;border-radius:9px;display:flex;align-items:center;gap:8px;">
            ← Back to Exhibition
        </a>
    </div>
</div>

<div class="ex-form-wrap">

    @if($errors->any())
    <div class="ex-alert">
        <span>⚠️</span>
        <div>
            <strong>Please fix the following:</strong>
            <ul style="margin:4px 0 0;padding-left:18px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.exhibitions.update', $exhibition) }}" method="POST"
          enctype="multipart/form-data" novalidate>
        @csrf @method('PUT')

        {{-- 1. Basic Info --}}
        <div class="ex-card">
            <div class="ex-card-header"><div class="ex-card-icon">🏛️</div><div class="ex-card-title">Basic Information</div></div>
            <div class="ex-card-body">

                <div class="field-row">
                    <label class="field-label" for="title">Exhibition Title <span class="req">*</span></label>
                    <input type="text" id="title" name="title"
                           class="@error('title') is-invalid @enderror"
                           value="{{ old('title', $exhibition->title) }}"
                           placeholder="Exhibition title" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="field-row two-col">
                    <div>
                        <label class="field-label" for="category_id">Category <span class="req">*</span></label>
                        <select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $exhibition->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="tour_link">Virtual Tour Link</label>
                        <input type="url" id="tour_link" name="tour_link"
                               value="{{ old('tour_link', $exhibition->tour_link) }}"
                               placeholder="https://my360tour.com/...">
                        @error('tour_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="field-hint">Optional — Matterport, Kuula, etc.</div>
                    </div>
                </div>

                <div class="field-row">
                    <label class="field-label" for="description">Description <span class="req">*</span></label>
                    <textarea id="description" name="description"
                              class="@error('description') is-invalid @enderror" rows="4"
                              placeholder="Tell visitors what makes this exhibition special…">{{ old('description', $exhibition->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- 2. Media --}}
        <div class="ex-card">
            <div class="ex-card-header"><div class="ex-card-icon">🖼️</div><div class="ex-card-title">Media</div></div>
            <div class="ex-card-body">

                {{-- Cover Image --}}
                <div class="field-row">
                    <label class="field-label">Cover / Hero Image</label>
                    @if($exhibition->cover_image)
                    <div style="margin-bottom:12px;display:flex;align-items:center;gap:14px;">
                        <img src="{{ asset('public/'.$exhibition->cover_image) }}"
                             style="height:80px;object-fit:cover;border-radius:8px;border:1.5px solid var(--border)">
                        <small style="color:var(--muted);font-size:12px;">Upload a new image to replace.</small>
                    </div>
                    @endif
                    <div class="file-zone" id="coverZone">
                        <input type="file" name="cover_image" accept="image/*" id="coverInput" onchange="previewCover(event)">
                        <div class="file-zone-icon">📸</div>
                        <div class="file-zone-text"><strong>Click or drag</strong> to upload new cover</div>
                        <div class="file-zone-text" style="margin-top:4px">JPG, PNG, WEBP · Max 4MB</div>
                    </div>
                    <div class="cover-preview-wrap" id="coverPreviewWrap" style="display:none">
                        <img id="coverPreviewImg" src="" alt="Preview">
                    </div>
                    @error('cover_image')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                </div>

                {{-- Gallery Images --}}
                <div class="field-row">
                    <label class="field-label">Gallery Images</label>

                    @if($exhibition->galleryImages->count())
                    <div class="existing-gallery" id="existingGallery">
                        @foreach($exhibition->galleryImages as $img)
                        <div class="existing-thumb" id="gthumb_{{ $img->id }}">
                            <img src="{{ asset('public/'.$img->image_path) }}" alt="">
                            <input type="checkbox" name="delete_gallery[]" value="{{ $img->id }}"
                                   id="del_{{ $img->id }}" style="display:none">
                            <button type="button" class="del-btn" id="delbtn_{{ $img->id }}"
                                    onclick="toggleDelete({{ $img->id }})" title="Mark for removal">✕</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="field-hint" style="margin-bottom:10px">Click <strong>✕</strong> on a photo to mark it for removal when you save.</div>
                    @endif

                    <div class="file-zone" id="galleryZone">
                        <input type="file" name="gallery_images[]" accept="image/*" multiple id="galleryInput" onchange="previewGallery(event)">
                        <div class="file-zone-icon">🗂️</div>
                        <div class="file-zone-text"><strong>Click or drag</strong> to add more gallery images</div>
                        <div class="file-zone-text" style="margin-top:4px">Multiple · JPG, PNG, WEBP · Max 4MB each</div>
                    </div>
                    <div class="file-preview-strip" id="galleryPreviewStrip"></div>
                    @error('gallery_images')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>

        {{-- 3. Artifacts --}}
        <div class="ex-card">
            <div class="ex-card-header"><div class="ex-card-icon">🏺</div><div class="ex-card-title">Artifacts</div></div>
            <div class="ex-card-body">
                <div class="artifact-cards" id="artifactsContainer">

                    {{-- Existing artifacts --}}
                    @foreach($exhibition->artifacts as $ai => $artifact)
                    <div class="artifact-card" id="art_exist_{{ $ai }}">
                        <div class="artifact-card-header">
                            <span class="artifact-badge">Artifact #{{ $ai + 1 }}</span>
                            <button type="button" class="artifact-remove" onclick="removeArtifact('art_exist_{{ $ai }}')">✕</button>
                        </div>
                        <input type="hidden" name="existing_artifacts[{{ $ai }}][id]" value="{{ $artifact->id }}">
                        <div class="artifact-grid">
                            <div>
                                <div class="field-row">
                                    <label class="field-label">Name <span class="req">*</span></label>
                                    <input type="text" name="existing_artifacts[{{ $ai }}][name]"
                                           class="@error('existing_artifacts.'.$ai.'.name') is-invalid @enderror"
                                           value="{{ old('existing_artifacts.'.$ai.'.name', $artifact->name) }}" required>
                                    @error('existing_artifacts.'.$ai.'.name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="field-row">
                                    <label class="field-label">Description</label>
                                    <textarea name="existing_artifacts[{{ $ai }}][description]" rows="3">{{ old('existing_artifacts.'.$ai.'.description', $artifact->description) }}</textarea>
                                </div>
                            </div>
                            <div>
                                <div class="field-row">
                                    <label class="field-label">Image</label>
                                    @if($artifact->image_path)
                                    <img src="{{ asset('public/'.$artifact->image_path) }}"
                                         style="height:70px;object-fit:cover;border-radius:8px;border:1.5px solid var(--border);margin-bottom:8px;display:block">
                                    @endif
                                    <div class="file-zone" style="padding:16px">
                                        <input type="file" name="existing_artifacts[{{ $ai }}][image]" accept="image/*"
                                               onchange="previewArtifactImg(this,'aep_{{ $ai }}')">
                                        <div class="file-zone-text" style="font-size:12px">Click to replace image</div>
                                    </div>
                                    <img class="artifact-image-preview" id="aep_{{ $ai }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <button type="button" class="btn-add-artifact" onclick="addArtifact()">
                    <span>＋</span> Add New Artifact
                </button>
                <div class="field-hint" style="margin-top:8px">Add new artifacts or modify existing ones above.</div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="form-footer">
            <button type="submit" class="btn-save">💾 Save Changes</button>
            <a href="{{ route('admin.exhibitions.show', $exhibition) }}" class="btn-cancel">Cancel</a>
        </div>

    </form>
</div>

<script>
let artifactIdx = {{ $exhibition->artifacts->count() }};

function addArtifact() {
    artifactIdx++;
    const n  = artifactIdx;
    const id = 'art_new_' + n;
    const html = `
    <div class="artifact-card slide-in" id="${id}">
        <div class="artifact-card-header">
            <span class="artifact-badge new">New Artifact</span>
            <button type="button" class="artifact-remove" onclick="removeArtifact('${id}')">✕</button>
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
            </div>
            <div>
                <div class="field-row">
                    <label class="field-label">Image</label>
                    <div class="file-zone" style="padding:16px">
                        <input type="file" name="artifacts[${n}][image]" accept="image/*"
                               onchange="previewArtifactImg(this,'ap_${n}')">
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
    if (el) { el.style.opacity='0'; el.style.transition='opacity .2s'; setTimeout(()=>el.remove(), 200); }
}

function toggleDelete(imgId) {
    const cb    = document.getElementById('del_' + imgId);
    const btn   = document.getElementById('delbtn_' + imgId);
    const thumb = document.getElementById('gthumb_' + imgId);
    cb.checked = !cb.checked;
    thumb.style.opacity  = cb.checked ? '0.35' : '1';
    btn.classList.toggle('marked', cb.checked);
    btn.title = cb.checked ? 'Click to undo removal' : 'Mark for removal';
}

function previewCover(e) {
    const f = e.target.files[0]; if (!f) return;
    document.getElementById('coverPreviewImg').src = URL.createObjectURL(f);
    document.getElementById('coverPreviewWrap').style.display = 'block';
}

function previewGallery(e) {
    const strip = document.getElementById('galleryPreviewStrip'); strip.innerHTML = '';
    Array.from(e.target.files).forEach(f => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(f);
        img.className = 'gallery-new-thumb';
        strip.appendChild(img);
    });
}

function previewArtifactImg(input, id) {
    const p = document.getElementById(id);
    if (input.files[0] && p) { p.src=URL.createObjectURL(input.files[0]); p.style.display='block'; }
}

document.querySelectorAll('.file-zone').forEach(z => {
    z.addEventListener('dragover', e=>{ e.preventDefault(); z.classList.add('drag-over'); });
    z.addEventListener('dragleave', ()=>z.classList.remove('drag-over'));
    z.addEventListener('drop', ()=>z.classList.remove('drag-over'));
});
</script>

@endsection