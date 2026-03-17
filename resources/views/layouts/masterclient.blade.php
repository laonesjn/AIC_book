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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Noto+Sans+Tamil:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">

    @yield('styles')

    <style>
        /* ============================================================
           CSS VARIABLES
        ============================================================ */
        :root {
            --primary-bg:    #f6e3c5;
            --accent-dark:   #0f2540;
            --accent-muted:  #bfa98b;
            --card-bg:       #f6ece0;
            --hover-bg:      #e6d3bd;
            --border-radius: 12px;
            --font-serif:    "Georgia", "Times New Roman", serif;
            --header-h-mob:  64px;
            --header-h-desk: 88px;
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
            background-color: var(--primary-bg);
            color: var(--accent-dark);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            user-select: none;
        }

        h1, h2, h3 {
            font-family: var(--font-serif);
            font-weight: 700;
            line-height: 1.3;
        }

        h1 { font-size: clamp(1.5rem,  5vw, 2.5rem); }
        h2 { font-size: clamp(1.25rem, 4vw, 2rem);   }
        h3 { font-size: clamp(1.1rem,  3vw, 1.5rem); }
        p  { font-size: clamp(0.875rem, 2.5vw, 1rem); }

        /* ============================================================
           ACCESSIBILITY
        ============================================================ */
        .skip-link {
            position: absolute;
            top: -40px; left: 0;
            background: var(--accent-dark);
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            z-index: 9999;
            border-radius: 0 0 4px 0;
        }
        .skip-link:focus { top: 0; outline: 3px solid #ffd700; }

        /* ============================================================
           HEADER
        ============================================================ */
        header {
            background: #fff;
            border-bottom: 1px solid rgba(15,37,64,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.55rem 1rem;        /* mobile */
        }

        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 1rem;
        }

        /* ============================================================
           LOGO
        ============================================================ */
        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            color: var(--accent-dark);
            flex-shrink: 0;
        }

        .logo img {
            width:  48px;   /* mobile */
            height: 48px;
            background: #fff;
            flex-shrink: 0;
            display: block;
        }

        .logo-text { display: flex; flex-direction: column; }

        .logo-text .ta {
            font-family: var(--font-serif);
            font-size: 1.05rem;   /* mobile */
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1.15;
        }

        .logo-text .en {
            font-size: 0.62rem;
            color: var(--accent-muted);
            font-weight: 600;
        }

        .logo-text .meta {
            font-size: 0.58rem;
            color: var(--accent-muted);
        }

        /* ============================================================
           DESKTOP NAV  — hidden below 992px
        ============================================================ */
        .main-nav { display: none; }

        .main-nav ul {
            list-style: none;
            padding: 0; margin: 0;
            display: flex;
            gap: 0.15rem;
            align-items: center;
            flex-wrap: nowrap;
        }

        .main-nav li { position: relative; }

        .main-nav > ul > li > a,
        .main-nav > ul > li > .nav-link-btn {
            font-family: var(--font-serif);
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--accent-dark);
            text-decoration: none;
            padding: 0.45rem 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            border-radius: 8px;
            white-space: nowrap;
            transition: background 0.2s, outline 0.2s;
            cursor: pointer;
            background: none;
            border: none;
            line-height: 1.4;
        }

        .main-nav > ul > li > a:hover,
        .main-nav > ul > li > a:focus,
        .main-nav > ul > li > .nav-link-btn:hover,
        .main-nav > ul > li > .nav-link-btn:focus {
            background: var(--hover-bg);
            outline: 2px solid var(--accent-dark);
            outline-offset: 2px;
        }

        .main-nav > ul > li > a.active {
            background: var(--accent-dark);
            color: #fff;
        }

        /* chevron icon for desktop dropdown triggers */
        .main-nav .nav-chevron {
            font-size: 0.65rem;
            transition: transform 0.25s;
            pointer-events: none;
        }

        .dropdown-parent:hover .nav-chevron,
        .dropdown-parent:focus-within .nav-chevron {
            transform: rotate(180deg);
        }

        /* ---- DESKTOP DROPDOWN ---- */
        .dropdown-parent { position: relative; }

        .dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.13);
            min-width: 210px;
            padding: 0.4rem 0;
            display: none;
            z-index: 200;
            border: 1px solid rgba(15,37,64,0.07);
        }

        .dropdown a {
            font-family: var(--font-serif);
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--accent-dark);
            text-decoration: none;
            padding: 0.7rem 1.2rem;
            display: block;
            white-space: nowrap;
            transition: background 0.15s;
        }

        .dropdown a:hover,
        .dropdown a:focus {
            background: var(--hover-bg);
            outline: none;
        }

        .dropdown a.active {
            background: var(--accent-dark);
            color: #fff;
        }

        /* show on hover or keyboard focus-within */
        .dropdown-parent:hover .dropdown,
        .dropdown-parent:focus-within .dropdown {
            display: block;
        }

        /* ---- DESKTOP NAV RIGHT ACTIONS (optional search/cta) ---- */
        .nav-actions {
            display: none;  /* shown at 992px+ */
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        /* ============================================================
           MOBILE HAMBURGER BUTTON
        ============================================================ */
        .mobile-menu-btn {
            display: flex;          /* visible on mobile */
            align-items: center;
            justify-content: center;
            background: none;
            border: 2px solid var(--accent-dark);
            border-radius: 8px;
            padding: 0;
            cursor: pointer;
            min-width: 44px;
            min-height: 44px;
            width: 44px;
            height: 44px;
            color: var(--accent-dark);
            font-size: 1.15rem;
            transition: background 0.2s;
            flex-shrink: 0;
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
            width: min(310px, 88vw);
            height: 100dvh;
            background: #fff;
            z-index: 1300;
            padding: 0;
            overflow-y: auto;
            transition: right 0.32s cubic-bezier(0.4,0,0.2,1);
            display: flex;
            flex-direction: column;
        }
        .mobile-nav-drawer.open { right: 0; }

        /* Drawer header */
        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(15,37,64,0.08);
            /* background: var(--primary-bg); */
            flex-shrink: 0;
        }

        .drawer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--accent-dark);
        }

        .drawer-logo img { width: 100px; height: 80px; }

        .drawer-logo span {
            font-family: var(--font-serif);
            font-weight: 700;
            /* font-size: 0.95rem; */
              font-size: 1.3rem;
            line-height: 1.2;
        }

        .mobile-nav-close {
            background: none;
            border: 2px solid var(--accent-dark);
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            color: var(--accent-dark);
            min-width: 40px;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .mobile-nav-close:hover { background: var(--hover-bg); }

        /* Drawer body */
        .drawer-body {
            padding: 0.75rem 0;
            flex: 1;
            overflow-y: auto;
        }

        /* Single link item */
        .drawer-link {
            font-family: var(--font-serif);
            font-weight: 600;
            font-size: 1rem;
            color: var(--accent-dark);
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            min-height: 48px;
            transition: background 0.15s;
            border-left: 3px solid transparent;
        }

        .drawer-link:hover,
        .drawer-link:focus {
            background: var(--hover-bg);
            border-left-color: var(--accent-muted);
            outline: none;
        }

        .drawer-link.active {
            background: var(--accent-dark);
            color: #fff;
            border-left-color: var(--accent-dark);
        }

        /* Accordion group */
        .drawer-group {}

        .drawer-group-toggle {
            font-family: var(--font-serif);
            font-weight: 700;
            font-size: 1rem;
            color: var(--accent-dark);
            background: none;
            border: none;
            border-left: 3px solid transparent;
            padding: 0.8rem 1.5rem;
            width: 100%;
            text-align: left;
            cursor: pointer;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.15s;
        }

        .drawer-group-toggle:hover,
        .drawer-group-toggle:focus {
            background: var(--hover-bg);
            border-left-color: var(--accent-muted);
            outline: none;
        }

        .drawer-group-chevron {
            font-size: 0.7rem;
            transition: transform 0.25s;
        }

        .drawer-group-toggle[aria-expanded="true"] .drawer-group-chevron {
            transform: rotate(180deg);
        }

        .drawer-sub {
            display: none;
            background: rgba(15,37,64,0.03);
            border-left: 3px solid var(--accent-muted);
            margin-left: 1.5rem;
            margin-right: 0.75rem;
            border-radius: 0 0 6px 6px;
        }

        .drawer-sub.open { display: block; }

        .drawer-sub a {
            font-family: var(--font-serif);
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--accent-dark);
            text-decoration: none;
            padding: 0.65rem 1.1rem;
            display: block;
            min-height: 42px;
            transition: background 0.15s;
        }

        .drawer-sub a:hover,
        .drawer-sub a:focus {
            background: var(--hover-bg);
            outline: none;
        }

        .drawer-sub a.active {
            color: var(--accent-dark);
            font-weight: 700;
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
        @media (min-width: 992px) {
            .header-container  { padding: 0.75rem 1.5rem; }

            .logo img          { width: 80px; height: 80px; }
            .logo-text .ta     { font-size: 1.75rem; }

            /* Show desktop nav */
            .main-nav          { display: block; }

            /* Hide mobile hamburger */
            .mobile-menu-btn   { display: none; }

            .nav-actions       { display: flex; }

            main               { margin-top: 2.5rem; }

            .footer-content    { grid-template-columns: 2fr 1fr 1fr 1fr; }
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
    transition: opacity 0.4s ease, visibility 0.4s ease;
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

    <header role="banner">
        <div class="header-container">
            <div class="header-main">

                <!-- ── LOGO ── -->
                <a href="{{ route('client.home') }}" class="logo" aria-label="The Archives Home">
                    <img src="{{ asset('./images/newlogo.jpeg') }}"
                         alt="Tamil Bookshop Archives Logo"
                         width="100" height="100"
                         loading="eager">
                    <div class="logo-text">
                        <span class="ta">THE TIC <br>ARCHIVES</span>
                    </div>
                </a>

                <!-- ── DESKTOP NAVIGATION ── -->
                <nav class="main-nav" role="navigation" aria-label="Main navigation">
                    <ul>

                        <!-- Home -->
                        <li>
                            <a href="{{ route('client.home') }}"
                               class="{{ Route::is('client.home') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>

                        <!-- About (with dropdown) -->
                        <li class="dropdown-parent">
                            <a href="{{ route('client.about') }}"
                               class="{{ Route::is('client.about') ? 'active' : '' }}"
                               aria-haspopup="true">
                                About
                                <i class="fas fa-chevron-down nav-chevron" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown" role="menu">
                                <a href="{{ route('client.about') }}"
                                   class="{{ Route::is('client.about') ? 'active' : '' }}"
                                   role="menuitem">About TIC archive</a>
                                <a href="{{ route('client.archiving') }}"
                                   class="{{ Route::is('client.archiving') ? 'active' : '' }}"
                                   role="menuitem">Submit</a>
                                <a href="{{ route('client.committee') }}"
                                   class="{{ Route::is('client.committee') ? 'active' : '' }}"
                                   role="menuitem">Committee</a>
                                <a href="{{ route('client.technicalteam') }}"
                                    class="{{ Route::is('client.technicalteam') ? 'active' : '' }}"
                                    role="menuitem">Technical Team</a>
                            </div>
                        </li>

                        <!-- Archive Centre -->
                        <li>
                            <a href="{{ route('client.archivecentrecollection') }}"
                               class="{{ Route::is('client.archivecentrecollection') ? 'active' : '' }}">
                                Archive Centre
                            </a>
                        </li>

                        <!-- Exhibition -->
                        <li>
                            <a href="{{ route('client.heritage-centre') }} " class="{{ Route::is('client.heritage-centre') ? 'active' : '' }}">Exhibition</a>
                        </li>

                        <!-- Heritage Museum -->
                        <li>
                            <a href="{{ route('heritage.archive-centre') }}"class="{{ Route::is('heritage.archive-centre') ? 'active' : '' }}">Heritage Museum</a>
                        </li>

                        <!-- Join (with dropdown) -->
                        <li class="dropdown-parent">
                            <a href="#" aria-haspopup="true">
                                Join
                                <i class="fas fa-chevron-down nav-chevron" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown" role="menu">
                                <a href="{{ route('client.joinus') }}" role="menuitem">
                                    Membership
                                </a>
                                <a href="https://www.paypal.com/donate?hosted_button_id=YOUR_BUTTON_ID" role="menuitem" target="_blank">
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg"
                                        alt="Donate with PayPal"
                                        style="width:18px; height:auto; margin-right:6px; vertical-align:middle;">
                                    Donate
                                </a>
                            </div>
                        </li>

                        <!-- Shop -->
                        <li>
                            <a href="{{ route('client.publications') }}"
                               class="{{ Route::is('client.publications') ? 'active' : '' }}">
                                Shop
                            </a>
                        </li>

                        <!-- Contact -->
                        <li>
                            <a href="{{ route('client.contactus') }}"
                               class="{{ Route::is('client.contactus') ? 'active' : '' }}">
                                Contact
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /desktop nav -->

                <!-- ── MOBILE HAMBURGER BUTTON ── -->
                <button class="mobile-menu-btn"
                        id="mobileMenuBtn"
                        aria-label="Open navigation menu"
                        aria-expanded="false"
                        aria-controls="mobileNavDrawer">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>

            </div><!-- /header-main -->
        </div><!-- /header-container -->
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
    <nav class="mobile-nav-drawer"
         id="mobileNavDrawer"
         role="navigation"
         aria-label="Mobile navigation"
         aria-hidden="true">

        <!-- Drawer header -->
        <div class="drawer-header">
            <a href="{{ route('client.home') }}" class="drawer-logo" aria-label="Home">
                <img src="{{ asset('./images/newlogo.jpeg') }}" alt="" width="36" height="36">
                <span>THE ARCHIVES</span>
            </a>
            <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close navigation">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Drawer body -->
        <div class="drawer-body">

            <!-- Home -->
            <a href="{{ route('client.home') }}"
               class="drawer-link {{ Route::is('client.home') ? 'active' : '' }}">
                <i class="fas fa-home" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                Home
            </a>

            <!-- About accordion -->
            <div class="drawer-group">
                <button class="drawer-group-toggle"
                        aria-expanded="false"
                        aria-controls="drawerAbout">
                    <span>
                        <i class="fas fa-info-circle" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                        About
                    </span>
                    <i class="fas fa-chevron-down drawer-group-chevron" aria-hidden="true"></i>
                </button>
                <div class="drawer-sub" id="drawerAbout">
                    <a href="{{ route('client.about') }}"
                       class="{{ Route::is('client.about') ? 'active' : '' }}">About TIC archive</a>
                    <a href="{{ route('client.archiving') }}"
                       class="{{ Route::is('client.archiving') ? 'active' : '' }}">Submit</a>
                    <a href="{{ route('client.committee') }}"
                       class="{{ Route::is('client.committee') ? 'active' : '' }}">Committee</a>
                    <a href="{{ route('client.technicalteam') }}"
                       class="{{ Route::is('client.technicalteam') ? 'active' : '' }}">Technical Team</a>
                </div>
            </div>

            <div class="drawer-divider"></div>

            <!-- Archive Centre -->
            <a href="{{ route('client.archivecentrecollection') }}"
               class="drawer-link {{ Route::is('client.archivecentrecollection') ? 'active' : '' }}">
                <i class="fas fa-archive" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                Archive Centre
            </a>

            <!-- Exhibition -->
            <a href="{{ route('client.heritage-centre') }}"   class="drawer-link {{ Route::is('client.heritage-centre') ? 'active' : '' }}">
                <i class="fas fa-landmark" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                Exhibition
            </a>

            <!-- Heritage Museum -->
            <a href="{{ route('heritage.archive-centre') }}" class="drawer-link">
                <i class="fas fa-building-columns" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                Heritage Museum
            </a>

            <div class="drawer-divider"></div>

           <!-- Join accordion -->
<div class="drawer-group">
    <button class="drawer-group-toggle"
            aria-expanded="false"
            aria-controls="drawerJoin">
        <span>
            <i class="fas fa-users" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
            Join
        </span>
        <i class="fas fa-chevron-down drawer-group-chevron" aria-hidden="true"></i>
    </button>
    <div class="drawer-sub" id="drawerJoin">
        <a href="{{ route('client.joinus') }}">Membership</a>

        <!-- Donate link with PayPal icon -->
        <a href="https://www.paypal.com/donate?hosted_button_id=YOUR_BUTTON_ID" target="_blank">
            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg"
                 alt="Donate with PayPal"
                 style="width:20px;height:auto;margin-right:6px;vertical-align:middle;">
            Donate
        </a>
    </div>
</div>

            <div class="drawer-divider"></div>

            <!-- Shop -->
            <a href="{{ route('client.publications') }}"
               class="drawer-link {{ Route::is('client.publications') ? 'active' : '' }}">
                <i class="fas fa-shop" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                Shop
            </a>

            <!-- Contact -->
            <a href="{{ route('client.contactus') }}"
               class="drawer-link {{ Route::is('client.contactus') ? 'active' : '' }}">
                <i class="fas fa-envelope" style="width:18px;margin-right:10px;opacity:0.6" aria-hidden="true"></i>
                Contact
            </a>

        </div><!-- /drawer-body -->

        <!-- Drawer footer CTA -->
        <div class="drawer-footer">
            <a href="{{ route('client.contactus') }}">Get in Touch &rarr;</a>
        </div>

    </nav><!-- /mobile-nav-drawer -->

    <!-- ================================================================
         MAIN CONTENT
    ================================================================ -->
    <main id="main-content" role="main">
        <div class="container">
            @yield('content')
        </div>
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
        if(session('success'))
            toastr.success("{{ session('success') }}");
        endif

        if(session('error'))
            toastr.error("{{ session('error') }}");
        endif

        if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        endif

        if(session('info'))
            toastr.info("{{ session('info') }}");
        endif
    </script>

    <script> 
    
    window.addEventListener('load', function () {
        const loader = document.getElementById('page-loader');
        if (!loader) return;

        loader.classList.add('hidden');

        setTimeout(() => {
            loader.remove(); // optional but keeps DOM clean
        }, 500);
    });

    (function () {
        'use strict';

        /* ── Elements ── */
        const hamburger = document.getElementById('mobileMenuBtn');
        const overlay   = document.getElementById('mobileNavOverlay');
        const drawer    = document.getElementById('mobileNavDrawer');
        const closeBtn  = document.getElementById('mobileNavClose');

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

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && drawer.classList.contains('open')) {
                closeDrawer();
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