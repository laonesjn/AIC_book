{{-- FILE: resources/views/client/exhibition-show.blade.php --}}
@extends('layouts.masterclient')
@section('title', $exhibition->title)

@section('content')

<style>
/* ============================================================
   EXHIBITION SHOW — ARCHIVE PAGE AESTHETIC MATCH
   Warm parchment · Dark brown · Rust accent · Academic serif
   ============================================================ */

:root {
    --primary-bg:    #f6e3c5;
    --accent-dark:   #2c1810;
    --accent-rust:   #a85a3a;
    --accent-light:  #d4c4b8;
    --card-bg:       #ffffff;
    --border-color:  #e8ddd2;
    --text-dark:     #3a3a3a;
    --text-muted:    #757575;

    --font-serif: 'Georgia', 'Garamond', serif;
    --font-sans:  'Segoe UI', 'Helvetica Neue', sans-serif;

    --border-radius: 2px;
    --shadow-light:  0 2px 8px  rgba(0,0,0,0.08);
    --shadow-medium: 0 4px 16px rgba(0,0,0,0.12);
    --transition:    all 0.3s cubic-bezier(0.4,0,0.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { color: var(--text-dark); font-family: var(--font-sans); line-height: 1.6; }

/* PAGE WRAPPER */
.archive-page { max-width: 1400px; margin: 0 auto; padding: 2.5rem 2rem; }

/* BREADCRUMB */
.page-nav       { margin-bottom: 2.5rem; }
.breadcrumb-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
.breadcrumb-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.65rem 1.25rem;
    background: var(--accent-dark); color: white;
    border: none; border-radius: var(--border-radius);
    font-family: var(--font-sans); font-size: 0.9rem; font-weight: 500;
    text-decoration: none; cursor: pointer; transition: var(--transition);
}
.breadcrumb-btn::before { content: '←'; font-size: 1.1rem; }
.breadcrumb-btn:hover { background: var(--accent-rust); transform: translateY(-1px); box-shadow: var(--shadow-light); }

/* HERO */
.hero-section {
    display: grid; grid-template-columns: 45% 1fr;
    gap: 3.5rem; align-items: start;
    margin-bottom: 4rem; padding-bottom: 3rem;
    border-bottom: 2px solid var(--border-color);
}
.hero-image-container {
    position: relative; aspect-ratio: 2/1.8; overflow: hidden;
    background: var(--card-bg);
    border: 8px solid var(--accent-dark);
    box-shadow: var(--shadow-medium);
}
.hero-image-container img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s cubic-bezier(0.4,0,0.2,1); }
.hero-image-container:hover img { transform: scale(1.02); }
.hero-img-empty { display:flex; align-items:center; justify-content:center; height:100%; font-size:5rem; background:var(--accent-light); }

.hero-badge {
    position: absolute; bottom: 16px; left: 16px;
    background: var(--accent-dark); color: white;
    padding: 6px 14px; font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.5px; text-transform: uppercase; border-radius: var(--border-radius);
}
.hero-badge-tour {
    position: absolute; top: 16px; right: 16px;
    background: var(--accent-rust); color: white;
    padding: 6px 14px; font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.5px; text-transform: uppercase; border-radius: var(--border-radius);
    text-decoration: none; transition: var(--transition);
}
.hero-badge-tour:hover { background: var(--accent-dark); }

.hero-content { display: flex; flex-direction: column; justify-content: flex-start; padding-top: 0.5rem; }

.collection-title {
    font-family: var(--font-serif); font-size: 2.8rem; font-weight: 700;
    line-height: 1.15; color: var(--accent-dark); margin-bottom: 1.25rem; letter-spacing: -0.5px;
}
.collection-subtitle {
    font-family: var(--font-serif); font-size: 1.3rem; font-weight: 400;
    color: var(--accent-rust); margin-bottom: 1.75rem; font-style: italic; line-height: 1.4;
}
.hero-description { font-size: 0.95rem; line-height: 1.75; color: var(--text-dark); margin-bottom: 1.75rem; }

/* stat boxes */
.hero-stats { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
.stat-box {
    flex: 1; min-width: 90px; padding: 1.25rem 1rem;
    background: var(--accent-dark); color: white;
    text-align: center; border-radius: var(--border-radius);
}
.stat-box-rust { background: var(--accent-rust); }
.stat-box-light { background: var(--accent-light); }
.stat-number { font-family: var(--font-serif); font-size: 2rem; font-weight: 700; line-height: 1; display: block; }
.stat-box-light .stat-number { color: var(--accent-dark); }
.stat-label  { font-size: 0.7rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.65); margin-top: 4px; display: block; }
.stat-box-light .stat-label  { color: var(--text-muted); }

