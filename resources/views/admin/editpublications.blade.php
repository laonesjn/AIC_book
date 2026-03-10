@extends('layouts.masteradmin')

@section('title', 'Edit Publication')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Publication</h2>

    <form action="{{ route('admin.publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $publication->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Title Image</label>
            <input type="file" name="title_image" class="form-control">
            @if($publication->title_image)
                <img src="{{ asset($publication->title_image) }}" alt="Image" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="5" required>{{ $publication->content }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
                <option value="TIC Periodical" {{ $publication->category == 'TIC Periodical' ? 'selected' : '' }}>TIC Periodical</option>
                <option value="Free Publication" {{ $publication->category == 'Free Publication' ? 'selected' : '' }}>Free Publication</option>
                <option value="TIC Monograph" {{ $publication->category == 'TIC Monograph' ? 'selected' : '' }}>TIC Monograph</option>
            </select>
        </div>

        <div class="mb-3" id="priceField">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" value="{{ $publication->price }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Visible Type</label>
            <select name="visibleType" class="form-select" required>
                <option value="public" {{ $publication->visibleType == 'public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ $publication->visibleType == 'private' ? 'selected' : '' }}>Private</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">PDF File (optional)</label>
            <input type="file" name="pdf" class="form-control">
            @if($publication->pdf)
                <a href="{{ asset($publication->pdf) }}" target="_blank" class="d-block mt-2">Current PDF</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Publication</button>
    </form>
</div>

<script>
    const category = document.querySelector('select[name="category"]');
    const priceField = document.getElementById('priceField');

    function togglePrice() {
        priceField.style.display = category.value === 'Free Publication' ? 'none' : 'block';
    }

    category.addEventListener('change', togglePrice);
    togglePrice(); // initial
</script>
@endsection
