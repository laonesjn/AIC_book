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
}

/* About Page Hero Section Style */
.about-header {
    width: 100%; 
    
    margin: 0 auto 4rem auto; 
    
    text-align: center;
    display: flex;
    padding: 8rem 1rem 5rem; 
    flex-direction: column;
    align-items: center;
    justify-content: center;

    background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
    border: 1px solid rgba(0, 0, 0, 0.08); 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); 
    border-radius: var(--border-radius); /* Rounded corners */
}

.about-header h1 {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--accent-dark);
    margin: 0 0 1rem 0;
    letter-spacing: -1.5px;
    line-height: 1.2;
}

.about-header p {
    font-size: 1.25rem;
    color: var(--accent-dark);
    opacity: 0.8;
    margin: 0;
    max-width: 800px; 
}
.about-section {
    background-color: var(--card-bg);
  padding: 5rem 5.5rem;
    margin-top:  -10.5rem;
    border-radius: var(--border-radius);
    
}

.about-section h2 {
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
    color: var(--accent-dark);
}
.about-section.guiding-principle {
    max-width: 1100px;
    margin: 0 auto;              /* center align */
    padding: 5rem 5.5rem;        /* internal spacing */
    text-align: center;
    position: relative;
}


/* CONTAINER */
.vision-mission {
       display: grid;
    grid-template-columns: 1fr;
    gap: 2.5rem;
    max-width: 1150px;
    margin: 0 auto;
    padding: 4rem 1.5rem;;
}

/* Cards container for Vision & Mission */
.vm-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2.5rem;
}

/* ALL CARDS */
.vm-card {
    background: var(--card-bg);
    padding: 2.2rem;
    border-radius: var(--border-radius);
    box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.vm-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 32px rgba(0,0,0,0.12);
    background: var(--hover-bg);
}

/* Intro Card - Full Width */
.vm-intro {
    grid-column: 1 / -1;
    text-align: center;
}

.vm-intro h2 {
    font-size: 2.2rem;
    margin-bottom: 0.8rem;
    color: var(--accent-dark);
}

.vm-intro p {
    max-width: 850px;
    margin: 0 auto;
    line-height: 1.9;
    color: #000000;
}

/* ICONS */
.vm-card .icon-wrapper {
    text-align: center;
    margin-bottom: 1.5rem;
}

.vm-card .icon-wrapper i {
    color: var(--accent-dark);
    transition: all 0.4s ease;
}

.vm-card:hover .icon-wrapper i {
    color: var(--accent-muted);
    transform: scale(1.2) rotate(10deg);
}

/* HEADINGS */
.vm-card h3 {
    font-size: 2.5rem;
    color: var(--accent-dark);
    margin-bottom: 1rem;
    text-align: center;
    position: relative;
}

.vm-card h3::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    margin: 0.5rem auto 0;
    border-radius: 4px;
    background: linear-gradient(to right, var(--accent-muted), var(--accent-dark));
}

/* LISTS */
.vm-card ul {
    padding-left: 1.2rem;
    margin-top: 1rem;
}

.vm-card li {
    margin-bottom: 0.8rem;
    line-height: 1.6;
    position: relative;
}

.vm-list li::marker {
    color: var(--accent-dark);
    font-weight: bold;
}

/* MISSION intro */
.mission-intro {
    margin-bottom: 1rem;
    line-height: 1.6;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .vm-cards {
        grid-template-columns: 1fr;
    }
}

.view-more, .join-today {
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-more {
    background-color: var(--accent-dark);
    color: white;
}

.view-more:hover {
    background-color: var(--hover-bg);
    color: var(--accent-dark);
}

.join-today {
    background-color: white;
    color: var(--accent-dark);
        border-radius: #0f2540;

}

.join-today:hover {
    background-color: var(--hover-bg);
}

.peace-building, .work-partners {
    padding: 1.5rem;
    margin: 2rem 8REM;
     max-width: 1100px;
    border-radius: var(--border-radius);
}

.peace-building {
    background-color: var(--card-bg);
}


.peace-building h2,
 .work-partners h2 {
    color:  #0f2540;
    padding-bottom: 0.5rem;
        text-align: center;
}

.work-partners {
    background-color: var(--card-bg);
    color:  #0f2540;
    text-align: center;
    padding: 2rem;
}

.work-partners h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.work-partners p {
    margin-bottom: 1rem;
}

/* Mobile dropdown styles */
.mobile-dropdown-parent {
    position: relative;
}

.mobile-dropdown-content {
    display: none;
    padding-left: 1rem;
    background-color: rgba(15, 37, 64, 0.05);
    border-radius: 8px;
    margin-top: 0.5rem;
}

.mobile-dropdown-content.active {
    display: block;
}

.mobile-dropdown-toggle .arrow {
    margin-left: auto;
    transition: transform 0.3s ease;
}

.mobile-dropdown-toggle[aria-expanded="true"] .arrow {
    transform: rotate(180deg);
}

/* TIC at a Glance */
.tic-glance h2 {
    text-align: center;
    margin-bottom: 4rem;
    color: var(--accent-dark);
    font-size: 2.5rem;
    font-weight: 800;
    position: relative;
}

.tic-glance h2::after {
    content: '';
    width: 100px;
    height: 4px;
    background: var(--accent-muted);
    display: block;
    margin: 1rem auto 0;
}

.glance-grid {
    display:contents;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.glance-flip-card {
    width: 280px;
    height: 380px;
    perspective: 1000px;
}

.glance-flip-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    transform-style: preserve-3d;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 20px;
}

.glance-flip-card:hover .glance-flip-inner {
   transform: rotateY(180deg);
}

.glance-front, .glance-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    border-radius: 20px;
    background: white;
}

.glance-front {
    background: linear-gradient(135deg, #f6e3c5, #ffffff);
}

.glance-front img {
    width: 180px;
    height: 180px;
    object-fit: contain;
    margin-bottom: 2rem;
    filter: drop-shadow(0 5px 10px rgba(15,37,64,0.2));
    border-radius: 24px;
    background: rgba(255,255,255,0.8);
    padding: 1rem;
}

.glance-front h3, .glance-back h3 {
    color: var(--accent-dark);
    font-family: 'Georgia', serif;
    font-size: 1.4rem;
    margin: 0;
}

.glance-back {
    background: var(--accent-dark);
    color: white;
    transform: rotateY(180deg);
    overflow-y: auto;
}

.glance-back p {
    font-size: 1rem;
    line-height: 1.7;
    text-align: left;
    margin-top: 1rem;
    font-family: 'Inter', sans-serif;
}

.second-row-wrapper {
    display: flex;
    justify-content: center;
    gap: 2rem;
    width: 100%;
    flex-wrap: wrap;
}
/* TIC Intro Card */
.tic-intro {
    background: var(--card-bg);
    padding: 2.5rem 2rem;
    border-radius: var(--border-radius);
    box-shadow: 0 10px 30px rgba(15, 37, 64, 0.1);
    text-align: center;
    max-width: 1100px;
    margin: 0 auto 3rem auto;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.tic-intro h2 {
    font-size: 2.2rem;
    color: var(--accent-dark);
    margin-bottom: 1rem;
}

.tic-intro p {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #000;
}
.tic-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    justify-items: center;
}


/* Accordion FAQ Styles (New - Replaces old details/summary) */
.faq h2 {
    color: var(--accent-dark);
    padding-bottom: 0.5rem;
    text-align: center;
    font-size: 2rem;
    margin: 2rem 0;
    
}

.faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    
}

.faq-item {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(15, 37, 64, 0.05);
    transition: all 0.3s ease;
}