/* metadata box */
.collection-metadata {
    display: flex; flex-direction: column; gap: 0.75rem;
    padding: 1.5rem; background: var(--accent-light);
    border-left: 4px solid var(--accent-dark); margin-bottom: 1.5rem;
}
.metadata-item  { font-size: 0.85rem; color: var(--accent-dark); font-weight: 500; }
.metadata-label { font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.2rem; }
.metadata-value { display: block; margin-left: 0.5rem; color: var(--text-dark); }

/* buttons */
.hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.75rem 1.75rem; background: var(--accent-dark); color: white;
    border: none; border-radius: var(--border-radius);
    font-family: var(--font-sans); font-size: 0.9rem; font-weight: 600;
    text-decoration: none; cursor: pointer; transition: var(--transition);
}
.btn-primary:hover { background: var(--accent-rust); transform: translateY(-2px); box-shadow: var(--shadow-light); }
.btn-outline {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.75rem 1.75rem; background: transparent; color: var(--accent-dark);
    border: 2px solid var(--accent-dark); border-radius: var(--border-radius);
    font-family: var(--font-sans); font-size: 0.9rem; font-weight: 600;
    text-decoration: none; cursor: pointer; transition: var(--transition);
}
.btn-outline:hover { background: var(--accent-dark); color: white; transform: translateY(-2px); }

/* SECTION SHARED */
.page-section { margin-bottom: 4rem; }
.section-heading {
    font-family: var(--font-serif); font-size: 1.8rem; font-weight: 700;
    color: var(--accent-dark); margin-bottom: 2rem; padding-bottom: 1rem;
    border-bottom: 3px solid var(--accent-rust); display: inline-block;
}

/* OVERVIEW */
.overview-content { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start; }
.overview-text { font-size: 0.95rem; line-height: 1.8; color: var(--text-dark); }
.overview-text p { margin-bottom: 1.5rem; }
.overview-text p:last-child { margin-bottom: 0; }
.overview-image img {
    width: 100%; height: auto; object-fit: cover;
    border-radius: var(--border-radius); box-shadow: var(--shadow-light);
    transition: transform 0.4s ease;
}
.overview-image img:hover { transform: scale(1.02); }

