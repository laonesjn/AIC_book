@extends('layouts.masterclient')

@section('title', 'Tamil Bookshop Archives - Preserving Tamil Heritage Since 1983')

@section('meta_description', 'Explore the Tamil Bookshop Archives featuring rare books, historical documents, cultural exhibitions, and Tamil heritage collections from Sri Lanka and the Tamil diaspora.')

<style>
    /* Update the font family in your CSS variables */
:root {
    --primary-bg: #f6e3c5;
    --accent-dark: #0f2540;
    --accent-muted: #bfa98b;
    --card-bg: #f6ece0;
    --hover-bg: #e6d3bd;
    --border-radius: 12px;
    /* Added the requested Font Stack here */
    --font-serif: "Georgia", "Times New Roman", serif;
}

body {
    /* Apply the serif font to the whole body */
    font-family: "Georgia", "Times New Roman", serif;
    background-color: var(--primary-bg);
    color: var(--accent-dark);
    line-height: 1.2;
    -webkit-font-smoothing: antialiased;
    user-select: none; 
}


/* Optional: Headings styling */
h1, h2, h3, h4, h5, h6 {
    font-family: "Georgia", "Times New Roman", serif;
}

/* Optional: Paragraph, span, li */
p, span, li {
    font-family: "Georgia", "Times New Roman", serif;
}




/* Make headings stand out with the serif style */
h1, h2, h3 {
    font-family: var(--font-serif);
    font-weight: 700;
}

        /* Skip to content link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: var(--accent-dark);
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            z-index: 9999;
            border-radius: 0 0 4px 0;
        }

        .skip-link:focus {
            top: 0;
            outline: 3px solid #ffd700;
        }



        /* Desktop Navigation - Show at 768px and above */
        @media (min-width: 768px) {
            .main-nav {
                display: block;
            }

            .mobile-menu-btn {
                display: none;
            }

           
        }

      

    /* Hero Section */
    .hero-section {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin: 1.5rem 0 2.5rem;
        align-items: center;
    }


    .hero-content h1 {
        font-size: 1rem;
        font-weight: 200;
        line-height: 1;
        color: var(--accent-dark);
        margin-bottom: 0.875rem;
        
    }

    .hero-content p {
        font-size: 0.50rem;
        color: #243447;
        margin-bottom: 1.25rem;
        line-height: 1.6;
    }

    /* Search Box */
    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid rgba(15, 37, 64, 0.2);
        border-radius: 12px;
        max-width: 100%;
        margin-top: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .search-box input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.95rem;
        padding: 0.875rem 1rem;
        background: transparent;
        min-width: 0;
    }

    .search-box button {
        background: transparent;
        color: #000;
        border: none;
        padding: 0.875rem 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .search-box button:hover,
    .search-box button:focus {
        background: rgba(15, 37, 64, 0.05);
        outline: 2px solid var(--accent-dark);
        outline-offset: -2px;
    }

    .search-box svg {
        width: 20px;
        height: 20px;
    }
/* Hero Image */
.hero-image {
    display: flex;
    align-items: flex-end; 
    justify-content: flex-end;
    width: 100%;
    height: 450px; 
    overflow: visible; 
}



.hero-image-content {
    width: 110%;
    height: auto;
    object-fit: cover;
}
.hero-video-wrap {
  width: 100%;
  height: 100%;
  overflow: hidden;     
  background: transparent;
}

#hero-vid {
  width: 100%;
  height: 100%;
  border: none;
  outline: none;
  box-shadow: none;
  background: transparent;
  display: block;
}


    /* Section Titles */
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 2.5rem 0 1.25rem;
        color: var(--accent-dark);
    }

    /* Featured Collections Grid */
    .featured-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }

    .featured-card {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.4));
        /* border-radius: 12px; */
        border: 1px solid rgba(15, 37, 64, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .featured-card:hover {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.55));
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .featured-card:focus-within {
        outline: 3px solid var(--accent-dark);
        outline-offset: 2px;
    }

   .card-thumb {
  width: 100%;
  overflow: hidden;
  background: transparent;
}

