@extends('layouts.masteradmin')

@section('title', $newsItem->title)

@section('content')
<div class="container my-5">
    <h2 class="fw-bold text-primary mb-4">{{ $newsItem->title }}</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4 shadow-sm border-0 rounded-3 overflow-hidden">
        {{-- News Image --}}
        @if($newsItem->title_image)
            <img src="{{ asset($newsItem->title_image) }}" class="card-img-top" alt="{{ $newsItem->title }}" style="height:400px;object-fit:cover;">
        @else
            <img src="https://via.placeholder.com/800x400?text=No+Image" class="card-img-top" alt="No Image">
        @endif

        <div class="card-body">
            <p class="card-text text-secondary">{{ $newsItem->content }}</p>

            <div class="mb-2">
                <span class="badge bg-info text-dark">{{ $newsItem->category }}</span>
                <span class="text-muted small ms-2">
                    <i class="bi bi-eye"></i> {{ $newsItem->views }} views
                </span>
            </div>

            <p class="text-muted small mb-3">
                <i class="bi bi-calendar"></i> {{ $newsItem->created_at->format('M d, Y') }}
            </p>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.news.edit', $newsItem->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <form action="{{ route('admin.news.destroy', $newsItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this news?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