/* ARTIFACTS GRID */
.artifacts-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px,1fr)); gap: 2rem; }
.artifact-card {
    position: relative; background: var(--card-bg);
    border: 1px solid var(--border-color); border-radius: var(--border-radius);
    overflow: hidden; box-shadow: var(--shadow-light); transition: var(--transition); cursor: pointer;
}
.artifact-card:hover { box-shadow: var(--shadow-medium); transform: translateY(-4px); border-color: var(--accent-rust); }
.artifact-card-image { width: 100%; height: 220px; background: linear-gradient(135deg,#f5f1ec,#ebe4dc); overflow: hidden; }
.artifact-card-image img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.artifact-card:hover .artifact-card-image img { transform: scale(1.08); }
.artifact-card-empty { display:flex; align-items:center; justify-content:center; height:100%; font-size:3rem; color:var(--accent-light); }
.artifact-card-arrow {
    position: absolute; top: 12px; right: 12px;
    width: 32px; height: 32px; background: var(--accent-rust); color: white;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; opacity: 0; transform: scale(0.7); transition: var(--transition);
}
.artifact-card:hover .artifact-card-arrow { opacity: 1; transform: scale(1); }
.artifact-card-body { padding: 1.25rem; }
.artifact-card-title { font-family: var(--font-serif); font-size: 1.05rem; font-weight: 700; color: var(--accent-dark); margin-bottom: 0.5rem; line-height: 1.3; }
.artifact-card-desc  { font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; }

/* GALLERY */
.gallery-scroll-track {
    display: flex; gap: 1.25rem; overflow-x: auto;
    padding-bottom: 1rem; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
    scrollbar-width: thin; scrollbar-color: var(--accent-rust) var(--border-color);
}
.gallery-scroll-track::-webkit-scrollbar { height: 4px; }
.gallery-scroll-track::-webkit-scrollbar-track { background: var(--border-color); }
.gallery-scroll-track::-webkit-scrollbar-thumb { background: var(--accent-rust); border-radius: 2px; }
.gallery-thumb-wrap {
    flex: 0 0 300px; height: 200px; overflow: hidden;
    border: 1px solid var(--border-color); border-radius: var(--border-radius);
    cursor: pointer; scroll-snap-align: start; box-shadow: var(--shadow-light);
    transition: var(--transition); position: relative; background: var(--accent-light);
}
.gallery-thumb-wrap:hover { transform: translateY(-3px); box-shadow: var(--shadow-medium); border-color: var(--accent-rust); }
.gallery-thumb { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.gallery-thumb-wrap:hover .gallery-thumb { transform: scale(1.06); }
.gallery-zoom {
    position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
    background: rgba(44,24,16,0.35); font-size: 1.5rem;
    opacity: 0; transition: opacity 0.3s ease;
}
.gallery-thumb-wrap:hover .gallery-zoom { opacity: 1; }

/* VISIT GRID */
.visit-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 2rem; }
.visit-card {
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: var(--border-radius); padding: 1.75rem; box-shadow: var(--shadow-light);
}
.visit-card h3 {
    font-family: var(--font-serif); font-size: 1.1rem; font-weight: 700; color: var(--accent-dark);
    margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--accent-light);
}
.hours-row { display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 0; border-bottom: 1px solid #f0ede9; font-size: 0.875rem; }
.hours-row:last-child { border-bottom: none; }
.hours-day  { font-weight: 600; color: var(--accent-dark); }
.hours-time { color: var(--text-muted); }
.contact-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0ede9; font-size: 0.875rem; color: var(--text-dark); }
.contact-item:last-of-type { border-bottom: none; }
.contact-icon { width: 32px; height: 32px; flex-shrink: 0; background: var(--accent-light); border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
.map-placeholder { height: 160px; background: linear-gradient(135deg,var(--accent-light),var(--border-color)); border: 1px dashed var(--border-color); border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-top: 0.5rem; }

/* SIDEBAR */
.sidebar-section { display: grid; grid-template-columns: repeat(2,1fr); gap: 2rem; margin-top: 4rem; padding-top: 3rem; border-top: 2px solid var(--border-color); }
.sidebar-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 1.75rem; box-shadow: var(--shadow-light); }
.sidebar-card h3 { font-family: var(--font-serif); font-size: 1.1rem; font-weight: 700; color: var(--accent-dark); margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--accent-light); }
.sidebar-item { display: flex; justify-content: space-between; align-items: center; padding: 0.9rem 0; border-bottom: 1px solid #f0ede9; }
.sidebar-item:last-child { border-bottom: none; }
.sidebar-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-muted); }
.sidebar-value { font-size: 0.95rem; font-weight: 600; color: var(--accent-dark); text-align: right; }
.status-badge { display: inline-block; padding: 0.4rem 0.9rem; border-radius: var(--border-radius); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.status-public  { background: #e8f5e9; color: #1b5e20; }
.status-virtual { background: #e3f2fd; color: #0d47a1; }

/* LIGHTBOX */
#ex-lightbox {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(44,24,16,0.92);
    display: none; align-items: center; justify-content: center; padding: 24px;
}
#ex-lightbox.open { display: flex; }
#ex-lightbox-img { max-width: min(90vw,900px); max-height: 85vh; object-fit: contain; border: 6px solid var(--accent-dark); box-shadow: var(--shadow-medium); }
#ex-lightbox-close {
    position: fixed; top: 20px; right: 24px;
    background: var(--accent-dark); border: 2px solid var(--accent-rust); color: white;
    width: 40px; height: 40px; border-radius: 50%; font-size: 16px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: var(--transition);
}
#ex-lightbox-close:hover { background: var(--accent-rust); }

/* ARTIFACT MODAL */
#ex-artModal {
    position: fixed; inset: 0; z-index: 9998;
    background: rgba(44,24,16,0.8);
    display: none; align-items: center; justify-content: center; padding: 24px;
}
#ex-artModal.open { display: flex; }
.art-modal-inner {
    background: var(--card-bg); border: 2px solid var(--accent-dark);
    border-radius: var(--border-radius);
    max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto;
    position: relative; box-shadow: var(--shadow-medium);
    animation: modalIn 0.3s ease;
}
@keyframes modalIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
.art-modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1.25rem 1.75rem; background: var(--accent-dark); color: white;
}
.art-modal-header h2 { font-family: var(--font-serif); font-size: 1.1rem; font-weight: 700; color: white; }
.art-modal-close-btn { background: none; border: none; color: white; font-size: 1.6rem; cursor: pointer; line-height: 1; opacity: 0.8; transition: opacity 0.2s; }
.art-modal-close-btn:hover { opacity: 1; }
.art-modal-img { width: 100%; max-height: 320px; object-fit: cover; display: block; }
.art-modal-no-img { height: 200px; background: var(--accent-light); display: flex; align-items: center; justify-content: center; font-size: 4rem; }
.art-modal-body { padding: 1.75rem; }
.art-modal-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--accent-rust); margin-bottom: 0.5rem; }
.art-modal-desc { font-size: 0.9rem; line-height: 1.75; color: var(--text-muted); }

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .hero-section     { grid-template-columns: 50% 1fr; gap: 2.5rem; }
    .overview-content { grid-template-columns: 1fr; gap: 1.5rem; }
    .visit-grid       { grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .visit-grid > :last-child { grid-column: 1 / -1; }
    .sidebar-section  { grid-template-columns: repeat(2,1fr); }
    .artifacts-grid   { grid-template-columns: repeat(auto-fill,minmax(200px,1fr)); gap: 1.5rem; }
}

