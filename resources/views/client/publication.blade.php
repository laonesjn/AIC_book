
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
  }

  .page-header-section {
    width: 100%; 
    padding: 4rem 1rem 1.5rem !important;
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
    line-height: 1.1;
  }

  .page-header-section .page-subtitle {
    font-size: 1.25rem;
    color: var(--accent-dark);
    opacity: 0.8;
    margin: 0;
    max-width: 800px;
    line-height: 1.6;
  }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Filter Section */
  .filter-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  }

  .filter-title {
    font-size: 1.2rem;
    color: var(--primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
  }

  .filter-group {
    display: flex;
    flex-direction: column;
  }

  .filter-group label {
    font-weight: 600;
    color: #0f2540;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .filter-group select {
    padding: 0.75rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    background: white;
    cursor: pointer;
    transition: all 0.3s;
  }

  .filter-group select:focus {
    outline: none;
    border-color: #c41e3a;
    box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.1);
  }

  .filter-group select:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
    opacity: 0.6;
  }

  .reset-btn {
    padding: 0.75rem 1.5rem;
    background: #0f2540;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
  }

  .reset-btn:hover {
    background: #0f2540;
    transform: translateY(-2px);
  }

  .publications-layout {
    display: grid;
    grid-template-columns: minmax(280px, 1fr) minmax(0, 2.5fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  .rules-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    animation: slideInLeft 0.6s ease;
    position: sticky;
    top: 80px;
  }

  @keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
  }

  .section-title {
    font-size: clamp(1.2rem, 3vw, 1.6rem);
    color:  #0f2540;
    margin-bottom: 1.2rem;
    padding-bottom: 0.6rem;
    border-bottom: 3px solid #d4af37;
  }

  .rule-item {
    margin-bottom: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: 8px;
    border-left: 4px solid #d4af37;
    transition: all 0.3s;
  }

  .rule-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border-left-color: #0f2540;
  }

  .rule-item h4 {
    color: #0f2540;
    margin-bottom: 0.5rem;
    font-size: clamp(0.9rem, 2vw, 1rem);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .rule-item p {
    color: #666;
    line-height: 1.5;
    margin-bottom: 0.5rem;
    font-size: clamp(0.8rem, 2vw, 0.9rem);
  }

  .contact-box {
    padding: 1rem;
    border-radius: 8px;
    background: #f8f9fa;
    margin-top: 0.8rem;
  }

  .contact-box h5 {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: #0f2540;
  }

  .contact-box p {
    margin: 0.2rem 0;
    font-size: 0.8rem;
  }

  .publications-section {
    animation: slideInRight 0.6s ease;
    min-width: 0;
  }

  @keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
  }

  .publications-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.2rem;
  }

  .book-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(196, 30, 58, 0.15);
  }

  .book-cover-container {
    position: relative;
    width: 100%;
    overflow: hidden;
  }

  .book-cover {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: linear-gradient(135deg, #e8eef5, #f5f7fa);
    transition: transform 0.3s ease;
  }

  .book-card:hover .book-cover {
    transform: scale(1.05);
  }

  .book-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
  }

  .book-badge.free {
        background-color: #5cb85c;
    color: white;
  }

  .book-badge.paid {
    background:  #0f2540;
    color: white;
  }

  .book-badge.private {
    background: #0f2540;
    color: white;
  }

  .book-info {
    padding: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .book-category {
    font-size: 0.75rem;
    color:  #0f2540;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 0.4rem;
  }

  .book-title {
    font-size: clamp(0.9rem, 2vw, 1rem);
    font-weight: 700;
    color: #0f2540;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .book-description {
    color: #666;
    font-size: 0.85rem;
    line-height: 1.4;
    margin-bottom: 0.8rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
  }

  .book-price {
    font-size: 1rem;
    font-weight: 700;
    color:  #0f2540;
    margin-bottom: 0.8rem;
  }

  .book-price.free {
    color: #0f580f;
  }

 .view-details-btn {
    width: 100%;
    padding: 0.6rem;
    color: white;
    border: none;
    border-radius: 6px;
    /* font-weight: 600; */
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.85rem;
    margin-top: auto;
    background-color: #5cb85c; /* default */
}

.view-details-btn.free {
    background-color: #28a745; /* green for free */
}


  .view-details-btn:hover {
    background:  #0f2540;
  }

  /* Loading Spinner */
  .loading-spinner {
    display: none;
    text-align: center;
    padding: 2rem;
  }

  .loading-spinner.active {
    display: block;
  }

  .spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid  #0f2540;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Modal Base Styles */
  .modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 2000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    animation: fadeIn 0.3s ease;
    overflow-y: auto;
  }

  .modal.open {
    display: flex;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .modal-content {
    background: white;
    border-radius: 12px;
    max-width: 900px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    animation: slideUp 0.4s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .modal-header {
    background: linear-gradient(135deg,  #0f2540,  #143154);
    color: white;
    padding: 1.2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .modal-header h2 {
    font-size: clamp(1rem, 3vw, 1.3rem);
    margin: 0;
    padding-right: 1rem;
  }

  .modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid white;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .modal-close:hover {
    background: white;
    color:  #0f2540;
    transform: rotate(90deg);
  }

  /* PUBLIC Modal Layout */
  .modal-body-public {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 1.2rem;
    padding: 1.2rem;
  }

  .modal-cover {
    width: 100%;
    height: auto;
    max-height: 350px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .modal-details h3 {
    color:  #0f2540;
    margin-bottom: 0.8rem;
    font-size: 1.1rem;
  }

  .modal-details p {
    color: #666;
    line-height: 1.5;
    margin-bottom: 1rem;
    font-size: 0.9rem;
  }

  .detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.6rem;
    background: #f8f9fa;
    border-radius: 6px;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    flex-wrap: wrap;
    gap: 0.3rem;
  }

  .detail-item strong {
    color: #0f2540;
  }

  .detail-item span {
    color:  #0f2540;
    font-weight: 700;
  }

  .action-buttons {
    display: flex;
    gap: 0.8rem;
    margin-top: 1rem;
    flex-wrap: wrap;
  }

  .order-btn, .download-btn {
    flex: 1;
    min-width: 120px;
    padding: 0.8rem;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s;
  }

  .order-btn {
    background: #d4af37;
    color: white;
  }

  .order-btn:hover {
    background:  #0f2540;
    transform: translateY(-2px);
  }

  .download-btn {
    background: #0f2540;
    color: white;
  }

  .download-btn:hover {
    background: #1a3a52;
    transform: translateY(-2px);
  }

  /* PRIVATE Modal Layout */
  .modal-body-private {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    padding: 1.5rem;
  }

  .private-details-section {
    border-right: 2px solid #e0e0e0;
    padding-right: 1.5rem;
  }

  .private-details-section h3 {
    color:  #0f2540;
    margin-bottom: 1rem;
    font-size: 1.1rem;
  }

  .private-cover {
    width: 100%;
    height: auto;
    max-height: 280px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
  }

  .private-info {
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
    font-size: 0.9rem;
  }

  .access-notice {
    background: #fff3cd;
    border-left: 4px solid #d4af37;
    padding: 1rem;
    border-radius: 6px;
    margin-top: 1rem;
  }

  .access-notice p {
    margin: 0;
    color: #856404;
    font-size: 0.85rem;
  }

  /* Request Form */
  .request-form-section h3 {
    color: #0f2540;
    margin-bottom: 1rem;
    font-size: 1.1rem;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .form-group label {
    display: block;
    font-weight: 600;
    color: #0f2540;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .form-group label .required {
    color:  #0f2540;
  }

  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.9rem;
    font-family: inherit;
    transition: all 0.3s;
  }

  .form-group input:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: #c41e3a;
    box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.1);
  }

  .form-group textarea {
    resize: vertical;
    min-height: 100px;
  }

  .submit-request-btn {
    width: 100%;
    padding: 0.9rem;
    background: #c41e3a;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
  }

  .submit-request-btn:hover {
    background: #a01729;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(196, 30, 58, 0.3);
  }

  .form-error {
    color: #c41e3a;
    font-size: 0.8rem;
    margin-top: 0.3rem;
    display: none;
  }

  .form-group.error input,
  .form-group.error textarea {
    border-color: #c41e3a;
  }

  .form-group.error .form-error {
    display: block;
  }

  .no-publications {
    text-align: center;
    padding: 2rem 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    grid-column: 1 / -1;
  }

  .no-publications h3 {
    color: #0f2540;
    font-size: 1.2rem;
    margin-bottom: 0.8rem;
  }

  /* Responsive Styles */
  @media (max-width: 1024px) {
    .publications-layout {
      grid-template-columns: 1fr;
    }

    .rules-section {
      position: static;
      order: 2;
      max-height: none;
    }

    .publications-section {
      order: 1;
    }

    .modal-body-private {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    .private-details-section {
      border-right: none;
      border-bottom: 2px solid #e0e0e0;
      padding-right: 0;
      padding-bottom: 1.5rem;
    }
  }

  @media (max-width: 768px) {
    .page-header-section {
      padding: 2rem 1rem 1rem !important;
    }

    .page-header-section .page-title {
      font-size: 2rem;
    }

    .filter-section {
      padding: 1rem;
    }

    .filter-row {
      grid-template-columns: 1fr;
    }

    .rules-section {
      padding: 1rem;
    }

    .publications-grid {
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1rem;
    }

    .book-cover {
      height: 160px;
    }

    .modal-body-public {
      grid-template-columns: 1fr;
      gap: 1rem;
      padding: 1rem;
    }

    .modal-cover {
      max-height: 250px;
      justify-self: center;
    }
  }

  @media (max-width: 480px) {
    .container {
      padding: 0 0.75rem;
    }

    .page-header-section {
      padding: 1.5rem 0.75rem !important;
    }

    .page-header-section .page-title {
      font-size: 1.5rem;
    }

    .filter-group select {
      padding: 0.6rem 0.8rem;
      font-size: 0.9rem;
    }

    .publications-grid {
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
    }

    .book-cover {
      height: 130px;
    }

    .book-info {
      padding: 0.75rem;
    }

    .book-title {
      font-size: 0.85rem;
    }

    .book-description {
      display: none;
    }

    .book-price {
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .view-details-btn {
      padding: 0.5rem;
      font-size: 0.8rem;
    }

    .rule-item {
      padding: 0.8rem;
      margin-bottom: 0.8rem;
    }

    .modal-header {
      padding: 1rem;
    }

    .action-buttons {
      flex-direction: column;
    }
  }

  @media (max-width: 360px) {
    .publications-grid {
      grid-template-columns: 1fr;
    }

    .book-cover {
      height: 150px;
    }

    .book-description {
      display: -webkit-box;
    }
  }
</style>

<section class="page-header-section">
  <h1 class="page-title">Publications</h1>
  <p class="page-subtitle">Explore our collection of Tamil heritage books and research materials</p>
</section>
<br>

<!-- Main Content -->
<main class="container">
  
  <!-- Filter Section -->
  <div class="filter-section">
    <h3 class="filter-title">Filter Publications</h3>
    <div class="filter-row">
      <div class="filter-group">
        <label for="mainCategorySelect">Main Category</label>
        {{-- ✅ CORRECTED: Changed from publicationTypes to mainCategories --}}
        <select id="mainCategorySelect">
          <option value="">All Categories</option>
          @foreach($mainCategories as $mainCat)
            <option value="{{ $mainCat->id }}" {{ request('main_category') == $mainCat->id ? 'selected' : '' }}>
              {{ $mainCat->name }}
            </option>
          @endforeach
        </select>
      </div>
      
      <div class="filter-group">
        <label for="subCategorySelect">Subcategory</label>
        {{-- ✅ CORRECTED: Changed from category to subcategory --}}
        <select id="subCategorySelect" {{ !request('main_category') ? 'disabled' : '' }}>
          <option value="">All Subcategories</option>
          @if(isset($subcategories) && $subcategories->count() > 0)
            @foreach($subcategories as $subCat)
              <option value="{{ $subCat->id }}" {{ request('subcategory') == $subCat->id ? 'selected' : '' }}>
                {{ $subCat->name }}
              </option>
            @endforeach
          @endif
        </select>
      </div>
      
      <div class="filter-group">
        <button type="button" class="reset-btn" onclick="resetFilters()">
         Reset Filters
        </button>
      </div>
    </div>
  </div>

  <div class="publications-layout">

   <!-- LEFT SIDE: Rules -->
    <div class="rules-section">
      <h2 class="section-title">Publications Guide</h2>

      <div class="rule-item">
        <h4>📖 Search & Order</h4>
        <p>Browse publications or search for specific materials. Some publications can be downloaded free (marked "FREE").</p>
      </div>

      <div class="rule-item">
        <h4>🔒 Private Publications</h4>
        <p>Private publications require access approval. Submit a request with your details and reason for access.</p>
      </div>

      <div class="rule-item">
        <h4>🛒 How to Order</h4>
        <p>Orders can be placed online or by sending an order form via fax, mail, or telephone.</p>
        
        <div class="contact-box">
          <h5>Contact:</h5>
          <p><strong>Tamil Information Centre</strong></p>
          <p>Thulasi Bridge End Close,</p>
          <p>Kingston Upon Thames, KT2 6PZ</p>
          <p>United Kingdom</p>
          <p style="margin-top: 0.5rem;">
            Tel: 020 8546 1560<br>
            Email: info@tamilinfo.org
          </p>
        </div>
      </div>

      <div class="rule-item">
        <h4>💳 Payment</h4>
        <p>We accept VISA, MasterCard, Discover, American Express via PayPal.</p>
      </div>

      <div class="rule-item">
        <h4>📦 Shipping</h4>
        <p>Orders dispatched within 3–5 working days via Royal Mail. Add 20% for handling.</p>
      </div>
    </div>
    

    <!-- RIGHT SIDE: Publications -->
    <div class="publications-section">
      <h2 class="section-title">
        Our Publications 
        <span style="font-size: 0.85rem; color: #666; font-weight: 400;">
          (<span id="pubCount">{{ $publications->count() }}</span> books)
        </span>
      </h2>
      
      <!-- Loading Spinner -->
      <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
        <p>Loading publications...</p>
      </div>
      
      <!-- Publications Grid -->
      <div class="publications-grid" id="publicationsGrid">
        @include('client.partials.publications-grid', ['publications' => $publications])
      </div>
    </div>

  </div>
</main>

<!-- PUBLIC Modal -->
<div id="publicModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 id="publicModalTitle"></h2>
      <button class="modal-close" onclick="closePublicModal()">×</button>
    </div>
    <div class="modal-body-public">
      <div>
        <img id="publicModalCover" src="" alt="Book cover" class="modal-cover" loading="lazy">
      </div>
      <div class="modal-details">
        <h3>Description</h3>
        <p id="publicModalDescription"></p>
        
        <div class="detail-item">
          <strong>📁 Main Category:</strong>
          <span id="publicModalMainCategory"></span>
        </div>
        
        <div class="detail-item">
          <strong>📂 Subcategory:</strong>
          <span id="publicModalSubcategory"></span>
        </div>
        
        <div class="detail-item">
          <strong>💵 Price:</strong>
          <span id="publicModalPrice"></span>
        </div>
        
        <div class="detail-item">
          <strong>📅 Published:</strong>
          <span id="publicModalDate"></span>
        </div>
        
        <div class="action-buttons" id="publicActionButtons"></div>
      </div>
    </div>
  </div>
</div>

<!-- PRIVATE Modal -->
<div id="privateModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 id="privateModalTitle"></h2>
      <button class="modal-close" onclick="closePrivateModal()">×</button>
    </div>
    <div class="modal-body-private">
      <!-- Left: Book Details -->
      <div class="private-details-section">
        <h3>📖 Publication Details</h3>
        <img id="privateModalCover" src="" alt="Book cover" class="private-cover" loading="lazy">
        
        <div class="private-info">
          <div class="detail-item">
            <strong>📁 Main Category:</strong>
            <span id="privateModalMainCategory"></span>
          </div>
          
          <div class="detail-item">
            <strong>📂 Subcategory:</strong>
            <span id="privateModalSubcategory"></span>
          </div>
          
          <div class="detail-item">
            <strong>💵 Price:</strong>
            <span id="privateModalPrice"></span>
          </div>
          
          <div class="detail-item">
            <strong>📅 Published:</strong>
            <span id="privateModalDate"></span>
          </div>
        </div>

        <div class="access-notice">
          <p><strong>🔒 Private Publication</strong><br>
          This publication requires access approval. Please submit the request form to gain access.</p>
        </div>
      </div>

      <!-- Right: Request Form -->
      <div class="request-form-section">
        <h3>📝 Request Access Form</h3>
        <form id="requestAccessForm" method="POST" action="{{ route('publications.request.submit') }}">
          @csrf
          <input type="hidden" name="publication_id" id="requestPublicationId">
          
          <div class="form-group">
            <label for="requestName">Full Name <span class="required">*</span></label>
            <input type="text" id="requestName" name="name" required>
            <div class="form-error">Please enter your full name</div>
          </div>

          <div class="form-group">
            <label for="requestEmail">Email Address <span class="required">*</span></label>
            <input type="email" id="requestEmail" name="email" required>
            <div class="form-error">Please enter a valid email address</div>
          </div>

          <div class="form-group">
            <label for="requestPhone">Phone Number <span class="required">*</span></label>
            <input type="tel" id="requestPhone" name="phone" required>
            <div class="form-error">Please enter your phone number</div>
          </div>

          <div class="form-group">
            <label for="requestWhy">Reason for Access <span class="required">*</span></label>
            <textarea id="requestWhy" name="why" required placeholder="Please explain why you need access to this publication..."></textarea>
            <div class="form-error">Please provide a reason for requesting access</div>
          </div>

          <button type="submit" class="submit-request-btn">
            📤 Submit Request
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // ✅ CORRECTED: Publications data with new relationships
  let publications = @json($publications->load(['mainCategory', 'subcategory']));
  
  const mainCategorySelect = document.getElementById('mainCategorySelect');
  const subCategorySelect = document.getElementById('subCategorySelect');
  const publicationsGrid = document.getElementById('publicationsGrid');
  const loadingSpinner = document.getElementById('loadingSpinner');
  const pubCount = document.getElementById('pubCount');

  // Load subcategories when main category changes
  mainCategorySelect.addEventListener('change', function() {
    const mainCategoryId = this.value;
    
    // Reset subcategory
    subCategorySelect.innerHTML = '<option value="">All Subcategories</option>';
    
    if (!mainCategoryId) {
      subCategorySelect.disabled = true;
      filterPublications();
      return;
    }
    
    subCategorySelect.disabled = false;
    
    // ✅ CORRECTED: API endpoint for subcategories
    fetch(`{{ url('/api/subcategories-by-main-category') }}/${mainCategoryId}`)
      .then(response => response.json())
      .then(data => {
        if (data.data && data.data.length > 0) {
          data.data.forEach(subCat => {
            const option = document.createElement('option');
            option.value = subCat.id;
            option.textContent = subCat.name;
            subCategorySelect.appendChild(option);
          });
        }
      })
      .catch(error => console.error('Error loading subcategories:', error));
    
    // Filter publications
    filterPublications();
  });

  // Filter when subcategory changes
  subCategorySelect.addEventListener('change', filterPublications);

  // Filter publications via AJAX
  function filterPublications() {
    const mainCategoryId = mainCategorySelect.value;
    const subcategoryId = subCategorySelect.value;
    
    // Show loading
    loadingSpinner.classList.add('active');
    publicationsGrid.style.opacity = '0.5';
    
    // Build URL
    let url = '{{ route("publications.filter") }}?';
    if (mainCategoryId) url += `main_category=${mainCategoryId}&`;
    if (subcategoryId) url += `subcategory=${subcategoryId}&`;
    
    fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      publicationsGrid.innerHTML = data.html;
      pubCount.textContent = data.count;
      publications = data.publications;
      
      // Hide loading
      loadingSpinner.classList.remove('active');
      publicationsGrid.style.opacity = '1';
      
      // Update URL without reload
      const newUrl = new URL(window.location);
      if (mainCategoryId) {
        newUrl.searchParams.set('main_category', mainCategoryId);
      } else {
        newUrl.searchParams.delete('main_category');
      }
      if (subcategoryId) {
        newUrl.searchParams.set('subcategory', subcategoryId);
      } else {
        newUrl.searchParams.delete('subcategory');
      }
      window.history.pushState({}, '', newUrl);
    })
    .catch(error => {
      console.error('Error:', error);
      loadingSpinner.classList.remove('active');
      publicationsGrid.style.opacity = '1';
    });
  }

  // Reset filters
  function resetFilters() {
    mainCategorySelect.value = '';
    subCategorySelect.innerHTML = '<option value="">All Subcategories</option>';
    subCategorySelect.disabled = true;
    filterPublications();
  }

  // PUBLIC Modal functions
  function openPublicModal(bookId) {
    const book = publications.find(p => p.id === bookId);
    if (!book) {
      console.error('Book not found:', bookId);
      return;
    }

    document.getElementById('publicModalTitle').textContent = book.title;
    

    const coverImg = document.getElementById('publicModalCover');

  if (book.title_image) {
    if (book.title_image.startsWith('http://') || book.title_image.startsWith('https://')) {
        coverImg.src = book.title_image;
    } else {
        coverImg.src = `/public/${book.title_image}`;
    }
} else {
    coverImg.src = '/images/newlogo.jpeg';
}

coverImg.onerror = function() {
    this.src = '/images/newlogo.jpeg';
};

    
    document.getElementById('publicModalDescription').innerHTML = book.content || 'No description available.';
    {{-- ✅ CORRECTED: Changed from publication_type to mainCategory --}}
    document.getElementById('publicModalMainCategory').textContent = book.main_category?.name || 'N/A';
    {{-- ✅ CORRECTED: Changed from category to subcategory --}}
    document.getElementById('publicModalSubcategory').textContent = book.subcategory?.name || 'N/A';
    document.getElementById('publicModalPrice').textContent = book.price == 0 ? 'FREE' : `${parseFloat(book.price).toFixed(2)}`;
    document.getElementById('publicModalDate').textContent = new Date(book.created_at).toLocaleDateString();

    // const actionButtons = document.getElementById('publicActionButtons');
    // actionButtons.innerHTML = '';

    // if (book.pdf) {
    //   const downloadBtn = document.createElement('button');
    //   downloadBtn.className = 'download-btn';
    //   downloadBtn.innerHTML = '📥 Download PDF';
    //   downloadBtn.onclick = () => window.open(`/storage/${book.pdf}`, '_blank');
    //   actionButtons.appendChild(downloadBtn);
    // }

    const actionButtons = document.getElementById('publicActionButtons');
    actionButtons.innerHTML = '';

    if (book.pdf) {
        const downloadLink = document.createElement('a');

        downloadLink.href = `/publicfree/download-pdf/${book.id}`;
        downloadLink.className = 'download-btn';
        downloadLink.innerHTML = '📥 Download PDF'
        actionButtons.appendChild(downloadLink);
    }


    if (book.price > 0) {
      const orderBtn = document.createElement('button');
      orderBtn.className = 'order-btn';
      orderBtn.innerHTML = '🛒 Order Now';
      orderBtn.onclick = () => orderBook(book.id, book.title, book.price);
      actionButtons.appendChild(orderBtn);
    }

    document.getElementById('publicModal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closePublicModal() {
    document.getElementById('publicModal').classList.remove('open');
    document.body.style.overflow = 'auto';
  }

  // PRIVATE Modal functions
  function openPrivateModal(bookId) {
    const book = publications.find(p => p.id === bookId);
    if (!book) {
      console.error('Book not found:', bookId);
      return;
    }

    document.getElementById('privateModalTitle').textContent = book.title;
    
  const coverImg = document.getElementById('privateModalCover');

if (book.title_image) {
    // If it's a full URL, use it directly; otherwise, use local storage
    if (book.title_image.startsWith('http://') || book.title_image.startsWith('https://')) {
        coverImg.src = book.title_image;
    } else {
        coverImg.src = `/public/${book.title_image}`;
    }
} else {
    coverImg.src = '{{ asset("images/newlogo.jpeg") }}';
}

// Fallback if image fails to load
coverImg.onerror = function() {
    this.src = '{{ asset("images/newlogo.jpeg") }}';
};

    
    {{-- ✅ CORRECTED: Changed from publication_type to mainCategory --}}
    document.getElementById('privateModalMainCategory').textContent = book.main_category?.name || 'N/A';
    {{-- ✅ CORRECTED: Changed from category to subcategory --}}
    document.getElementById('privateModalSubcategory').textContent = book.subcategory?.name || 'N/A';
    document.getElementById('privateModalPrice').textContent = book.price == 0 ? 'FREE' : `${parseFloat(book.price).toFixed(2)}`;
    document.getElementById('privateModalDate').textContent = new Date(book.created_at).toLocaleDateString();

    // Set publication ID in hidden input
    document.getElementById('requestPublicationId').value = book.id;

    // Clear form
    document.getElementById('requestAccessForm').reset();
    document.querySelectorAll('.form-group').forEach(group => group.classList.remove('error'));

    document.getElementById('privateModal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closePrivateModal() {
    document.getElementById('privateModal').classList.remove('open');
    document.body.style.overflow = 'auto';
  }

  // Main function to open correct modal based on visibility type
  function openModal(bookId) {
    const book = publications.find(p => p.id === bookId);
    if (!book) {
      console.error('Book not found:', bookId);
      return;
    }

    if (book.visibleType === 'private') {
      openPrivateModal(bookId);
    } else {
      openPublicModal(bookId);
    }
  }

  // Order book function
  function orderBook(id, title, price) {
    alert(`Order placed for: ${title}\nPrice: ${parseFloat(price).toFixed(2)}\n\nYou will be redirected to payment.`);
    // Add actual order logic here
  }

  // Form validation
  document.getElementById('requestAccessForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let isValid = true;
    const form = this;
    
    // Validate each field
    const name = document.getElementById('requestName');
    const email = document.getElementById('requestEmail');
    const phone = document.getElementById('requestPhone');
    const why = document.getElementById('requestWhy');
    
    // Reset errors
    document.querySelectorAll('.form-group').forEach(group => group.classList.remove('error'));
    
    if (!name.value.trim()) {
      name.closest('.form-group').classList.add('error');
      isValid = false;
    }
    
    if (!email.value.trim() || !email.value.includes('@')) {
      email.closest('.form-group').classList.add('error');
      isValid = false;
    }
    
    if (!phone.value.trim()) {
      phone.closest('.form-group').classList.add('error');
      isValid = false;
    }
    
    if (!why.value.trim()) {
      why.closest('.form-group').classList.add('error');
      isValid = false;
    }
    
    if (isValid) {
      form.submit();
    }
  });

  // Close modals on escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closePublicModal();
      closePrivateModal();
    }
  });

  // Close modals on outside click
  document.getElementById('publicModal').addEventListener('click', (e) => {
    if (e.target.id === 'publicModal') closePublicModal();
  });

  document.getElementById('privateModal').addEventListener('click', (e) => {
    if (e.target.id === 'privateModal') closePrivateModal();
  });
</script>
@endsection