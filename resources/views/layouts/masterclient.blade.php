<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The TIC Archives</title>


    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Cinzel:wght@400;600&display=swap" rel="stylesheet" />
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">


    <style>
        /* ============================================================
           CSS VARIABLES
        ============================================================ */
        :root {
            --parchment: #f4ede0;
            --parchment-dark: #e8dcc8;
            --ink: #1a1008;
            --rust: #8b2d2d;
            --rust-dark: #6e2222;
            --gold: #c9973a;
            --text-muted: #5a4030;
            --nav-h: 64px;
            --font-serif: 'EB Garamond', Georgia, serif;
            --font-heading: 'Cinzel', serif;
            --font-accent: 'Playfair Display', serif;
            --container-max: 1200px;
        }

        /* ============================================================
           RESET / BASE
        ============================================================ */
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: var(--font-serif);
            background-color: var(--parchment);
            color: var(--ink);
            font-size: 17px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            user-select: none;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 400;
            color: var(--ink);
        }

        h1 { font-size: clamp(1.8rem, 5vw, 2.5rem); }
        h2 { font-size: clamp(1.5rem, 4vw, 2rem); }
        h3 { font-size: clamp(1.2rem, 3vw, 1.5rem); }
        p { font-size: clamp(0.95rem, 2.5vw, 1.1rem); }

        /* ============================================================
           ACCESSIBILITY
        ============================================================ */
        .skip-link {
            position: fixed;
            top: -100px; left: 0;
            background: var(--rust);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            z-index: 99999;
            border-radius: 0 0 8px 0;
            font-weight: bold;
            transition: top 0.3s ease;
        }
        .skip-link:focus { top: 0; outline: 3px solid #ffd700; }

        /* ============================================================
           HEADER
        ============================================================ */
        header {
            background: #0a0602 url('{{ asset("images/tornbkrund.png") }}') center/cover;
            background-blend-mode: multiply;
            border-bottom: 1px solid #3a2a18;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: var(--nav-h);
            display: flex;
            align-items: center;
        }

        .header-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 28px;
        }

        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .nav-brand {
            font-family: 'Cinzel', serif;
            font-size: 16px;
            font-weight: 700;
            color: #e8dcc8;
            letter-spacing: 0.12em;
            text-decoration: none;
            white-space: nowrap;
        }

        .main-nav ul {
            display: flex;
            align-items: center;
            gap: 24px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-nav a {
            font-family: 'EB Garamond', serif;
            font-size: 16px;
            font-weight: 600;
            color: #d4c4a8;
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .main-nav a:hover {
            color: var(--gold);
        }

        .nav-active {
            background: var(--gold);
            color: #ffffff !important;
            padding: 6px 14px;
            border-radius: 6px;
        }

        /* Dropdown Styles */
        .dropdown-parent {
            position: relative;
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            left: 0;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 220px;
            padding: 12px 0;
            display: none;
            z-index: 100;
            margin-top: 10px;
        }

        .dropdown-parent:hover .dropdown-menu-custom {
            display: block;
        }

        .dropdown-menu-custom::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            width: 100%;
            height: 10px;
            background: transparent;
        }

        .dropdown-menu-custom a {
            display: block !important;
            padding: 10px 20px !important;
            color: #001f3f !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: all 0.2s !important;
            gap: 0 !important;
        }

        .dropdown-menu-custom a:hover {
            background: #f1f5f9 !important;
            color: #003366 !important;
            padding-left: 24px !important;
        }

        .dropdown-parent > a i {
            transition: transform 0.2s;
        }

        .dropdown-parent:hover > a i {
            transform: rotate(180deg);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-search-btn {
            background: none;
            border: none;
            color: #d4c4a8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .nav-search-btn:hover {
            color: var(--gold);
        }

        /* ─────────────── SEARCH OVERLAY ─────────────── */
        .search-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(10, 6, 2, 0.96);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .search-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .search-overlay-close {
            position: absolute;
            top: 30px;
            right: 40px;
            background: none;
            border: none;
            color: #d4c4a8;
            font-size: 36px;
            cursor: pointer;
            transition: color 0.2s;
            padding: 10px;
        }

        .search-overlay-close:hover {
            color: var(--gold);
        }

        .search-form-container {
            width: 100%;
            max-width: 700px;
            padding: 0 20px;
            position: relative;
            transform: translateY(-20px);
            transition: transform 0.4s ease;
        }

        .search-overlay.open .search-form-container {
            transform: translateY(0);
        }

        .search-form-container input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 2px solid #3a2a18;
            color: #e8dcc8;
            font-size: clamp(24px, 4vw, 36px);
            font-family: var(--font-heading);
            padding: 15px 50px 15px 10px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-form-container input::placeholder {
            color: rgba(212, 196, 168, 0.4);
        }

        .search-form-container input:focus {
            border-bottom-color: var(--gold);
        }

        .search-submit-btn {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gold);
            font-size: 24px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .search-submit-btn:hover {
            opacity: 0.8;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
        }

        .mobile-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: #d4c4a8;
            transition: 0.3s;
        }

        .mobile-menu-btn:hover,
        .mobile-menu-btn:focus {
            background: var(--hover-bg);
            outline: 2px solid var(--accent-dark);
        }

        /* ============================================================
           MOBILE NAV — OVERLAY + DRAWER
        ============================================================ */
        .mobile-nav-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1200;
            backdrop-filter: blur(2px);
        }
        .mobile-nav-overlay.open { display: block; }

        .mobile-nav-drawer {
            position: fixed;
            top: 0; right: -100%;
            width: 300px;
            height: 100dvh;
            background: rgba(10, 6, 2, 0.98);
            z-index: 1300;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #3a2a18;
        }
        .mobile-nav-drawer.open { right: 0; }

        .drawer-header {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .drawer-logo {
            font-family: 'Cinzel', serif;
            font-size: 15px;
            color: #d4c4a8;
            text-decoration: none;
            letter-spacing: 0.1em;
        }

        .mobile-nav-close {
            background: none;
            border: none;
            color: #d4c4a8;
            font-size: 20px;
            cursor: pointer;
        }

        .drawer-body ul {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .drawer-body a {
            display: block;
            padding: 13px 24px;
            font-family: 'EB Garamond', serif;
            font-size: 17px;
            color: #d4c4a8;
            text-decoration: none;
            letter-spacing: 0.04em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            transition: 0.2s;
        }

        .drawer-body a:hover {
            color: var(--gold);
            background: rgba(255, 255, 255, 0.04);
        }

        /* Drawer Accordion Styles */
        .drawer-group {
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .drawer-group-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 24px;
            font-family: 'EB Garamond', serif;
            font-size: 17px;
            color: #d4c4a8;
            background: none;
            border: none;
            text-decoration: none;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: 0.2s;
        }

        .drawer-group-toggle:hover {
            background: rgba(255, 255, 255, 0.04);
            color: var(--gold);
        }

        .drawer-sub-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            background: rgba(0, 0, 0, 0.2);
            display: none;
        }

        .drawer-sub-menu.open {
            display: block;
        }

        .drawer-sub-menu a {
            padding-left: 44px !important;
            font-size: 16px !important;
            border-bottom: none !important;
            opacity: 0.85;
        }

        .drawer-divider {
            height: 1px;
            background: rgba(15,37,64,0.08);
            margin: 0.4rem 1.25rem;
        }

        /* Drawer footer CTA */
        .drawer-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(15,37,64,0.08);
            background: var(--primary-bg);
            flex-shrink: 0;
        }

        .drawer-footer a {
            display: block;
            text-align: center;
            background: var(--accent-dark);
            color: #fff;
            font-family: var(--font-serif);
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .drawer-footer a:hover { opacity: 0.85; }

        /* ============================================================
           MAIN CONTENT
        ============================================================ */
        main {
            margin-top: 1.5rem;  /* mobile */
        }

        /* .container {
            padding-left: 1rem;
            padding-right: 1rem;
        } */

        /* ============================================================
           HERO IMAGE — aspect-ratio based, no fixed height
        ============================================================ */
        .hero-image {
            width: 100%;
            max-width: 800px;
            height: auto;
            aspect-ratio: 16 / 9;
            margin: auto;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }

        .hero-image-content {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: none;
            display: block;
        }

        /* ============================================================
           FEATURED CARD
        ============================================================ */
        .featured-card { cursor: pointer; }

        /* ============================================================
           WHATSAPP FLOAT
        ============================================================ */
        .whatsapp-float {
            position: fixed;
            width: 52px; height: 52px;
            bottom: 20px; left: 20px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover  { transform: scale(1.1); box-shadow: 0 5px 15px rgba(0,0,0,0.4); }
        .whatsapp-float img    { width: 32px; height: 32px; }

        .whatsapp-float::after {
            content: '';
            position: absolute;
            width: 62px; height: 62px;
            background: rgba(19,124,58,0.3);
            border-radius: 50%;
            animation: pulse 2s infinite;
            z-index: -1;
        }

        @keyframes pulse {
            0%   { transform: scale(1);   opacity: 0.7; }
            70%  { transform: scale(1.45); opacity: 0; }
            100% { transform: scale(1.45); opacity: 0; }
        }

        /* ============================================================
           FOOTER
        ============================================================ */
        footer {
            background: #0f0f0f;
            color: #fff;
            padding: 2.5rem 0 1rem;
            margin-top: 3rem;
        }

        /* Mobile: single column, hidden sections collapsed */
        .footer-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .footer-section h3 {
            margin-bottom: 0.75rem;
            font-size: clamp(0.95rem, 3vw, 1.1rem);
        }

        .footer-section p {
            color: #ccc;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            line-height: 1.65;
        }

        .footer-section ul {
            list-style: none;
            padding: 0; margin: 0;
        }

        .footer-section ul li { margin-bottom: 0.35rem; }

        .footer-section a {
            color: #ccc;
            text-decoration: none;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            display: inline-block;
            min-height: 36px;
            line-height: 36px;
            transition: color 0.2s;
        }

        .footer-section a:hover { color: #fff; }

        .footer-bottom {
            text-align: center;
            padding: 1.25rem 1rem 0;
            border-top: 1px solid #333;
            color: #999;
            font-size: 0.8rem;
        }

        /* PayPal btn */
        .footer-section form button {
            font-size: 0.875rem !important;
            padding: 9px 15px !important;
        }

        /* ============================================================
           TABLET  768px+
        ============================================================ */
        @media (min-width: 768px) {
            .header-container { padding: 0.65rem 1.5rem; }

            .logo img         { width: 64px; height: 64px; }
            .logo-text .ta    { font-size: 1.4rem; }

            main              { margin-top: 2rem; }

            .footer-content   { grid-template-columns: repeat(2, 1fr); }
        }

        /* ============================================================
           DESKTOP  992px+  — show desktop nav, hide mobile btn
        ============================================================ */
            @media (max-width: 900px) {
                .main-nav { display: none; }
                .mobile-toggle { display: flex; }
                .header-container { padding: 0 20px; }
            }

        /* ============================================================
           LARGE DESKTOP  1200px+
        ============================================================ */
        @media (min-width: 1200px) {
            .header-container  { padding: 1rem 1.5rem; }

            .logo img          { width: 100px; height: 100px; }
            .logo-text .ta     { font-size: 2rem; }

            .main-nav > ul > li > a,
            .main-nav > ul > li > .nav-link-btn {
                font-size: 0.95rem;
                padding: 0.5rem 1.1rem;
            }
        }
        #page-loader {
    position: fixed;
    inset: 0;
    background: var(--primary-bg);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s ease, visibility 0.2s ease;
}

#page-loader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.loader-box {
    text-align: center;
    color: var(--accent-dark);
    font-family: var(--font-serif);
}

.spinner {
    width: 52px;
    height: 52px;
    border: 4px solid #ddd;
    border-top-color: var(--accent-dark);
    border-radius: 50%;
    animation: spin 0.9s linear infinite;
    margin: 0 auto 12px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Hide mobile footer on desktop & tablet */
.mobile-footer {
    display: none;
}

/* Hide full footer on mobile */
@media (max-width: 767px) {
    .desktop-footer {
        display: none;
    }
    .mobile-footer {
        display: block;
    }
}


    </style>
    @yield('styles')
</head>
<body>

    <div id="page-loader" aria-hidden="false">
        <div class="loader-box">
            <div class="spinner"></div>
            <p>Loading The Archives…</p>
        </div>
    </div>


    <!-- Skip to content -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <button class="search-overlay-close" id="closeSearchBtn" aria-label="Close search">
            <i class="fas fa-times"></i>
        </button>
        <div class="search-form-container">
            <form action="{{ route('search.results') }}" method="GET">
                <input type="text" name="search" id="globalSearchInput" placeholder="Search the archives..." autocomplete="off" required>
                <button type="submit" class="search-submit-btn" aria-label="Submit search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <header role="banner">
        <div class="header-container">
            <div class="header-main">
                <a href="{{ route('client.home') }}" class="nav-brand">THE TIC ARCHIVES</a>

                <nav class="main-nav" role="navigation">
                    <ul>
                        <li><a href="{{ route('client.home') }}" class="{{ request()->routeIs('client.home') ? 'nav-active' : '' }}">Home</a></li>
                        <li class="dropdown-parent">
                            <a href="{{ route('client.about') }}" class="{{ request()->routeIs('client.about', 'client.committee', 'client.technicalteam') ? 'nav-active' : '' }}">
                                About <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
                            </a>
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('client.about') }}">About Us</a>
                                <a href="{{ route('client.committee') }}">Committee</a>
                                <a href="{{ route('client.technicalteam') }}">Technical Team</a>
                            </div>
                        </li>
                        <li><a href="{{ route('client.archivecentrecollection') }}" class="{{ request()->routeIs('client.archivecentrecollection') ? 'nav-active' : '' }}">Archive Centre</a></li>
                        <li><a href="{{ route('client.heritage-centre') }}" class="{{ request()->routeIs('client.heritage-centre') ? 'nav-active' : '' }}">Exhibition</a></li>
                        <li><a href="{{ route('heritage.archive-centre') }}" class="{{ request()->routeIs('heritage.archive-centre') ? 'nav-active' : '' }}">Heritage Museum</a></li>
                        <li class="dropdown-parent">
                            <a href="{{ route('client.joinus') }}" class="{{ request()->routeIs('client.joinus') ? 'nav-active' : '' }}">
                                Join <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
                            </a>
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('client.joinus') }}">Member Application</a>
                                <a href="{{ route('client.joinus') }}#volunteer-section">Become a Volunteer</a>
                            </div>
                        </li>
                        <li><a href="{{ route('client.publications') }}" class="{{ request()->routeIs('client.publications') ? 'nav-active' : '' }}">Shop</a></li>
                        <li><a href="{{ route('client.contactus') }}" class="{{ request()->routeIs('client.contactus') ? 'nav-active' : '' }}">Contact</a></li>
                    </ul>
                </nav>

                <div class="nav-right">
                    <button class="nav-search-btn" aria-label="Search" onclick="toggleSearchOverlay()">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </button>
                    <button class="mobile-toggle" id="mobile-toggle" aria-label="Menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- ================================================================
         MOBILE NAV OVERLAY
    ================================================================ -->
    <div class="mobile-nav-overlay"
         id="mobileNavOverlay"
         aria-hidden="true"
         role="presentation"></div>

    <!-- ================================================================
         MOBILE NAV DRAWER
    ================================================================ -->
    <nav class="mobile-nav-drawer" id="mobileNavDrawer" role="navigation" aria-hidden="true">
        <div class="drawer-header">
            <a href="{{ route('client.home') }}" class="drawer-logo">THE TIC ARCHIVES</a>
            <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="drawer-body">
            <ul>
                <li><a href="{{ route('client.home') }}">Home</a></li>
                <li class="drawer-group">
                    <button class="drawer-group-toggle" aria-expanded="false" aria-controls="about-sub">
                        About <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </button>
                    <ul id="about-sub" class="drawer-sub-menu">
                        <li><a href="{{ route('client.about') }}">About Us</a></li>
                        <li><a href="{{ route('client.committee') }}">Committee</a></li>
                        <li><a href="{{ route('client.technicalteam') }}">Technical Team</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('client.archivecentrecollection') }}">Archive Centre</a></li>
                <li><a href="{{ route('client.heritage-centre') }}">Exhibition</a></li>
                <li><a href="{{ route('heritage.archive-centre') }}">Heritage Museum</a></li>
                <li class="drawer-group">
                    <button class="drawer-group-toggle" aria-expanded="false" aria-controls="join-sub">
                        Join <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </button>
                    <ul id="join-sub" class="drawer-sub-menu">
                        <li><a href="{{ route('client.joinus') }}">Member Application</a></li>
                        <li><a href="{{ route('client.joinus') }}#volunteer-section">Become a Volunteer</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('client.publications') }}">Shop</a></li>
                <li><a href="{{ route('client.contactus') }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- ================================================================
         MAIN CONTENT
    ================================================================ -->
    <main id="main-content" role="main">
        @hasSection('no-container')
            @yield('content')
        @else
            <div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
                @yield('content')
            </div>
        @endif
    </main>

    <!-- ================================================================
         FOOTER
    ================================================================ -->
    <footer>
    <div class="container">

        <!-- Full footer: desktop & tablet -->
        <div class="footer-content desktop-footer">
            <!-- Brand -->
            <div class="footer-section">
                <h3>The Archives</h3>
                <p>Your trusted source for Tamil community news, culture, and heritage updates from Sri Lanka and around the world.</p>
                <p style="color:#999;font-size:0.82rem;margin-top:0.75rem;">© The Archives</p>
                <div style="margin-top:1rem;">
                    <form action="https://www.paypal.com/donate" method="post" target="_blank">
                        <input type="hidden" name="hosted_button_id" value="">
                        <button type="submit"
                                style="background:#0070ba;color:#fff;padding:10px 16px;border:none;border-radius:6px;cursor:pointer;font-size:0.875rem;font-weight:600;display:inline-flex;align-items:center;gap:8px;">
                            <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png"
                                 alt="PayPal" style="height:16px;">
                            Donate with PayPal
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route('client.about') }}">About Us</a></li>
                    <li><a href="{{ route('client.contactus') }}">Contact</a></li>
                    <li><a href="#events">Events</a></li>
                    <li><a href="{{ route('client.publications') }}">Publications</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="footer-section">
                <h3>Categories</h3>
                <ul>
                    <li><a href="#heritage">Heritage</a></li>
                    <li><a href="#">Culture</a></li>
                    <li><a href="#">Community</a></li>
                    <li><a href="{{ route('client.publications') }}">Shop</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
            </div>
        </div><!-- /desktop-footer -->

        <!-- Minimal footer: mobile only -->
        <div class="mobile-footer text-center">
            <p style="color:#999;font-size:0.82rem;margin:0;">&copy; {{ date('Y') }} The Archives. All rights reserved</p>
        </div>

        <div class="footer-bottom desktop-footer">
            <p>&copy; {{ date('Y') }} The Archives. All rights reserved.</p>
        </div>

    </div>
