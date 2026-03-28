@extends('layouts.masterclient')

@section('content')
<style>
  .news-detail-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 3rem 1.5rem;
  }

  .back-to-news {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary, #2563eb);
    text-decoration: none;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s;
    margin-bottom: 2rem;
  }

  .back-to-news:hover {
    transform: translateX(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  .news-breadcrumb {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    margin-bottom: 2.5rem;
    font-size: 0.9rem;
    color: #666;
    flex-wrap: wrap;
  }

  .news-breadcrumb a {
    color: var(--primary, #2563eb);
    text-decoration: none;
    transition: color 0.3s;
  }

  .news-breadcrumb a:hover {
    color: var(--accent, #1e40af);
  }

  .news-layout {
    display: flex;
    gap: 3rem;
    align-items: flex-start;
  }

  /* Left Column - Fixed Width Image Gallery */
  .news-images-column {
    flex: 0 0 350px;
    position: sticky;
    top: 2rem;
    align-self: flex-start;
    max-height: calc(100vh - 4rem);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--primary, #2563eb) #f1f1f1;
  }

  .news-images-column::-webkit-scrollbar {
    width: 6px;
  }

  .news-images-column::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  .news-images-column::-webkit-scrollbar-thumb {
    background: var(--primary, #2563eb);
    border-radius: 10px;
  }

  .news-images-column::-webkit-scrollbar-thumb:hover {
    background: var(--accent, #1e40af);
  }

  .images-stack {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .image-item {
    width: 100%;
    height: 280px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .image-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
  }

  .image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  /* Right Column - Content */
  .news-content-column {
    flex: 1;
    min-width: 0;
  }

  .news-header {
    margin-bottom: 2rem;
  }

  .news-meta {
    display: flex;
    gap: 1.5rem;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }

  .news-category {
    background: linear-gradient(135deg, var(--primary, #2563eb) 0%, var(--accent, #1e40af) 100%);
    color: white;
    padding: 0.5rem 1.2rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .news-date {
    color: #666;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
  }

  .news-stats {
    display: flex;
    gap: 1.5rem;
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
  }

  .news-stats span {
    display: flex;
    align-items: center;
    gap: 0.3rem;
  }

  .news-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.3;
    margin-bottom: 1.5rem;
    letter-spacing: -0.5px;
  }

  .news-excerpt {
    font-size: 1.2rem;
    color: #555;
    line-height: 1.7;
    font-weight: 500;
    margin-bottom: 2rem;
    padding-left: 1.5rem;
    border-left: 4px solid var(--primary, #2563eb);
    background: #f8f9fa;
    padding: 1.5rem;
    padding-left: 1.5rem;
    border-radius: 8px;
  }

  .news-main-content {
    background: white;
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
  }

  .news-main-content p {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #444;
    margin-bottom: 1.5rem;
  }

  .news-main-content h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 2.5rem 0 1rem;
  }

  .news-main-content h3 {
    font-size: 1.4rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 2rem 0 1rem;
  }

  .news-main-content blockquote {
    background: #f8f9fa;
    border-left: 4px solid var(--primary, #2563eb);
    padding: 1.5rem 2rem;
    margin: 2rem 0;
    font-style: italic;
    font-size: 1.2rem;
    color: #555;
    border-radius: 8px;
  }

  /* Reference Links Section */
  .reference-section {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
  }

  .reference-section h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .reference-links-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .reference-link-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.2rem;
    background: #f8f9fa;
    border-left: 4px solid var(--primary, #2563eb);
    border-radius: 8px;
    transition: all 0.3s;
  }

  .reference-link-item:hover {
    background: #e9ecef;
    padding-left: 1.8rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }

  .reference-link-item .icon {
    font-size: 1.2rem;
    flex-shrink: 0;
  }

  .reference-link-item a {
    color: var(--primary, #2563eb);
    text-decoration: none;
    font-weight: 600;
    word-break: break-word;
    transition: color 0.3s;
  }

  .reference-link-item a:hover {
    color: var(--accent, #1e40af);
    text-decoration: underline;
  }

  /* Read More Section */
  .read-more-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2.5rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
  }

  .read-more-section h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1rem;
  }

  .read-more-section p {
    font-size: 1rem;
    color: #666;
    margin-bottom: 1.5rem;
  }

  .read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--primary, #2563eb) 0%, var(--accent, #1e40af) 100%);
    color: white;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    font-size: 1.1rem;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
  }

  .read-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(37, 99, 235, 0.4);
    color: white;
  }

  /* Downloads Section */
  .downloads-section {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
  }

  .downloads-section h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .download-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s;
  }

  .download-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
  }

  .download-info {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
  }

  .download-title {
    font-weight: 600;
    color: #1a1a1a;
    font-size: 1rem;
  }

  .download-type {
    color: #666;
    font-size: 0.85rem;
  }

  .download-btn {
    background: var(--primary, #2563eb);
    color: white;
    padding: 0.7rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    white-space: nowrap;
  }

  .download-btn:hover {
    background: var(--accent, #1e40af);
    transform: scale(1.05);
    color: white;
  }

  /* Social Share */
  .social-share {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
  }

  .social-share h3 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #1a1a1a;
  }

  .share-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .share-btn {
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.3s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .share-btn:hover {
    transform: translateY(-3px);
  }

  .share-btn.facebook { background: #1877f2; }
  .share-btn.twitter { background: #1da1f2; }
  .share-btn.whatsapp { background: #25d366; }
  .share-btn.email { background: #666; }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .news-images-column {
      flex: 0 0 300px;
    }

    .image-item {
      height: 240px;
    }

    .news-layout {
      gap: 2rem;
    }
  }

  @media (max-width: 768px) {
    .news-layout {
      flex-direction: column;
      gap: 2rem;
    }

    .news-images-column {
      flex: 1;
      width: 100%;
      position: static;
    }

    .images-stack {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1rem;
    }

    .image-item {
      height: 220px;
    }

    .news-title {
      font-size: 2rem;
    }

    .news-excerpt {
      font-size: 1.05rem;
      padding: 1.2rem;
    }

    .news-main-content {
      padding: 1.5rem;
    }

    .news-main-content p {
      font-size: 1rem;
    }

    .reference-section,
    .downloads-section,
    .social-share {
      padding: 1.5rem;
    }

    .download-item {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }

    .download-btn {
      width: 100%;
      text-align: center;
    }

    .share-buttons {
      flex-direction: column;
    }

    .share-btn {
      justify-content: center;
    }
  }

  @media (max-width: 576px) {
    .news-detail-wrapper {
      padding: 2rem 1rem;
    }

    .news-title {
      font-size: 1.6rem;
    }

    .news-excerpt {
      font-size: 0.95rem;
      padding: 1rem;
    }

    .news-main-content {
      padding: 1.2rem;
    }

    .images-stack {
      grid-template-columns: 1fr;
    }

    .image-item {
      height: 200px;
    }

    .reference-section,
    .downloads-section,
    .read-more-section,
    .social-share {
      padding: 1.2rem;
    }

    .read-more-btn {
      padding: 0.9rem 2rem;
      font-size: 1rem;
    }
  }

  .news-main-content p {
  margin-bottom: 16px;
  line-height: 1.8;
}

.news-main-content ul {
  padding-left: 20px;
  margin-bottom: 16px;
}

.news-main-content li {
  margin-bottom: 8px;
}

.news-main-content a {
  color: #2563eb;
  text-decoration: underline;
}

</style>

<div class="news-detail-wrapper">
  <!-- Back Button -->
  <a href="{{ route('client.news') }}" class="back-to-news">
    ← Back to All News
  </a>

  <!-- Breadcrumb -->
  <div class="news-breadcrumb">
    <a href="{{ url('/') }}">Home</a>
    <span>›</span>
    <a href="{{ route('client.news') }}">News</a>
    <span>›</span>
    <span>{{ $news->title }}</span>
  </div>

  <!-- Main Layout: Images Left, Content Right -->
  <div class="news-layout">
    
    <!-- Left Column: Fixed Width Image Gallery -->
    <div class="news-images-column">
      <div class="images-stack">
        @if(!empty($news->title_image))
          <div class="image-item">
            <img src="{{ asset($news->title_image) }}" alt="{{ $news->title }}" loading="lazy">
          </div>
        @else
          <div class="image-item">
            <img src="https://picsum.photos/350/280?random=1" alt="{{ $news->title }}" loading="lazy">
          </div>
        @endif

        @if(!empty($news->images))
          @php
            $images = json_decode($news->images, true) ?: [];
          @endphp
          @foreach($images as $img)
            <div class="image-item">
              <img src="{{ asset($img) }}" alt="Gallery image" loading="lazy">
            </div>
          @endforeach
        @else

        @endif
      </div>
    </div>

    <!-- Right Column: Content -->
    <div class="news-content-column">
      
      <!-- Header -->
      <div class="news-header">
        <div class="news-meta">
          <span class="news-category">{{ $news->category ?? 'Community' }}</span>
          
          @php
            use Carbon\Carbon;
            $published = $news->published_at ?? $news->created_at;
            $publishedDate = $published ? Carbon::parse($published)->format('F j, Y') : '';
          @endphp
          <span class="news-date">📅 {{ $publishedDate }}</span>
        </div>

        <div class="news-stats">
          <span>👁️ {{ number_format($news->views ?? 0) }} views</span>
          @php
            $plain = strip_tags($news->content ?? '');
            $words = str_word_count($plain);
            $minutes = max(1, (int) ceil($words / 200));
          @endphp
          <span>🕒 {{ $minutes }} min read</span>
        </div>

        <h1 class="news-title">{{ $news->title }}</h1>

        @if(!empty($news->excerpt))
          <div class="news-excerpt">{{ $news->excerpt }}</div>
        @endif
      </div>

      <!-- Main Content -->
<div class="news-main-content">
    {!! $news->content !!}
</div>


      <!-- Reference Links Section -->
      @if(!empty($news->reference_links))
        @php
          $refs = is_string($news->reference_links) ? json_decode($news->reference_links, true) : $news->reference_links;
          if (!is_array($refs) && is_string($news->reference_links)) {
              $refs = array_filter(array_map('trim', explode("\n", $news->reference_links)));
          }
          $refs = is_array($refs) ? $refs : [];
        @endphp

        @if(count($refs))
        @endif
      @endif

      <a href="{{ route('news.download.pdf', $news->id) }}" class="download-btn">Download PDF</a>

    </div>
  </div>
</div>

@endsection