.card-thumb img {
  width: 100%;
  height: auto;         
  display: block;        
}



    .featured-card-content {
        padding: 2rem;
    }

    .featured-card h3 {
        font-size: 1.125rem;
        /* text-align: center; */
        font-weight: 700;
        margin-bottom: 0.875rem;
        color: var(--accent-dark);
    }

    .explore-btn {
        display: inline-block;
        padding: 0.5rem 0.5rem;
        border: 2px solid var(--accent-dark);
        background: transparent;
        color: var(--accent-dark);
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .explore-btn:hover,
    .explore-btn:focus {
        background: var(--accent-dark);
        color: white;
        transform: translateX(4px);
        outline: 2px solid #ffd700;
        outline-offset: 2px;
    }

    /* New Items Grid */
    .new-items-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }

    .new-item-card {
        background: rgba(255, 255, 255, 0.4);
        /* border-radius: 12px; */
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .new-item-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .new-item-image {
        width: 100%;
        height: 160px;
        overflow: hidden;
        background: linear-gradient(135deg, #d4c5b5 0%, #bfa98b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .new-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .new-item-meta {
        padding: 1rem;
        text-align: center;
    }

    .new-item-meta strong {
        display: block;
        font-size: 1rem;
        color: var(--accent-dark);
        margin-bottom: 0.75rem;
    }

    /* Call to Action */
    .cta-section {
        background: var(--accent-dark);
        color: white;
        padding: 1.75rem;
        /* border-radius: 12px; */
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin: 2.5rem 0;
    }

    .cta-content {
        flex: 1;
    }

    .cta-content h2 {
        font-size: 1.375rem;
        font-weight: 700;
        margin-bottom: 0.625rem;
        line-height: 1.3;
    }

    .cta-content p {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.6;
        opacity: 0.95;
    }

    .cta-btn {
        background: var(--card-bg);
        color: var(--accent-dark);
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        align-self: flex-start;
        text-align: center;
    }

    .cta-btn:hover,
    .cta-btn:focus {
        background: white;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        outline: 2px solid #ffd700;
        outline-offset: 2px;
    }

    /* Responsive Design - Mobile First */
    
    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {
        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .hero-image {
            height: 250px;
        }

        .search-box {
            max-width: 500px;
        }

        .search-box input {
            font-size: 1rem;
            padding: 1rem;
        }

        .search-box button {
            padding: 1rem 1.125rem;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .featured-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .new-items-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .card-thumb {
            height: 200px;
        }

        .new-item-image {
            height: 180px;
        }

        .featured-card h3 {
            font-size: 1.2rem;
        }

        .cta-section {
            padding: 2rem;
        }

        .cta-content p {
            font-size: 1rem;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .hero-section {
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            margin: 2rem 0 3rem;
        }

        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-content p {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .hero-image {
            height: 100%;
            min-height: 300px;
        }

        .search-box {
            max-width: 550px;
            margin-top: 1.5rem;
        }

        .section-title {
            font-size: 2rem;
            margin: 3rem 0 1.5rem;
        }

        .featured-grid {
            gap: 1.75rem;
        }

        .new-items-grid {
            gap: 1.75rem;
        }

        .card-thumb {
            height: 220px;
        }

        .new-item-image {
            height: 200px;
        }

        .featured-card h3 {
            font-size: 1.25rem;
        }

        .new-item-meta strong {
            font-size: 1.1rem;
        }

        .explore-btn {
            font-size: 0.95rem;
            padding: 0.6rem 1.125rem;
        }

        .cta-section {
            gap: 1.5rem;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .hero-section {
            grid-template-columns: 1.0fr 0.8fr;
            gap: 3rem;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-image {
            min-height: 350px;
        }

        .search-box {
            max-width: 600px;
        }

        .featured-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .new-items-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .card-thumb {
            height: 200px;
        }

        .new-item-image {
            height: 180px;
        }

        .cta-section {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 2.5rem 3rem;
        }

        .cta-content h2 {
            font-size: 1.75rem;
        }

        .cta-btn {
            align-self: center;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .hero-content h1 {
            font-size: 3.0rem;
        }

        .hero-image {
            min-height: 380px;
        }

        .card-thumb {
            height: 220px;
        }

        .new-item-image {
            height: 200px;
        }
    }

    /* Extra small devices adjustments */
    @media (max-width: 375px) {
        .hero-content h1 {
            font-size: 1.5rem;
        }

        .hero-content p {
            font-size: 0.875rem;
        }

        .hero-image {
            height: 200px;
        }

        .section-title {
            font-size: 1.375rem;
        }

        .featured-card h3,
        .new-item-meta strong {
            font-size: 1rem;
        }

        .explore-btn {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
        }

        .cta-content h2 {
            font-size: 1.25rem;
        }

        .cta-content p {
            font-size: 0.875rem;
        }
    }

/* Desktop Navigation - Show at 768px and above */
@media (min-width: 768px) {
    .main-nav {
        display: block;
    }

    .mobile-menu-btn {
        display: none;
    }
}


.featured-card {
    cursor: pointer;
}







@keyframes pulse {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(1.5); opacity: 0; }
}

/* ===============================
   FEATURED COLLECTIONS – MOBILE ROW (NO SWIPER)
   =============================== */
@media (max-width: 640px) {

  .featured-grid {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: minmax(220px, 1fr);
    gap: 12px;
    overflow-x: auto;
    padding: 0 8px 12px;
  }

  .featured-grid::-webkit-scrollbar {
    display: none;
  }

  .featured-card {
    border-radius: 10px;
  }

  /* image small – no big image */
  .featured-card .card-thumb img {
    height: 130px;
    object-fit: cover;
  }

  /* compact content */
  .featured-card-content {
    padding: 10px;
  }

  .featured-card-content h3 {
    font-size: 14.5px;
    line-height: 1.3;
    margin-bottom: 6px;
  }

  .featured-card .explore-btn {
    font-size: 13px;
    padding: 6px 12px;
  }
}
@media (max-width: 640px) {
  .featured-grid {
    grid-auto-columns: 70%;
  }
}
/* ===============================
   FEATURED COLLECTIONS – MOBILE (SMALLER CARDS)
   =============================== */
@media (max-width: 640px) {

  .featured-grid {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: 32%;
    gap: 10px;
    overflow-x: auto;
    padding: 0 6px 10px;
  }

  .featured-grid::-webkit-scrollbar {
    display: none;
  }

  .featured-card {
    border-radius: 8px;
  }

  /* image VERY small */
  .featured-card .card-thumb img {
    height: 95px;
    object-fit: cover;
  }

  /* compact content */
  .featured-card-content {
    padding: 6px;
  }

  .featured-card-content h3 {
    font-size: 12px;
    line-height: 1.25;
    margin-bottom: 4px;
  }

  .featured-card .explore-btn {
    font-size: 11px;
    padding: 4px 8px;
  }
}
@media (max-width: 640px) {
  .featured-grid {
    width: 100%;
    box-sizing: border-box;
  }
}@media (max-width: 640px) {

  .featured-grid {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: 32%;
    gap: 10px;
    overflow-x: auto;
    padding: 0 6px 10px;
    align-items: stretch;          /* ← added */
  }

  .featured-card {
    display: flex;
    flex-direction: column;
    height: 100%;                  /* ← very important */
    border-radius: 8px;
  }

  .featured-card-content {
    padding: 6px;
    margin-top: auto;              /* ← pushes button to bottom */
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .featured-card .explore-btn {
    margin-top: auto;              /* extra safety */
    align-self: flex-start;        /* or center / stretch – your choice */
    font-size: 11px;
    padding: 4px 8px;
  }

}
/* ===============================
   CTA SECTION – FORCE ROW (MOBILE)
   =============================== */
@media (max-width: 640px) {

  .cta-section {
    display: flex;
    flex-direction: row;
    align-items: center;           /* vertically centers button with text */
    justify-content: space-between;
    gap: 12px;
    padding: 12px 10px;            /* optional – better spacing on small screens */
  }

  .cta-content {
    flex: 1 1 auto;
    text-align: justify;           /* makes text nicely spread / justified */
    hyphens: auto;                 /* optional: better line breaks in Tamil/English mix */
  }

  .cta-content h2 {
    margin: 0 0 4px 0;
    line-height: 1.3;
  }

  .cta-content p {
    font-size: 12.5px;
    margin: 0;
    line-height: 1.35;
  }

  .cta-btn {
    /* Centers button vertically relative to text block */
    align-self: center;
    
    /* Looks better centered/compact on mobile */
    white-space: nowrap;
    font-size: 12px;
    padding: 6px 14px;           /* slightly wider padding → nicer touch target */
    margin-left: 8px;             /* small breathing space from text */

    /* Optional: make it feel more "button-like" */
    flex-shrink: 0;
  }

 
}

@media (max-width: 768px) {
    .hero-section p {
        text-align: justify;    /* justify text */
        font-size: 1rem;        /* increase font size for mobile */
        line-height: 1.2;       /* optional: make text more readable */
    }

    .hero-section h1 {
        text-align: justify;    /* justify text */
        font-size: 1.2rem;        /* increase font size for mobile */
        line-height: 1.4;       /* optional: make text more readable */
    }
}
</style>

@section('content')
    <!-- Main Content -->

  
        <div class="container">
            <section class="hero-section">
    <div class="hero-content">
        <h1>"An archive committed to preserving and celebrating the histories,heritage,
            culture, and human rights of Tamil-speaking people in Sri Lanka" </h1>
        <p><i>- A  secure digital archive preserving affidavits,documents,Photographs,
            Recorded testimonies that bear witness to history,heritage,human rights -</p></i>

        
    {{--
    DROP-IN REPLACEMENT for your homepage search-box <form> block.
    Searches: Collections · Exhibitions · Heritage · Publications
--}}

<div class="search-wrapper" style="position:relative; max-width:600px; margin-top:1rem;">

    <form class="search-box" action="{{ route('search.results') }}" method="GET"
          role="search" autocomplete="off" id="global-search-form">
        <input
            type="search"
            name="q"
            id="global-search-input"
            placeholder="Search collections, exhibitions, publications..."
            aria-label="Search archive collection"
            aria-autocomplete="list"
            aria-controls="search-dropdown"
            aria-expanded="false"
            minlength="2"
            maxlength="100">

        <button type="submit" aria-label="Search">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" fill="none"/>
            </svg>
        </button>
    </form>

    {{-- Live dropdown --}}
    <div id="search-dropdown"
         role="listbox"
         aria-label="Search suggestions"
         style="
            display:none;
            position:absolute;
            top:calc(100% + 6px);
            left:0; right:0;
            background:#fff;
            border:1.5px solid rgba(15,37,64,0.15);
            border-radius:12px;
            box-shadow:0 8px 24px rgba(0,0,0,0.12);
            z-index:9999;
            overflow:hidden;
            max-height:420px;
            overflow-y:auto;
         ">
    </div>
</div>

{{-- ── Dropdown styles ─────────────────────────────────────────────────────── --}}
<style>
.sdrop-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 14px;
    cursor: pointer;
    text-decoration: none;
    color: #0f2540;
    transition: background 0.12s;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
.sdrop-item:last-of-type { border-bottom: none; }
.sdrop-item:hover, .sdrop-item:focus, .sdrop-item.active {
    background: #f6ece0;
    outline: none;
}

/* Thumbnail */
.sdrop-thumb {
    width: 42px; height: 42px;
    border-radius: 7px;
    object-fit: cover;
    flex-shrink: 0;
    background: #e6d3bd;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
}
.sdrop-thumb img {
    width: 42px; height: 42px;
    border-radius: 7px;
    object-fit: cover;
}

/* Text */
.sdrop-info { flex:1; min-width:0; }
.sdrop-title {
    font-size: 0.875rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sdrop-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 2px;
}
.sdrop-type {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #bfa98b;
}
.sdrop-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 20px;
    background: #fff3cd;
    color: #856404;
}
.sdrop-badge.free {
    background: #d4edda;
    color: #155724;
}

/* Status & footer */
.sdrop-status {
    padding: 13px 16px;
    font-size: 0.875rem;
    color: #666;
    text-align: center;
}
.sdrop-footer {
    padding: 9px 14px;
    border-top: 1px solid rgba(0,0,0,0.07);
    text-align: center;
}
.sdrop-footer a {
    font-size: 0.8rem;
    font-weight: 600;
    color: #0f2540;
    text-decoration: none;
    opacity: 0.65;
}
.sdrop-footer a:hover { opacity:1; text-decoration:underline; }

/* Section separators inside dropdown */
.sdrop-section-label {
    padding: 6px 14px 4px;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #aaa;
    background: #fafafa;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}
</style>

{{-- ── JavaScript ───────────────────────────────────────────────────────────── --}}
<script>
(function () {
    const input    = document.getElementById('global-search-input');
    const dropdown = document.getElementById('search-dropdown');
    const form     = document.getElementById('global-search-form');
    const liveUrl  = '{{ route("search.live") }}';

    const typeIcons = {
        Collection:  '📚',
        Exhibition:  '🏛️',
        Heritage:    '🏺',
        Publication: '📖',
    };

    let debounceTimer = null;
    let currentIndex  = -1;
    let currentQuery  = '';
    let controller    = null;

    // ── helpers ───────────────────────────────────────────────────────────────

    const showDrop = () => { dropdown.style.display = 'block'; input.setAttribute('aria-expanded','true'); };
    const hideDrop = () => { dropdown.style.display = 'none';  input.setAttribute('aria-expanded','false'); currentIndex = -1; };

    function setStatus(html) {
        dropdown.innerHTML = `<div class="sdrop-status">${html}</div>`;
        showDrop();
    }

    function escHtml(str) {
        const d = document.createElement('div');
        d.textContent = String(str ?? '');
        return d.innerHTML;
    }

    // ── render ────────────────────────────────────────────────────────────────

    function renderResults(results, query) {
        if (!results.length) { setStatus('No results found.'); return; }

        dropdown.innerHTML = '';

        // Group by type to show section labels
        const grouped = {};
        results.forEach(item => {
            if (!grouped[item.type]) grouped[item.type] = [];
            grouped[item.type].push(item);
        });

        let itemIdx = 0;

        Object.entries(grouped).forEach(([type, items]) => {
            // Section label
            const label = document.createElement('div');
            label.className   = 'sdrop-section-label';
            label.textContent = type + 's';
            dropdown.appendChild(label);

            items.forEach(item => {
                const a = document.createElement('a');
                a.className    = 'sdrop-item';
                a.href         = item.url;
                a.role         = 'option';
                a.dataset.idx  = itemIdx++;
                a.tabIndex     = -1;

                // Thumbnail
                const imageSrc = item.image
  ? (item.image.startsWith('http://') || item.image.startsWith('https://')
      ? item.image
      : `/storage/${item.image}`)
  : null;

const thumbHtml = imageSrc
  ? `<div class="sdrop-thumb">
        <img src="${escHtml(imageSrc)}" alt="" loading="lazy">
     </div>`
  : `<div class="sdrop-thumb">${typeIcons[item.type] ?? '📄'}</div>`;

                // Price badge (Publications only)
                let badgeHtml = '';
                if (item.badge) {
                    const isFree = item.badge === 'Free';
                    badgeHtml = `<span class="sdrop-badge ${isFree ? 'free' : ''}">${escHtml(item.badge)}</span>`;
                }

                a.innerHTML = `
                    ${thumbHtml}
                    <div class="sdrop-info">
                        <div class="sdrop-title">${escHtml(item.label)}</div>
                        <div class="sdrop-meta">
                            <span class="sdrop-type">${escHtml(item.type)}</span>
                            ${badgeHtml}
                        </div>
                    </div>`;

                a.addEventListener('mousedown', e => {
                    e.preventDefault();
                    window.location.href = item.url;
                });

                dropdown.appendChild(a);
            });
        });

        // Footer: see all results
        const footer = document.createElement('div');
        footer.className = 'sdrop-footer';
        footer.innerHTML = `<a href="{{ route('search.results') }}?q=${encodeURIComponent(query)}">See all results →</a>`;
        dropdown.appendChild(footer);

        showDrop();
        currentIndex = -1;
    }

    // ── fetch ─────────────────────────────────────────────────────────────────

    async function fetchResults(query) {
        if (controller) controller.abort();
        controller = new AbortController();

        try {
            const resp = await fetch(`${liveUrl}?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                signal: controller.signal,
            });
            if (!resp.ok) throw new Error('error');
            const data = await resp.json();
            renderResults(data.results ?? [], query);
        } catch (err) {
            if (err.name === 'AbortError') return;
            setStatus('Search unavailable. Please try again.');
        }
    }

    // ── input / debounce ─────────────────────────────────────────────────────

    input.addEventListener('input', function () {
        const val = this.value.trim();
        clearTimeout(debounceTimer);
        if (val.length < 2) { hideDrop(); return; }
        if (val === currentQuery) return;
        currentQuery = val;
        setStatus('<span style="opacity:.45">Searching…</span>');
        debounceTimer = setTimeout(() => fetchResults(val), 320);
    });

    // ── keyboard navigation ──────────────────────────────────────────────────

    input.addEventListener('keydown', function (e) {
        const items = [...dropdown.querySelectorAll('.sdrop-item')];
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentIndex = Math.min(currentIndex + 1, items.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentIndex = Math.max(currentIndex - 1, 0);
        } else if (e.key === 'Escape') {
            hideDrop(); input.blur(); return;
        } else if (e.key === 'Enter' && currentIndex >= 0) {
            e.preventDefault();
            items[currentIndex].dispatchEvent(new MouseEvent('mousedown'));
            return;
        } else { return; }

        items.forEach((el, i) => el.classList.toggle('active', i === currentIndex));
        if (items[currentIndex]) items[currentIndex].focus();
    });

    // ── close on outside click ────────────────────────────────────────────────

    document.addEventListener('click', e => {
        if (!form.parentElement.contains(e.target)) hideDrop();
    });

    input.addEventListener('focus', function () {
        if (this.value.trim().length >= 2) showDrop();
    });

})();
</script>
    </div>


<div class="hero-image">
    <img id="hero-img" class="hero-image-content" 
         src="./images/TIC.jfif"
         alt="Tamil heritage image">

    <video id="hero-vid" class="hero-image-content" style="display: none;" muted loop>
        <source src="image/Tamil TIC   promo 2023 final.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
</section>




<!-- Featured Collections Section -->
<h2 class="section-title">Featured Collections</h2>
<section class="featured-grid">
    <article class="featured-card" tabindex="0" data-link="./collections.html">
        <div class="card-thumb">
            <img src="./images/collection.jpg"
                 alt="Archive Centre collection"
                 draggable="false"
                 ondragstart="return false;"
                 loading="lazy" />
        </div>
        <div class="featured-card-content">
            <h3>Discover the Collections</h3>
            <a href="{{ route('client.discoverourcollection') }}" class="explore-btn">Explore</a>
        </div>
    </article>


<article class="featured-card" tabindex="0" data-link="./exhibition.html">
    <div class="card-thumb">
        <img src="./images/exhibition.png"
             alt="ToL Exhibition"
             draggable="false" ondragstart="return false;"
             loading="lazy" />
    </div>
    <div class="featured-card-content">
        <h3>Explore the Exhibition</h3>
        <a href="{{ route('client.explorexhibition') }}" class="explore-btn">Explore</a>
    </div>
</article>

<article class="featured-card" tabindex="0" data-link="./Heritage Hub.html">
    <div class="card-thumb">
        <img src="./images/heritage.png"
             alt="Heritage Hub"
             draggable="false" ondragstart="return false;"
             loading="lazy" />
    </div>
    <div class="featured-card-content">
        <h3>Explore the Heritage Museum</h3>
        <a href="{{ route('heritage.discover') }}" class="explore-btn">Explore</a>
    </div>
</article>
</section>

<!-- Call to Action Section -->
<section class="cta-section">
    <div class="cta-content">
        <h2>History of TIC Archives</h2>
        <p>{{ now()->year - 1983 }} Years of Ilankai Tamils activism and documentation</p>
        
    </div>
   <a href="{{ route('client.about') }}" class="cta-btn">Read More</a>

</section>
        </div>
  
@endsection
