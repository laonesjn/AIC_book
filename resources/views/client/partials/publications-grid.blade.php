{{-- FILE: resources/views/Client/partials/publications-grid.blade.php --}}

<style>
  /* ===========================
   PAGINATION STYLES
=========================== */
.pagination-container {
  margin-top: 2.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  grid-column: 1 / -1;
}

.page-info {
  font-size: 0.9rem;
  color:#0f2540;
  font-weight: 500;
}

.pagination {
  display: flex;
  gap: 0.5rem;
  list-style: none;
  padding: 0;
  margin: 0;
  flex-wrap: wrap;
  justify-content: center;
}

.pagination li a,
.pagination li span {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 42px;
  height: 42px;
  padding: 0 0.75rem;
  border-radius: 10px;
  background: #0f2540;
  border: 2px solid #e5e7eb;
  color:white;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.25s ease;
}

.pagination li.active span {
  background: #c41e3a; 
  border-color: #c41e3a;
  color: white;
  font-weight: 700;
  box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3);
}

.pagination li a:hover {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3);
}

.pagination li.disabled span {
  background: #0f2540;
  color: white;
  cursor: not-allowed;
  border-color: #e5e7eb;
}

.pagination li.ellipsis span {
  border: none;
  background: transparent;
  cursor: default;
  color: #0f2540;
}

.pagination li.prev a,
.pagination li.next a,
.pagination li.prev span,
.pagination li.next span {
  font-weight: 600;
  padding: 0 1rem;
}

.pagination-extra {
  font-size: 0.85rem;
  color: #888;
}

.pagination-extra .muted {
  font-weight: 500;
}

/* Responsive Pagination */
@media (max-width: 768px) {
  .pagination-container {
    margin-top: 2rem;
  }

  .pagination {
    gap: 0.4rem;
  }

  .pagination li a,
  .pagination li span {
    min-width: 38px;
    height: 38px;
    font-size: 0.9rem;
  }

  .pagination li.prev a,
  .pagination li.next a,
  .pagination li.prev span,
  .pagination li.next span {
    padding: 0 0.8rem;
  }
}

@media (max-width: 576px) {
  .pagination-container {
    margin-top: 1.5rem;
    gap: 0.5rem;
  }

  .page-info {
    font-size: 0.85rem;
  }

  .pagination {
    gap: 0.35rem;
  }

  .pagination li a,
  .pagination li span {
    min-width: 34px;
    height: 34px;
    font-size: 0.85rem;
    border-radius: 8px;
    padding: 0 0.5rem;
  }

  .pagination li.prev a,
  .pagination li.next a,
  .pagination li.prev span,
  .pagination li.next span {
    padding: 0 0.7rem;
    font-size: 0.8rem;
  }

  .pagination-extra {
    font-size: 0.8rem;
  }
}

@media (max-width: 400px) {
  .pagination li a,
  .pagination li span {
    min-width: 32px;
    height: 32px;
    font-size: 0.8rem;
  }

  .pagination li.prev,
  .pagination li.next {
    display: none;
  }
}
</style>

{{-- FILE: resources/views/Client/partials/publications-grid.blade.php --}}

{{-- Client/partials/publications-grid.blade.php --}}

@if($publications->count() > 0)
  @foreach($publications as $pub)
    <div class="book-card" onclick="openModal({{ $pub->id }})">
     <div class="book-cover-container">
    @php
        $imgSrc = $pub->title_image
            ? (Str::startsWith($pub->title_image, ['http://','https://'])
                ? $pub->title_image
                : asset($pub->title_image))
            : asset('images/newlogo.jpeg');
    @endphp

    <img src="{{ $imgSrc }}" loading="lazy" 
         alt="{{ $pub->title }}" 
         class="book-cover"
         onerror="this.src='{{ asset('images/newlogo.jpeg') }}'">

    @if($pub->visibleType === 'private')
        <span class="book-badge private">🔒 Private</span>
    @elseif($pub->price == 0)
        <span class="book-badge free">Free</span>
    @else
        <span class="book-badge paid">Paid</span>
    @endif