@media (max-width: 768px) {
    .archive-page    { padding: 1.5rem 1rem; }
    .hero-section    { grid-template-columns: 1fr; gap: 2rem; margin-bottom: 3rem; padding-bottom: 2rem; }
    .hero-image-container { aspect-ratio: 3/2; }
    .collection-title   { font-size: 2rem; }
    .collection-subtitle{ font-size: 1.1rem; }
    .section-heading    { font-size: 1.5rem; }
    .sidebar-section    { grid-template-columns: 1fr; margin-top: 3rem; padding-top: 2rem; }
    .visit-grid         { grid-template-columns: 1fr; }
    .visit-grid > :last-child { grid-column: auto; }
    .overview-content   { grid-template-columns: 1fr; }
    .artifacts-grid     { grid-template-columns: repeat(auto-fill,minmax(160px,1fr)); gap: 1rem; }
    .artifact-card-image{ height: 180px; }
    .gallery-thumb-wrap { flex: 0 0 240px; height: 165px; }
    .hero-stats         { gap: 0.75rem; }
    .stat-number        { font-size: 1.6rem; }
}

@media (max-width: 480px) {
    .collection-title   { font-size: 1.5rem; margin-bottom: 1rem; }
    .collection-subtitle{ font-size: 1rem; }
    .hero-image-container { aspect-ratio: 4/3; }
    .section-heading    { font-size: 1.25rem; margin-bottom: 1.5rem; }
    .sidebar-card       { padding: 1.25rem; }
    .artifacts-grid     { grid-template-columns: repeat(2,1fr); gap: 0.75rem; }
    .artifact-card-image{ height: 140px; }
    .artifact-card-body { padding: 0.75rem; }
    .artifact-card-title{ font-size: 0.9rem; }
    .hero-actions       { flex-direction: column; }
    .btn-primary, .btn-outline { justify-content: center; width: 100%; }
    .gallery-thumb-wrap { flex: 0 0 200px; height: 140px; }
    .art-modal-body     { padding: 1.25rem; }
}
</style>

