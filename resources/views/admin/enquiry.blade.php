@extends('layouts.masteradmin')

@section('title', 'Manage Enquiries')

@section('content')
<div>
    <h2 class="mb-4 fw-bold">
        All Enquiries ({{ $enquiries->count() }})
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ENQUIRY TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($enquiries as $index => $enquiry)
                <tr>
                    <td class="fw-semibold">{{ $index + 1 }}</td>
                    <td>{{ $enquiry->name }}</td>
                    <td>{{ $enquiry->email }}</td>
                    <td>{{ Str::limit($enquiry->subject, 40) }}</td>
                    <td>
                        <form action="{{ route('admin.enquiries.updateStatus', $enquiry->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm text-center" onchange="this.form.submit()">
                                <option value="Pending" {{ $enquiry->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $enquiry->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $enquiry->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-info"
                                data-bs-toggle="modal"
                                data-bs-target="#viewModal{{ $enquiry->id }}">
                            <i class="bi bi-eye"></i> View
                        </button>
                    </td>
                </tr>

                <!-- 🟦 ENQUIRY DETAIL MODAL -->
                <div class="modal fade" id="viewModal{{ $enquiry->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $enquiry->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">
                                    <i class="bi bi-info-circle me-2"></i> Enquiry Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6"><strong>Name:</strong> {{ $enquiry->name }}</div>
                                    <div class="col-md-6"><strong>Email:</strong> {{ $enquiry->email }}</div>
                                    <div class="col-md-6"><strong>Phone:</strong> {{ $enquiry->phone ?? '-' }}</div>
                                    <div class="col-md-6"><strong>Subject:</strong> {{ $enquiry->subject }}</div>
                                    <div class="col-md-6">
                                        <strong>Status:</strong>
                                        <span class="badge
                                            @if($enquiry->status == 'Completed') bg-success
                                            @elseif($enquiry->status == 'In Progress') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ $enquiry->status }}
                                        </span>
                                    </div>
                                    <div class="col-12">
                                        <strong>Message:</strong>
                                        <div class="border rounded p-3 bg-light mt-1" style="min-height: 80px;">
                                            {{ $enquiry->message ?? 'No message provided' }}
                                        </div>
                                    </div>
                                    <div class="col-12 text-end text-muted small">
                                        <strong>Date:</strong> {{ $enquiry->created_at->format('d M Y, h:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
