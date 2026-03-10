@if($announcements->isEmpty())
  <div class="text-muted">No announcements yet.</div>
@else
  @foreach($announcements as $announcement)
    <div class="announcement-row card p-3 mb-2" data-id="{{ $announcement->id }}">
      <div class="d-flex align-items-start gap-3">
        <div class="flex-grow-1 announcement-content">{!! nl2br(e($announcement->content ?? '')) !!}</div>
        <div class="text-end" style="min-width:120px">
          <button class="btn btn-sm btn-outline-primary me-1 edit-btn">Edit</button>
          <button class="btn btn-sm btn-outline-danger delete-btn">Delete</button>
        </div>
      </div>
      <div class="text-muted small mt-2">{{ $announcement->created_at ? $announcement->created_at->format('Y-m-d H:i') : '' }}</div>
    </div>
  @endforeach
@endif