.faq-question {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 1.25rem 1.5rem;
    font-weight: 600;
    font-size: 1rem;
    color: var(--accent-dark);
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.faq-question:hover,
.faq-question[aria-expanded="true"] {
    background-color: var(--hover-bg);
}

.faq-question .icon {
    font-weight: bold;
    font-size: 1.8rem;
    transition: transform 0.3s ease;
}

.faq-question[aria-expanded="true"] .icon {
    transform: rotate(45deg);
}

/* Optional: Show − instead of rotated + */
.faq-question[aria-expanded="true"] .icon::before {
    content: "−";
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease, padding 0.4s ease;
    padding: 0 1.5rem;
}

.faq-answer.open {
    max-height: 500px; /* Increased for longer content */
    padding: 1rem 1.5rem 1.5rem;
    border-top: 1px solid rgba(15, 37, 64, 0.1);
}

.faq-answer p {
    margin: 0;
    line-height: 1.7;
}

.faq-question:focus-visible {
    outline: 3px solid var(--accent-dark);
    outline-offset: -3px;
}

/* ===================================================
   RESPONSIVE DESIGN (Media Queries)
   =================================================== */
@media (min-width: 768px) {
    .main-nav { display: block; }
    .mobile-menu-btn { display: none; }
   
}



@media (max-width: 1200px) {
    .glance-grid { justify-content: center; }
    .glance-flip-card { width: 250px; height: 360px; }
    .second-row-wrapper { justify-content: center; }
}





/* Tamil News Section Specific */
.news-section .footer-desc {
    color: #ccc;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}    
    .news-section {
        grid-column: span 1;
        text-align: center;
    }
    
    
  
/* Grid Layout */
    .glance-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .second-row-wrapper {
        grid-column: 1 / -1; /* Full width for second row */
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .glance-card {
        width: 100%;
        max-width: 280px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
    }

    .glance-card:hover {
        transform: translateY(-15px) scale(1.05);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .glance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(0,0,0,0.3));
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
    }

    .glance-card:hover::before {
        opacity: 1;
    }

    .icon-wrapper {
        text-align: center;
        padding: 30px 0 20px;
        background: #f0f4f8;
        transition: all 0.4s ease;
    }

    .icon-wrapper i {
        color: #3b82f6; /* Blue theme */
        transition: transform 0.4s ease;
    }

    .glance-card:hover .icon-wrapper i {
        transform: scale(1.2) rotate(10deg);
    }

    .glance-content {
        padding: 20px;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .glance-content h3 {
        margin: 0 0 10px;
        color: #333;
        font-size: 1.6rem;
    }

    .glance-content p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .glance-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .second-row-wrapper {
            flex-direction: column;
            align-items: center;
        }
    }

    @media (max-width: 768px) {
        .glance-grid {
            grid-template-columns: 1fr;
        }
    }
    .tic-glance h2 {
        text-align: center;
        color: var(--accent-dark);
        margin-bottom: 40px;
    }

    .glance-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .second-row-wrapper {
        grid-column: 1 / -1;
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .glance-card {
        width: 100%;
        max-width: 280px;
        background: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: 0 10px 30px rgba(15, 37, 64, 0.1);
        overflow: hidden;
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
    }

    .glance-card:hover {
        transform: translateY(-15px) scale(1.05);
        box-shadow: 0 20px 40px rgba(15, 37, 64, 0.2);
        background: var(--hover-bg);
    }

    .glance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(191, 169, 139, 0.2), rgba(15, 37, 64, 0.3));
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
    }

    .glance-card:hover::before {
        opacity: 1;
    }

    .icon-wrapper {
        text-align: center;
        padding: 30px 0 20px;
        background: rgba(246, 227, 197, 0.5);
        transition: all 0.4s ease;
    }

    .icon-wrapper i {
        color: var(--accent-dark);
        transition: all 0.4s ease;
    }

    .glance-card:hover .icon-wrapper i {
        color: var(--accent-muted);
        transform: scale(1.2) rotate(10deg);
    }

    .glance-content {
        padding: 20px;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .glance-content h3 {
        margin: 0 0 10px;
        color: var(--accent-dark);
        font-size: 1.6rem;
    }

    .glance-content .details {
        display: none; /* Default hide details */
        color: #000000; /* Dark black text */
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 15px 0 0;
    }

    .glance-card:hover .details {
        display: block; /* Show on hover */
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .glance-grid { grid-template-columns: repeat(2, 1fr); }
        .second-row-wrapper { flex-direction: column; align-items: center; }
    }

    @media (max-width: 768px) {
        .glance-grid { grid-template-columns: 1fr; }
    }
:root {
    --primary-bg:#f6e3c5;;
    --primary-gold: #c5a059;
    --accent-dark: #0f2540;
    --accent-muted: #bfa98b;
    --accent-red: #8e1b1b;
    --card-bg: #f6ece0;
    --border-radius: 12px;
}

/* ===============================
   BASE
================================ */
body {
    background-color:#f6e3c5;;
    /* font-family: 'Inter', sans-serif; */
    color: var(--accent-dark);
    overflow-x: hidden;
}

/* ===============================
   HERO SECTION
================================ */
.archive-hero {
    background-color: #e2caa8;
    padding: 50px 20px;
    text-align: center;
    border-bottom: 1px solid var(--accent-muted);
    margin-bottom: 0.5rem;
}

.archive-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    margin-bottom: 1rem;
}

.archive-tagline {
    font-size: 1.2rem;
    max-width: 800px;
    margin: 0 auto;
    opacity: 0.85;
    border-top: 1px solid var(--accent-muted);
    padding-top: 1.5rem;
}

/* ===============================
   ESTABLISHED TEXT
================================ */
.established-text {
    text-align: center;
    font-weight: 700;
    letter-spacing: 3px;
    margin: 20px 0 40px;
    text-transform: uppercase;
    font-size: 0.9rem;
}

/* ===============================
   ARCHIVE CONTENT
================================ */
.archive-history {
    max-width: 900px;
    margin: auto;
    /* padding: 0 2rem 5rem; */
}

.history-article {
    max-width: 850px;
    margin: 0 auto;
}

.lead-text {
    font-size: 1.3rem;
    line-height: 1.8;
    font-weight: 600;
    margin-bottom: 30px;
    border-left: 5px solid var(--accent-red);
    padding-left: 20px;
}

.content-main p {
    font-size: 1.3rem;
    line-height: 1.9;
    margin-bottom: 25px;
    color: #333;
    text-align: justify;
}

/* ===============================
   HIGHLIGHT / LEGACY
================================ */
.highlight-box {
    background-color: var(--card-bg);
    padding: 30px;
    border-radius: var(--border-radius);
    margin: 40px 0;
    border: 1px solid var(--accent-muted);
}

.highlight-box p {
    font-style: italic;
    margin-bottom: 0;
}

.legacy-section {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 2px solid var(--primary-bg);
}

.legacy-section p {
    font-weight: 600;
    color: var(--accent-red);
}

/* ===============================
   RESPONSIVE
================================ */
@media (max-width: 768px) {
    .archive-hero h1 {
        font-size: 2.5rem;
    }

    .archive-hero {
        padding: 50px 15px;
    }

    .lead-text {
        font-size: 1.15rem;
    }

    .content-main p {
        font-size: 1rem;
    }
}

@media (max-width: 767px) {
    /* Common for both sections */
    .about-section,
    .work-partners {
        padding: 2rem 1.5rem !important;   /* smaller padding for mobile */
        /* negative margin remove pannu */
        margin-bottom: 2rem;
        text-align: center;                 /* h2 & p center aagum */
        background: var(--card-bg);         /* background clear aagum */
        border-radius: var(--border-radius);
    }

    /* h2 mobile la smaller & bold */
    .about-section h2,
    .tic-glance h2,
    .work-partners h2 {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--accent-muted); /* optional underline for separation */
    }

    /* Paragraphs mobile la readable */
    .about-section p,
     .tic-intro p,
    .work-partners p {
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        text-align: left;                   /* center venumna center pannu, left better readability ku */
        max-width: 100%;                    /* full width use pannum */
        padding: 0 0.5rem;
    }



    /* Join Today button mobile la big touch target */
    .join-today {
        display: inline-block;
        margin-top: 1.5rem;
        padding: 0.9rem 2rem;
        font-size: 1.1rem;
        min-width: 200px;                   /* easy touch */
        text-align: center;
    }

    /* Extra space sections kulla */
    .about-section.peace-building,
    .work-partners {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08); /* light shadow for separation */
    }
}
@media (max-width: 767px) {
    /* Rendu sections kum common fix */
    .about-section.peace-building,
    .work-partners {
        width: 95% !important;              /* width increase - almost full screen */
        max-width: 100%;                    /* no restriction */
        margin-left: auto;
        margin-right: auto;
        padding: 1.8rem 1.2rem !important;  /* padding reduce to make height shorter */
       /* negative margin eduthu */
        margin-bottom: 1.5rem;
        text-align: left;                   /* left align better readability ku */
        background: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    /* h2 smaller & tight */
    .about-section.peace-building h2,
    .work-partners h2 {
        font-size: 1.7rem;
        margin-bottom: 0.8rem;
        padding-bottom: 0.4rem;
    }

    /* p text compact & readable */
    .about-section.peace-building p,
    .work-partners p {
        font-size: 0.98rem;
        line-height: 1.65;
        margin-bottom: 1rem;
        padding: 0 0.3rem;
        text-align: justify;                /* justify pannina neat look varum */
    }

    /* Join Today button mobile la neat */
    .work-partners .join-today {
        margin-top: 1rem;
        padding: 0.8rem 1.8rem;
        font-size: 1rem;
        min-width: 180px;
    }
}
@media (max-width: 768px) {
    .archive-hero h1,
    .archive-hero .archive-tagline {
        white-space: nowrap;        /* keep in a single line */
        overflow: hidden;           /* hide overflow */
        text-overflow: ellipsis;    /* show ... if text too long */
    }

    .archive-hero h1 {
        font-size: 1.4rem;          /* scale down for mobile */
    }

    .archive-hero .archive-tagline {
        font-size: 0.95rem;         /* adjust text size for mobile */
    }
}



</style>


<section style='font-family: "Georgia", "Times New Roman", serif;'>

     <section class="archive-hero">
            <div class="container">
            <h1>About Tamil Information Centre</h1>
                <p class="archive-tagline">
                    Preserving memory, history, and human rights for future generations
                </p>
            </div>
        </section>

        <div class="established-text">
            --- Established in 1979 ---
        </div>

        <section class="archive-history">
            <article class="history-article">
                
                <p class="lead-text">
                    The Tamil Information Centre (TIC) Digital Archive is an independent and authoritative 
                    repository dedicated to the collection, preservation, and dissemination of historical,
                     cultural, and human rights documentation relating to Tamil-speaking people in Sri Lanka.
                </p>

                <div class="content-main">
                    <p>
                        Established in 1979 by Tamil activists based in the United Kingdom, the Tamil Information 
                        Centre has, for over four decades, played a pioneering role in the systematic documentation 
                        of first-hand, authentic, and verifiable information. From its early operations in London 
                        and Tamil Nadu, TIC emerged as one of the earliest and most professionally committed research
                         and documentation organisations focused on the lived realities, historical experiences, 
                         and human rights conditions of Tamil-speaking communities.
                    </p>

                    <p>
                        The archive reflects TIC’s principled commitment to human rights grounded in justice, 
                        equality, and respect for fundamental freedoms. TIC does not promote any particular
                         political solution for Sri Lanka; rather, it maintains a neutral and rights-based approach,
                          guided by the Universal Declaration of Human Rights (UDHR) and other internationally recognised human rights instruments.
                    </p>

                    <div class="highlight-box">
                        <p>
                            Over the years, TIC researchers and contributors undertook their work under
                             extremely challenging and often dangerous conditions, facing threats from military 
                             forces and armed groups in Sri Lanka and India. Despite these risks, they demonstrated 
                             exceptional dedication in collecting, safeguarding, and preserving critical records.
                        </p>
                    </div>

                    <p>
                        The TIC Digital Archive contains a wide range of primary source materials, including affidavits, 
                        habeas corpus applications, official and unofficial documents, correspondence from detainees 
                        and political prisoners, eye-witness testimonies, reports from conflict zones, photographs, 
                        and audio-visual recordings of interviews and speeches. 
                    </p>

                    <p>
                        Through its extensive global network, TIC has collaborated with governmental and 
                        non-governmental organisations, legal professionals, and human rights defenders. Accuracy, 
                        integrity, and accountability form the foundation of the archive.
                    </p>

                    <div class="legacy-section">
                        <p>
                            The TIC Digital Archive is an extension of this legacy and a commitment to its continuation. 
                            It stands as both a historical record and a living resource for research, education, 
                            public engagement, and intergenerational memory.
                        </p>
                    </div>
                     <p>
                        At this crucial stage in the development of the TIC Digital Archive, as the organisation carries 
                        forward the long-standing legacy established by its pioneers, supporters, and the wider Tamil-speaking community, 
                        the public launch of these collections represents both a milestone and a responsibility. This moment is also one of remembrance. 
                        The archive honours the memory and lifelong contributions of the founders and pioneers of the Tamil Information Centre, 
                        including the late<b> Mr. Kanthasamy</b>, 
                        the late<b> Mr. Varadakumar</b>, and the late <b>Fr. James Pathinathar</b>, as well as many others whose commitment, sacrifice, and vision laid the foundations for this work. Their journeys,
                         principles, and dedication continue to guide the mission of TIC and inspire the preservation of these records for generations to come.
                    </p>
                </div>
            </article>
        </section>


        <section class="vision-mission">

        <!-- Intro Card -->
        <div class="vm-card vm-intro">
            <h2>Vision and Mission</h2>
            <p>
                The TIC desires peace, stability, and harmony in the island of Sri Lanka where
                fundamental human rights, dignity, and justice are upheld for all communities.
            </p>
        </div>

        <div class="vm-cards">

            <!-- Vision Card -->
            <div class="vm-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-eye fa-3x"></i>
                </div>
                <h3>Vision</h3>
                <ul class="vm-list">
                    <li>People live with dignity free from persecution, and their civil, political, economic, and cultural rights as enshrined in the UDHR and other UN instruments are recognised.</li>
                    <li>Self-preservation within their homeland is promoted, and every individual in any part of the island is respected, cared for and loved.</li>
                    <li>Human rights are respected, fostered and promoted without oppression.</li>
                    <li>The right of self-determination of all peoples is recognised, empowering them to freely determine their political status and pursue political, economic, social, and cultural development.</li>
                </ul>
            </div>

            <!-- Mission Card -->
            <div class="vm-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-bullseye fa-3x"></i>
                </div>
                <h3>Mission</h3>
                <p class="mission-intro">
                    The TIC’s mission is to empower people, particularly those suffering persecution and human rights abuses, valuing distinct identities and improving quality of life through access to knowledge. In pursuing this mission, TIC strives to:
                </p>
                <ul class="vm-list">
                    <li>Assist in the search for a just and lasting peace in Sri Lanka.</li>
                    <li>Respond to the needs of victims of war or oppression in Sri Lanka.</li>
                    <li>Protect refugees and asylum-seekers at risk of persecution by providing information on Sri Lanka, refugee rights, and related issues.</li>
                    <li>Initiate advocacy and public campaigns to promote just policies and procedures by governments and international institutions.</li>
                </ul>
            </div>

        </div>
        </section>


        <section class="about-section guiding-principle">
            <h2>The Guiding Principle</h2>
            <p>A primary function of the TIC is to provide a forum for the exchange of views and information. 
                The TIC fosters cooperation between governmental, non-governmental and intergovernmental agencies, 
                and supports activities that promote human rights, peace and community development.</p>
        </section>

        <section class="about-section peace-building">
            <h2>Peace Building</h2>
            <p>The TIC continues to prioritise peace building as an important area of work, realising emphasis on 
                solidarity with human rights and justice groups throughout the world. The knowledge and experience
                 of the TIC in this field have now been transformed into common guidelines for the promotion of peace and 
                 advocacy work and placed at the disposal of organisations involved in peace work, aimed at strengthening 
                 cooperative partnership.</p>
        </section>

                <!--tic-glance-->
        <section class="tic-glance">
            <!-- Intro Card -->
            <div class="tic-intro">
                <h2>Tamil Information Centre (TIC) at a Glance</h2>
                <p>The<b> Tamil Information Centre (TIC)</b> is an independent, community-based, non-profit organisation dedicated
                    to the promotion and protection of the human rights of the Tamil-speaking people of Sri Lanka.
                    Established in <b>1979 in London, United Kingdom,</b> TIC was founded to empower Tamil-speaking communities
                    through access to knowledge, information, and a wide range of services, programmes, and initiatives.
        The core aim of TIC is to contribute towards the creation of a just, inclusive, and cohesive society—free from
        persecution—where human dignity is respected, individual freedoms are protected, and fundamental human rights are upheld and promoted.
                </p>
            </div>
            <div class="glance-grid">
                <!-- First Row: 4 Cards -->
                <div class="glance-card">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-building-columns fa-4x"></i>
                    </div>
                    <div class="glance-content">
                        <h3>Structure</h3>
                        <p class="details">The Tamil Information Centre is based in <b>London </b>and operates under the direction 
                            of a <b>voluntary Board</b>, supported by a small number of staff, volunteers, and associates. 
                            TIC draws upon a wide pool of skilled volunteers, programme partners, consultants,
                            and subject-matter experts to deliver its work across human rights, community development, peace building, and documentation.</p>
                    </div>
                </div>

                <div class="glance-card">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-network-wired fa-4x"></i>
                    </div>
                    <div class="glance-content">
                        <h3>Communication, Cooperation and Network</h3>
                        <p class="details">A central function of TIC is to serve as a platform for the exchange of information,
                            perspectives, and expertise. Over the years, TIC has developed strong working
                            relationships with <b>governmental, non-governmental, and intergovernmental organisations</b>, 
                            as well as individuals across the world.
        These relationships form TIC’s information and cooperation network and regularly give rise to seminars, 
        workshops, conferences, campaigns, and joint initiatives aimed at advancing human rights, peace, and sustainable development.</p>
                    </div>
                </div>

                <div class="glance-card">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-book-open fa-4x"></i>
                    </div>
                    <div class="glance-content">
                        <h3>Resource Centre and Documentation</h3>
                        <p class="details">TIC maintains a dedicated <b>documentation and resource centre </b>that serves as a comprehensive repository
                            of materials relating to the Tamil-speaking people of Sri Lanka.
                            The collection—now comprising<b> nearly 25,000 items</b>—includes documents obtained through 
                            TIC’s own sources as well as external materials.
        This resource has become a significant reference point for researchers, journalists, campaigners, practitioners, 
        students, and media professionals. TIC also supports journalists, NGO representatives, researchers,
        and students during visits to war-affected and sensitive areas in Sri Lanka, facilitating access to first-hand information and informed analysis.</p>
                    </div>
                </div>

                <div class="glance-card">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-magnifying-glass-chart fa-4x"></i>
                    </div>
                    <div class="glance-content">
                        <h3>Information, Research and Advocacy</h3>
                        <p class="details">TIC provides a broad range of specialist and general information services. The organisation recognises
                            that <b>rigorous research and informed advocacy </b>are essential to
                            influencing policy and practice, both within Sri Lanka and internationally.
        TIC’s publications include briefing papers, analytical reports, books, and thematic studies addressing political, 
        social, humanitarian, and human rights issues affecting the Tamil-speaking population. Where appropriate,
        TIC has also engaged in strategic litigation.</p>
                    </div>
                </div>

                <!-- Second Row: 3 Cards -->
                <div class="second-row-wrapper">
                    <div class="glance-card">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-bell fa-4x"></i>
                        </div>
                        <div class="glance-content">
                            <h3>Current Awarenessand Information Service</h3>
                            <p class="details">The Tamil Information Centre responds to a wide spectrum of
                                enquiries from NGOs, journalists, researchers, students, refugee agencies, government bodies, 
                                legal professionals, social workers, cultural practitioners, human rights defenders, and community organisations.
        Subjects addressed include history, displacement, refugees and asylum seekers, militarisation, 
        human rights violations, culture, education, employment, relief and rehabilitation, peace initiatives, 
        political movements, and national and international organisations.
        Enquiries are handled by experienced documentalists and researchers, providing a cost-effective and reliable information service.</p>
                        </div>
                    </div>

                    <div class="glance-card">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-handshake fa-4x"></i>
                        </div>
                        <div class="glance-content">
                            <h3>Liaison, Community Development, and Training</h3>
                            <p class="details">TIC works closely with grassroots organisations, civil society groups, 
                                resistance movements, and international agencies to promote dialogue, cooperation, and collective 
                                action in pursuit of justice, peace, and human rights in Sri Lanka.
        Its community development programmes engage women, elders, refugees, and social, cultural, and human rights workers, aiming to 
        strengthen community resilience and participation. TIC conducts studies, training programmes, seminars, and workshops to enhance
        skills, foster leadership, and encourage informed civic engagement.
        Book launches organised by TIC have also supported emerging and disadvantaged writers, contributing to cultural expression, 
        intellectual exchange, and social networking within the community.</p>
                        </div>
                    </div>

                    <div class="glance-card">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-dove fa-4x"></i>
                        </div>
                        <div class="glance-content">
                            <h3>Peace Building, Campaigns, and Solidarity</h3>
                            <p class="details">Peace building remains a priority area of TIC’s work. Drawing on decades of experience, 
                                TIC promotes solidarity with global human rights and justice movements and shares its knowledge and best 
                                practices with organisations engaged in peace advocacy.
        Campaigning is one of the most visible ways in which TIC represents its constituents. Through human rights alerts, urgent actions,
        advocacy campaigns, and public engagement, TIC highlights abuses, mobilises support, and seeks accountability. These efforts are 
        underpinned by solidarity and collective action, recognising that meaningful progress requires cooperation across diverse actors and networks.</p>
                        </div>
                    </div>

                    <div class="glance-card">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-folder-open fa-4x"></i>

                        </div>
                        <div class="glance-content">
                            <h3>Documentation, Archives, and Heritage</h3>
                            <p class="details">The Tamil Information Centre continues to collect artefacts, documents, books, 
                                and other materials to preserve and present Tamil history, culture, and heritage. TIC has organised 
                                numerous historical exhibitions and is actively working towards the establishment of a permanent 
                                archive and heritage museum, ensuring that these histories are preserved and made accessible for present and future generations..</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
                <section class="work-partners">
            <h2>Work with partners</h2>
            <p>We work with partners in two capacities, either on a joint project to conduct an event or program to
                 reduce costs, or as part of our advocacy program where we bring together different actors with expertise and
                  a variety of complementary skills to achieve our objectives.</p>
            <p>In other words TIC partnership is about providing the spaces where creative thoughts and ideas can emerge, gain 
                support and build momentum in order to bring about positive transformation. Partnership working can also help to avoid unnecessary duplication of effort.</p>
<a href="./form.html" class="join-today">
    Join Today
</a>

        </section>
<!-- FAQ Section -->
<section class="faq">
    <h2>Frequently Asked Questions</h2>
    
    <div class="faq-accordion">
        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                What is the main purpose of TIC? 
                <span class="icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer">
                <p>The primary purpose of the Tamil Information Centre (TIC) is to collect, preserve, and provide access to information, documentation, and research materials concerning Tamil-speaking communities and related issues in Sri Lanka. It serves as a vital resource hub for understanding the historical, social, political, and cultural contexts affecting these communities.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                Does TIC run relief or development projects? 
                <span class="icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer">
                <p>No, TIC does not directly implement relief or development projects on the ground. Instead, it focuses on supporting organisations, researchers, and community groups engaged in such work by providing reliable information, documentation, research assistance, and advocacy support.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                Where is TIC based? 
                <span class="icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer">
                <p>The Tamil Information Centre is based in London, United Kingdom. It operates under the guidance of a volunteer Board of Trustees, with a dedicated team of staff and volunteers who manage its collections, services, and outreach activities.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                Who can use TIC's resources? 
                <span class="icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer">
                <p>TIC's resources are open to everyone with a genuine interest in Tamil-speaking communities and Sri Lankan issues. This includes researchers, academics, journalists, NGOs, human rights organisations, students, diaspora community members, policymakers, and the general public seeking credible information.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                How extensive is the TIC collection? 
                <span class="icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer">
                <p>TIC maintains an extensive archive of nearly 25,000 items, including books, reports, newspapers, periodicals, photographs, audio-visual materials, and digital resources. The collection covers a wide range of topics such as conflict, displacement, human rights, peace-building, resettlement, culture, and post-war developments.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                How can organisations collaborate with TIC? 
                <span class="icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer">
                <p>TIC actively collaborates with local and international organisations through joint seminars, workshops, research initiatives, information-sharing, and capacity-building programs. Interested organisations can get in touch via the contact form on this website, email, or by visiting the centre to explore partnership opportunities.</p>
            </div>
        </div>
    </div>
</section>
</section>
    <!-- Full Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      
document.addEventListener('DOMContentLoaded', function () {
    const questions = document.querySelectorAll('.faq-question');

    questions.forEach(question => {
        question.addEventListener('click', function () {
            const currentlyOpen = document.querySelector('.faq-question[aria-expanded="true"]');
            const thisAnswer = this.nextElementSibling;
            const thisIcon = this.querySelector('.icon');

            // Close any open answer first
            if (currentlyOpen && currentlyOpen !== this) {
                currentlyOpen.setAttribute('aria-expanded', 'false');
                currentlyOpen.nextElementSibling.classList.remove('open');
            }

            // Toggle current one
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                this.setAttribute('aria-expanded', 'false');
                thisAnswer.classList.remove('open');
            } else {
                this.setAttribute('aria-expanded', 'true');
                thisAnswer.classList.add('open');
            }
        });
    });
});

    </script>

@endsection