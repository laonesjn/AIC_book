@extends('layouts.masterclient')

@section('content')
<style>
.page-hero { 
  background: linear-gradient(135deg, #c41e3a, #1a1a2e);
  color: white;
  padding: 2rem 0;
  text-align: center;
  margin-bottom: 1.5rem;
}
.page-hero h1 {
  font-size: clamp(1.5rem, 5vw, 2.5rem);
  margin-bottom: 0.8rem;
  animation: fadeInUp 0.8s ease;
}
.page-hero p {
  font-size: clamp(0.9rem, 2.5vw, 1.1rem);
  opacity: 0.9;
  animation: fadeInUp 1s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}

.exhibition-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  height: 100%;
}

.exhibition-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 30px rgba(196,30,58,0.25);
}

.exhibition-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  position: relative;
}

.exhibition-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #c41e3a;
  color: white;
  padding: 0.4rem 1rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 700;
  z-index: 1;
}

.exhibition-content {
  padding: 1.5rem;
}

.exhibition-title {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1a1a2e;
  margin-bottom: 0.8rem;
}

.exhibition-dates {
  color: #c41e3a;
  font-weight: 600;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.exhibition-description {
  color: #666;
  line-height: 1.7;
  margin-bottom: 1rem;
}

.exhibition-btn {
  display: inline-block;
  background: #1a1a2e;
  color: white;
  padding: 0.7rem 1.5rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: background 0.3s;
}

.exhibition-btn:hover {
  background: #c41e3a;
  color: white;
}

.timeline-container {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  margin-bottom: 3rem;
}

.timeline-scroll {
  overflow-x: auto;
  padding: 2rem 0;
}

.timeline-items {
  display: flex;
  gap: 2rem;
  min-width: max-content;
  padding-bottom: 1rem;
}

.timeline-item {
  min-width: 280px;
  background: linear-gradient(135deg, #f8f9fa, #fff);
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  padding: 1.5rem;
  position: relative;
  transition: all 0.3s;
}

.timeline-item:hover {
  border-color: #c41e3a;
  box-shadow: 0 6px 20px rgba(196,30,58,0.15);
}

.timeline-date {
  background: #c41e3a;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 700;
  display: inline-block;
  margin-bottom: 1rem;
}

.timeline-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1a1a2e;
  margin-bottom: 0.5rem;
}

.timeline-desc {
  color: #666;
  font-size: 0.9rem;
  line-height: 1.6;
}

.visitor-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.info-card {
  background: white;
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.info-card:hover {
  transform: translateY(-5px);
}

.info-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.info-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1a1a2e;
  margin-bottom: 1rem;
}

.info-details {
  color: #666;
  line-height: 1.8;
}

.info-highlight {
  background: #fff3f5;
  color: #c41e3a;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  display: inline-block;
  margin-top: 1rem;
  font-weight: 600;
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1rem;
  margin-bottom: 3rem;
}

.gallery-item {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
  aspect-ratio: 1;
}

.gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s;
}

.gallery-item:hover img {
  transform: scale(1.1);
}

.gallery-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
  display: flex;
  align-items: flex-end;
  padding: 1rem;
  opacity: 0;
  transition: opacity 0.3s;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-caption {
  color: white;
  font-weight: 600;
  font-size: 0.95rem;
}

.section-header {
  margin-bottom: 2rem;
}

.section-title {
  font-size: clamp(1.5rem, 4vw, 2rem);
  color: #1a1a2e;
  margin-bottom: 0.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 3px solid #c41e3a;
  display: inline-block;
}

.section-subtitle {
  color: #666;
  font-size: 1.1rem;
  margin-top: 0.5rem;
}

