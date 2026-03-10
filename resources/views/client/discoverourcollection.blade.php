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
    /* display: grid; */
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

  .book-card {
  width: 100%;
  max-width: 350px;
  height: 300px;
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: #111;
}

.book-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
}

.book-content {
  width: 100%;
  height: 100%;
  position: relative;
}

.book-image {
  width: 100%;
  height: 100%;
  object-fit: cover; 
  object-position: center;
  display: block;
}

/* Overlay */
.book-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55));
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 20px;
  color: #fff;
}

.book-title-tamil {
  font-size: 18px;
  margin-bottom: 10px;
  line-height: 1.4;
}

.book-title-english {
  font-size: 20px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
}
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
      /* gap: 1px; */
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
      /* height: 120vw; */
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
      /* width: 50vw; */
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
      font-size: 1.5rem;
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

    .book-title-tamil {
      font-size: 16px;
    }

    .book-title-english {
      font-size: 18px;
      letter-spacing: 2px;
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

  /* Tablet / iPad view: 768px – 991px */
@media (min-width: 768px) and (max-width: 991px) {
    .brand-title {
        font-size: 30px;          /* smaller, fits tablet */
        letter-spacing: 1.5px;    /* less wide */
        font-weight: 600;          /* slightly bolder for clarity */
        text-transform: uppercase;
        white-space: nowrap;       /* keeps text on one line */
        margin: 0;
    }
}



</style>

<!-- Heritage Brand Section -->
<section class="heritage-brand">
    <div class="brand-logo">
        <img src="{{ asset('images/tol.jpg') }}" alt="TIC Logo">
    </div>
    <div class="brand-text">
        <span class="brand-title">Welcome to Our Collections</span>
    </div>
</section>

<!-- Main Content -->
<main id="main-content" class="sm:px-8 lg:px-16">
    <div class="max-w-6xl mx-auto relative">

        <!-- Hero Collage -->
        <div class="hero-container">
            <img src="{{ asset('images/news.jfif') }}" class="collage-img" alt="News">
            <img src="{{ asset('images/low.jfif') }}" class="collage-img" alt="Archive">
            <img src="{{ asset('images/tamil.jpg') }}" class="collage-img" alt="Culture">
            <img src="{{ asset('images/confidence.jpg') }}" class="collage-img" alt="Books">
        </div>

        <!-- Sidebar + Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4">
            
            <!-- Desktop Sidebar -->
            <aside class="sidebar hidden md:block md:col-span-1 h-full p-4 border-r border-gray-200">
                <div class="intro-box bg-red-600 text-white font-bold text-sm uppercase p-3 mb-8 text-center rounded">
                    Collections
                </div>
                <ul class="space-y-6">
                    <li><a href="#all" class="text-black font-semibold uppercase hover:text-red-600 block">All Collections</a></li>
                    @foreach($masterCategories as $master)
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
                <h1 class="text-5xl font-extrabold mb-6 tracking-tight text-black">Discover the Collections</h1>
                
                <div class="text-lg leading-relaxed text-black max-w-3xl">
                    <div id="intro-text" class="intro-content">
                        <p class="mb-4 intro-p1">
                           <strong>The TIC Archives</strong>
                             is an independent and authoritative digital archive of the Tamil Information Centre (TIC), dedicated to the collection, preservation,
                             and public access of historical, cultural, and human rights records relating to the Tamil-speaking people of Sri Lanka.

                        
                        </p>
                        <p class="mb-4">
                           Founded on the pioneering work of the Tamil Information Centre, established in London in 1979, the archive represents more than four decades of principled research, 
                    documentation, and human rights advocacy. It brings together first-hand, authentic, and verifiable materials gathered through the dedication and sacrifice of researchers,
                     activists, and community members who worked under challenging and often dangerous conditions to ensure that history, memory, and evidence were not lost.
                


                        </p>
                        <p class="mb-4 intro-p2" style="display: none;">
                            
                              At this crucial stage, as TIC fulfils a long-standing vision of its founders, pioneers, supporters, and the wider Tamil-speaking community,
                     The TIC Archives makes these invaluable collections publicly accessible for the first time. In doing so, the archive honours the memory and lifelong 
                     contributions of those who laid its foundations—including the late Mr. Kanthasamy, the late Mr. Varadakumar, and the late Fr. James Pathinathar, among many
                      others—whose commitment, courage, and integrity continue to guide this work.

                        
                        </p>

                         <p class="mb-4 intro-p2" style="display: none;">

                           Guided by the principles of justice, equality, accuracy, and respect for fundamental human rights, and informed by the Universal Declaration
                     of Human Rights (UDHR) and other international human rights instruments, The TIC Archives serves as both a historical record and a living resource.
                      It exists to support research, education, public understanding, and intergenerational memory, while carrying forward a respected legacy for generations to com
                        
                        </p>

                      
                        <p style="display: none;" id="more-content">
                         
                               We invite researchers, students, educators, community members, and the wider public to explore 
                    The TIC Archives—to engage with preserved records, to bear witness to documented histories, and to share in the responsibility of safeguarding truth, memory, and heritage for the future.
                        
                        </p>

                        <button id="read-more-btn" class="mt-3 text-red-600 font-semibold hover:text-red-800 transition-colors flex items-center gap-2">
                            Read more <span class="text-xl">↓</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Collections by Master Category -->
      @foreach($masterCategories as $master)
        @if($master->collections->isNotEmpty())
            <div class="classification-box" id="{{ Str::slug($master->name) }}">
                <h2 class="classification-title">{{ $master->name }}</h2>

                <div class="swiper governanceSwiper">
                    <div class="swiper-wrapper">
                        @foreach($master->collections as $collection)
    <div class="swiper-slide">
        <a href="{{ route('client.archivecentrecollection', ['category' => $collection->master_main_category_id]) }}" 
           style="text-decoration: none; display: block;">
            <div class="book-card">
                <div class="book-content">
                   <img 
    src="{{ 
        $collection->title_image
            ? (Str::startsWith($collection->title_image, ['http://', 'https://']) 
                ? $collection->title_image 
                : asset('public/'.$collection->title_image))
            : asset('public/images/default-category.jpg') 
    }}"
    alt="{{ $collection->title }}"
    class="book-image"
>
                    <div class="book-overlay">
                        <div class="book-title-english">{{ $collection->title }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        @endif
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