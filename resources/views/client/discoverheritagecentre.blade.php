@extends('layouts.masterclient')

@section('content')

<style>
  /* Hero brand section */
  .heritage-brand {
    display: flex;
    align-items: center;
    gap: 28px;
    width: 100%;
    max-width: 1400px;
    padding: 20px 40px;
    font-family: "Georgia", "Times New Roman", serif;
      margin-left: 40px;
  }

  .brand-logo {
    width: 60px;
    height: auto;
    flex-shrink: 0;
  }

  .brand-logo img {
    width: 100%;
    height: auto;
    display: block;
  }

  .brand-text {
    display: flex;
    align-items: center;
    gap: 16px;
    color: #111;
  }

  .brand-title {
    font-size: 50px;
    letter-spacing: 3px;
    font-weight: 500;
    text-transform: uppercase;
    white-space: nowrap;
    margin: 0;
  }

  /* Hero container */
  .hero-container {
    position: relative;
    width: 100%;
    max-width: 1100px;
    height: 420px;
    margin: 2rem auto;
    overflow: hidden;
    border-radius: 12px;
  }

  .collage-img {
    position: absolute;
    border-radius: 12px;
    object-fit: cover;
    transition: all 0.5s ease-in-out;
  }

  /* Page header section */
  .page-header-section {
    width: 100%;
    margin: 0 auto 0 !important;
    padding: 2rem 1rem 0.5rem !important;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-radius: var(--border-radius);
  }

  .page-header-section .page-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--accent-dark);
    margin: 0 0 1rem 0;
    letter-spacing: -1.5px;
    line-height: 1.2;
  }

  .page-header-section .page-subtitle {
    font-size: 1.25rem;
    color: var(--accent-dark);
    opacity: 0.8;
    margin: 0;
    max-width: 800px;
    line-height: 1.6;
  }

  /* Main content layout */
  .publications-main-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  @media (min-width: 992px) {
    .publications-main-content {
      grid-template-columns: 300px 1fr;
    }
  }

  /* Sidebar */
  .publication-guide {
    background-color: white;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(15, 37, 64, 0.1);
    height: fit-content;
  }

  .publication-guide h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent-dark);
    margin-bottom: 1rem;
    border-left: 5px solid var(--accent-muted);
    padding-left: 1rem;
  }

  .guide-section {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px dashed #e0e0e0;
  }

  .guide-section:last-child {
    border-bottom: none;
  }

  .guide-section h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--accent-dark);
    margin-bottom: 0.5rem;
  }

  .guide-section p {
    font-size: 0.85rem;
    color: #555;
    line-height: 1.5;
  }

  /* Classification box styling */
  .classification-box {
    background: #e6dacc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem 1.25rem;
    margin: 0 auto 2.5rem auto;
    max-width: 1200px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  }

  .classification-title {
    color: #0f2540;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-align: center !important;
    margin: 0 0 1.5rem 0;
    padding: 0.5rem 0 0.75rem 0;
    font-size: clamp(1.6rem, 4.2vw, 2.25rem);
    border-bottom: 3px solid #dc2626;
    max-width: 90%;
    margin-left: auto;
    margin-right: auto;
  }

  /* Swiper configuration */
  .governanceSwiper {
    position: relative;
    width: 100%;
    overflow: hidden;
    min-height: 380px;
    padding-bottom: 90px !important;
  }

  .governanceSwiper .swiper-wrapper {
    align-items: stretch;
    transition-timing-function: ease-out;
  }

  .governanceSwiper .swiper-slide {
    height: auto;
    display: flex;
    justify-content: center;
    box-sizing: border-box;
    align-items: stretch;
  }

  /* Pagination dots */
  .governanceSwiper .swiper-pagination {
    position: absolute !important;
    bottom: 25px !important;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 50 !important;
    padding: 10px 0;
  }

  .governanceSwiper .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: #444;
    opacity: 0.7;
    margin: 0 6px;
    border-radius: 50%;
  }

  .governanceSwiper .swiper-pagination-bullet-active {
    background: #dc2626;
    opacity: 1;
    transform: scale(1.4);
  }

  /* ============================================
     UPDATED: Modern Heritage Book Card
  ============================================ */
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500&family=Noto+Sans+Tamil:wght@400;500&display=swap');

  .book-card {
    width: 100%;
    max-width: 300px;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    background: #ffffff;
    box-shadow:
      0 2px 8px rgba(0, 0, 0, 0.06),
      0 12px 32px rgba(0, 0, 0, 0.10),
      0 0 0 1px rgba(0,0,0,0.04);
    cursor: pointer;
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    display: flex;
    flex-direction: column;
  }

  .book-card:hover {
    transform: translateY(-10px) scale(1.015);
    box-shadow:
      0 4px 16px rgba(0, 0, 0, 0.08),
      0 24px 48px rgba(0, 0, 0, 0.16),
      0 0 0 1px rgba(0,0,0,0.06);
  }

  /* Image section — top half */
 .book-content {
  width: 100%;
  height: 220px;        /* pick ONE fixed height */
  min-height: 220px;
  max-height: 220px;
  position: relative;
  overflow: hidden;
}