<main class="archive-page">

    {{-- BREADCRUMB --}}
    <div class="page-nav">
        <div class="breadcrumb-nav">
            <a href="{{ url()->previous() }}" class="breadcrumb-btn">Back to Exhibitions</a>
        </div>
    </div>

    {{-- HERO --}}
    <section class="hero-section">
        <div class="hero-image-container">
            @if($exhibition->cover_image)
                <img src="{{ asset('public/'.$exhibition->cover_image) }}" alt="{{ $exhibition->title }}">
            @else
                <div class="hero-img-empty">🏛️</div>
            @endif
            @if($exhibition->artifacts->count())
            <div class="hero-badge">{{ $exhibition->artifacts->count() }} Artifacts</div>
            @endif
            @if($exhibition->tour_link)
            <a href="{{ $exhibition->tour_link }}" target="_blank" rel="noopener" class="hero-badge-tour">360° Tour</a>
            @endif
        </div>

        <div class="hero-content">
            <h1 class="collection-title">{{ $exhibition->title }}</h1>
            <p class="collection-subtitle">{{ $exhibition->category->name }}</p>

            <div class="hero-description">
                {{ Str::limit(strip_tags($exhibition->description), 280) }}
            </div>

            <div class="hero-stats">
                <div class="stat-box">
                    <span class="stat-number">{{ $exhibition->artifacts->count() ?: '—' }}</span>
                    <span class="stat-label">Artifacts</span>
                </div>
                <div class="stat-box stat-box-rust">
                    <span class="stat-number">{{ $exhibition->galleryImages->count() ?: '—' }}</span>
                    <span class="stat-label">Gallery</span>
                </div>
                <div class="stat-box stat-box-light">
                    <span class="stat-number">{{ $exhibition->tour_link ? '360°' : '—' }}</span>
                    <span class="stat-label">Virtual</span>
                </div>
            </div>

            <div class="collection-metadata">
                <div class="metadata-item">
                    <span class="metadata-label">Category:</span>
                    <span class="metadata-value">{{ $exhibition->category->name }}</span>
                </div>
                <div class="metadata-item">
                    <span class="metadata-label">Access:</span>
                    <span class="metadata-value">{{ $exhibition->tour_link ? 'In-Person & Virtual' : 'In-Person Only' }}</span>
                </div>
            
            </div>

            <div class="hero-actions">
                @if($exhibition->tour_link)
                <a href="{{ $exhibition->tour_link }}" target="_blank" rel="noopener" class="btn-primary">🌐 Virtual Tour</a>
                @endif
                @if($exhibition->artifacts->count())
                <a href="#artifacts" class="btn-outline">📦 View Artifacts</a>
                @endif
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="page-section" id="about">
        <h2 class="section-heading">About This Exhibition</h2>
        <div class="overview-content">
            <div class="overview-text">
                <p>{{ $exhibition->description }}</p>
            </div>
            @php
                $overviewImg = $exhibition->galleryImages->first()->image_path ?? $exhibition->cover_image ?? null;
            @endphp
            @if($overviewImg)
            <div class="overview-image">
                <img src="{{ asset('public/'.$overviewImg) }}" alt="{{ $exhibition->title }}">
            </div>
            @endif
        </div>
    </section>

    {{-- ARTIFACTS --}}
    @if($exhibition->artifacts->count())
    <section class="page-section" id="artifacts">
        <h2 class="section-heading">Featured Artifacts</h2>
        <div class="artifacts-grid">
            @foreach($exhibition->artifacts->take(8) as $artifact)
            <div class="artifact-card"
                 onclick="openArtifact('{{ addslashes($artifact->name) }}','{{ $artifact->image_path ? asset($artifact->image_path) : '' }}','{{ addslashes($artifact->description ?? '') }}')">
                <div class="artifact-card-image">
                    @if($artifact->image_path)
                        <img src="{{ asset('public/'.$artifact->image_path) }}" alt="{{ $artifact->name }}">
                    @else
                        <div class="artifact-card-empty">🏺</div>
                    @endif
                </div>
                <div class="artifact-card-arrow">→</div>
                <div class="artifact-card-body">
                    <div class="artifact-card-title">{{ $artifact->name }}</div>
                    @if($artifact->description)
                    <div class="artifact-card-desc">{{ Str::limit($artifact->description, 80) }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- GALLERY --}}
    @if($exhibition->galleryImages->count())
    <section class="page-section" id="gallery">
        <h2 class="section-heading">Exhibition Gallery</h2>
        <div class="gallery-scroll-track">
            @foreach($exhibition->galleryImages as $img)
            <div class="gallery-thumb-wrap" onclick="openLightbox('{{ asset($img->image_path) }}')">
                <img class="gallery-thumb" src="{{ asset('public/'.$img->image_path) }}" alt="Gallery image">
                <div class="gallery-zoom">🔍</div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- VISITOR INFO --}}
    <section class="page-section" id="visit">
        <h2 class="section-heading">Visitor Information</h2>
        <div class="visit-grid">
           <div class="visit-card">
    <h3>🕐 Opening Hours</h3>

    <div class="hours-row">
        <span class="hours-day">Monday</span>
        <span class="hours-time">10:00 AM – 12:30 PM</span>
    </div>
    <div class="hours-row">
        <span class="hours-day">Tuesday</span>
        <span class="hours-time">10:00 AM – 12:30 PM</span>
    </div>
    <div class="hours-row">
        <span class="hours-day">Wednesday</span>
        <span class="hours-time">10:00 AM – 12:30 PM</span>
    </div>
    <div class="hours-row">
        <span class="hours-day">Thursday</span>
        <span class="hours-time">10:00 AM – 12:30 PM</span>
    </div>
    <div class="hours-row">
        <span class="hours-day">Friday</span>
        <span class="hours-time">10:00 AM – 12:30 PM</span>
    </div>
    <div class="hours-row">
        <span class="hours-day">Saturday</span>
        <span class="hours-time">10:00 AM – 12:30 PM</span>
    </div>
    <div class="hours-row">
        <span class="hours-day">Sunday</span>
        <span class="hours-time">Closed</span>
    </div>
