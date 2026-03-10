@props(['slider' => null, 'action', 'method' => 'POST'])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="sliderForm">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Subtitle</label>
        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" {{ $slider ? '' : 'required' }}>
        @if(isset($slider->image))
            <small>Current: <img src="{{ asset($slider->image) }}" width="100" class="rounded"></small>
        @endif
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="status" value="1" {{ old('status', $slider->status ?? 1) ? 'checked' : '' }}>
        <label class="form-check-label">Active</label>
    </div>

    <button type="submit" class="btn btn-primary">
        <span class="btnText">{{ $slider ? 'Update Slider' : 'Add Slider' }}</span>
        <span class="spinner-border spinner-border-sm d-none btnLoader"></span>
    </button>
</form>
