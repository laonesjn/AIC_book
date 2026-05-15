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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Cinzel:wght@400;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">


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
        /* ============================================================
           NEW HEADER STYLE (From welcome.blade.php)
        ============================================================ */
        header[role="banner"] {
          background: rgba(10, 5, 2, 0.85); /* Slightly more opaque for better contrast on inner pages */
          padding: 0 60px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          height: 62px;
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          width: 100%;
          z-index: 1000;
          border-bottom: 1px solid rgba(196, 168, 122, 0.2);
        }

        .nav-logo-text {
          font-family: 'Playfair Display', serif;
          font-size: 20px;
          font-weight: 700;
          color: #f5e8d0;
          letter-spacing: 0.04em;
          white-space: nowrap;
          text-decoration: none;
        }

        .nav-links {
          display: flex;
          align-items: center;
          gap: 18px;
          list-style: none;
          margin: 0;
          padding: 0;
        }

        .nav-links a {
          color: #d4c4a8;
          text-decoration: none;
          font-size: 13.5px;
          font-weight: 400;
          padding: 8px 12px;
          transition: color 0.2s;
        }

        .nav-links a:hover {
          color: #fff;
        }

        .nav-links a.active {
          color: #ffffff;
          border-bottom: 2px solid #ffffff;
          padding-bottom: 4px;
        }

        .nav-right {
          display: flex;
          align-items: center;
          gap: 16px;
          flex-shrink: 0;
        }

        /* Dropdown Styles */
        .nav-links li {
          position: relative;
        }

        .dropdown-menu {
          position: absolute;
          top: 100%;
          left: 0;
          background: rgba(10, 5, 2, 0.95);
          border: 1px solid rgba(196, 168, 122, 0.2);
          list-style: none;
          min-width: 180px;
          display: none;
          flex-direction: column;
          padding: 8px 0;
          z-index: 1000;
        }

        .nav-links li:hover .dropdown-menu {
          display: flex;
        }

        .dropdown-menu li a {
          padding: 10px 20px;
          font-size: 13px;
          display: block;
          white-space: nowrap;
          border-bottom: none !important;
        }

        .dropdown-menu li a:hover {
          background: rgba(196, 168, 122, 0.1);
        }

        .nav-search-btn {
          background: none;
          border: none;
          cursor: pointer;
          color: #d4c4a8;
          padding: 15px;
          line-height: 0;
          transition: color 0.2s;
        }

        .nav-search-btn:hover {
          color: #fff;
        }

        /* ─── SEARCH BAR ─── */
        .search-bar {
          position: fixed;
          top: 62px;
          left: 0;
          right: 0;
          background: rgba(10, 5, 2, 0.95);
          border-bottom: 1px solid rgba(196, 168, 122, 0.3);
          padding: 12px 60px;
          display: flex;
          align-items: center;
          gap: 12px;
          z-index: 999;
          transform: translateY(-110%);
          opacity: 0;
          transition: transform 0.3s ease, opacity 0.3s ease;
          pointer-events: none;
        }

        .search-bar.open {
          transform: translateY(0);
          opacity: 1;
          pointer-events: all;
        }

        .search-bar input {
          flex: 1;
          background: rgba(255, 255, 255, 0.08);
          border: 1px solid rgba(196, 168, 122, 0.35);
          border-radius: 4px;
          padding: 9px 16px;
          color: #f5e8d0;
          font-size: 15px;
          font-family: 'Lato', sans-serif;
          outline: none;
          transition: border-color 0.2s;
        }

        .search-bar input::placeholder {
          color: rgba(196, 168, 122, 0.55);
        }

        .search-bar input:focus {
          border-color: rgba(196, 168, 122, 0.7);
        }

        .search-close-btn {
          background: none;
          border: none;
          cursor: pointer;
          color: #d4c4a8;
          padding: 8px;
          line-height: 0;
          transition: color 0.2s;
          flex-shrink: 0;
        }

        .search-close-btn:hover {
          color: #fff;
        }

        .nav-hamburger {
          display: none;
          background: none;
          border: none;
          cursor: pointer;
          flex-direction: column;
          gap: 5px;
          padding: 4px;
        }

        .nav-hamburger span {
          display: block;
          width: 22px;
          height: 2px;
          background: #d4c4a8;
          border-radius: 2px;
          transition: transform 0.3s, opacity 0.3s;
        }

        .nav-hamburger.open span:nth-child(1) {
          transform: translateY(7px) rotate(45deg);
        }

        .nav-hamburger.open span:nth-child(2) {
          opacity: 0;
        }

        .nav-hamburger.open span:nth-child(3) {
          transform: translateY(-7px) rotate(-45deg);
        }

        @media (max-width: 900px) {
          header[role="banner"] {
            padding: 0 20px;
          }

          .search-bar {
            padding: 10px 20px;
          }

          .nav-links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 62px;
            left: 0;
            right: 0;
            background: rgba(10, 5, 2, 0.97);
            padding: 12px 20px 20px;
            gap: 2px;
            border-bottom: 1px solid rgba(196, 168, 122, 0.2);
            z-index: 99;
          }

          .nav-links.open {
            display: flex;
          }

          .nav-links a {
            padding: 10px 8px;
            font-size: 14px;
          }

          .nav-links a.active {
            border-bottom: none;
            border-left: 2px solid #fff;
            padding-left: 10px;
          }

          /* Mobile Dropdowns */
          .dropdown-menu {
            position: static;
            display: flex;
            background: transparent;
            border: none;
            padding: 0 0 0 15px;
            min-width: auto;
          }

          .nav-links li:hover .dropdown-menu {
            display: flex;
          }

          .nav-hamburger {
            display: flex;
          }
        }

        /* ============================================================
           MAIN CONTENT
        ============================================================ */
        main {
            margin-top: 62px;
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
            .footer-content   { grid-template-columns: repeat(2, 1fr); }
        }

        /* ============================================================
           DESKTOP  992px+  — show desktop nav, hide mobile btn
        ============================================================ */
        @media (min-width: 992px) {
            .footer-content    { grid-template-columns: 2fr 1fr 1fr 1fr; }
        }

        /* ============================================================
           LARGE DESKTOP  1200px+
        ============================================================ */
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

    <header role="banner">
        <a href="{{ route('client.home') }}" class="nav-logo-text">THE TIC ARCHIVES</a>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('client.home') }}" class="{{ request()->routeIs('client.home') ? 'active' : '' }}">Home</a></li>
            <li class="dropdown">
                <a href="{{ route('client.about') }}" class="{{ request()->routeIs('client.about', 'client.committee', 'client.technicalteam') ? 'active' : '' }}">About ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('client.about') }}">About Us</a></li>
                    <li><a href="{{ route('client.archiving') }}">Submit</a></li>
                    <li><a href="{{ route('client.committee') }}">Committee</a></li>
                    <li><a href="{{ route('client.technicalteam') }}">Technical Team</a></li>
                </ul>
            </li>
            <li><a href="{{ route('client.archivecentrecollection') }}" class="{{ request()->routeIs('client.archivecentrecollection') ? 'active' : '' }}">Archive Centre</a></li>
            <li><a href="{{ route('client.heritage-centre') }}" class="{{ request()->routeIs('client.heritage-centre') ? 'active' : '' }}">Exhibition</a></li>
            <li><a href="{{ route('heritage.archive-centre') }}" class="{{ request()->routeIs('heritage.archive-centre') ? 'active' : '' }}">Heritage Museum</a></li>
            <li class="dropdown">
                <a href="{{ route('client.joinus') }}" class="{{ request()->routeIs('client.joinus') ? 'active' : '' }}">Join ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('client.joinus') }}">Member Application</a></li>
                    <li><a href="{{ route('client.joinus') }}#volunteer-section">Become a Volunteer</a></li>
                </ul>
            </li>
            <li><a href="{{ route('client.publications') }}" class="{{ request()->routeIs('client.publications') ? 'active' : '' }}">Shop</a></li>
            <li><a href="{{ route('client.contactus') }}" class="{{ request()->routeIs('client.contactus') ? 'active' : '' }}">Contact</a></li>
        </ul>
        <div class="nav-right">
            <button class="nav-search-btn" id="searchToggle" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="6" stroke="#d4c4a8" stroke-width="2" />
                    <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="#d4c4a8" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
            <button class="nav-hamburger" id="hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <form action="{{ route('search.results') }}" method="GET" class="search-bar" id="searchBar">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;opacity:0.5;">
            <circle cx="11" cy="11" r="6" stroke="#d4c4a8" stroke-width="2" />
            <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="#d4c4a8" stroke-width="2" stroke-linecap="round" />
        </svg>
        <input type="text" name="q" id="searchInput" placeholder="Search the archives…" autocomplete="off" required>
        <button type="button" class="search-close-btn" id="searchClose" aria-label="Close search">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <line x1="5" y1="5" x2="19" y2="19" stroke="#d4c4a8" stroke-width="2" stroke-linecap="round" />
                <line x1="19" y1="5" x2="5" y2="19" stroke="#d4c4a8" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </form>



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

        // Nav and Search logic (From welcome.blade.php)
        var hamburger = document.getElementById('hamburger');
        var navLinks = document.getElementById('navLinks');
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', function () {
              var isOpen = navLinks.classList.toggle('open');
              hamburger.classList.toggle('open', isOpen);
            });
        }

        var searchToggle = document.getElementById('searchToggle');
        var searchBar = document.getElementById('searchBar');
        var searchClose = document.getElementById('searchClose');
        var searchInput = document.getElementById('searchInput');

        if (searchToggle) {
            searchToggle.addEventListener('click', function () {
              searchBar.classList.add('open');
              setTimeout(function () { searchInput.focus(); }, 50);
            });
        }

        if (searchClose) {
            searchClose.addEventListener('click', function () {
              searchBar.classList.remove('open');
              searchInput.value = '';
            });
        }

        document.addEventListener('keydown', function (e) {
          if (searchBar && e.key === 'Escape' && searchBar.classList.contains('open')) {
            searchBar.classList.remove('open');
            searchInput.value = '';
          }
        });
    </script>

    <!-- intl-tel-input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/intlTelInput.min.js"></script>

    @yield('modal')
    @yield('scripts')

</body>
</html>