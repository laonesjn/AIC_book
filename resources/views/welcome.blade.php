<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <title>The TIC Archives - Preserving Tamil Heritage</title>
  <meta name="description"
    content="Explore The TIC Archives featuring rare books, historical documents, cultural exhibitions, and Tamil heritage collections.">
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=EB+Garamond:wght@400;600&family=Lato:wght@300;400;700&display=swap"
    rel="stylesheet">
  <link rel="preload" as="image" href="{{ asset('images/topimg.jpeg') }}" fetchpriority="high">
  <link rel="preload" as="image" href="{{ asset('images/logo.png') }}" fetchpriority="high">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --crimson: #8B1A1A;
      --crimson-hover: #A52020;
      --sepia-bg: #f0e8d8;
      --sepia-light: #f5ede0;
      --text-dark: #1a1008;
      --text-mid: #3a2a1a;
      --text-muted: #6b5a48;
      --gold-line: #c4a87a;
      --max-width: 1200px;
    }

    /* ─── Full page background image ─── */
    body {
      font-family: 'Lato', sans-serif;
      color: var(--text-dark);
      line-height: 1.6;
      background-image: url('{{ asset("images/backround.jpeg") }}');
      background-size: cover;
      background-position: center center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-color: #2a1a0e;
    }

    /* iOS/mobile: fixed attachment doesn't work, use scroll */
    @supports (-webkit-touch-callout: none) {
      body {
        background-attachment: scroll;
      }
    }

    /* Overlay tints for readability on sections — semi-transparent so body bg shows */
    .featured {
      background: rgba(240, 232, 216, 0.82);
    }

    .about {
      background: rgba(240, 232, 216, 0.88);
    }

    /* ─── NAV ─── */
    nav {
      background: rgba(10, 5, 2, 0.68);
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
      z-index: 100;
      border-bottom: 1px solid rgba(196, 168, 122, 0.2);
    }

    .nav-logo-text {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      font-weight: 700;
      color: #f5e8d0;
      letter-spacing: 0.04em;
      white-space: nowrap;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 18px;
      list-style: none;
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

    /* ─── SEARCH BAR (below nav) ─── */
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
      z-index: 99;
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

    /* ─── HERO ─── */
    .hero {
      position: relative;
      min-height: 600px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      background: #1c140d;
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      background-image: url('{{ asset("images/topimg.jpeg") }}');
      background-size: cover;
      background-position: center;
      opacity: 0.90;
      filter: sepia(30%) brightness(0.75);
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom,
          rgba(12, 6, 2, 0.22) 0%,
          rgba(12, 6, 2, 0.38) 55%,
          rgba(70, 31, 5, 0.6) 100%);
    }

    .hero-seal {
      position: relative;
      z-index: 2;
      margin-top: 72px;
      /* margin-bottom: 28px; */
      display: flex;
      justify-content: center;
    }

    .hero-seal img {
      width: 220px;
      height: 220px;
      border-radius: 50%;
      object-fit: contain;
      object-position: center;
      /* border: 2px solid rgba(196, 168, 122, 0.55); */
      /* background: rgba(255, 255, 255, 0.92); */
      padding: 6px;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      max-width: 820px;
      padding: 0 48px 80px;
    }

    .hero-content h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(24px, 4.5vw, 48px);
      font-weight: 400;
      color: #ffffff;
      line-height: 1.3;
      margin-bottom: 14px;
      text-shadow: 2px 2px 15px rgba(0, 0, 0, 0.8);
    }

    .hero-content h1+h1 {
      margin-top: -10px;
    }

    .hero-content .hero-sub {
      font-family: 'Times New Roman', Times, serif;
      font-size: clamp(16px, 2vw, 22px);
      font-weight: 400;
      color: rgba(255, 255, 255, 0.9);
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto 30px;
      text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
    }

    .hero-btns {
      display: flex;
      flex-wrap: nowrap;
      gap: 12px;
      justify-content: center;
      width: 100%;
      visibility: hidden;
    }

    .btn-primary {
      background: var(--crimson);
      color: #f5e8d0;
      border: none;
      padding: 13px 16px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.04em;
      cursor: pointer;
      border-radius: 3px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      transition: background 0.2s;
      font-family: 'Lato', sans-serif;
      flex: 1;
      max-width: 160px;
      min-height: 56px;
      line-height: 1.3;
      word-break: break-word;
    }

    .btn-primary:hover {
      background: var(--crimson-hover);
    }

    /* ─── SECTION TITLE ─── */
    .section-title-wrap {
      display: flex;
      align-items: center;
      gap: 16px;
      margin: 0 auto 36px;
      justify-content: center;
      width: 100%;
      max-width: 100%;
      padding: 0 40px;
    }

    .section-title-line {
      flex: 1;
      min-width: 0;
      height: 1px;
      background: var(--gold-line);
      opacity: 0.6;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(20px, 2.5vw, 28px);
      font-weight: 700;
      color: var(--text-dark);
      white-space: nowrap;
    }

    /* ─── COLLECTIONS GRID ─── */
    .featured {
      padding: 40px 0 70px;
    }

    .featured-inner {
      max-width: 1500px;
      margin: 0 auto;
      padding: 0 80px;
    }

    .collections-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 80px;
      margin: 0 auto;
    }

    /* ─── FIX 3: Collection cards height increased ─── */
    .coll-card {
      position: relative;
      height: 450px;
      /* was 520px */
      border-radius: 0px;
      overflow: hidden;
      background: #000;
      cursor: pointer;
    }

    .coll-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center top;
      filter: brightness(0.8);
      transition: transform 0.4s ease, filter 0.4s ease;
    }

    .coll-card::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to top,
          rgba(10, 4, 1, 0.92) 0%,
          rgba(10, 4, 1, 0.55) 38%,
          rgba(0, 0, 0, 0.05) 70%);
      z-index: 1;
    }

    .coll-body {
      position: absolute;
      bottom: 0;
      width: 100%;
      padding: 24px 20px;
      text-align: center;
      z-index: 2;
    }

    .coll-title {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 700;
      color: #f5e8d0;
      margin-bottom: 6px;
      line-height: 1.25;
    }

    .coll-desc {
      font-size: 17px;
      color: rgba(245, 232, 208, 0.72);
      margin-bottom: 18px;
      line-height: 1.5;
      font-family: 'Times New Roman', Times, serif;
    }

    .coll-card:hover .coll-img {
      transform: scale(1.06);
      filter: brightness(0.55);
    }

    .coll-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: var(--crimson);
      color: #f5e8d0;
      border: none;
      padding: 9px 20px;
      font-size: 11px;
      font-weight: 700;
      cursor: pointer;
      border-radius: 3px;
      text-decoration: none;
      font-family: 'Lato', sans-serif;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      transition: background 0.2s;
    }

    .coll-btn:hover {
      background: var(--crimson-hover);
    }

    /* ─── ABOUT / STATS ─── */
    .about {
      padding: 60px 40px;
    }

    .about-inner {
      max-width: 820px;
      margin: 0 auto;
      text-align: center;
    }

    .about-desc {
      font-size: clamp(16px, 1.8vw, 17px);
      color: var(--text-mid);
      line-height: 1.75;
      margin-bottom: 28px;
      font-family: 'Times New Roman', Times, serif;
    }

    .about-desc strong {
      color: var(--text-dark);
      font-weight: 700;
    }

    .read-more {
      font-size: inherit;
      font-family: inherit;
      text-decoration: none;
      color: #8b1e1e;
      font-weight: 600;
      white-space: nowrap;
      display: inline;
      transition: color 0.3s ease;
    }

    .read-more .arrow {
      display: inline-block;
      transition: transform 0.3s ease;
      margin-left: 2px;
    }

    .read-more:hover {
      color: #5a0f0f;
    }

    .read-more:hover .arrow {
      transform: translateX(4px);
    }

    .stats-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      border: 1px solid rgba(196, 168, 122, 0.5);
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 36px;
    }

    .stat-item {
      padding: 24px 12px;
      text-align: center;
      border-right: 1px solid rgba(196, 168, 122, 0.4);
    }

    .stat-item:last-child {
      border-right: none;
    }

    .stat-num {
      font-family: 'Times New Roman', Times, serif;
      font-size: clamp(38px, 3vw, 38px);
      font-weight: 700;
      color: var(--crimson);
      display: block;
      line-height: 1.1;
      margin-bottom: 7px;
    }

    .stat-label {
      font-size: 15.5px;
      color: var(--text-muted);
      text-transform: lowercase;
      letter-spacing: 0.05em;
      font-weight: 400;
      font-family: 'Times New Roman', Times, serif;
      line-height: 1.4;
    }

    .about-tagline {
      font-family: 'EB Garamond', serif;
      font-style: normal;
      font-size: clamp(15px, 1.8vw, 18px);
      color: var(--text-muted);
    }

    /* ─── FOOTER ─── */
    .footer-banner {
      position: relative;
      width: 100%;
      min-height: 150px;
      padding: 52px 0 24px;
      background-image:
        linear-gradient(rgba(15, 8, 5, 0.68), rgba(15, 8, 5, 0.88)),
        url('{{ asset("images/footer-bg.png") }}');
      background-size: cover;
      background-position: center 40%;
      overflow: hidden;
    }

    .footer-inner {
      position: relative;
      z-index: 2;
      max-width: var(--max-width);
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 16px;
      padding: 0 40px;
    }

    .footer-links {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 28px;
      flex-wrap: wrap;
    }

    .footer-links a {
      color: rgba(241, 239, 237, 0.92);
      text-decoration: none;
      font-size: 15px;
      transition: color 0.2s;
    }

    .footer-links a:hover {
      color: #fff;
    }

    .footer-sep {
      color: rgba(241, 239, 237, 0.45);
      font-size: 15px;
    }

    .footer-fb {
      width: 44px;
      height: 44px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.16);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #f1efed;
      text-decoration: none;
      font-size: 18px;
      font-weight: 700;
    }

    .footer-copy {
      font-size: 15px;
      color: rgba(241, 239, 237, 0.78);
      text-align: center;
      margin: 0;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 900px) {
      nav {
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

      .featured {
        padding: 70px 0 60px;
      }

      .about {
        padding: 44px 20px;
      }

      .featured-inner {
        padding: 0 25px;
      }

      .collections-grid {
        gap: 25px;
        max-width: 100%;
      }

      .coll-card {
        height: 380px;
      }
    }

    @media (max-width: 600px) {

      /* ─── FIX 1: Mobile logo size குறைக்கிறேன் ─── */
      .nav-logo-text {
        font-size: 14px;
        letter-spacing: 0.02em;
      }

      .hero {
        min-height: 520px;
      }

      .hero-seal {
        margin-top: 80px;
      }

      .hero-content {
        padding: 0 16px 52px;
      }

      .hero-content h1 {
        font-size: clamp(18px, 5.5vw, 26px);
      }

      .hero-btns {
        flex-wrap: nowrap;
        gap: 8px;
      }

      .btn-primary {
        font-size: 11px;
        padding: 10px 8px;
        min-height: 52px;
        max-width: none;
        flex: 1;
        letter-spacing: 0.02em;
      }

      .search-bar {
        padding: 10px 16px;
      }

      .search-bar input {
        font-size: 14px;
        padding: 8px 12px;
      }

      .featured {
        padding: 56px 0 48px;
      }

      .about {
        padding: 44px 20px;
      }

      .stats-row {
        grid-template-columns: repeat(2, 1fr);
      }

      .stat-item:nth-child(2) {
        border-right: none;
      }

      .stat-item:nth-child(3) {
        border-top: 1px solid rgba(196, 168, 122, 0.4);
      }

      .stat-item:nth-child(4) {
        border-top: 1px solid rgba(196, 168, 122, 0.4);
        border-right: none;
      }

      .footer-banner {
        min-height: 110px;
        padding: 24px 0 16px;
      }

      .footer-inner {
        padding: 0 16px;
        gap: 12px;
      }

      .footer-links {
        gap: 14px;
      }

      .footer-links a {
        font-size: 13px;
      }

      .footer-fb {
        width: 36px;
        height: 36px;
      }

      .footer-copy {
        font-size: 13px;
      }

      /* Mobile: 3 columns one row, neat height */
      .collections-grid {
        grid-template-columns: 1fr !important;
        gap: 24px;
        padding: 0 20px;
      }

      .coll-card {
        height: 300px;
      }

      .coll-title {
        font-size: 20px;
        margin-bottom: 8px;
        line-height: 1.2;
      }

      .coll-desc {
        font-size: 15px;
        margin-bottom: 15px;
        line-height: 1.4;
      }

      .coll-body {
        padding: 24px 20px;
      }

      .coll-btn {
        font-size: 11px;
        padding: 9px 18px;
        letter-spacing: 0.04em;
      }
    }
  </style>
</head>

<body>

  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <nav>
      <div class="nav-logo-text">THE TIC ARCHIVES</div>
      <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('client.home') }}"
            class="{{ request()->routeIs('client.home') ? 'active' : '' }}">Home</a></li>
        <li class="dropdown">
          <a href="{{ route('client.about') }}"
            class="{{ request()->routeIs('client.about', 'client.committee', 'client.technicalteam') ? 'active' : '' }}">About
            ▾</a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('client.about') }}">About Us</a></li>
            <li><a href="{{ route('client.archiving') }}">Submit</a></li>
            <li><a href="{{ route('client.committee') }}">Committee</a></li>
            <li><a href="{{ route('client.technicalteam') }}">Technical Team</a></li>
          </ul>
        </li>
        <li><a href="{{ route('client.archivecentrecollection') }}"
            class="{{ request()->routeIs('client.archivecentrecollection') ? 'active' : '' }}">Archive Centre</a></li>
        <li><a href="{{ route('client.heritage-centre') }}"
            class="{{ request()->routeIs('client.heritage-centre') ? 'active' : '' }}">Exhibition</a></li>
        <li><a href="{{ route('heritage.archive-centre') }}"
            class="{{ request()->routeIs('heritage.archive-centre') ? 'active' : '' }}">Heritage Museum</a></li>
        <li class="dropdown">
          <a href="{{ route('client.joinus') }}" class="{{ request()->routeIs('client.joinus') ? 'active' : '' }}">Join
            ▾</a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('client.joinus') }}">Member Application</a></li>
            <li><a href="{{ route('client.joinus') }}#volunteer-section">Become a Volunteer</a></li>
          </ul>
        </li>
        <li><a href="{{ route('client.publications') }}"
            class="{{ request()->routeIs('client.publications') ? 'active' : '' }}">Shop</a></li>
        <li><a href="{{ route('client.contactus') }}"
            class="{{ request()->routeIs('client.contactus') ? 'active' : '' }}">Contact</a></li>
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
    </nav>

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

    <div class="hero-seal">
      <img src="{{ asset('images/logo.png') }}" alt="TIC Seal" fetchpriority="high" loading="eager">
    </div>

    <div class="hero-content">
      <h1>"Every document tells a story.</h1>
      <h1>Every story preserves a people"</h1>
      <p class="hero-sub">A living archive dedicated to preserving, documenting, and exhibiting the human rights legacy,
        history, heritage, and culture of the Tamil-speaking people of Ilankai (Sri Lanka).<br><br><em>— Tamil
          Information Centre (TIC)</em></p>
      <div class="hero-btns">
        <a href="{{ route('client.archivecentrecollection') }}" class="btn-primary">Explore Collections</a>
        <a href="{{ route('client.heritage-centre') }}" class="btn-primary">Visit the Exhibition</a>
        <a href="{{ route('client.about') }}" class="btn-primary">About the Archive</a>
      </div>
    </div>
  </section>

  <!-- FEATURED COLLECTIONS -->
  <section class="featured">
    <div class="section-title-wrap">
      <div class="section-title-line"></div>
      <h2 class="section-title">Featured Collections</h2>
      <div class="section-title-line"></div>
    </div>
    <div class="featured-inner">
      <div class="collections-grid">
        <div class="coll-card" onclick="window.location='{{ route('client.archivecentrecollection') }}'">
          <img src="{{ asset('images/collection.jpeg') }}" alt="Oral Testimonies" class="coll-img" loading="lazy">
          <div class="coll-body">
            <div class="coll-title">The TIC Collection</div>
            <div class="coll-desc"></div>
            <a href="{{ route('client.archivecentrecollection') }}" class="coll-btn">View Collection</a>
          </div>
        </div>
        <div class="coll-card" onclick="window.location='{{ route('client.heritage-centre') }}'">
          <img src="{{ asset('images/exhibiton.jpeg') }}" alt="Historical Documents" class="coll-img" loading="lazy">
          <div class="coll-body">
            <div class="coll-title">Explore the Exhibition</div>
            <div class="coll-desc"></div>
            <a href="{{ route('client.heritage-centre') }}" class="coll-btn">View Collection</a>
          </div>
        </div>
        <div class="coll-card" onclick="window.location='{{ route('heritage.archive-centre') }}'">
          <img src="{{ asset('images/museum.jpeg') }}" alt="Photographic Archive" class="coll-img" loading="lazy">
          <div class="coll-body">
            <div class="coll-title">Visit the Heritage <br> Museum</div>
            <div class="coll-desc"></div>
            <a href="{{ route('heritage.archive-centre') }}" class="coll-btn">View Collection</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about">
    <div class="section-title-wrap">
      <div class="section-title-line"></div>
      <h2 class="section-title">About The TIC Archives</h2>
      <div class="section-title-line"></div>
    </div>
    <div class="about-inner">
      <p class="about-desc">With over <strong>43 years</strong> of documentation and activism, The TIC Archives is
        dedicated to preserving the history, human rights and cultural heritage of Tamil-speaking people in Ilankai /
        Sri Lanka. <a href="{{ route('client.about') }}" class="read-more">Read more <span class="arrow">→</span></a>
      </p>

      <div class="stats-row">
        <div class="stat-item">
          <span class="stat-num">43+</span>
          <span class="stat-label">Years of Documentation</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">5,000+</span>
          <span class="stat-label">Historical Records Preserved</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">700+</span>
          <span class="stat-label">Oral Histories Collected</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">1M+</span>
          <span class="stat-label">Digital Files Archived</span>
        </div>
      </div>
      <p class="about-tagline">A global resource for researchers, educators, and communities worldwide.</p>
    </div>
  </section>

  <!-- FOOTER BANNER -->
  <footer class="footer-banner">
    <div class="footer-inner">
      <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <span class="footer-sep">|</span>
        <a href="#">Terms of Use</a>
        <span class="footer-sep">|</span>
        <a href="{{ route('client.contactus') }}">Contact Us</a>
        <span class="footer-sep">|</span>
        <a href="https://facebook.com" class="footer-fb">f</a>
      </div>
      <p class="footer-copy">© 2026 The TIC Archives. All rights reserved</p>
    </div>
  </footer>

  <script>
    var hamburger = document.getElementById('hamburger');
    var navLinks = document.getElementById('navLinks');
    hamburger.addEventListener('click', function () {
      var isOpen = navLinks.classList.toggle('open');
      hamburger.classList.toggle('open', isOpen);
    });

    var searchToggle = document.getElementById('searchToggle');
    var searchBar = document.getElementById('searchBar');
    var searchClose = document.getElementById('searchClose');
    var searchInput = document.getElementById('searchInput');

    searchToggle.addEventListener('click', function () {
      searchBar.classList.add('open');
      setTimeout(function () { searchInput.focus(); }, 50);
    });

    searchClose.addEventListener('click', function () {
      searchBar.classList.remove('open');
      searchInput.value = '';
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && searchBar.classList.contains('open')) {
        searchBar.classList.remove('open');
        searchInput.value = '';
      }
    });
  </script>
</body>

</html>