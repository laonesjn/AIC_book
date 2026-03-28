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
    .active-filters-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin-top: 12px;
    }
    .filter-tag {
        background: var(--accent-dark);
        color: #fff;
        border-radius: 20px;
        padding: 3px 12px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .filter-tag a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
    }
    .results-count {
        font-size: 0.9rem;
        color: var(--accent-dark);
        opacity: 0.7;
        margin-top: 10px;
    }
</style>

{{-- Hero --}}
<section class="archive-hero text-center mb-5">
    <h1>Exhibition Centre Collection</h1>
    <p>Discover curated guides to Tamil heritage.</p>
</section>

{{-- Search + Filter Form --}}
<section class="search-section mb-5">
    <form method="GET" action="{{ route('heritage.archive-centre') }}" id="filterForm">
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
                            name="search"
                            id="searchInput"
                            class="form-control border-start-0 ps-0"
                            placeholder="Search by title or description..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                        @if(request('search'))
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="document.getElementById('searchInput').value=''; document.getElementById('filterForm').submit();">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Filters Row --}}
            <div class="row g-3 justify-content-center align-items-end">

                {{-- Main Category Filter - dynamically from DB --}}
                <div class="col-12 col-md-5">
                    <label class="small fw-bold mb-1 text-secondary">
                        <i class="fas fa-filter me-1"></i> Main Category
                    </label>
                    <select class="form-select filter-select shadow-sm" name="category" id="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach($masterCategories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Access Type Filter --}}
                <div class="col-12 col-md-4">
                    <label class="small fw-bold mb-1 text-secondary">
                        <i class="fas fa-lock me-1"></i> Access Type
                    </label>
                    <select class="form-select filter-select shadow-sm" name="access_type" id="accessFilter">
                        <option value="">All Access Types</option>
                        <option value="Public"  {{ request('access_type') == 'Public'  ? 'selected' : '' }}>Public</option>
                        <option value="Private" {{ request('access_type') == 'Private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                    @if(request()->hasAny(['search', 'category', 'access_type']))
                        <a href="{{ route('client.archivecentrecollection') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </div>

            {{-- Active Filter Tags + Results Count --}}
            @if(request()->hasAny(['search', 'category', 'access_type']))
                <div class="active-filters-bar mt-3">
                    <span class="small text-muted fw-bold me-1">Active filters:</span>

                    @if(request('search'))
                        <span class="filter-tag">
                            Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}">×</a>
                        </span>
                    @endif

                    @if(request('category'))
                        <span class="filter-tag">
                            Category: {{ $masterCategories->find(request('category'))?->name ?? request('category') }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}">×</a>
                        </span>
                    @endif

                    @if(request('access_type'))
                        <span class="filter-tag">
                            Access: {{ request('access_type') }}
                            <a href="{{ request()->fullUrlWithQuery(['access_type' => null]) }}">×</a>
                        </span>
                    @endif
                </div>
            @endif

            {{-- Results Count --}}
            <p class="results-count mt-2 mb-0">
                Showing <strong>{{ $collections->count() }}</strong> collection(s)
            </p>

        </div>
    </form>
</section>

{{-- Collections Grid --}}
<div id="collectionsContainer">
    <section class="collection-section mb-5">

        @if($collections->isEmpty())
            {{-- No Results State --}}
            <div class="d-flex justify-content-center">
                <div class="no-results-box">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="fw-bold">No matching collections</h3>
                    <p class="text-muted" style="font-size:0.9rem;">
                        Your search or selected filters didn't return any results.
                    </p>
                    <a href="{{ route('client.archivecentrecollection') }}" class="btn btn-dark btn-sm mb-3">
                        <i class="fas fa-times me-1"></i> Clear all filters
                    </a>
                    <p class="text-muted" style="font-size:0.85rem;">
                        Tip: Try broader keywords or remove one filter at a time.
                    </p>
                </div>
            </div>

        @else
            <div class="row g-4 justify-content-center">
                @foreach($collections as $collection)
                    <div class="col-12 col-sm-6 col-lg-3 collection-card">
                        <div class="card h-100 border-0 shadow-sm text-center">

                            {{-- Collection Image --}}
                            @if($collection->title_image)
                                <img
                                    src="{{ Str::startsWith($collection->title_image, ['http://', 'https://'])
                                        ? $collection->title_image
                                        : asset('public/'.$collection->title_image) }}"
                                    class="card-img-top"
                                    alt="{{ $collection->title }}"
                                    loading="lazy"
                                >
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                     style="height:180px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">

                                {{-- Main Category Badge (from DB) --}}
                                <!-- <span class="badge bg-secondary mb-2 mx-auto" style="font-size:0.75rem;">
                                    {{ $collection->masterMainCategory->name ?? 'Uncategorized' }}
                                </span> -->

                                {{-- Collection Title --}}
                                <h5 class="card-title fw-bold">
                                    {{ $collection->title }}
                                </h5>

                                {{-- Description --}}
                                <!-- <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($collection->description, 120) }}
                                </p> -->

                                {{-- Access Badge --}}
                                <div class="mb-2">
                                    <span class="badge {{ $collection->access_type === 'Public' ? 'bg-success' : 'bg-danger' }}">
                                        <i class="fas {{ $collection->access_type === 'Public' ? 'fa-globe' : 'fa-lock' }} me-1"></i>
                                        {{ $collection->access_type }}
                                    </span>
                                </div>

                                {{-- View Button --}}
                                <a href="{{ route('heritage.collection.show', $collection->id) }}"
                                   class="btn btn-dark btn-sm mt-auto mx-auto">
                                    View Collection
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </section>
</div>

{{-- Auto-submit on dropdown change + debounced search --}}
<script>
    // Auto-submit when any dropdown changes
    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });

    // Debounced search on typing (500ms delay)
    let searchTimer;
    document.getElementById('searchInput').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });
</script>

@endsection