</div>

      
      <div class="book-info">
        <div class="book-category">
          {{ $pub->subcategory->name ?? 'Uncategorized' }}
        </div>
        
        <h3 class="book-title">{{ $pub->title }}</h3>
        
        <p class="book-description">
          {{ Str::limit(strip_tags($pub->content), 100) }}
        </p>
        
        <div class="book-price {{ $pub->price == 0 ? 'free' : '' }}">
          {{ $pub->price == 0 ? 'FREE' : ' £ ' . number_format($pub->price, 2) }}
        </div>
        
       <button class="view-details-btn"
          style="background-color: {{ $pub->price == 0 ? '#28a745' : '#0f2540' }};"
          onclick="event.stopPropagation(); 
              {{ $pub->visibleType === 'private' ? 'openPrivateModal('.$pub->id.')' : 'openPublicModal('.$pub->id.')' }}">
          {{ $pub->visibleType === 'private' ? '🔒 Request Access' : 'Download Now' }}
       </button>

      </div>
    </div>
  @endforeach
@else
  <div class="no-publications">
    <h3>📭 No Publications Found</h3>
    <p>Try adjusting your filters or check back later for new publications.</p>
  </div>
@endif

{{-- Pagination --}}
@if($publications->hasPages())
  <div class="pagination-container" aria-label="Publications pagination">
    {{-- Page info --}}
    <div class="page-info" aria-hidden="true">
      Page {{ $publications->currentPage() }} of {{ $publications->lastPage() }}
    </div>

    <ul class="pagination" role="navigation" aria-label="Pagination Navigation">
      {{-- Previous --}}
      <li class="{{ $publications->onFirstPage() ? 'disabled' : '' }} prev">
        @if($publications->onFirstPage())
          <span aria-disabled="true" aria-label="Previous page">‹ Prev</span>
        @else
          <a href="{{ $publications->previousPageUrl() }}" 
             rel="prev" aria-label="Previous page" class="pagination-link" data-page="{{ $publications->currentPage() - 1 }}">‹ Prev</a>
        @endif
      </li>

      {{-- First page & leading ellipsis --}}
      @if($publications->currentPage() > 3)
        <li><a href="{{ $publications->url(1) }}" class="pagination-link" data-page="1">1</a></li>
      @endif
      @if($publications->currentPage() > 4)
        <li class="ellipsis"><span aria-hidden="true">…</span></li>
      @endif

      {{-- Page number window (2 before, current, 2 after) --}}
      @foreach(range(1, $publications->lastPage()) as $i)
        @if($i >= $publications->currentPage() - 2 && $i <= $publications->currentPage() + 2)
          <li class="{{ $i === $publications->currentPage() ? 'active' : '' }}">
            @if($i === $publications->currentPage())
              <span aria-current="page">{{ $i }}</span>
            @else
              <a href="{{ $publications->url($i) }}" class="pagination-link" data-page="{{ $i }}">{{ $i }}</a>
            @endif
          </li>
        @endif
      @endforeach

      {{-- Trailing ellipsis + last --}}
      @if($publications->currentPage() < $publications->lastPage() - 3)
        <li class="ellipsis"><span aria-hidden="true">…</span></li>
      @endif
      @if($publications->currentPage() < $publications->lastPage() - 2)
        <li><a href="{{ $publications->url($publications->lastPage()) }}" class="pagination-link" data-page="{{ $publications->lastPage() }}">{{ $publications->lastPage() }}</a></li>
      @endif

      {{-- Next --}}
      <li class="{{ $publications->hasMorePages() ? '' : 'disabled' }} next">
        @if($publications->hasMorePages())
          <a href="{{ $publications->nextPageUrl() }}" 
             rel="next" aria-label="Next page" class="pagination-link" data-page="{{ $publications->currentPage() + 1 }}">Next ›</a>
        @else
          <span aria-disabled="true" aria-label="Next page">Next ›</span>
        @endif
      </li>
    </ul>

    {{-- Items count --}}
    <div class="pagination-extra" aria-hidden="true">
      <span class="muted">Showing {{ $publications->firstItem() ?: 0 }}–{{ $publications->lastItem() ?: 0 }} of {{ $publications->total() }}</span>
    </div>
  </div>
@endif