.book-image {
  width: 100%;
  height: 100% !important;
  object-fit: cover;
  object-position: center;
  display: block;
}


  .book-card:hover .book-image {
    transform: scale(1.06);
  }

  /* Subtle warm gradient at bottom of image for smooth transition */
  .book-content::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.95));
    pointer-events: none;
  }

  /* Category badge on image */
  .book-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #8B1A1A;
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    padding: 5px 10px;
    border-radius: 20px;
    font-family: 'DM Sans', sans-serif;
    border: 1px solid rgba(139, 26, 26, 0.15);
  }

  /* Text body below image */
  .book-body {
    padding: 18px 20px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
  }

  /* Thin decorative line accent */
  .book-accent-line {
    width: 36px;
    height: 2px;
    background: linear-gradient(90deg, #dc2626, #b45309);
    border-radius: 2px;
    margin-bottom: 2px;
  }

  /* English title */
  .book-title-english {
    font-family: 'Cormorant Garamond', 'Georgia', serif;
    font-size: 17px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.35;
    letter-spacing: 0.2px;
    margin: 0;
  }

  /* Tamil title / category name */
  .book-title-tamil {
    font-family: 'Noto Sans Tamil', 'Latha', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #5c4a32;
    line-height: 1.6;
    margin: 0;
    padding: 8px 12px;
    background: #faf6f0;
    border-radius: 8px;
    border-left: 3px solid #b45309;
  }

  /* English description */
  .book-description {
    font-family: 'DM Sans', sans-serif;
    font-size: 11.5px;
    font-weight: 400;
    color: #6b6b6b;
    line-height: 1.65;
    margin: 0;
  }

  /* Footer row: arrow icon */
  .book-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f0ebe3;
    margin-top: 4px;
  }

  .book-explore-text {
    font-family: 'DM Sans', sans-serif;
    font-size: 10.5px;
    font-weight: 500;
    color: #8B1A1A;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .book-arrow {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dc2626, #b45309);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
  }

  .book-card:hover .book-arrow {
    transform: translateX(3px);
  }

  .book-arrow svg {
    width: 12px;
    height: 12px;
    fill: none;
    stroke: #fff;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* ============================================
     END: Updated Book Card
  ============================================ */

  /* Hero text content */
  .hero-text-content {
    text-align: left;
  }

  .hero-text-content h2 {
    font-size: 2rem;
    font-weight: 600;
    color: var(--accent-dark);
    margin-bottom: 0.5rem;
  }

  .hero-text-content h1 {
    font-size: 3rem;
    font-weight: 800;
    color: var(--accent-dark);
    margin-bottom: 1.5rem;
  }

  .hero-text-content p {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #333;
    margin-bottom: 1rem;
  }

  /* Read more button */
  #read-more-btn {
    margin-top: 1.5rem;
    color: #dc2626;
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
  }

  #read-more-btn:hover {
    color: #b91c1c;
    transform: translateX(4px);
  }

  /* Responsive styles */
  @media (max-width: 767px) {
    .heritage-brand {
      flex-direction: row;
      padding: 10px 15px;
      width: 100%;
      margin-left: 20px;
    }

    .brand-logo {
     width: 53px;
    }

    .brand-title {
      font-size: 20px;
      letter-spacing: 1px;
      white-space: normal;
    }

    .hero-container {
      margin: 1.5rem auto;
    }

    .collage-img {
      width: 60vw;
      height: 32vw;
      top: 1vw;
      left: 15vw;
    }

    .collage-img:nth-child(2) {
      width: 40vw;
      height: 40vw;
      top: 25vw;
      left: 1vw;
    }

    .collage-img:nth-child(3) {
      width: 48vw;
      height: 65vw;
      top: 25vw;
      left: 45vw;
    }

    .collage-img:nth-child(4) {
      height: 35vw;
      top: 72vw;
      right: 5vw;
      left: auto;
    }

    .publications-main-content {
      grid-template-columns: 1fr;
    }

    .publication-guide {
      order: -1;
      margin-bottom: 1.5rem;
    }

    .page-header-section .page-title {
      font-size: clamp(2.1rem, 8vw, 2.8rem);
    }

    .page-header-section .page-subtitle {
      font-size: clamp(1.05rem, 4.5vw, 1.25rem);
    }

    .hero-text-content h2 {
      font-size: 1.6rem;
    }

    .hero-text-content h1 {
      font-size: 1.9rem;
    }

    .hero-text-content p {
      font-size: 0.95rem;
    }

    .governanceSwiper {
      padding-bottom: 70px !important;
      min-height: 340px;
    }

    .governanceSwiper .swiper-pagination {
      bottom: 18px !important;
    }

    .governanceSwiper .swiper-pagination-bullet {
      width: 8px;
      height: 8px;
    }

    .classification-box {
      padding: 1.25rem 1rem;
      margin-bottom: 2rem;
    }

    .classification-title {
      font-size: clamp(1.4rem, 5vw, 1.85rem);
      margin-bottom: 1.2rem;
    }

    .book-card {
      max-width: 100%;
    }

    .book-title-english {
      font-size: 15px;
    }

    .book-title-tamil {
      font-size: 12px;
    }

    .book-description {
      font-size: 11px;
    }
  }

  @media (min-width: 768px) {
    .hero-container {
      height: 550px;
    }

    .collage-img:nth-child(1) {
      width: 300px;
      height: 220px;
      top: 0px;
      left: 220px;
    }

    .collage-img:nth-child(2) {
      width: 280px;
      height: 240px;
      top: 170px;
      left: 50px;
    }

    .collage-img:nth-child(3) {
      width: 250px;
      height: 360px;
      top: 100px;
      left: 420px;
    }

    .collage-img:nth-child(4) {
      width: 320px;
      height: 260px;
      top: 300px;
      right: 80px;
      left: auto;
    }

    .publication-guide {
      position: sticky;
      top: 1.5rem;
      align-self: start;
    }

    .governanceSwiper {
      padding-bottom: 90px !important;
    }

    .governanceSwiper .swiper-pagination {
      bottom: 25px !important;
    }
  }