</div>

           <div class="visit-card">
    <h3>📍 Location</h3>
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19853.872712345678!2d-0.1357!3d51.5074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b3333333333%3A0x123456789abcdef!2sLondon%2C%20UK!5e0!3m2!1sen!2sin!4v1699999999999!5m2!1sen!2sin"
        width="100%" 
        height="250" 
        style="border:0; border-radius:8px;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
    <p style="font-size:0.85rem;color:var(--text-muted);margin-top:0.75rem;">
        London, United Kingdom
    </p>
</div>

            <div class="visit-card">
                <h3>📞 Contact Us</h3>
                <div class="contact-item"><div class="contact-icon">📍</div><span>125 Museum Ave, City, ST 12345</span></div>
                <div class="contact-item"><div class="contact-icon">📞</div><span>(125) 458-7596</span></div>
                <div class="contact-item"><div class="contact-icon">✉️</div><span>info@museum.org</span></div>
                @if($exhibition->tour_link)
                <div style="margin-top:1.25rem;">
                    <a href="{{ $exhibition->tour_link }}" target="_blank" rel="noopener" class="btn-primary" style="width:100%;justify-content:center;">🌐 Virtual Tour</a>
                </div>
                @endif
            </div>
        </div>
    </section>

</main>

{{-- LIGHTBOX --}}
<div id="ex-lightbox" onclick="closeLightbox()">
  <button id="ex-lightbox-close" onclick="closeLightbox()">✕</button>
  <img id="ex-lightbox-img" src="" alt="">
</div>

{{-- ARTIFACT MODAL --}}
<div id="ex-artModal" onclick="closeArtifact(event)">
  <div class="art-modal-inner" onclick="event.stopPropagation()">
    <div class="art-modal-header">
      <h2 id="artModalTitle"></h2>
      <button class="art-modal-close-btn" id="artModalCloseBtn">×</button>
    </div>
    <div id="artModalImgWrap"></div>
    <div class="art-modal-body">
      <div class="art-modal-eyebrow">Exhibition Artifact</div>
      <div class="art-modal-desc" id="artModalDesc"></div>
    </div>
  </div>
</div>

<script>
function openLightbox(src) {
  document.getElementById('ex-lightbox-img').src = src;
  document.getElementById('ex-lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('ex-lightbox').classList.remove('open');
  document.body.style.overflow = '';
}
function openArtifact(name, imgSrc, desc) {
  document.getElementById('artModalTitle').textContent = name;
  document.getElementById('artModalDesc').textContent  = desc || '';
  const wrap = document.getElementById('artModalImgWrap');
  wrap.innerHTML = imgSrc
    ? `<img class="art-modal-img" src="${imgSrc}" alt="${name}">`
    : `<div class="art-modal-no-img">🏺</div>`;
  document.getElementById('ex-artModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeArtifact(e) {
  if (e && e.target !== document.getElementById('ex-artModal')) return;
  document.getElementById('ex-artModal').classList.remove('open');
  document.body.style.overflow = '';
}
document.getElementById('artModalCloseBtn').addEventListener('click', function () {
  document.getElementById('ex-artModal').classList.remove('open');
  document.body.style.overflow = '';
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeLightbox();
    document.getElementById('ex-artModal').classList.remove('open');
    document.body.style.overflow = '';
  }
});
document.querySelectorAll('a[href^="#"]').forEach(function(a) {
  a.addEventListener('click', function(e) {
    var target = document.querySelector(a.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
  });
});
</script>

@endsection