<script>
  // Publications data
  let publications = @json($publications->items());
  const mainCategorySelect = document.getElementById('mainCategorySelect');
  const subCategorySelect = document.getElementById('subCategorySelect');
  const publicationsGrid = document.getElementById('publicationsGrid');
  const loadingSpinner = document.getElementById('loadingSpinner');
  const pubCount = document.getElementById('pubCount');

  // Load sub categories when main category changes
  mainCategorySelect.addEventListener('change', function() {
    const typeId = this.value;
    
    // Reset sub category
    subCategorySelect.innerHTML = '<option value="">All Categories</option>';
    
    if (!typeId) {
      subCategorySelect.disabled = true;
      filterPublications();
      return;
    }
    
    subCategorySelect.disabled = false;
    
    // Fetch categories via AJAX
    fetch(`{{ url('/api/categories-by-type') }}/${typeId}`)
      .then(response => response.json())
      .then(data => {
        if (data.categories && data.categories.length > 0) {
          data.categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.name;
            subCategorySelect.appendChild(option);
          });
        }
      })
      .catch(error => console.error('Error loading categories:', error));
    
    // Filter publications
    filterPublications();
  });

  // Filter when sub category changes
  subCategorySelect.addEventListener('change', filterPublications);

  // Filter publications via AJAX
  function filterPublications(page = 1) {
    const typeId = mainCategorySelect.value;
    const categoryId = subCategorySelect.value;
    
    // Show loading
    loadingSpinner.classList.add('active');
    publicationsGrid.style.opacity = '0.5';
    
    // Build URL
    let url = '{{ route("publications.filter") }}?page=' + page;
    if (typeId) url += `&type=${typeId}`;
    if (categoryId) url += `&category=${categoryId}`;
    
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
      
      // Re-attach pagination link handlers
      attachPaginationHandlers();
      
      // Hide loading
      loadingSpinner.classList.remove('active');
      publicationsGrid.style.opacity = '1';
      
      // Scroll to top of publications
      document.querySelector('.publications-section').scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start' 
      });
      
      // Update URL without reload
      const newUrl = new URL(window.location);
      newUrl.searchParams.set('page', page);
      if (typeId) {
        newUrl.searchParams.set('type', typeId);
      } else {
        newUrl.searchParams.delete('type');
      }
      if (categoryId) {
        newUrl.searchParams.set('category', categoryId);
      } else {
        newUrl.searchParams.delete('category');
      }
      window.history.pushState({}, '', newUrl);
    })
    .catch(error => {
      console.error('Error:', error);
      loadingSpinner.classList.remove('active');
      publicationsGrid.style.opacity = '1';
    });
  }

  // Attach click handlers to pagination links
  function attachPaginationHandlers() {
    const paginationLinks = document.querySelectorAll('.pagination-link');
    paginationLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        filterPublications(page);
      });
    });
  }

  // Reset filters
  function resetFilters() {
    mainCategorySelect.value = '';
    subCategorySelect.innerHTML = '<option value="">All Categories</option>';
    subCategorySelect.disabled = true;
    filterPublications(1);
  }

    const book = publications.find(p => p.id === bookId);
    if (!book) return;

    document.getElementById('modalTitle').textContent = book.title;
    document.getElementById('modalCover').src = `/storage/${book.title_image}`;
    document.getElementById('modalCover').onerror = function() {
      this.src = '{{ asset("images/newlogo.jpeg") }}';
    };
    document.getElementById('modalDescription').innerHTML = book.content;
    document.getElementById('modalType').textContent = book.publication_type?.name || 'N/A';
    document.getElementById('modalCategory').textContent = book.category?.name || 'N/A';
    document.getElementById('modalPrice').textContent = book.price == 0 ? 'FREE' : `$${parseFloat(book.price).toFixed(2)}`;
    document.getElementById('modalAccess').textContent = book.visibleType === 'public' ? 'Public' : 'Private';
    document.getElementById('modalDate').textContent = new Date(book.created_at).toLocaleDateString();

    const actionButtons = document.getElementById('actionButtons');
    actionButtons.innerHTML = '';

    if (book.pdf) {
      const downloadBtn = document.createElement('button');
      downloadBtn.className = 'download-btn';
      downloadBtn.innerHTML = '📥 Download PDF';
      downloadBtn.onclick = () => window.open(`/storage/${book.pdf}`, '_blank');
      actionButtons.appendChild(downloadBtn);
    }

    if (book.price > 0) {
      const orderBtn = document.createElement('button');
      orderBtn.className = 'order-btn';
      orderBtn.innerHTML = '🛒 Order Now';
      orderBtn.onclick = () => orderBook(book.id, book.title, book.price);
      actionButtons.appendChild(orderBtn);
    }

    document.getElementById('bookModal').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  // function closeModal() {
  //   document.getElementById('bookModal').classList.remove('open');
  //   document.body.style.overflow = 'auto';
  // }

  function orderBook(id, title, price) {
    alert(`Order placed for: ${title}\nPrice: $${parseFloat(price).toFixed(2)}\n\nYou will be redirected to payment.`);
  }

  // Close modal on escape/outside click
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });

  document.getElementById('bookModal').addEventListener('click', (e) => {
    if (e.target.id === 'bookModal') closeModal();
  });

  // Initialize pagination handlers on page load
  document.addEventListener('DOMContentLoaded', function() {
    attachPaginationHandlers();
  });
</script>