</style>

<!-- Heritage Brand Section -->
<section class="heritage-brand">
    <div class="brand-logo">
        <img src="{{ asset('images/tol.jpg') }}" alt="TIC Logo">
    </div>
    <div class="brand-text">
        <span class="brand-title">Welcome to Our ONLINE MUSEUM</span>
    </div>
</section>

<!-- Main Content -->
<main id="main-content" class="sm:px-8 lg:px-16">
    <div class="max-w-6xl mx-auto relative">

        <!-- Hero Collage -->
        <div class="hero-container">
            <img src="{{ asset('images/1.jfif') }}" class="collage-img" alt="News">
            <img src="{{ asset('images/dancer.png') }}" class="collage-img" alt="Archive">
            <img src="{{ asset('images/3.jfif') }}" class="collage-img" alt="Culture">
            <img src="{{ asset('images/2.avif') }}" class="collage-img" alt="Books">
        </div>

        <!-- Sidebar + Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4">

            <!-- Desktop Sidebar -->
            <aside class="sidebar hidden md:block md:col-span-1 h-full p-4 border-r border-gray-200">
                <div class="intro-box bg-red-600 text-white font-bold text-sm uppercase p-3 mb-8 text-center rounded">
                    
               INTRODUCTION
    
                </div>

                <ul class="space-y-6 text-sm">
    <li>
        <a href="#all" class="text-black font-semibold uppercase hover:text-red-600 block">
            All Collections
        </a>
    </li>

    @foreach($masterCategories->take(5) as $master)
        <li>
            <a href="#{{ str_replace(' ', '-', strtolower($master->name)) }}"
               class="text-black font-semibold uppercase hover:text-red-600 block">
                {{ $master->name }}
            </a>
        </li>
    @endforeach