</footer>


    <!-- ================================================================
         WHATSAPP FLOAT
    ================================================================ -->
    <a href="https://wa.me/94712345678?text=Hi%20TIC%20Archives!%20I%20have%20a%20question%20about..."
       class="whatsapp-float"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="Chat on WhatsApp">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
             alt="WhatsApp" width="60" height="60">
    </a>

    <!-- ================================================================
         SCRIPTS
    ================================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- jQuery and Toastr JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Global Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Laravel Session Messages to Toastr
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>

    <script> 
    
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('page-loader');
        if (!loader) return;

        loader.classList.add('hidden');

        setTimeout(() => {
            loader.remove(); // optional but keeps DOM clean
        }, 200);
    });

    (function () {
        'use strict';

        /* ── Elements ── */
        const hamburger = document.getElementById('mobile-toggle');
        const overlay   = document.getElementById('mobileNavOverlay');
        const drawer    = document.getElementById('mobileNavDrawer');
        const closeBtn  = document.getElementById('mobileNavClose');
        
        const searchOverlay = document.getElementById('searchOverlay');
        const closeSearchBtn = document.getElementById('closeSearchBtn');
        const searchInput = document.getElementById('globalSearchInput');

        /* ── Open / Close helpers ── */
        function openDrawer() {
            drawer.classList.add('open');
            overlay.classList.add('open');
            hamburger.setAttribute('aria-expanded', 'true');
            drawer.setAttribute('aria-hidden', 'false');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            // Move focus into drawer for accessibility
            closeBtn.focus();
        }

        window.toggleSearchOverlay = function() {
            searchOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
            setTimeout(() => searchInput.focus(), 100);
        };

        function closeSearchOverlay() {
            searchOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        function closeDrawer() {
            drawer.classList.remove('open');
            overlay.classList.remove('open');
            hamburger.setAttribute('aria-expanded', 'false');
            drawer.setAttribute('aria-hidden', 'true');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            hamburger.focus();
        }

        /* ── Event Listeners ── */
        hamburger.addEventListener('click', openDrawer);
        closeBtn.addEventListener('click', closeDrawer);
        overlay.addEventListener('click', closeDrawer);
        closeSearchBtn.addEventListener('click', closeSearchOverlay);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                if (drawer.classList.contains('open')) closeDrawer();
                if (searchOverlay.classList.contains('open')) closeSearchOverlay();
            }
        });

        /* ── Accordion toggles inside drawer ── */
        document.querySelectorAll('.drawer-group-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const targetId = this.getAttribute('aria-controls');
                const sub      = document.getElementById(targetId);
                const isOpen   = sub.classList.toggle('open');
                this.setAttribute('aria-expanded', String(isOpen));
            });
        });

        /* ── Auto-close drawer if viewport expands to desktop ── */
        const mq = window.matchMedia('(min-width: 992px)');
        mq.addEventListener('change', function (e) {
            if (e.matches) closeDrawer();
        });

    })();
    </script>

    <!-- intl-tel-input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/intlTelInput.min.js"></script>

    @yield('modal')
    @yield('scripts')

</body>
</html>