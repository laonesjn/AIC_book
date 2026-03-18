@extends('layouts.masterclient')
@section('content')

<style>
    :root {
        /* Color Palette - Academic Archive Style */
        --primary-bg: #f6e3c5;
        --accent-dark: #2c1810;
        --accent-rust: #a85a3a;
        --accent-light: #d4c4b8;
        --card-bg: #ffffff;
        --border-color: #e8ddd2;
        --text-dark: #3a3a3a;
        --text-muted: #757575;
        --hover-overlay: rgba(44, 24, 16, 0.04);
        
        /* Typography */
        --font-serif: 'Georgia', 'Garamond', serif;
        --font-sans: 'Segoe UI', 'Helvetica Neue', sans-serif;
        
        /* Spacing & Effects */
        --border-radius: 2px;
        --shadow-light: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-medium: 0 4px 16px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        /* background: var(--primary-bg); */
        color: var(--text-dark);
        font-family: var(--font-sans);
        line-height: 1.6;
    }

    /* ============ PAGE STRUCTURE ============ */
    .archive-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2.5rem 2rem;
    }

    /* Navigation */
    .page-nav {
        margin-bottom: 2.5rem;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .breadcrumb-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        background: var(--accent-dark);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        font-family: var(--font-sans);
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .breadcrumb-btn:hover {
        background: var(--accent-rust);
        transform: translateY(-1px);
        box-shadow: var(--shadow-light);
    }

    .breadcrumb-btn::before {
        content: '←';
        font-size: 1.1rem;
    }

    /* ============ HERO SECTION ============ */
    .hero-section {
        display: grid;
        grid-template-columns: 45% 1fr;
        gap: 3.5rem;
        align-items: start;
        margin-bottom: 4rem;
        padding-bottom: 3rem;
        border-bottom: 2px solid var(--border-color);
    }

    .hero-image-container {
        position: relative;
        aspect-ratio: 2/1.8;
        overflow: hidden;
        background: var(--card-bg);
        border: 8px solid var(--accent-dark);
        box-shadow: var(--shadow-medium);
    }

    .hero-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
    }

    .hero-image-container:hover img {
        transform: scale(1.02);
    }

    .hero-content {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding-top: 0.5rem;
    }

    .collection-title {
        font-family: var(--font-serif);
        font-size: 2.8rem;
        font-weight: 700;
        line-height: 1.15;
        color: var(--accent-dark);
        margin-bottom: 1.25rem;
        letter-spacing: -0.5px;
    }

    .collection-subtitle {
        font-family: var(--font-serif);
        font-size: 1.3rem;
        font-weight: 400;
        color: var(--accent-rust);
        margin-bottom: 1.75rem;
        font-style: italic;
        line-height: 1.4;
    }

    .hero-description {
        font-size: 0.95rem;
        line-height: 1.75;
        color: var(--text-dark);
        margin-bottom: 2rem;
    }

    .hero-description p {
        margin-bottom: 1rem;
    }

    .hero-description p:last-child {
        margin-bottom: 0;
    }

    .collection-metadata {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 1.5rem;
        background: var(--accent-light);
        border-left: 4px solid var(--accent-dark);
        margin-top: 2rem;
    }

    .metadata-item {
        font-size: 0.85rem;
        color: var(--accent-dark);
        font-weight: 500;
    }

    .metadata-label {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 0.2rem;
    }

    .metadata-value {
        display: block;
        margin-left: 0.5rem;
        color: var(--text-dark);
    }

    /* ============ IMAGES GRID SECTION ============ */
    .images-grid-section {
        margin-bottom: 4rem;
    }

    .images-grid-heading {
        font-family: var(--font-serif);
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--accent-rust);
        display: inline-block;
    }

    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .image-card {
        position: relative;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
    }

    .image-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-4px);
        border-color: var(--accent-rust);
    }

    .image-card-image {
        width: 100%;
        height: 260px;
        background: linear-gradient(135deg, #f5f1ec 0%, #ebe4dc 100%);
        overflow: hidden;
    }

    .image-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    .image-card:hover .image-card-image img {
        transform: scale(1.08);
    }

    .image-card-caption {
        padding: 1.25rem;
        font-size: 0.9rem;
        color: var(--text-dark);
        line-height: 1.5;
    }

    /* ============ OVERVIEW SECTION ============ */
    .overview-section {
        margin-bottom: 4rem;
    }

    .section-heading {
        font-family: var(--font-serif);
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--accent-rust);
        display: inline-block;
    }

    .overview-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
         align-items: start;
    }

    .overview-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    transition: transform 0.4s ease;
}

