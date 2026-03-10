@extends('layouts.masteradmin')
@section('title', 'Publication Orders')

@section('content')
<div class="container-fluid">
  <h2 class="fw-bold text-primary mb-4">📦 Publication Orders</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Publication</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Requested On</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
        @php
          $pub = $publications[$order->publication_id] ?? null;
        @endphp
        <tr data-aos="fade-up">
          <td>{{ $order->id }}</td>
          <td>{{ $pub->title ?? 'N/A' }}</td>
          <td>{{ $order->name }}</td>
          <td>{{ $order->email }}</td>
          <td>{{ $order->phone ?? '-' }}</td>
          <td>
            <span class="badge bg-{{ $order->status == 'Pending' ? 'warning' : 'success' }}">
              {{ $order->status }}
            </span>
          </td>
          <td>{{ $order->created_at->format('Y-m-d') }}</td>
          <td>
            <button class="btn btn-sm btn-primary view-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#viewModal"
                    data-id="{{ $order->id }}"
                    data-name="{{ $order->name }}"
                    data-email="{{ $order->email }}"
                    data-phone="{{ $order->phone }}"
                    data-why="{{ $order->why }}"
                    data-status="{{ $order->status }}"
                    data-publication-title="{{ $pub->title ?? 'N/A' }}"
                    data-publication-image="{{ $pub ? (filter_var($pub->title_image, FILTER_VALIDATE_URL) ? $pub->title_image : asset($pub->title_image)) : '' }}"
                    data-publication-content="{{ $pub->content ?? '' }}"
                    data-publication-category="{{ $pub->category ?? '' }}"
                    data-publication-price="{{ $pub->price ?? '' }}"
                    data-publication-visible="{{ $pub->visibleType ?? '' }}"
                    data-publication-pdf="{{ $pub ? (filter_var($pub->pdf, FILTER_VALIDATE_URL) ? $pub->pdf : asset($pub->pdf)) : '' }}">
              <i class="bi bi-eye"></i> View
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted">No orders available.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="viewModalLabel">Order Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Left: Publication Details -->
          <div class="col-md-6">
            <h5>📖 Publication Details</h5>
            <ul class="list-group">
              <li class="list-group-item"><strong>Title:</strong> <span id="modalPublicationTitle"></span></li>
              <li class="list-group-item"><strong>Image:</strong><br>
                <img id="modalPublicationImage" class="img-fluid rounded shadow-sm mt-2" style="max-height:150px">
              </li>
              <li class="list-group-item"><strong>Content:</strong> <span id="modalPublicationContent"></span></li>
              <li class="list-group-item"><strong>Category:</strong> <span id="modalPublicationCategory"></span></li>
              <li class="list-group-item"><strong>Price:</strong>
                <span id="modalPublicationPrice" class="fw-bold text-success"></span>
              </li>
              <li class="list-group-item"><strong>Visible Type:</strong> <span id="modalPublicationVisible"></span></li>
              <li class="list-group-item"><strong>PDF:</strong>
                <a id="modalPublicationPdf" href="#" target="_blank" class="text-primary">Download</a>
              </li>
            </ul>
          </div>

          <!-- Right: Order Details -->
          <div class="col-md-6">
            <h5>👤 Customer Details</h5>
            <ul class="list-group">
              <li class="list-group-item"><strong>Name:</strong> <span id="modalName"></span></li>
              <li class="list-group-item"><strong>Email:</strong> <span id="modalEmail"></span></li>
              <li class="list-group-item"><strong>Phone:</strong> <span id="modalPhone"></span></li>
              <li class="list-group-item"><strong>Status:</strong> <span id="modalStatus"></span></li>
              <li class="list-group-item"><strong>Reason:</strong> <span id="modalWhy"></span></li>
            </ul>
            <button id="changeStatusBtn" class="btn btn-success mt-3">Change Status</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.view-btn').forEach(button => {
  button.addEventListener('click', function () {
    // Publication details
    document.getElementById('modalPublicationTitle').textContent = this.dataset.publicationTitle;
    document.getElementById('modalPublicationImage').src = this.dataset.publicationImage;
    document.getElementById('modalPublicationContent').textContent = this.dataset.publicationContent;
    document.getElementById('modalPublicationCategory').textContent = this.dataset.publicationCategory;
    document.getElementById('modalPublicationPrice').textContent = this.dataset.publicationPrice == 0 ? 'Free' : '$' + this.dataset.publicationPrice;
    document.getElementById('modalPublicationVisible').textContent = this.dataset.publicationVisible;
    document.getElementById('modalPublicationPdf').href = this.dataset.publicationPdf;

    // Order details
    document.getElementById('modalName').textContent = this.dataset.name;
    document.getElementById('modalEmail').textContent = this.dataset.email;
    document.getElementById('modalPhone').textContent = this.dataset.phone || '-';
    document.getElementById('modalStatus').textContent = this.dataset.status;
    document.getElementById('modalWhy').textContent = this.dataset.why || 'N/A';

    // Store order ID in button
    document.getElementById('changeStatusBtn').dataset.id = this.dataset.id;
  });
});

// AJAX status toggle
document.getElementById('changeStatusBtn').addEventListener('click', function () {
    const orderId = this.dataset.id;
    const url = '{{ route("admin.orders.toggle-status", ":id") }}'.replace(':id', orderId);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('modalStatus').textContent = data.new_status;
            alert('Status updated to ' + data.new_status);
            location.reload();
        }
    });
});
</script>
@endsection
