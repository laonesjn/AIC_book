@extends('layouts.masterclient')

@section('content')
<style>
    :root {
        --primary-bg: #f6e3c5;
        --accent-dark: #0f2540;
        --accent-muted: #bfa98b;
        --card-bg: #f6ece0;
        --hover-bg: #e6d3bd;
        --border-radius: 12px;
        --font-serif: "Georgia", "Times New Roman", serif;
        --accent-red: #d32f2f;
    }

    /* Archive Hero Section */
    .archive-hero {
        width: 100%; 
        margin: 0 auto 1.5rem auto; 
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem 2rem;
        background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
        border: 1px solid rgba(0,0,0,0.08); 
        box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
        border-radius: var(--border-radius);
    }

    .archive-hero h1 {
        /* font-size: 3rem; */
        font-weight: 800;
        color: var(--accent-dark);
        margin: 0 0 0.8rem 0;
        letter-spacing: -1px;
    }

    .archive-hero p {
        font-size: 1.2rem;
        color: var(--accent-dark);
        opacity: 0.85;
        margin: 0;
        max-width: 700px;
    }

    /* Arts and Culture Section */
    .arts-culture-section {
        position: relative;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 40px 20px;
        margin-bottom: 3rem;
    }

    .overlay-text {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 30px;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .overlay-text h2 {
        font-size: 2rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .overlay-text p {
        font-size: 1rem;
        line-height: 1.6;
        color: #333;
    }

    /* ========== SECTION TITLE WITH RED UNDERLINE ========== */
    .section-header {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--accent-dark);
        margin: 0 0 1.5rem 0;
        letter-spacing: -1px;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: -0.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 400px;
        height: 4px;
        background-color: var(--accent-red);
        border-radius: 2px;
    }

    /* ========== CAROUSEL CONTAINER ========== */
    .carousel-wrapper {
        position: relative;
        padding: 0 50px;
        margin-bottom: 2rem;
    }

    .carousel-container {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 1rem 0;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .carousel-container::-webkit-scrollbar {
        height: 6px;
    }

    .carousel-container::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .carousel-container::-webkit-scrollbar-thumb {
        background: var(--accent-muted);
        border-radius: 10px;
    }

    .carousel-container::-webkit-scrollbar-thumb:hover {
        background: var(--accent-dark);
    }

    /* ========== CARD DESIGN ========== */
    .carousel-card {
        flex: 0 0 calc(33.333% - 1rem);
        min-height: 280px;
        border-radius: var(--border-radius);
        overflow: hidden;
        position: relative;
        cursor: pointer;
        scroll-snap-align: start;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .carousel-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
    }

    .carousel-card-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }

    .carousel-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.5) 100%);
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        transition: background 0.3s ease;
    }

    .carousel-card:hover .carousel-card-overlay {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.65) 100%);
    }

    .carousel-card-content {
        position: relative;
        z-index: 3;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
    }

    .carousel-card-tamil {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.4;
        letter-spacing: 0.5px;
    }

    .carousel-card-english {
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        opacity: 0.95;
    }

    /* ========== NAVIGATION ARROWS ========== */
    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: var(--accent-dark);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: background 0.3s ease, transform 0.2s ease;
        font-size: 1.2rem;
    }

    .carousel-nav:hover {
        background: var(--accent-red);
        transform: translateY(-50%) scale(1.1);
    }

    .carousel-nav.prev {
        left: 0;
    }

    .carousel-nav.next {
        right: 0;
    }

    .carousel-nav:active {
        transform: translateY(-50%) scale(0.95);
    }

    /* ========== RESPONSIVE GRID (NO CAROUSEL) ========== */
    .responsive-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    /* ========== RESPONSIVE STYLING ========== */
    @media (max-width: 1024px) {
        .carousel-card {
            flex: 0 0 calc(50% - 0.75rem);
            min-height: 260px;
        }

        .carousel-card-tamil {
            font-size: 1.4rem;
        }

        .carousel-nav {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .carousel-wrapper {
            padding: 0 40px;
        }
    }

    @media (max-width: 768px) {
        .carousel-wrapper {
            padding: 0 40px;
        }

        .carousel-card {
            flex: 0 0 calc(100% - 1.5rem);
            min-height: 240px;
        }

        .carousel-card-tamil {
            font-size: 1.2rem;
        }

        .carousel-card-english {
            font-size: 0.85rem;
        }

        .carousel-nav {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }

        .section-header h2 {
            font-size: 2rem;
        }

        .section-header::after {
            max-width: 300px;
            height: 3px;
        }

        .arts-culture-section {
            padding: 20px 15px;
            min-height: 300px;
            justify-content: center;
        }

        .overlay-text {
            max-width: 100%;
            text-align: center;
            padding: 20px;
        }

        .overlay-text h2 {
            font-size: 1.6rem;
        }

        .overlay-text p {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {
        .carousel-wrapper {
            padding: 0 35px;
        }

        .carousel-card {
            min-height: 200px;
        }

        .carousel-card-tamil {
            font-size: 1rem;
        }

        .carousel-card-english {
            font-size: 0.75rem;
        }

        .carousel-card-content {
            padding: 1.5rem;
        }

        .carousel-nav {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }

        .section-header h2 {
            font-size: 1.6rem;
        }

        .section-header::after {
            max-width: 200px;
            height: 2px;
        }
    }
</style>

<!-- Arts and Culture Section -->
<section class="arts-culture-section" 
         style="background: url('{{ Str::startsWith($data['image'], ['http://', 'https://']) ? $data['image'] : asset($data['image']) }}') center center / cover no-repeat;">
    <div class="overlay-text">
        <h2>{{ $data['name'] }}</h2>
        <p>{{ $data['description'] }}</p>
    </div>
</section>

<br>

<div id="collectionsContainer">
    @forelse($data['subcategories'] as $sub)
        <!-- SECTION HEADER WITH RED UNDERLINE -->
        <div class="section-header">
            <h2>{{ $sub['name'] }}</h2>
        </div>

        <!-- CAROUSEL / GRID CONTAINER -->
        <div class="carousel-wrapper">
            <button class="carousel-nav prev" data-carousel="carousel-{{ $loop->index }}" onclick="scrollCarousel(this, -1)">
                &#10094;
            </button>

            <div class="carousel-container" id="carousel-{{ $loop->index }}">
                @foreach($sub['collections'] as $col)
                    <a href="{{ route('client.collection.show', $col['id']) }}" class="carousel-card">
                     <img src="{{ $col['title_image'] 
            ? (Str::startsWith($col['title_image'], ['http://', 'https://']) 
                ? $col['title_image'] 
                : asset($col['title_image'])) 
            : asset('default-image.jpg') }}"
     class="carousel-card-image"
     alt="{{ $col['title'] }}"
     onerror="this.onerror=null;this.src='{{ asset('default-image.jpg') }}';">

                        
                        <div class="carousel-card-overlay">
                            <div class="carousel-card-content">
                                <div class="carousel-card-tamil">{{ $col['title'] }}</div>
                                <div class="carousel-card-english">
                                    {{ Str::limit($col['description'], 60) }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <button class="carousel-nav next" data-carousel="carousel-{{ $loop->index }}" onclick="scrollCarousel(this, 1)">
                &#10095;
            </button>
        </div>

    @empty
        <div class="alert alert-light text-center">
            No collections available in this category yet.
        </div>
    @endforelse
</div>

<script>
    function scrollCarousel(button, direction) {
        const carouselId = button.getAttribute('data-carousel');
        const carousel = document.getElementById(carouselId);
        
        if (!carousel) return;

        const cardWidth = carousel.querySelector('.carousel-card').offsetWidth;
        const gap = 24; // 1.5rem in pixels (assuming 16px base)
        const scrollAmount = (cardWidth + gap) * 3; // Scroll 3 cards at a time

        carousel.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }

    // Optional: Update arrow visibility based on scroll position
    function updateArrowVisibility() {
        document.querySelectorAll('.carousel-container').forEach(carousel => {
            const wrapper = carousel.closest('.carousel-wrapper');
            const prevBtn = wrapper.querySelector('.carousel-nav.prev');
            const nextBtn = wrapper.querySelector('.carousel-nav.next');

            prevBtn.style.opacity = carousel.scrollLeft > 0 ? '1' : '0.5';
            nextBtn.style.opacity = 
                carousel.scrollLeft < (carousel.scrollWidth - carousel.clientWidth - 10) ? '1' : '0.5';
        });
    }

    // Update on load and scroll
    window.addEventListener('load', updateArrowVisibility);
    document.querySelectorAll('.carousel-container').forEach(carousel => {
        carousel.addEventListener('scroll', updateArrowVisibility);
    });
</script>

@endsection