.overview-image img:hover {
    transform: scale(1.03);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .overview-content {
        grid-template-columns: 1fr; /* Stack on mobile */
    }

    .overview-image {
        margin-top: 1.5rem;
    }
}

    .overview-text {
        font-size: 0.95rem;
        line-height: 1.8;
        color: var(--text-dark);
    }

    .overview-text p {
        margin-bottom: 1.5rem;
    }

    .overview-text p:last-child {
        margin-bottom: 0;
    }

    .overview-text h3 {
        font-family: var(--font-serif);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin: 2rem 0 1rem 0;
    }

    /* ============ PDF SECTION ============ */
    .pdf-section {
        background: linear-gradient(135deg, var(--accent-light) 0%, #e8ddd2 100%);
        border: 2px solid var(--accent-dark);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 4rem;
        transition: var(--transition);
    }

    .pdf-section:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .pdf-icon {
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .pdf-content {
        flex: 1;
    }

    .pdf-content h3 {
        font-family: var(--font-serif);
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 0.35rem;
    }

    .pdf-content p {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .pdf-btn {
        padding: 0.75rem 1.75rem;
        background: var(--accent-dark);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .pdf-btn:hover {
        background: var(--accent-rust);
        transform: translateY(-2px);
        box-shadow: var(--shadow-light);
    }

    /* ============ BOTTOM CARDS SECTION ============ */
    .related-section {
        margin-bottom: 3rem;
    }

    .related-heading {
        font-family: var(--font-serif);
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 2rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .content-card {
        display: flex;
        flex-direction: column;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow-light);
    }

    .content-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-4px);
        border-color: var(--accent-rust);
    }

    .card-image {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #f5f1ec 0%, #ebe4dc 100%);
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .content-card:hover .card-image img {
        transform: scale(1.08);
    }

    .card-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-family: var(--font-serif);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .card-caption {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* ============ SIDEBAR ============ */
    .sidebar-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 2px solid var(--border-color);
    }

    .sidebar-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 1.75rem;
        box-shadow: var(--shadow-light);
    }

    .sidebar-card h3 {
        font-family: var(--font-serif);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent-light);
    }

    .sidebar-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.9rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .sidebar-item:last-child {
        border-bottom: none;
    }

    .sidebar-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
    }

    .sidebar-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--accent-dark);
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.9rem;
        border-radius: var(--border-radius);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-public {
        background: #e8f5e9;
        color: #1b5e20;
    }

    .status-private {
        background: #ffebee;
        color: #b71c1c;
    }

    /* ============ RESPONSIVE DESIGN ============ */
    @media (max-width: 1200px) {
        .hero-section {
            grid-template-columns: 50% 1fr;
            gap: 2.5rem;
        }

        .overview-content {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .sidebar-section {
            grid-template-columns: repeat(2, 1fr);
        }

        .images-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .archive-page {
            padding: 1.5rem 1rem;
        }

        .hero-section {
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
        }

        .hero-image-container {
            aspect-ratio: 3/4;
        }

        .collection-title {
            font-size: 2rem;
        }

        .collection-subtitle {
            font-size: 1.1rem;
        }

        .section-heading {
            font-size: 1.5rem;
        }

        .sidebar-section {
            grid-template-columns: 1fr;
            margin-top: 3rem;
            padding-top: 2rem;
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .pdf-section {
            flex-direction: column;
            text-align: center;
        }

        .overview-content {
            grid-template-columns: 1fr;
        }

        .images-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .image-card-image {
            height: 200px;
        }
    }

    @media (max-width: 480px) {
        .collection-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .collection-subtitle {
            font-size: 1rem;
        }

        .hero-image-container {
            aspect-ratio: 3/4;
        }

        .section-heading {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .sidebar-card {
            padding: 1.25rem;
        }

        .images-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .image-card-image {
            height: 140px;
        }

        .image-card-caption {
            padding: 0.75rem;
            font-size: 0.8rem;
        }

        .pdf-section {
            padding: 1.5rem;
        }

        .pdf-icon {
            font-size: 2rem;
        }
    }
    .modal {
        position: fixed;
        z-index: 9999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-content-private {
        background: #fff;
        border-radius: 6px;
        width: 100%;
        max-width: 820px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .modal-header-private {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        border-bottom: 2px solid var(--border-color);
        background-color: #0f2540;
        color: white;
        border-radius: 6px 6px 0 0;
    }

    .modal-header-private h2 {
        font-family: var(--font-serif);
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
        color: white;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.8rem;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .modal-close-btn:hover { opacity: 1; }

    .modal-body-private {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 0;
    }

    .private-details-section {
        padding: 2rem;
        background-color: #0f2540;
        border-right: 1px solid var(--border-color);
    }

    .private-details-section h3,
    .request-form-section h3 {
        font-family: var(--font-serif);
        font-size: 1.1rem;
        color:white;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent-light);
    }

    .request-form-section h3 {
        color:black;
    }

    .private-cover {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 1.25rem;
        border: 3px solid var(--accent-dark);
    }

    .private-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        font-size: 0.875rem;
        color: white;
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .detail-item strong {
        color: white;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .access-notice {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-left: 4px solid #ffc107;
        border-radius: 4px;
        padding: 1rem;
        color: #856404;
        line-height: 1.5;
        font-size: 0.75rem;   /* very small */
    }

    .request-form-section {
        padding: 2rem;
    }

    .form-group-modal {
        margin-bottom: 1.25rem;
    }

    .form-group-modal label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--accent-dark);
        margin-bottom: 0.4rem;
    }

    .required { color: #dc3545; }

    .form-group-modal input,
    .form-group-modal textarea {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 0.9rem;
        font-family: var(--font-sans);
        transition: border-color 0.2s;
        outline: none;
    }

    .form-group-modal input:focus,
    .form-group-modal textarea:focus {
        border-color: var(--accent-rust);
        box-shadow: 0 0 0 3px rgba(168, 90, 58, 0.12);
    }

    .form-group-modal input.input-error,
    .form-group-modal textarea.input-error {
        border-color: #dc3545;
    }

    .form-group-modal textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-error-msg {
        display: none;
        font-size: 0.8rem;
        color: #dc3545;
        margin-top: 0.3rem;
    }

    .submit-request-btn {
        width: 100%;
        padding: 0.85rem;
        background-color: #0f2540;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
        margin-top: 0.5rem;
    }

    .submit-request-btn:hover {
        background: var(--accent-rust);
        transform: translateY(-1px);
    }

    .submit-request-btn:disabled {
        background: #aaa;
        cursor: not-allowed;
        transform: none;
    }

    .request-success {
        background: #d4edda;
        border: 1px solid #28a745;
        color: #155724;
        padding: 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .request-error {
        background: #f8d7da;
        border: 1px solid #dc3545;
        color: #721c24;
        padding: 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 640px) {
        .modal-body-private {
            grid-template-columns: 1fr;
        }
        .private-details-section {
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }
    }
    .iti { width: 100%; }
    .iti__flag-container { z-index: 10001; }

    /* ============ ONEDRIVE SECTION ============ */
.onedrive-section {
    margin-bottom: 4rem;
}

.onedrive-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2rem;
}

.onedrive-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    overflow: hidden;
    box-shadow: var(--shadow-light);
    transition: var(--transition);
}

.onedrive-card:hover {
    box-shadow: var(--shadow-medium);
    transform: translateY(-3px);
    border-color: var(--accent-rust);
}

.onedrive-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: var(--accent-dark);
    color: white;
}

.onedrive-icon {
    font-size: 1.3rem;
    flex-shrink: 0;
}

.onedrive-title {
    font-family: var(--font-serif);
    font-size: 0.95rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.onedrive-embed-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #000;
}

.onedrive-iframe {
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    border: none;
    display: block;
}

.onedrive-footer {
    padding: 0.85rem 1.25rem;
    background: var(--accent-light);
    text-align: right;
    border-top: 1px solid var(--border-color);
}

.onedrive-open-btn {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--accent-dark);
    text-decoration: none;
    transition: color 0.2s;
}

.onedrive-open-btn:hover {
    color: var(--accent-rust);
}

@media (max-width: 768px) {
    .onedrive-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main class="container">
    <!-- Navigation -->
    <div class="page-nav">
        <div class="breadcrumb-nav">
            <a href="{{ route('client.archivecentrecollection') }}" class="breadcrumb-btn">Back to Collections</a>
        </div>
    </div>

    <!-- Hero Section with Title & Subtitle -->
 
    <section class="hero-section">
        <!-- Hero Image -->
        <div class="hero-image-container">
             <img src="{{ Str::startsWith($titleImg, ['http://','https://']) ? $titleImg : asset('public/'.$titleImg) }}" 
             alt="{{ $collection->title }}">
        </div>

        <!-- Hero Content -->
        <div class="hero-content">
            <h1 class="collection-title">{{ $collection->title }}</h1>
            
            @if($collection->details)
            <p class="collection-subtitle">{{ $collection->details }}</p>
            @endif

            <div class="hero-description">
                {!! Str::limit(strip_tags($collection->description), 300) !!}
            </div>

            <!-- Metadata Box -->
            <div class="collection-metadata">
                <div class="metadata-item">
                    <span class="metadata-label">Category:</span>
                    <span class="metadata-value">{{  $collection->masterMainCategory->name ?? 'N/A' }}</span>
                </div>
               
                <div class="metadata-item">
                    <span class="metadata-label">Status:</span>
                    <span class="status-badge {{ $collection->access_type === 'Public' ? 'status-public' : 'status-private' }}">
                        {{ $collection->access_type === 'Public' ? '🔓 Public' : '🔒 Private' }}
                    </span>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Images Grid Section
    @if(count($images) > 1)
    <section class="images-grid-section">
        <h2 class="images-grid-heading">Collection Images</h2>
        <div class="images-grid">
            @foreach($images as $index => $img)
                @if($index > 0)
                <div class="image-card">
                    <div class="image-card-image">
                        <img src="{{ Str::startsWith($img, ['http://','https://']) ? $img : asset($img) }}" 
                             alt="{{ $collection->title }} - Image {{ $index + 1 }}">
                    </div>
                    <div class="image-card-caption">
                        Image {{ $index + 1 }} - {{ $collection->title }}
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </section>
    @endif -->

    @if(count($images) > 0)
<section class="images-grid-section">
    <h2 class="images-grid-heading">Collection Images</h2>
    <div class="images-grid">
        @foreach($images as $index => $img)
        <div class="image-card">
            <div class="image-card-image">
                <img src="{{ Str::startsWith($img, ['http://','https://']) ? $img : asset('public/'.$img) }}" 
                     alt="{{ $collection->title }} - Image {{ $index + 1 }}">
            </div>
            <div class="image-card-caption">
                Image {{ $index + 1 }} - {{ $collection->title }}
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

    <!-- Overview Section -->
    <!-- <section class="overview-section">
        <h2 class="section-heading">About This Collection</h2>
        <div class="overview-content">
            <div class="overview-text">
                {!! $collection->description !!}
            </div>
        </div>
    </section> -->

      <!-- Overview Section -->
<!-- <section class="overview-section">
    <h2 class="section-heading">About This Collection</h2>
    <div class="overview-content">
        
        <div class="overview-text">
            {!! $collection->description !!}
        </div>
        @if(count($images) > 0)
        <div class="overview-image">
            <img src="{{ Str::startsWith($images[count($images)-1], ['http://','https://']) ? $images[count($images)-1] : asset($images[count($images)-1]) }}" 
                 alt="{{ $collection->title }} - Last Image">
        </div>
        @endif
    </div>
</section> -->

  <section class="overview-section">
    <h2 class="section-heading">About This Collection</h2>
    <div class="overview-content">
        <div class="overview-text">
            {!! $collection->description !!}
        </div>

        @if($overviewImg)
        <div class="overview-image">
            <img src="{{ Str::startsWith($overviewImg, ['http://','https://']) ? $overviewImg : asset('public/'.$overviewImg) }}" 
                 alt="{{ $collection->title }}">
        </div>
        @endif
    </div>
</section>

    <!-- PDF Section -->
    @if($hasPdf)
    <div class="pdf-section">
        <div class="pdf-icon">📄</div>
        <div class="pdf-content">
            <h3>Collection Document</h3>
            <p>Download the complete collection documentation</p>
        </div>

        @if($collection->access_type === 'Public')
            {{-- Public: direct download --}}
            <a href="{{ route('news.download.pdf', $collection->id) }}" 
               class="pdf-btn" target="_blank">
                📥 Download PDF
            </a>
        @else
            {{-- Private: open request modal --}}
          <button class="pdf-btn" 
    onclick="openPrivateModal(
        '{{ $collection->id }}',
        '{{ addslashes($collection->title) }}',
        '{{ $collection->masterMainCategory->name ?? 'N/A' }}',
        '{{ $collection->subcategory ?? 'N/A' }}',
        '{{ $collection->created_at->format('F d, Y') }}',
        '{{ Str::startsWith($titleImg, ['http://','https://']) ? $titleImg : asset('public/'.$titleImg) }}'
    )">
    🔒 Request Access
</button>
        @endif
    </div>
    @endif

        {{-- ============ ONEDRIVE LINKS SECTION ============ --}}
@if($collection->oneDriveLinks->isNotEmpty())
<section class="onedrive-section">
    <h2 class="section-heading">Related Videos</h2>

    <div class="onedrive-grid">
        @foreach($collection->oneDriveLinks as $link)
        @php
            $embedUrl = $link->url;

            /*
            |--------------------------------------------------------------------------
            | GOOGLE DRIVE
            |--------------------------------------------------------------------------
            */
            if (str_contains($embedUrl, 'drive.google.com')) {

                preg_match('/\/d\/(.*?)\//', $embedUrl, $matches);

                if (isset($matches[1])) {
                    $fileId = $matches[1];
                    $embedUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                }
            }

            /*
            |--------------------------------------------------------------------------
            | YOUTUBE
            |--------------------------------------------------------------------------
            */
            elseif (str_contains($embedUrl, 'youtube.com') || str_contains($embedUrl, 'youtu.be')) {

                preg_match('/(youtu\.be\/|v=)([^&]+)/', $embedUrl, $matches);

                if (isset($matches[2])) {
                    $videoId = $matches[2];
                    $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                }
            }

            /*
            |--------------------------------------------------------------------------
            | ONEDRIVE
            |--------------------------------------------------------------------------
            */
            elseif (str_contains($embedUrl, '1drv.ms') || str_contains($embedUrl, 'onedrive.live.com')) {

                // OneDrive share links usually work directly in iframe
                // If needed, you can modify to use embed format
                $embedUrl = $embedUrl;
            }
        @endphp

        <div class="onedrive-card">
            <div class="onedrive-header">
                <span class="onedrive-icon">🎬</span>
                <span class="onedrive-title">
                    {{ $link->title ?? 'Video' }}
                </span>
            </div>

            <div class="onedrive-embed-wrapper">
                <iframe
                    src="{{ $embedUrl }}"
                    class="onedrive-iframe"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen
                    loading="lazy">
                </iframe>
            </div>

            <div class="onedrive-footer">
                <a href="{{ $link->url }}" target="_blank" class="onedrive-open-btn">
                    ↗ Open Link
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
</main>

<!-- ============ PRIVATE ACCESS MODAL ============ -->
<div id="privateModal" class="modal" style="display:none;">
  <div class="modal-content-private">
    <div class="modal-header-private">
      <h2 id="privateModalTitle"></h2>
      <button class="modal-close-btn" onclick="closePrivateModal()">×</button>
    </div>
    <div class="modal-body-private">

      <!-- Left: Collection Details -->
      <div class="private-details-section">
        <h3>📖 Collection Details</h3>
        <img id="privateModalCover" src="" alt="Collection cover" class="private-cover">
        <div class="private-info">
          <div class="detail-item">
            <strong>📁 Main Category:</strong>
            <span id="privateModalMainCategory"></span>
          </div>
          <div class="detail-item">
            <strong>📂 Subcategory:</strong>
            <span id="privateModalSubcategory"></span>
          </div>
          <div class="detail-item">
            <strong>📅 Published:</strong>
            <span id="privateModalDate"></span>
          </div>
        </div>
        <div class="access-notice">
          <p><strong>🔒 Private Collection</strong><br>
          This collection requires access approval. Please submit the request form to gain access.</p>
        </div>
      </div>

      <!-- Right: Request Form -->
      <div class="request-form-section">
        <h3>📝 Request Access Form</h3>
        <div id="requestSuccessMsg" style="display:none;" class="request-success">
            ✅ Your request has been submitted successfully! We will contact you soon.
        </div>
        <div id="requestErrorMsg" style="display:none;" class="request-error"></div>

        <form id="requestAccessForm">
          @csrf
          <input type="hidden" name="collection_id" id="requestCollectionId">

          <div class="form-group-modal">
            <label>Full Name <span class="required">*</span></label>
            <input type="text" id="requestName" name="name" placeholder="Enter your full name">
            <div class="form-error-msg" id="nameError">Please enter your full name</div>
          </div>

          <div class="form-group-modal">
            <label>Email Address <span class="required">*</span></label>
            <input type="email" id="requestEmail" name="email" placeholder="Enter your email">
            <div class="form-error-msg" id="emailError">Please enter a valid email address</div>
          </div>

          <div class="form-group-modal">
            <label>Phone Number <span class="required">*</span></label>
            <input type="tel" id="requestPhone" name="phone_input" placeholder="Enter your phone number">
            <input type="hidden" name="phone" id="full_phone_modal">
            <input type="hidden" name="country_name" id="country_name_modal">
            <div class="form-error-msg" id="phoneError">Please enter a valid phone number</div>
          </div>

          <div class="form-group-modal">
            <label>Reason for Access <span class="required">*</span></label>
            <textarea id="requestWhy" name="why" rows="4" 
                placeholder="Please explain why you need access to this collection..."></textarea>
            <div class="form-error-msg" id="whyError">Please provide a reason (at least 10 characters)</div>
          </div>

          <button type="button" class="submit-request-btn" onclick="submitAccessRequest()">
            📤 Submit Request
          </button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- ============ MODAL JAVASCRIPT ============ -->
<script>
    let phoneInputModal;
    
    // Initialize intl-tel-input
    document.addEventListener("DOMContentLoaded", function() {
        const phoneInputFieldModal = document.querySelector("#requestPhone");
        phoneInputModal = window.intlTelInput(phoneInputFieldModal, {
            initialCountry: "gb",
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js",
        });
    });

    function openPrivateModal(id, title, mainCat, subCat, date, coverImg) {
        document.getElementById('requestCollectionId').value = id;
        document.getElementById('privateModalTitle').textContent = title;
        document.getElementById('privateModalMainCategory').textContent = mainCat;
        document.getElementById('privateModalSubcategory').textContent = subCat;
        document.getElementById('privateModalDate').textContent = date;
        document.getElementById('privateModalCover').src = coverImg;

        // Reset form state
        resetModalForm();

        document.getElementById('privateModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePrivateModal() {
        document.getElementById('privateModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    function resetModalForm() {
        ['requestName', 'requestEmail', 'requestPhone', 'requestWhy'].forEach(id => {
            const el = document.getElementById(id);
            el.value = '';
            el.classList.remove('input-error');
        });
        ['nameError', 'emailError', 'phoneError', 'whyError'].forEach(id => {
            document.getElementById(id).style.display = 'none';
        });
        document.getElementById('requestSuccessMsg').style.display = 'none';
        document.getElementById('requestErrorMsg').style.display = 'none';
    }

    function validateModalForm() {
        let valid = true;

        const name  = document.getElementById('requestName');
        const email = document.getElementById('requestEmail');
        const phone = document.getElementById('requestPhone');
        const why   = document.getElementById('requestWhy');

        // Reset errors
        [name, email, phone, why].forEach(el => el.classList.remove('input-error'));
        ['nameError','emailError','phoneError','whyError'].forEach(id => {
            document.getElementById(id).style.display = 'none';
        });

        if (!name.value.trim()) {
            name.classList.add('input-error');
            document.getElementById('nameError').style.display = 'block';
            valid = false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim() || !emailRegex.test(email.value)) {
            email.classList.add('input-error');
            document.getElementById('emailError').style.display = 'block';
            valid = false;
        }

        if (!phone.value.trim()) {
            phone.classList.add('input-error');
            const phoneError = document.getElementById('phoneError');
            phoneError.textContent = 'Please enter your phone number';
            phoneError.style.display = 'block';
            valid = false;
        } else if (!phoneInputModal.isValidNumber()) {
            phone.classList.add('input-error');
            const phoneError = document.getElementById('phoneError');
            phoneError.textContent = 'Please enter a valid international phone number';
            phoneError.style.display = 'block';
            valid = false;
        }

        if (!why.value.trim() || why.value.trim().length < 10) {
            why.classList.add('input-error');
            document.getElementById('whyError').style.display = 'block';
            valid = false;
        }

        return valid;
    }

    function submitAccessRequest() {
        if (!validateModalForm()) return;

        const btn = document.querySelector('.submit-request-btn');
        btn.disabled = true;
        btn.textContent = '⏳ Submitting...';

        const formData = new FormData();
        const token = document.querySelector('input[name="_token"]').value;
        
        formData.append('_token', token);
        formData.append('collection_id', document.getElementById('requestCollectionId').value);
        formData.append('name',          document.getElementById('requestName').value.trim());
        formData.append('email',         document.getElementById('requestEmail').value.trim());
        formData.append('phone',         document.getElementById('requestPhone').value.trim());
        formData.append('full_phone',    phoneInputModal.getNumber());
        formData.append('country_name',  phoneInputModal.getSelectedCountryData().name);
        formData.append('why',           document.getElementById('requestWhy').value.trim());

        fetch('{{ route('heritagecollections.request.submit') }}', {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('requestSuccessMsg').style.display = 'block';
                document.getElementById('requestErrorMsg').style.display = 'none';
                document.getElementById('requestAccessForm').style.display = 'none';
            } else {
                document.getElementById('requestErrorMsg').textContent = data.message;
                document.getElementById('requestErrorMsg').style.display = 'block';
            }
        })
        .catch(() => {
            document.getElementById('requestErrorMsg').textContent = 'Something went wrong. Please try again.';
            document.getElementById('requestErrorMsg').style.display = 'block';
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = '📤 Submit Request';
        });
    }

    // Close modal on backdrop click
    document.getElementById('privateModal').addEventListener('click', function(e) {
        if (e.target === this) closePrivateModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePrivateModal();
    });
</script>


@endsection