</ul>

            </aside>

            <!-- Mobile Sidebar -->
            <div class="block md:hidden col-span-1 my-6">
                <div class="intro-box bg-red-600 text-white font-bold text-sm uppercase p-3 mb-4 text-center rounded">
                    Collections
                </div>
                <ul class="space-y-3">
                    <li><a href="#all" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">All Collections</a></li>
                    @foreach($masterCategories as $master)
                        <li>
                            <a href="#{{ str_replace(' ', '-', strtolower($master->name)) }}"
                               class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                                {{ $master->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <hr class="my-6">
            </div>

            <!-- Main Content Area -->
            <div class="md:col-span-3 hero-text-content" id="content-area">
                <h2 class="text-4xl font-bold mb-2 text-black">வணக்கம்</h2>
                <h1 class="text-5xl font-extrabold mb-6 tracking-tight text-black">Our Online Museum</h1>

                <div class="text-lg leading-relaxed text-black max-w-3xl">
                    <div id="intro-text" class="intro-content">
                        <p class="mb-4 intro-p1">
                        The Online Tamil Heritage Museum is a cultural & research-oriented platform dedicated to the documentation,
                        preservation, & interpretation of Tamil history, culture, & heritage. Conceived as an authoritative & accessible resource,
                        the museum brings together archival materials, scholarly research, & cultural narratives to examine
                        the historical experiences & contributions of Tamil communities within their local, national, & global contexts.
                    
                        </p>
                        <p class="mb-4">
                          
                    Through curated collections, exhibitions, & research initiatives, the museum facilitates critical inquiry, interdisciplinary scholarship,
                    & knowledge production. By linking historical documentation with contemporary cultural expression, the Online Tamil Heritage Museum
                    supports long-term heritage preservation while contributing to academic discourse, public history, & intergenerational memory in the United Kingdom & beyond.
                
                           
                        </p>
                        <!-- <p class="mb-4 intro-p2" style="display: none;">
                            We preserve records across multiple categories including governance, human rights, cultural heritage, and historical documentation. Each collection is carefully curated to ensure accuracy, authenticity, and respect for the communities represented.
                        </p>
                        <p style="display: none;" id="more-content">
                            Our mission is to make these vital historical records accessible to researchers, educators, students, and community members. We believe in the power of documentation to preserve truth, honor collective memory, and support justice and reconciliation efforts.
                        </p> -->

                        <!-- <button id="read-more-btn" class="mt-3 text-red-600 font-semibold hover:text-red-800 transition-colors flex items-center gap-2">
                            Read more <span class="text-xl">↓</span>
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collections by Master Category -->
    @foreach($masterCategories as $master)
        <div class="classification-box" id="{{ str_replace(' ', '-', strtolower($master->name)) }}">
            <h2 class="classification-title">{{ $master->name }}</h2>

           @if($master->collections->isNotEmpty())
    <div class="swiper governanceSwiper">
        <div class="swiper-wrapper">
            @foreach($master->collections as $category)

                            @php
                                $image = $category->title_image;

                                if ($image) {
                                    if (Str::startsWith($image, ['http://', 'https://'])) {
                                        $imageUrl = $image;
                                    } else {
                                        $imageUrl = asset('public/' . $image);
                                    }
                                } else {
                                    $imageUrl = asset('images/default-category.jpg');
                                }
                            @endphp

                            {{-- ============================================
                                 UPDATED: Modern Heritage Card Slide
                            ============================================ --}}
                            <div class="swiper-slide">
                                  <a href="{{ route('heritage.archive-centre', ['category' => $category->master_main_category_id]) }}" 
                                   style="text-decoration: none; display: block; width: 100%;">

                                    <div class="book-card"
                                         data-link="{{ route('heritage.collection.show', $category->id) }}"
                                         data-category="{{ $category->id }}">

                                        {{-- Top image section --}}
                                        <div class="book-content">
                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="{{ $category->title}}"
                                                class="book-image"
                                                loading="lazy"
                                            >
                                        </div>

                                        {{-- Text body below image --}}
                                        <div class="book-body">

                                            {{-- Decorative accent line --}}
                                            <div class="book-accent-line"></div>

                                            {{-- English title --}}
                                            <h3 class="book-title-english">{{ $category->title }}</h3>

                                            {{-- Tamil description block --}}
                                            <p class="book-title-tamil">
                                                தமிழ் பண்பாடு மற்றும் கட்டிடக்கலையின் பெருமையை
                                                பேணிப் பாதுகாக்கும் இந்தத் தொகுப்பு, நமது
                                                வரலாற்று மரபுகளை அடுத்த தலைமுறைக்கு
                                                கொண்டு செல்கிறது.
                                            </p>

                                            {{-- Short English description --}}
                                            <p class="book-description">
    {{ \Illuminate\Support\Str::limit($category->description, 200) }}
</p>


                                            {{-- Footer row with explore CTA --}}
                                            <!-- <div class="book-footer">
                                                <span class="book-explore-text">Explore</span>
                                                <div class="book-arrow">
                                                    <svg viewBox="0 0 24 24">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </div>
                                            </div> -->

                                        </div>{{-- end .book-body --}}

                                    </div>{{-- end .book-card --}}
                                </a>
                            </div>
                            {{-- ============================================
                                 END: Updated Card Slide
                            ============================================ --}}

                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <p class="text-center text-gray-500 py-8">No categories available in this collection.</p>
            @endif
        </div>
    @endforeach

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
// Mobile menu toggle
(function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileNavOffcanvas = document.getElementById('mobileNavOffcanvas');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');
    const mobileNavClose = document.getElementById('mobileNavClose');

    if (!mobileMenuBtn || !mobileNavOffcanvas) return;

    function openMobileMenu() {
        mobileNavOffcanvas.classList.add('active');
        mobileNavOverlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        mobileNavOffcanvas.classList.remove('active');
        mobileNavOverlay?.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileMenuBtn.addEventListener('click', openMobileMenu);
    mobileNavClose?.addEventListener('click', closeMobileMenu);
    mobileNavOverlay?.addEventListener('click', closeMobileMenu);

    document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const target = document.getElementById(this.dataset.target);
            target?.classList.toggle('active');
            this.setAttribute('aria-expanded', target?.classList.contains('active'));
        });
    });
})();

// Read more button functionality
document.getElementById('read-more-btn')?.addEventListener('click', function () {
    const more = document.getElementById('more-content');
    const p2 = document.querySelector('.intro-p2');
    if (more.style.display === 'none' || !more.style.display) {
        more.style.display = 'block';
        if (p2) p2.style.display = 'block';
        this.innerHTML = 'Show less <span class="text-xl">↑</span>';
    } else {
        more.style.display = 'none';
        if (p2) p2.style.display = 'none';
        this.innerHTML = 'Read more <span class="text-xl">↓</span>';
    }
});

// Book card click redirect
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.book-card').forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', () => {
            const link = card.dataset.link;
            const category = card.dataset.category;
            if (!link) return;

            const url = new URL(link, window.location.origin);
            if (category) {
                url.searchParams.set('category', category);
            }
            window.location.href = url.toString();
        });
    });
});

// Swiper initialization
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.governanceSwiper').forEach(function (container) {
        new Swiper(container, {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            loop: false,
            pagination: {
                el: container.querySelector('.swiper-pagination'),
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                1280: {
                    slidesPerView: 3,
                    spaceBetween: 12
                }
            }
        });
    });
});
</script>

@endsection