{{-- FILE: resources/views/client/heritagecentre.blade.php --}}
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

    .collection-card .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid #ddd !important;
        border-radius: var(--border-radius);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .collection-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .collection-card .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
    }
    .collection-card .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .collection-card .card-title {
        font-size: 1rem;
        font-weight: 700;
        margin-top: 8px;
    }
    .collection-card .card-text {
        font-size: 0.85rem;
        color: #666;
        flex-grow: 1;
    }
    .collection-card .btn {
        margin-top: auto;
    }
    .no-results-box {
        max-width: 420px;
        padding: 2.2rem 2rem;
        background: var(--card-bg);
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    .no-results-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        font-size: 1.3rem;
    }
    .results-count {
        font-size: 0.9rem;
        color: var(--accent-dark);
        opacity: 0.7;
        margin-top: 10px;
    }

    /* No-results overlay (JS-driven) */
    .search-section { position: relative; }
    .no-results {
        position: absolute;
        inset: 0;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(246, 236, 224, 0.65);
        backdrop-filter: blur(3px);
    }
</style>

{{-- Hero --}}
<section class="archive-hero text-center mb-5">
    <h1>Exhibition &amp; Heritage Centre</h1>
    <p>Discover our exhibitions and heritage displays.</p>
</section>

{{-- Search + Filter --}}
<section class="search-section mb-5">

    <div id="noResults" class="no-results d-none" role="status" aria-live="polite">
        <div class="no-results-box">
            <div class="no-results-icon"><i class="fas fa-search"></i></div>
            <h3 class="fw-bold">No matching collections</h3>
            <p class="text-muted" style="font-size:0.9rem;">
                Your search or selected filters didn't return any results.
            </p>
            <button id="clearFiltersBtn" class="btn btn-dark btn-sm mb-3">
                <i class="fas fa-times me-1"></i> Clear all filters
            </button>
            <p class="text-muted" style="font-size:0.85rem;">
                Tip: Try broader keywords or remove one filter at a time.
            </p>
        </div>
    </div>

    <div class="card shadow border-0 p-4 p-md-5" style="border-radius: 15px; background: #f6ece0;">

        {{-- Search Input --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="input-group input-group-lg shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control border-start-0 ps-0"
                        id="searchInput"
                        placeholder="Search by title, keyword or description..."
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>

        {{-- Filters Row --}}
        <div class="row g-3 justify-content-center align-items-end">

            <div class="col-12 col-md-5">
                <label class="small fw-bold mb-1 text-secondary">
                    <i class="fas fa-filter me-1"></i> Category
                </label>
                <select class="form-select filter-select shadow-sm" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-3 d-flex gap-2">
                <button id="clearFiltersBtn2" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>

        </div>

        {{-- Results Count --}}
        <p class="results-count mt-2 mb-0">
            Showing <strong id="visibleCount">{{ $exhibitions->count() }}</strong> exhibition(s)
        </p>

    </div>
</section>

{{-- Exhibitions Grid --}}
<div id="collectionsContainer">
    <section class="collection-section mb-5">

        @if($exhibitions->isEmpty())
            <div class="d-flex justify-content-center">
                <div class="no-results-box">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="fw-bold">No exhibitions available</h3>
                    <p class="text-muted" style="font-size:0.9rem;">
                        There are no exhibitions available at this time.
                    </p>
                </div>
            </div>

        @else
            <div class="row g-4 justify-content-center" id="exhibitionsGrid">
                @foreach($exhibitions as $exhibition)
                    <div class="col-12 col-sm-6 col-lg-3 collection-card"
                         data-title="{{ strtolower($exhibition->title) }}"
                         data-desc="{{ strtolower($exhibition->description) }}"
                         data-category="{{ $exhibition->category_id }}">
                        <div class="card h-100 border-0 shadow-sm text-center">

                            {{-- Exhibition Image --}}
                            @if($exhibition->cover_image)
                                <img
                                    src="{{ asset('public/'.$exhibition->cover_image) }}"
                                    class="card-img-top"
                                    alt="{{ $exhibition->title }}"
                                >
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                     style="height:180px;">
                                    <span style="font-size:48px;">🏛️</span>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">

                                {{-- Category Badge --}}
                                <span class="badge bg-secondary mb-2 mx-auto" style="font-size:0.75rem;">
                                    {{ $exhibition->category->name ?? 'Uncategorized' }}
                                </span>

                                {{-- Title --}}
                                <h5 class="card-title fw-bold">
                                    {{ $exhibition->title }}
                                </h5>

                                {{-- View Button --}}
                                <a href="{{ route('client.exhibition.show', $exhibition) }}"
                                   class="btn btn-dark btn-sm mt-auto mx-auto">
                                    Explore Exhibition
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </section>
</div>

<script>
(function () {
    const searchInput    = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const clearBtn1      = document.getElementById('clearFiltersBtn');
    const clearBtn2      = document.getElementById('clearFiltersBtn2');
    const grid           = document.getElementById('exhibitionsGrid');
    const noResultsBox   = document.getElementById('noResults');
    const visibleCount   = document.getElementById('visibleCount');

    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll('.collection-card'));

    function applyFilters() {
        const search   = searchInput.value.trim().toLowerCase();
        const category = categoryFilter.value;
        let visible    = 0;

        cards.forEach(function(card) {
            const title = card.dataset.title    || '';
            const desc  = card.dataset.desc     || '';
            const catId = card.dataset.category || '';

            const matchSearch   = !search   || title.includes(search) || desc.includes(search);
            const matchCategory = !category || catId === category;

            if (matchSearch && matchCategory) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        visibleCount.textContent = visible;
        if (noResultsBox) noResultsBox.classList.toggle('d-none', visible > 0);
    }

    function clearAll() {
        searchInput.value    = '';
        categoryFilter.value = '';
        applyFilters();
    }

    // Auto-submit on dropdown change (mirrors archive-centre behaviour)
    categoryFilter.addEventListener('change', applyFilters);

    // Debounced search on typing (500ms delay)
    let searchTimer;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(applyFilters, 500);
    });

    if (clearBtn1) clearBtn1.addEventListener('click', clearAll);
    if (clearBtn2) clearBtn2.addEventListener('click', clearAll);

    applyFilters();
})();
</script>

@endsection