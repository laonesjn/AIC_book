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

  .brand-tagline {
    font-size: 32px;
    font-weight: 400;
    white-space: nowrap;
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

  .let-us-begin .tamil-text {
    font-size: 2rem;
    font-weight: 500;
    color: #111;
}

.let-us-begin .english-text {
    font-size: 1.6rem;
    font-weight: 400;
    color: #111;
    letter-spacing: 0.4em;
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
     margin-left: 0px;
    }

    .brand-logo {
      width: 40px;
    }

    .brand-title {
      font-size: 16px;
      letter-spacing: 1px;
      white-space: normal;
    }
    

     .brand-tagline {
    font-size: 18px;
    font-weight: 400;
    white-space: nowrap;
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

    .book-title-tamil {
      font-size: 16px;
    }

    .book-title-english {
      font-size: 18px;
      letter-spacing: 2px;
    }
  }

  @media (min-width: 768px) {

    .let-us-begin .tamil-text {
        font-size: 1.6rem;
    }
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

  .let-us-begin .tamil-text {
    font-size: 1.5rem;
    font-weight: 500;
    color: #111;
}

.let-us-begin .english-text {
    font-size: 1.3rem;
    font-weight: 400;
    color: #111;
    letter-spacing: 0.4em;
}

  @media (max-width: 480px) {
    /* .brand-logo {
      width: 35px;
    } */
      

    /* .brand-title {
      font-size: 16px;
    } */
  }
</style>

<!-- Heritage Brand Section -->
<section class="heritage-brand">
    <div class="brand-logo">
        <img src="{{ asset('images/tol.jpg') }}" alt="TIC Logo">
    </div>
    <div class="brand-text">
        <span class="brand-title">TAMILS OF LANKA</span>
    <span class="divider">|</span>
    <span class="brand-tagline">A Timeless Heritage</span>
    <span class="divider">|</span>
    </div>

    
</section>

<!-- Main Content -->
<main id="main-content" class="sm:px-8 lg:px-16">
    <div class="max-w-6xl mx-auto relative">

        <!-- Hero Collage -->
        <div class="hero-container">
            <img src="{{ asset('images/travel.png') }}" class="collage-img" alt="News">
            <img src="{{ asset('images/A1.jpg') }}" class="collage-img" alt="Archive">
            <img src="{{ asset('images/A2.jpeg') }}" class="collage-img" alt="Culture">
            <img src="{{ asset('images/road.png') }}" class="collage-img" alt="Books">
        </div>

        <!-- Sidebar + Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4">
            
            <!-- Desktop Sidebar -->
            <aside class="sidebar hidden md:block md:col-span-1 h-full p-4 border-r border-gray-200">
                <div class="intro-box bg-red-600 text-white font-bold text-sm uppercase p-3 mb-8 text-center rounded">
                    
                    EXHIBITION SECTIONS

                
                </div>

                <ul class="space-y-6">
                    <li>
                        <a href="#all" class="text-black font-semibold uppercase hover:text-red-600 block">
                            All Collections
                        </a>
                    </li>

                    <!-- Sample Static Categories -->
                    <li>
                        <a href="#men-fashion" class="text-black font-semibold uppercase hover:text-red-600 block">
                            HISTORY & HERITAGE
                        </a>
                    </li>

                    <li>
                        <a href="#women-fashion" class="text-black font-semibold uppercase hover:text-red-600 block">
                            POLITICAL RESISTANCE
                        </a>
                    </li>

                    <li>
                        <a href="#electronics" class="text-black font-semibold uppercase hover:text-red-600 block">
                            CONSEQUENCES OF WAR
                        </a>
                    </li>

                    <li>
                        <a href="#home-decor" class="text-black font-semibold uppercase hover:text-red-600 block">
                            MULLIVAIKAL
                        </a>
                    </li>

                    <li>
                        <a href="#sports-fitness" class="text-black font-semibold uppercase hover:text-red-600 block">
                            ART & CULTURE
                        </a>
                    </li>
                     <li>
                        <a href="#sports-fitness" class="text-black font-semibold uppercase hover:text-red-600 block">
                              Gallery and News
                        </a>
                    </li>
                </ul>
            </aside>

<!-- Mobile Sidebar -->
<div class="block md:hidden col-span-1 my-6">
    <div class="intro-box bg-red-600 text-white font-bold text-sm uppercase p-3 mb-4 text-center rounded">
        Collections
    </div>

    <ul class="space-y-3">
        <li>
            <a href="#all" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                All Collections
            </a>
        </li>

        <!-- Sample Static Categories -->
        <li>
            <a href="#men-fashion" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                HISTORY & HERITAGE
            </a>
        </li>

        <li>
            <a href="#women-fashion" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                POLITICAL RESISTANCE
            </a>
        </li>

        <li>
            <a href="#electronics" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                CONSEQUENCES OF WAR
            </a>
        </li>

        <li>
            <a href="#home-decor" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                MULLIVAIKAL
            </a>
        </li>

        <li>
            <a href="#sports-fitness" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                ART & CULTURE
            </a>
        </li>

        <li>
            <a href="#sports-fitness" class="text-black font-semibold uppercase hover:text-red-600 block text-center py-2 border-b">
                  Gallery and News
            </a>
        </li>
    </ul>

    <hr class="my-6">
</div>


            <!-- Main Content Area -->
            <div class="md:col-span-3 hero-text-content" id="content-area">
                <h2 class="text-4xl font-bold mb-2 text-black">வணக்கம்</h2>
                <h1 class="text-5xl font-extrabold mb-6 tracking-tight text-black">WELCOME TO OUR <br>  VIRTUAL EXHIBITION</h1>
                
                <div class="text-lg leading-relaxed text-black max-w-3xl">
  <div id="intro-text" class="intro-content">

    <p class="mb-4 intro-p1">
      <b>Tamils of Lanka: </b>A Timeless Heritage is a major exhibition presented by The TIC Archives,
                          reflecting the Tamil Information Centre’s enduring commitment to the preservation, documentation, 
                          and public presentation of the history, culture, and human rights experiences of Tamil-speaking
                          people of Sri Lanka (Ilankai).
    </p>

    <p class="mb-4 intro-p2">
     Rooted in more than four decades of principled research, documentation, and advocacy, the exhibition
                          draws upon the extensive archival holdings of the Tamil Information Centre to present a carefully curated and
                          evidence-based narrative of Tamil history. Through primary sources, personal testimonies, cultural artefacts,
                          and artistic expression, the exhibition traces the continuity
                          of Tamil civilisation while confronting the profound ruptures caused by conflict, displacement, and systemic injustice               
    </p>

    <div id="more-content" style="display: none;">

      <p class="mb-4">
       This exhibition is both commemorative and forward-looking. While it honours the memory of thos
e who lost their lives—particularly during the mass atrocities committed at Mullivaikkal—it also affirms
 cultural survival, intellectual resilience, and the enduring creativity of Tamil communities in the homeland 
 and across the global diaspora.

      </p>

      <p class="mb-4">
       By bringing together archival documents, photographs, artefacts, audio-visual records, and 
contemporary artistic works, Tamils of Lanka: A Timeless Heritage offers a multi-layered exploration
 of lived experience before, during, and after the armed conflict. Particular emphasis is placed on first-hand
  narratives and verified primary sources, ensuring historical accuracy, ethical representation, and scholarly integrity.
      </p>

      <p class="mb-4">
        The exhibition has been shaped through global collaboration, with contributions from artists,
 researchers, academics, and activists across Ilankai, India, Europe, North America, and Australia.
  This collective effort reflects the intergenerational and transnational nature of Tamil history,
   and the shared responsibility to preserve it.
      </p>

      <p class="mb-4">
     More than a temporary display, this exhibition represents a foundational step towards 
TIC’s long-term vision: the establishment of a permanent Tamil archive and heritage museum,
 supported by a growing digital repository accessible to researchers, educators, and the wider public.
  As such, the exhibition stands as both a historical record and a living resource—one that safeguards memory, 
  supports critical inquiry, and enables future generations to engage meaningfully with their past.
      </p>

      <p class="mb-4">
Tamils of Lanka: A Timeless Heritage invites visitors to reflect, to learn, and to bear witness—recognising
 that preserving history is not only an act of remembrance, but a responsibility to truth, justice, and human dignity.
      </p>


       <p class="mb-4">
                    <strong>Legacy and Remembrance</strong><br><br>
The exhibition also stands as a tribute to the pioneers of the Tamil Information Centre,
 particularly Late Mr Varadakumar, one of TIC’s founders, whose vision, leadership,
  and dedication were instrumental to this project. It honours the collective efforts of TIC’s founders,
   volunteers, contributors, and well-wishers who, over decades, worked—often under conditions of personal 
   risk—to ensure that truth and evidence were preserved.

                </p>
                <p class="mb-4">
By hosting the exhibition on 18 May, widely recognised as Tamil Genocide
 Remembrance Day, TIC reaffirms its commitment to remembrance, resilience, and historical 
 accountability, while celebrating the enduring cultural and intellectual contributions of Tamil-speaking people.

                </p>

    </div>

    <button
      id="read-more-btn"
      class="mt-3 text-red-600 font-semibold hover:text-red-800 transition-colors flex items-center gap-2"
    >
      Read more <span class="text-xl">↓</span>
    </button>

  </div>
</div>

            </div>
        </div>
    </div>

    <!-- PUT CODE Here -->

    <section class="let-us-begin text-center">
        <p class="tamil-text mb-2">ஆரம்பித்துவிடுவோம்…</p>
        <p class="english-text tracking-[0.4em] uppercase">LET US BEGIN…</p>
    </section>

     <div class="max-w-6xl mx-auto my-16">

    <div class="sections-grid grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6 mb-6">

      @foreach($categories as $category)
    <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer">
        <a href="{{ route('client.heritage-centre', ['category' => $category->id]) }}" class="block h-full">

            <img 
                src="{{ Str::startsWith($category->image, 'images/') 
                    ? asset($category->image) 
                    : asset('storage/'.$category->image) 
                }}" 
                class="w-full h-32 sm:h-64 md:h-80 object-cover transition-transform duration-500 hover:scale-105" 
                alt="{{ $category->name }}"
            >

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex items-end p-2 sm:p-5">
                <div class="text-white">
                    <h5 class="font-bold text-xs sm:text-xl mb-0 sm:mb-1">
                        {{ $category->name }}
                    </h5>
                    <p class="text-[10px] sm:text-sm opacity-90">
                        {{ $category->name }}
                    </p>
                </div>
            </div>

        </a>
    </div>
@endforeach

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
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

</script>


@endsection