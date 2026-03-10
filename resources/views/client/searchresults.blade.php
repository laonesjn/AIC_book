@extends('layouts.masterclient')

@section('title', 'Search Results: ' . $query . ' — Tamil Bookshop Archives')

@section('content')
<div class="container" style="padding: 2rem 0 4rem;">

    <h1 style="font-size:1.75rem; font-weight:700; margin-bottom:0.25rem;">
        Search Results
    </h1>
    <p style="color:#555; margin-bottom:2rem;">
        Showing results for "<strong>{{ $query }}</strong>"
    </p>

    {{-- ── Collections ─────────────────────────────────────────────────────── --}}
    @if($collections->count())
    <section style="margin-bottom:2.5rem;">
        <h2 style="font-size:1.25rem; font-weight:700; border-bottom:2px solid #0f2540; padding-bottom:0.5rem; margin-bottom:1rem;">
            Collections <span style="font-weight:400; color:#888;">({{ $collections->total() }})</span>
        </h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1.25rem;">
            @foreach($collections as $item)
            <a href="{{ route('client.collection.show', $item->id) }}" class="result-card">
                @if($item->title_image)
                   <img
    src="{{ \Illuminate\Support\Str::startsWith($item->title_image, ['http://', 'https://'])
        ? $item->title_image
        : asset($item->title_image) }}"
    alt="{{ $item->title }}"
    class="result-card-img"
>
                @else
                    <div class="result-card-placeholder">📚</div>
                @endif
                <div class="result-card-body">
                    <span class="result-card-type">Collection</span>
                    <p class="result-card-title">{{ Str::limit($item->title, 55) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:1rem;">{{ $collections->appends(['q' => $query])->links() }}</div>
    </section>
    @endif

    {{-- ── Exhibitions ──────────────────────────────────────────────────────── --}}
    @if($exhibitions->count())
    <section style="margin-bottom:2.5rem;">
        <h2 style="font-size:1.25rem; font-weight:700; border-bottom:2px solid #0f2540; padding-bottom:0.5rem; margin-bottom:1rem;">
            Exhibitions <span style="font-weight:400; color:#888;">({{ $exhibitions->total() }})</span>
        </h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1.25rem;">
            @foreach($exhibitions as $item)
            <a href="{{ route('client.exhibition.show', $item->id) }}" class="result-card">
                @if($item->cover_image)
                   <img
    src="{{ \Illuminate\Support\Str::startsWith($item->cover_image, ['http://', 'https://'])
        ? $item->cover_image
        : asset($item->cover_image) }}"
    alt="{{ $item->title }}"
    class="result-card-img"
>
                @else
                    <div class="result-card-placeholder">🏛️</div>
                @endif
                <div class="result-card-body">
                    <span class="result-card-type">Exhibition</span>
                    <p class="result-card-title">{{ Str::limit($item->title, 55) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:1rem;">{{ $exhibitions->appends(['q' => $query])->links() }}</div>
    </section>
    @endif

    {{-- ── Heritage ─────────────────────────────────────────────────────────── --}}
    @if($heritage->count())
    <section style="margin-bottom:2.5rem;">
        <h2 style="font-size:1.25rem; font-weight:700; border-bottom:2px solid #0f2540; padding-bottom:0.5rem; margin-bottom:1rem;">
            Heritage Museum <span style="font-weight:400; color:#888;">({{ $heritage->total() }})</span>
        </h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1.25rem;">
            @foreach($heritage as $item)
            <a href="{{ route('heritage.collection.show', $item->id) }}" class="result-card">
                @if($item->title_image)
                 <img
    src="{{ \Illuminate\Support\Str::startsWith($item->title_image, ['http://', 'https://'])
        ? $item->title_image
        : asset($item->title_image) }}"
    alt="{{ $item->title }}"
    class="result-card-img"
>
                @else
                    <div class="result-card-placeholder">🏺</div>
                @endif
                <div class="result-card-body">
                    <span class="result-card-type">Heritage</span>
                    <p class="result-card-title">{{ Str::limit($item->title, 55) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:1rem;">{{ $heritage->appends(['q' => $query])->links() }}</div>
    </section>
    @endif

    {{-- ── Publications ─────────────────────────────────────────────────────── --}}
    @if($publications->count())
    <section style="margin-bottom:2.5rem;">
        <h2 style="font-size:1.25rem; font-weight:700; border-bottom:2px solid #0f2540; padding-bottom:0.5rem; margin-bottom:1rem;">
            Publications <span style="font-weight:400; color:#888;">({{ $publications->total() }})</span>
        </h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1.25rem;">
            @foreach($publications as $item)
            <a href="{{ route('client.publication.show', $item->id) }}" class="result-card">
                @if($item->title_image)
                  <img
    src="{{ \Illuminate\Support\Str::startsWith($item->title_image, ['http://', 'https://'])
        ? $item->title_image
        : asset($item->title_image) }}"
    alt="{{ $item->title }}"
    class="result-card-img"
>
                @else
                    <div class="result-card-placeholder">📖</div>
                @endif
                <div class="result-card-body">
                    <span class="result-card-type">Publication</span>
                    <p class="result-card-title">{{ Str::limit($item->title, 55) }}</p>
                    {{-- Price badge --}}
                    <span style="
                        display:inline-block;
                        margin-top:6px;
                        font-size:0.72rem;
                        font-weight:700;
                        padding:2px 8px;
                        border-radius:20px;
                        background: {{ $item->price == 0 ? '#d4edda' : '#fff3cd' }};
                        color:       {{ $item->price == 0 ? '#155724' : '#856404' }};
                    ">
                        {{ $item->price == 0 ? 'Free' : '$' . number_format($item->price, 2) }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:1rem;">{{ $publications->appends(['q' => $query])->links() }}</div>
    </section>
    @endif

    {{-- ── No results ───────────────────────────────────────────────────────── --}}
    @if(!$collections->count() && !$exhibitions->count() && !$heritage->count() && !$publications->count())
    <div style="text-align:center; padding:4rem 0; color:#666;">
        <p style="font-size:3rem; margin-bottom:1rem;">🔍</p>
        <p style="font-size:1.25rem; font-weight:600;">No results found for "{{ $query }}"</p>
        <p style="font-size:0.95rem; margin-top:0.5rem;">Try a different keyword or browse our collections.</p>
        <a href="{{ route('client.discoverourcollection') }}"
           style="display:inline-block; margin-top:1.5rem; padding:0.75rem 1.5rem; background:#0f2540; color:#fff; border-radius:8px; text-decoration:none; font-weight:600;">
            Browse Collections
        </a>
    </div>
    @endif

</div>

{{-- Shared card styles --}}
<style>
.result-card {
    display: block;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    text-decoration: none;
    color: #0f2540;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}
.result-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.13);
}
.result-card-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
}
.result-card-placeholder {
    width: 100%;
    height: 140px;
    background: #e6d3bd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}
.result-card-body {
    padding: 0.875rem;
}
.result-card-type {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #bfa98b;
}
.result-card-title {
    font-weight: 600;
    margin: 0.25rem 0 0;
    font-size: 0.9rem;
    line-height: 1.35;
}
</style>
@endsection