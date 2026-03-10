@extends('layouts.masteradmin')

@section('title', 'Edit News')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold text-primary mb-4">Edit News</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Content</label>
            <textarea name="content" class="form-control" rows="6" required>{{ old('content', $news->content) }}</textarea>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category_id" class="form-select" required onchange="toggleOtherCategory(this)">
                <option value="">Select Category</option>
                @foreach(App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ $category->name == $news->category ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
                <option value="other" {{ !App\Models\Category::where('name', $news->category)->exists() ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div id="otherCategoryDiv" class="mb-3" style="display:none;">
            <label class="form-label fw-semibold">Other Category</label>
            <input type="text" name="other_category" class="form-control"
                placeholder="Enter new category name"
                value="{{ !App\Models\Category::where('name', $news->category)->exists() ? $news->category : '' }}">
        </div>

        <!-- Visibility -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Visibility</label>
            <select name="visibility" class="form-select" required>
                <option value="public" {{ $news->visibility == 'public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ $news->visibility == 'private' ? 'selected' : '' }}>Private</option>
            </select>
        </div>

        <!-- Current Title Image -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Current Title Image</label><br>
            @if($news->title_image)
                <img src="{{ asset($news->title_image) }}" width="200" class="rounded shadow-sm mb-2">
            @else
                <p>No image uploaded</p>
            @endif
        </div>

        <!-- Change Title Image -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Change Title Image</label>
            <input type="file" name="title_image" class="form-control" accept="image/*">
        </div>

        <!-- Current Additional Images -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Current Additional Images</label><br>
            @if($news->images)
                @foreach(json_decode($news->images, true) as $img)
                    <img src="{{ asset($img) }}" width="120" class="rounded shadow-sm m-1">
                @endforeach
            @else
                <p>No additional images</p>
            @endif
        </div>

        <!-- Change Additional Images -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Change Additional Images (optional)</label>
            <input type="file" name="additional_images[]" multiple class="form-control" accept="image/*">
        </div>

        <!-- Current PDF File -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Current PDF File</label><br>
            @if($news->pdf_file)
                <a href="{{ asset($news->pdf_file) }}" target="_blank" class="btn btn-outline-primary mb-2">
                    <i class="bi bi-file-earmark-pdf me-2"></i> View Current PDF
                </a>
            @else
                <p>No PDF uploaded</p>
            @endif
        </div>

        <!-- Upload New PDF -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Upload New PDF (optional)</label>
            <input type="file" name="pdf_file" class="form-control" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-check-circle"></i> Update News
        </button>
    </form>
</div>

<script>
function toggleOtherCategory(select) {
    document.getElementById('otherCategoryDiv').style.display = select.value === 'other' ? 'block' : 'none';
}
window.onload = function() {
    toggleOtherCategory(document.querySelector('select[name="category_id"]'));
}
</script>
@endsection