@media (max-width: 768px) {
  .timeline-items {
    gap: 1rem;
  }
  
  .timeline-item {
    min-width: 240px;
  }
  
  .visitor-info-grid {
    grid-template-columns: 1fr;
  }
  
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 576px) {
  .gallery-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="page-hero">
  <div class="container">
    <h1>🏛️ Exhibition & Heritage Centre</h1>
    <p>Discover our exhibitions and heritage displays</p>
  </div>
</div>

<main class="container my-4">
  <!-- Current Exhibitions -->
  <section class="section-header">
    <h2 class="section-title">🎨 Current Exhibitions</h2>
    <p class="section-subtitle">Experience our featured exhibitions showcasing Tamil heritage and culture</p>
  </section>

  <div class="row g-4 mb-5">
    <div class="col-lg-6">
      <article class="exhibition-card">
        <div style="position: relative;">
          <span class="exhibition-badge">NOW OPEN</span>
          <img src="https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=600" alt="Exhibition" class="exhibition-image" loading="lazy">
        </div>
        <div class="exhibition-content">
          <h3 class="exhibition-title">Voices of Resilience: Tamil Women in History</h3>
          <div class="exhibition-dates">📅 September 2025 - February 2026</div>
          <p class="exhibition-description">
            Celebrating the untold stories of Tamil women who shaped society through politics, arts, education, and social reform. Features rare photographs, personal artifacts, and multimedia presentations.
          </p>
          <a href="#" class="exhibition-btn">Explore Exhibition</a>
        </div>
      </article>
    </div>

    <div class="col-lg-6">
      <article class="exhibition-card">
        <div style="position: relative;">
          <span class="exhibition-badge">NOW OPEN</span>
          <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600" alt="Exhibition" class="exhibition-image" loading="lazy">
        </div>
        <div class="exhibition-content">
          <h3 class="exhibition-title">Sacred Spaces: Temple Architecture of Jaffna</h3>
          <div class="exhibition-dates">📅 October 2025 - January 2026</div>
          <p class="exhibition-description">
            Architectural journey through centuries of temple building traditions. Original blueprints, scale models, and photographic documentation of historic Hindu temples.
          </p>
          <a href="#" class="exhibition-btn">Explore Exhibition</a>
        </div>
      </article>
    </div>

    <div class="col-lg-6">
      <article class="exhibition-card">
        <div style="position: relative;">
          <span class="exhibition-badge">NOW OPEN</span>
          <img src="https://images.unsplash.com/photo-1541367777708-7905fe3296c0?w=600" alt="Exhibition" class="exhibition-image" loading="lazy">
        </div>
        <div class="exhibition-content">
          <h3 class="exhibition-title">Written Heritage: Tamil Manuscripts & Publishing</h3>
          <div class="exhibition-dates">📅 August 2025 - March 2026</div>
          <p class="exhibition-description">
            Exploring the evolution of Tamil writing from palm leaves to modern printing. Rare manuscripts, first editions, and the history of Tamil publishing in Ceylon.
          </p>
          <a href="#" class="exhibition-btn">Explore Exhibition</a>
        </div>
      </article>
    </div>

    <div class="col-lg-6">
      <article class="exhibition-card">
        <div style="position: relative;">
          <span class="exhibition-badge">NOW OPEN</span>
          <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600" alt="Exhibition" class="exhibition-image" loading="lazy">
        </div>
        <div class="exhibition-content">
          <h3 class="exhibition-title">Musical Traditions: Classical & Folk</h3>
          <div class="exhibition-dates">📅 July 2025 - December 2025</div>
          <p class="exhibition-description">
            Interactive exhibition featuring traditional instruments, audio recordings, and the evolution of Tamil musical forms from Carnatic classical to contemporary folk.
          </p>
          <a href="#" class="exhibition-btn">Explore Exhibition</a>
        </div>
      </article>
    </div>
  </div>

  <!-- Upcoming Exhibitions Timeline -->
  <section class="section-header">
    <h2 class="section-title">📅 Upcoming Exhibitions</h2>
    <p class="section-subtitle">Mark your calendar for these exciting upcoming exhibitions</p>
  </section>

  <div class="timeline-container">
    <div class="timeline-scroll">
      <div class="timeline-items">
        <div class="timeline-item">
          <div class="timeline-date">March 2026</div>
          <h4 class="timeline-title">Tamil Cinema: Golden Age</h4>
          <p class="timeline-desc">Retrospective of Tamil cinema from Ceylon, featuring posters, costumes, and rare film footage from 1950s-1980s.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-date">April 2026</div>
          <h4 class="timeline-title">Agricultural Heritage</h4>
          <p class="timeline-desc">Traditional farming practices and tools of Tamil communities. Interactive displays on irrigation and cultivation techniques.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-date">May 2026</div>
          <h4 class="timeline-title">Festivals & Celebrations</h4>
          <p class="timeline-desc">Immersive exhibition on Tamil festivals, religious ceremonies, and community celebrations through the decades.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-date">June 2026</div>
          <h4 class="timeline-title">Educational Institutions</h4>
          <p class="timeline-desc">History of Tamil education in Sri Lanka, featuring school records, student life, and notable educators.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-date">July 2026</div>
          <h4 class="timeline-title">Trade & Commerce</h4>
          <p class="timeline-desc">Economic history of Tamil communities, trade routes, merchant networks, and business enterprises.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Visitor Information -->
  <!-- <section class="section-header mt-5">
    <h2 class="section-title">ℹ️ Visitor Information</h2>
    <p class="section-subtitle">Plan your visit to our heritage centre</p>
  </section> -->

  <!-- <div class="visitor-info-grid">
    <div class="info-card">
      <div class="info-icon">🕐</div>
      <h3 class="info-title">Opening Hours</h3>
      <div class="info-details">
        <p><strong>Monday - Friday:</strong><br>10:00 AM - 6:00 PM</p>
        <p><strong>Saturday:</strong><br>10:00 AM - 4:00 PM</p>
        <p><strong>Sunday:</strong> Closed</p>
        <div class="info-highlight">Last entry 30 mins before closing</div>
      </div>
    </div>

    <div class="info-card">
      <div class="info-icon">🎫</div>
      <h3 class="info-title">Tickets & Pricing</h3>
      <div class="info-details">
        <p><strong>General Admission:</strong> LKR 500</p>
        <p><strong>Students/Seniors:</strong> LKR 250</p>
        <p><strong>Children under 12:</strong> Free</p>
        <p><strong>Group Tours (10+):</strong> LKR 400</p>
        <div class="info-highlight">Book online for 10% discount</div>
      </div>
    </div>

    <div class="info-card">
      <div class="info-icon">📍</div>
      <h3 class="info-title">Location</h3>
      <div class="info-details">
        <p><strong>Tamil Centre</strong></p>
        <p>123 Heritage Lane<br>Colombo 07, Sri Lanka</p>
        <p><strong>Transport:</strong><br>Bus: Routes 138, 154<br>Train: Colombo Fort Station</p>
        <div class="info-highlight">Free parking available</div>
      </div>
    </div>

    <div class="info-card">
      <div class="info-icon">♿</div>
      <h3 class="info-title">Accessibility</h3>
      <div class="info-details">
        <p>• Wheelchair accessible</p>
        <p>• Accessible restrooms</p>
        <p>• Elevators available</p>
        <p>• Braille information</p>
        <p>• Hearing loop system</p>
        <div class="info-highlight">Contact for assistance</div>
      </div>
    </div>
  </div> -->

  <!-- Exhibition Gallery -->
  <!-- <section class="section-header">
    <h2 class="section-title">📸 Exhibition Highlights</h2>
    <p class="section-subtitle">Browse through our exhibition spaces and displays</p>
  </section> -->

  <div class="gallery-grid">
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500" alt="Gallery 1" loading="lazy">
      <div class="gallery-overlay">
        <span class="gallery-caption">Main Exhibition Hall</span>
      </div>
    </div>

    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1577705998148-6da4f3963bc8?w=400" alt="Gallery 2" loading="lazy">
      <div class="gallery-overlay">
        <span class="gallery-caption">Artifact Display Area</span>
      </div>
    </div>

    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1580541631950-7282082b53ce?w=400" alt="Gallery 3" loading="lazy">
      <div class="gallery-overlay">
        <span class="gallery-caption">Interactive Zone</span>
      </div>
    </div>

    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500" alt="Gallery 4" loading="lazy">
      <div class="gallery-overlay">
        <span class="gallery-caption">Multimedia Room</span>
      </div>
    </div>

    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?w=400" alt="Gallery 5" loading="lazy">
      <div class="gallery-overlay">
        <span class="gallery-caption">Special Collections</span>
      </div>
    </div>

    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?w=400" alt="Gallery 6" loading="lazy">
      <div class="gallery-overlay">
        <span class="gallery-caption">Heritage Reading Room</span>
      </div>
    </div>
  </div>
</main>

@endsection