@extends('layouts.masteradmin')

@section('title', 'Edit Event')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-pencil-square"></i> Edit Event
        </h3>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                        <input type="text" name="event_title" class="form-control form-control-lg" 
                               value="{{ old('event_title', $event->event_title) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="event_category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('event_category_id', $event->event_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-2">
                            <input type="text" name="new_category" class="form-control form-control-sm" 
                                   placeholder="Or create new category...">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Title Image</label>
                    <input type="file" name="title_image" class="form-control" accept="image/*">
                    @if($event->title_image)
                        <div class="mt-2">
                            <img src="{{ asset($event->title_image) }}" 
                                 alt="Current image" class="rounded" style="max-height: 150px;">
                            <small class="d-block text-muted mt-1">Current image (upload new to replace)</small>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                    <textarea name="content" rows="5" class="form-control" required>{{ old('content', $event->content) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <input type="text" name="address" class="form-control" 
                               value="{{ old('address', $event->address) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Venue <span class="text-danger">*</span></label>
                        <input type="text" name="venue" class="form-control" 
                               value="{{ old('venue', $event->venue) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" 
                               value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Start Time <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" class="form-control" 
                               value="{{ old('start_time', $event->start_time) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" class="form-control" 
                               value="{{ old('end_time', $event->end_time) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">YouTube URL</label>
                    <input type="url" name="youtube_url" class="form-control" 
                           value="{{ old('youtube_url', $event->youtube_url) }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Related Images</label>
                    <input type="file" name="related_images[]" class="form-control" multiple accept="image/*">
                    @if($event->related_images && count($event->related_images) > 0)
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($event->related_images as $img)
                                <img src="{{ asset($img) }}" class="rounded" 
                                     style="height:80px;width:80px;object-fit:cover;">
                            @endforeach
                        </div>
                        <small class="text-muted">Current images (upload new to replace all)</small>
                    @endif
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-save me-1"></i> Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection