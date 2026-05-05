@extends('layouts.masterclient')

@section('title', 'The TIC Archives - Preserving Tamil Heritage')

@section('meta_description', 'Explore The TIC Archives featuring rare books, historical documents, cultural exhibitions, and Tamil heritage collections.')

@section('no-container', true)

@section('styles')
<style>
    /* ─────────────── HERO ─────────────── */
    .hero {
      position: relative;
      min-height: 480px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 60px 24px 80px;
      overflow: hidden;
      margin-top: calc(-1 * var(--nav-h)); /* Pull up to go under nav if needed, but nav is sticky */
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      background: url('{{ asset("images/topimg.jpeg") }}') center/cover no-repeat;
      filter: sepia(0.6) brightness(0.4) contrast(1.1);
      z-index: 0;
    }

    .hero-bg::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(10, 6, 2, 0.4) 0%, rgba(10, 6, 2, 0.2) 40%, rgba(10, 6, 2, 0.65) 100%);
    }

    /* Removed CSS torn-paper edge in favor of tornbkrund.png */

    .hero-content {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      max-width: 900px;
    }

    .hero-logo-box {
      width: 160px;
      height: 160px;
      margin: 0 auto 32px;
      /* background: rgba(255, 255, 255, 0.95); */
      border-radius: 50%;
      /* border: 4px solid rgba(255, 255, 255, 0.5); */
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    }

    .hero-logo-box img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      transform: scale(1.35) translateX(-3px); /* Scale to fit, nudge left to center */
    }

    .hero-quote {
      font-family: var(--font-accent);
      font-size: clamp(24px, 5vw, 42px);
      font-weight: 600;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 20px;
      text-shadow: 0 3px 15px rgba(0, 0, 0, 0.7);
    }

    .hero-sub {
      font-family: var(--font-serif);
      font-size: clamp(15px, 3vw, 18px);
      color: #e0d4be;
      max-width: 550px;
      line-height: 1.7;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
    }

    /* ─────────────── FEATURED ─────────────── */
    .featured-section {
      background: transparent;
      padding: 40px 24px 70px;
    }

    .section-head {
      font-family: var(--font-heading);
      font-size: clamp(20px, 4vw, 24px);
      text-align: center;
      letter-spacing: 0.08em;
      margin-bottom: 40px;
    }

    .cards-wrapper {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .archive-card {
      border-radius: 6px;
      overflow: hidden;
      background: #1a1008;
      display: flex;
      flex-direction: column;
      box-shadow: 0 6px 24px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-decoration: none;
    }

    .archive-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.45);
    }

    .card-media {
      position: relative;
      height: 220px;
      overflow: hidden;
    }

    .card-media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s ease;
    }

    .archive-card:hover .card-media img {
      transform: scale(1.08);
    }

    .card-overlay {
      position: absolute;
      inset: 0;
      background: rgba(10, 6, 2, 0.65);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
      color: #fff;
    }

    .overlay-title {
      font-family: var(--font-heading);
      font-size: 20px;
      font-weight: 600;
      line-height: 1.1;
      margin-bottom: 8px;
    }

    .overlay-sub {
      font-family: var(--font-serif);
      font-size: 14px;
      font-style: italic;
      color: #d4c4a8;
    }

    .card-content {
      padding: 16px 20px 24px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .card-headline {
      font-family: var(--font-accent);
      font-size: 18px;
      font-weight: 600;
      color: #e8dcc8;
      margin-bottom: 8px;
    }

    .card-summary {
      font-family: var(--font-serif);
      font-size: 14px;
      color: #b0a090;
      line-height: 1.5;
      margin-bottom: 15px;
    }

    .card-btn {
      display: inline-block;
      margin-top: auto;
      padding: 10px 22px;
      background: var(--rust);
      color: #fff;
      font-family: var(--font-serif);
      font-size: 14px;
      border: none;
      border-radius: 4px;
      text-align: center;
      transition: background 0.2s;
    }

    .archive-card:hover .card-btn {
      background: var(--rust-dark);
    }

    /* ─────────────── ABOUT ─────────────── */
    .about-section {
      background: transparent;
      padding: 40px 24px 80px;
      text-align: center;
      border-top: none;
    }

    .main-parchment-wrapper {
      background: url('{{ asset("images/tornbkrund.png") }}') center/100% 100% no-repeat;
      padding: 60px 0;
      margin-top: -40px;
      position: relative;
      z-index: 5;
    }

    footer {
      margin-top: 0 !important;
    }

    /* Standard inner container for full-width sections */
    .section-container {
      max-width: var(--container-max);
      margin: 0 auto;
    }

    .about-paragraph {
      font-family: var(--font-serif);
      font-size: clamp(16px, 3vw, 18px);
      max-width: 650px;
      margin: 0 auto 40px;
      line-height: 1.8;
    }

    .stats-container {
      display: flex;
      justify-content: center;
      max-width: 800px;
      margin: 0 auto 30px;
      border: 1px solid transparent;
    }

    .stat-box {
      flex: 1;
      padding: 10px 20px;
      border-right: 1px solid #c0b09a;
    }

    .stat-box:last-child {
      border-right: none;
    }

    .stat-val {
      font-family: var(--font-accent);
      font-size: clamp(26px, 5vw, 36px);
      font-weight: 700;
      display: block;
      line-height: 1;
    }

    .stat-tag {
      font-size: 12px;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-top: 8px;
      display: block;
    }

    .final-tagline {
      font-family: var(--font-serif);
      font-size: 16px;
      font-style: italic;
      color: var(--text-muted);
      margin-bottom: 25px;
    }

    .read-more-link {
      display: inline-block;
      font-family: var(--font-heading);
      font-size: 14px;
      font-weight: 600;
      color: var(--rust);
      text-decoration: none;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      transition: color 0.2s, transform 0.2s;
    }

    .read-more-link:hover {
      color: var(--ink);
      transform: translateX(5px);
    }

    /* ─────────────── RESPONSIVE ─────────────── */
    @media (max-width: 768px) {
      .cards-wrapper {
        grid-template-columns: 1fr;
        max-width: 400px;
      }
      .stats-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border: 1px solid #c0b09a;
      }
      .stat-box {
        border-bottom: 1px solid #c0b09a;
      }
      .stat-box:nth-child(even) {
        border-right: none;
      }
      .stat-box:nth-child(n+3) {
        border-bottom: none;
      }
    }
</style>
@endsection

@section('content')
  <!-- ── HERO SECTION ── -->
  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
      <div class="hero-logo-box">
        <img src="{{ asset('images/logo.png') }}" alt="TIC Logo" />
      </div>
      <h1 class="hero-quote">"Every collection tells a story.<br>Every story keeps our history alive."</h1>
      <p class="hero-sub">
        Preserving history, heritage, culture and human rights for generations to come —
        <em>by Tamil Information Centre (TIC).</em>
      </p>
    </div>
  </section>

  <div class="main-parchment-wrapper">
    <!-- ── FEATURED COLLECTIONS ── -->
    <section class="featured-section">
      <div class="section-container">
        <h2 class="section-head">Featured Collections</h2>
        <div class="cards-wrapper">

          <a href="{{ route('client.archivecentrecollection') }}" class="archive-card">
            <div class="card-media">
              <img src="{{ asset('images/topimg.jpeg') }}" alt="Archival Collections" loading="lazy" />
            </div>
            <div class="card-content">
              <div class="card-headline">The TIC Collections</div>
              <p class="card-summary">Sri Lanka's documented archives and historical records.</p>
              <span class="card-btn">View Collections</span>
            </div>
          </a>

          <a href="{{ route('client.heritage-centre') }}" class="archive-card">
            <div class="card-media">
              <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&q=80" alt="Exhibition" loading="lazy" />
              <div class="card-overlay">
                <div class="overlay-title">TAMILS<br>OF LANKA:</div>
                <div class="overlay-sub">A Timeless Heritage</div>
              </div>
            </div>
            <div class="card-content">
              <div class="card-headline">Explore the Exhibition</div>
              <p class="card-summary">Discover curated exhibitions showcasing our rich cultural journey.</p>
              <span class="card-btn">Visit Exhibition</span>
            </div>
          </a>

          <a href="{{ route('heritage.archive-centre') }}" class="archive-card">
            <div class="card-media">
              <img src="{{ asset('images/heritage.png') }}" alt="Heritage Museum" loading="lazy" />
            </div>
            <div class="card-content">
              <div class="card-headline">Visit the Heritage Museum</div>
              <p class="card-summary">Explore our heritage artefacts and preserved cultural treasures.</p>
              <span class="card-btn">Plan Visit</span>
            </div>
          </a>

        </div>
      </div>
    </section>

    <!-- ── ABOUT & STATS ── -->
    <section class="about-section">
      <div class="section-container">
        <h2 class="section-head">About The TIC Archives</h2>
        <p class="about-paragraph">
          With over 43 years of documentation & activism, The TIC Archives is dedicated
          to preserving the history, human rights, and cultural heritage of Tamil-speaking
          people in Ilankai / Sri Lanka.
        </p>

        <div class="stats-container">
          <div class="stat-box">
            <span class="stat-val">43+</span>
            <span class="stat-tag">Years of Documentation</span>
          </div>
          <div class="stat-box">
            <span class="stat-val">5,000+</span>
            <span class="stat-tag">Records Preserved</span>
          </div>
          <div class="stat-box">
            <span class="stat-val">700+</span>
            <span class="stat-tag">Oral Histories</span>
          </div>
          <div class="stat-box">
            <span class="stat-val">60,000+</span>
            <span class="stat-tag">Digital Archives</span>
          </div>
        </div>

        <p class="final-tagline">A global resource for researchers, educators, and communities worldwide.</p>
        <a href="{{ route('client.about') }}" class="read-more-link">Read More &rarr;</a>
      </div>
    </section>
  </div>
@endsection
