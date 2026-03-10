@extends('layouts.masteradmin')
@section('title', $exhibition->title)

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root{--ink:#0f0f0f;--cream:#faf8f4;--gold:#c9a84c;--gold-lt:#f0e6c8;--rust:#b34a2f;--muted:#7a7570;--border:#e2ddd6;--surface:#ffffff;--shadow:0 4px 24px rgba(15,15,15,.08);}
    body{background:var(--cream);font-family:'DM Sans',sans-serif;}
    .show-header{background:var(--ink);color:#fff;padding:48px 0 36px;position:relative;overflow:hidden;margin-bottom:0;}
    .show-header::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(-45deg,transparent,transparent 40px,rgba(201,168,76,.06) 40px,rgba(201,168,76,.06) 41px);}
    .show-header-inner{max-width:1100px;margin:0 auto;padding:0 32px;position:relative;display:flex;align-items:flex-start;justify-content:space-between;gap:20px;flex-wrap:wrap;}
    .cat-badge{display:inline-block;background:var(--gold);color:#fff;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:10px;}
    .show-header h1{font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,38px);font-weight:700;margin:0 0 8px;line-height:1.15;}
    .show-header-meta{font-size:12px;color:rgba(255,255,255,.45);}
    .action-btns{display:flex;gap:10px;flex-wrap:wrap;align-items:center;padding-top:4px;}
    .btn-edit{display:inline-flex;align-items:center;gap:7px;background:var(--gold);color:#fff;font-size:13px;font-weight:600;padding:10px 22px;border-radius:9px;text-decoration:none;transition:all .2s;}
    .btn-edit:hover{background:#b8962e;color:#fff;}
    .btn-trash{display:inline-flex;align-items:center;gap:7px;background:none;border:1.5px solid rgba(255,255,255,.25);color:rgba(255,255,255,.8);font-size:13px;font-weight:600;padding:10px 22px;border-radius:9px;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s;}
    .btn-trash:hover{background:var(--rust);border-color:var(--rust);color:#fff;}
    .btn-back{display:inline-flex;align-items:center;gap:7px;background:none;border:1.5px solid rgba(255,255,255,.2);color:rgba(255,255,255,.6);font-size:13px;padding:10px 18px;border-radius:9px;text-decoration:none;transition:all .2s;}
    .btn-back:hover{color:#fff;border-color:rgba(255,255,255,.5);}
    .wrap{max-width:1100px;margin:0 auto;padding:36px 32px 80px;}
    .main-grid{display:grid;grid-template-columns:320px 1fr;gap:28px;}
    @media(max-width:900px){.main-grid{grid-template-columns:1fr;}}
    .ex-card{background:var(--surface);border:1px solid var(--border);border-radius:14px;box-shadow:var(--shadow);overflow:hidden;margin-bottom:24px;}
    .ex-card:last-child{margin-bottom:0;}
    .ex-card-header{padding:16px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:linear-gradient(to right,#fdfcfa,#fff);}
    .ex-card-title{font-family:'Playfair Display',serif;font-size:15px;font-weight:600;display:flex;align-items:center;gap:8px;}
    .badge-count{background:var(--gold-lt);color:#7a5c10;font-size:12px;font-weight:700;padding:3px 9px;border-radius:12px;}
    .ex-card-body{padding:20px 22px;}
    .cover-img{width:100%;max-height:260px;object-fit:cover;border-radius:0;}
    .tour-btn{display:flex;align-items:center;gap:8px;background:none;border:1.5px solid var(--gold);color:var(--gold);font-size:13px;font-weight:600;padding:10px 18px;border-radius:9px;text-decoration:none;width:100%;justify-content:center;margin-top:14px;transition:all .2s;}
    .tour-btn:hover{background:var(--gold-lt);}
    /* Gallery */
    .gallery-grid{display:flex;flex-wrap:wrap;gap:10px;}
    .gallery-item{position:relative;}
    .gallery-item img{width:90px;height:70px;object-fit:cover;border-radius:8px;border:1.5px solid var(--border);cursor:zoom-in;transition:opacity .2s;}
    .gallery-item img:hover{opacity:.85;}
    .gallery-del-btn{position:absolute;top:3px;right:3px;background:rgba(179,74,47,.9);border:none;border-radius:4px;color:#fff;width:20px;height:20px;font-size:10px;font-weight:700;cursor:pointer;line-height:20px;padding:0;text-align:center;transition:all .15s;display:none;}
    .gallery-item:hover .gallery-del-btn{display:block;}
    /* Artifacts */
    .artifacts-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;}
    .artifact-card{border:1.5px solid var(--border);border-radius:12px;overflow:hidden;background:#fdfcfa;transition:box-shadow .2s,border-color .2s;}
    .artifact-card:hover{box-shadow:var(--shadow);border-color:var(--gold);}
    .artifact-img{width:100%;height:130px;object-fit:cover;}
    .artifact-no-img{width:100%;height:130px;background:var(--gold-lt);display:flex;align-items:center;justify-content:center;font-size:36px;}
    .artifact-body{padding:12px 14px;}
    .artifact-name{font-size:14px;font-weight:600;margin:0 0 4px;}
    .artifact-desc{font-size:12px;color:var(--muted);margin:0;}
    .artifact-footer{padding:8px 14px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;}
    .btn-del-sm{background:none;border:1.5px solid #f0d0c8;color:var(--rust);font-size:11px;font-weight:600;padding:4px 10px;border-radius:6px;cursor:pointer;transition:all .15s;}
    .btn-del-sm:hover{background:var(--rust);color:#fff;border-color:var(--rust);}
    .add-artifact-link{display:inline-flex;align-items:center;gap:7px;background:none;border:2px dashed var(--gold);color:var(--gold);font-size:13px;font-weight:600;padding:9px 18px;border-radius:9px;text-decoration:none;transition:all .2s;}
    .add-artifact-link:hover{background:var(--gold-lt);}
    .empty-note{font-size:13px;color:var(--muted);padding:20px 0;text-align:center;}
    .alert-success{background:#f0faf0;border:1.5px solid #6cbb6c;border-radius:10px;padding:12px 18px;font-size:13px;color:#1e5e1e;margin-bottom:20px;display:flex;align-items:center;gap:8px;}
</style>

@if(session('success'))
<div style="max-width:1100px;margin:20px auto 0;padding:0 32px">
    <div class="alert-success">✅ {{ session('success') }}</div>
</div>
@endif

<div class="show-header">
    <div class="show-header-inner">
        <div>
            <div class="cat-badge">{{ $exhibition->category->name }}</div>
            <h1>{{ $exhibition->title }}</h1>
            <div class="show-header-meta">
                Added {{ $exhibition->created_at->format('M d, Y') }}
                @if($exhibition->updated_at->gt($exhibition->created_at))
                    &nbsp;·&nbsp; Updated {{ $exhibition->updated_at->diffForHumans() }}
                @endif
            </div>
        </div>
        <div class="action-btns">
            <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" class="btn-edit">✏️ Edit</a>
            <form action="{{ route('admin.exhibitions.destroy', $exhibition) }}" method="POST"
                  onsubmit="return confirm('Delete this exhibition?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-trash">🗑 Delete</button>
            </form>
            <a href="{{ route('admin.exhibitions.index') }}" class="btn-back">← All Exhibitions</a>
        </div>
    </div>
</div>

<div class="wrap">
    <div class="main-grid">

        {{-- Left: cover + about --}}
        <div>
            @if($exhibition->cover_image)
            <div class="ex-card" style="overflow:hidden">
                <img src="{{ asset($exhibition->cover_image) }}" class="cover-img" alt="{{ $exhibition->title }}">
            </div>
            @endif

            <div class="ex-card">
                <div class="ex-card-header"><div class="ex-card-title">📝 About</div></div>
                <div class="ex-card-body">
                    <p style="font-size:14px;color:var(--muted);line-height:1.6;margin:0">{{ $exhibition->description }}</p>
                    @if($exhibition->tour_link)
                    <a href="{{ $exhibition->tour_link }}" target="_blank" rel="noopener" class="tour-btn">
                        🔭 View 360° Virtual Tour
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: gallery + artifacts --}}
        <div>

            {{-- Gallery --}}
            <div class="ex-card">
                <div class="ex-card-header">
                    <div class="ex-card-title">🖼️ Gallery <span class="badge-count">{{ $exhibition->galleryImages->count() }}</span></div>
                </div>
                <div class="ex-card-body">
                    @if($exhibition->galleryImages->count())
                    <div class="gallery-grid">
                        @foreach($exhibition->galleryImages as $img)
                        <div class="gallery-item">
                            <a href="{{ asset($img->image_path) }}" onclick="openLightbox('{{ asset($img->image_path) }}');return false;">
                                <img src="{{ asset($img->image_path) }}" alt="">
                            </a>
                            <form action="{{ route('admin.exhibitions.gallery.destroy', [$exhibition, $img]) }}"
                                  method="POST" onsubmit="return confirm('Delete this gallery image?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="gallery-del-btn" title="Delete image">✕</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-note">No gallery images yet. <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" style="color:var(--gold)">Add in Edit</a></div>
                    @endif
                </div>
            </div>

            {{-- Artifacts --}}
            <div class="ex-card">
                <div class="ex-card-header">
                    <div class="ex-card-title">🏺 Artifacts <span class="badge-count">{{ $exhibition->artifacts->count() }}</span></div>
                    <a href="{{ route('admin.exhibitions.edit', $exhibition) }}#artifacts" class="add-artifact-link">＋ Add</a>
                </div>
                <div class="ex-card-body">
                    @if($exhibition->artifacts->count())
                    <div class="artifacts-grid">
                        @foreach($exhibition->artifacts as $artifact)
                        <div class="artifact-card">
                            @if($artifact->image_path)
                                <img src="{{ asset($artifact->image_path) }}" class="artifact-img" alt="{{ $artifact->name }}">
                            @else
                                <div class="artifact-no-img">🏺</div>
                            @endif
                            <div class="artifact-body">
                                <p class="artifact-name">{{ $artifact->name }}</p>
                                @if($artifact->description)
                                <p class="artifact-desc">{{ Str::limit($artifact->description, 65) }}</p>
                                @endif
                            </div>
                            <div class="artifact-footer">
                                <form action="{{ route('admin.exhibitions.artifacts.destroy', [$exhibition->id, $artifact->id]) }}"
                                      method="POST" onsubmit="return confirm('Delete artifact \'{{ addslashes($artifact->name) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del-sm">🗑 Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-note">No artifacts yet. <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" style="color:var(--gold)">Add in Edit</a></div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Lightbox --}}
<div id="lightboxOverlay" onclick="closeLightbox()"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;">
    <img id="lightboxImg" src="" style="max-width:90vw;max-height:90vh;object-fit:contain;border-radius:8px;box-shadow:0 8px 40px rgba(0,0,0,.5)">
</div>

<script>
function openLightbox(src){
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox(){
    document.getElementById('lightboxOverlay').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLightbox(); });
</script>

@endsection