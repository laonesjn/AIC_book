@extends('layouts.masteradmin')

@section('title', 'Access Requests')

@section('content')

<style>
    :root {
        --clr-bg:        #f4f6fb;
        --clr-surface:   #ffffff;
        --clr-border:    #e4e9f2;
        --clr-dark:      #1a2035;
        --clr-primary:   #4361ee;
        --clr-success:   #2ec4b6;
        --clr-warning:   #f4a261;
        --clr-danger:    #e63946;
        --clr-muted:     #8892a4;
        --clr-pending-bg:  #fff8ec;
        --clr-pending-txt: #b45309;
        --clr-approved-bg: #ecfdf5;
        --clr-approved-txt:#065f46;
        --clr-rejected-bg: #fef2f2;
        --clr-rejected-txt:#991b1b;
        --radius:        10px;
        --shadow:        0 2px 12px rgba(26,32,53,0.08);
        --shadow-md:     0 4px 24px rgba(26,32,53,0.13);
        --font:          'Segoe UI', 'Helvetica Neue', sans-serif;
        --transition:    all 0.22s cubic-bezier(.4,0,.2,1);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── Header ── */
    .ar-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .ar-header-left h1 {
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--clr-dark);
        letter-spacing: -0.4px;
    }

    .ar-header-left p {
        color: var(--clr-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    /* ── Stats Bar ── */
    .ar-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 1.2rem;
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--clr-dark);
        box-shadow: var(--shadow);
    }

    .stat-pill .dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dot-all      { background: var(--clr-primary); }
    .dot-pending  { background: var(--clr-warning); }
    .dot-approved { background: var(--clr-success); }
    .dot-rejected { background: var(--clr-danger); }

    /* ── Filter Bar ── */
    .ar-filters {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 0.5rem 1.2rem;
        border-radius: 6px;
        border: 1px solid var(--clr-border);
        background: var(--clr-surface);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--clr-muted);
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
    }

    .filter-tab:hover,
    .filter-tab.active {
        background: var(--clr-primary);
        border-color: var(--clr-primary);
        color: #fff;
        box-shadow: 0 2px 8px rgba(67,97,238,.25);
    }

    .ar-search {
        margin-left: auto;
        position: relative;
    }

    .ar-search input {
        padding: 0.5rem 1rem 0.5rem 2.4rem;
        border: 1px solid var(--clr-border);
        border-radius: 6px;
        font-size: 0.875rem;
        width: 240px;
        outline: none;
        background: var(--clr-surface);
        color: var(--clr-dark);
        transition: var(--transition);
    }

    .ar-search input:focus {
        border-color: var(--clr-primary);
        box-shadow: 0 0 0 3px rgba(67,97,238,.12);
    }

    .ar-search .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--clr-muted);
        font-size: 0.85rem;
        pointer-events: none;
    }

    /* ── Alert ── */
    .ar-alert {
        padding: 0.9rem 1.25rem;
        border-radius: var(--radius);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .ar-alert-success {
        background: var(--clr-approved-bg);
        color: var(--clr-approved-txt);
        border-left: 4px solid var(--clr-success);
    }

    /* ── Table Card ── */
    .ar-card {
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .ar-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .ar-table thead {
        background: #f8fafd;
        border-bottom: 2px solid var(--clr-border);
    }

    .ar-table thead th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--clr-muted);
        white-space: nowrap;
    }

    .ar-table tbody tr {
        border-bottom: 1px solid var(--clr-border);
        transition: background 0.15s;
    }

    .ar-table tbody tr:last-child {
        border-bottom: none;
    }

    .ar-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        color: var(--clr-dark);
    }

    /* Requester cell */
    .requester-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }


    .requester-name {
        font-weight: 600;
        color: var(--clr-dark);
        font-size: 0.9rem;
    }

    .requester-email {
        font-size: 0.78rem;
        color: var(--clr-muted);
    }

    /* Collection cell */
    .collection-name {
        font-weight: 600;
        color: var(--clr-dark);
        font-size: 0.875rem;
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .collection-cat {
        font-size: 0.75rem;
        color: var(--clr-muted);
        margin-top: 0.15rem;
    }

    /* Reason cell */
    .reason-text {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: var(--clr-muted);
        font-size: 0.85rem;
        cursor: pointer;
    }

    .reason-text:hover {
        color: var(--clr-primary);
        text-decoration: underline;
    }

    /* Status badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .badge-pending  { background: var(--clr-pending-bg);  color: var(--clr-pending-txt); }
    .badge-approved { background: var(--clr-approved-bg); color: var(--clr-approved-txt); }
    .badge-rejected { background: var(--clr-rejected-bg); color: var(--clr-rejected-txt); }

    .badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Date cell */
    .date-main  { font-size: 0.875rem; font-weight: 500; color: var(--clr-dark); }
    .date-sub   { font-size: 0.75rem; color: var(--clr-muted); }

    /* Actions cell */
    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.4rem 0.85rem;
        border-radius: 6px;
        border: none;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        white-space: nowrap;
    }

    .btn-approve {
        background: var(--clr-approved-bg);
        color: var(--clr-approved-txt);
        border: 1px solid #a7f3d0;
    }

    .btn-approve:hover {
        background: var(--clr-success);
        color: white;
        border-color: var(--clr-success);
        box-shadow: 0 2px 8px rgba(46,196,182,.3);
    }

    .btn-reject {
        background: var(--clr-rejected-bg);
        color: var(--clr-rejected-txt);
        border: 1px solid #fecaca;
    }

    .btn-reject:hover {
        background: var(--clr-danger);
        color: white;
        border-color: var(--clr-danger);
        box-shadow: 0 2px 8px rgba(230,57,70,.3);
    }

    .btn-view {
        background: #eff6ff;
        color: var(--clr-primary);
        border: 1px solid #bfdbfe;
    }

    .btn-view:hover {
        background: var(--clr-primary);
        color: white;
        border-color: var(--clr-primary);
    }

    /* Disabled state for already actioned */
    .btn-action:disabled,
    .btn-action[disabled] {
        opacity: 0.45;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Empty state */
    .ar-empty {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--clr-muted);
    }

    .ar-empty .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .ar-empty h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--clr-dark);
        margin-bottom: 0.4rem;
    }

    .ar-empty p {
        font-size: 0.875rem;
    }

    /* Pagination */
    .ar-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--clr-border);
        background: #f8fafd;
        font-size: 0.85rem;
        color: var(--clr-muted);
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .ar-pagination .pagination-links { display: flex; gap: 0.25rem; }

    .ar-pagination .pagination-links a,
    .ar-pagination .pagination-links span {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        border: 1px solid var(--clr-border);
        background: var(--clr-surface);
        color: var(--clr-dark);
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .ar-pagination .pagination-links a:hover {
        border-color: var(--clr-primary);
        color: var(--clr-primary);
    }

    .ar-pagination .pagination-links span.active {
        background: var(--clr-primary);
        border-color: var(--clr-primary);
        color: white;
    }

    /* ── Detail Modal ── */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10,15,30,0.55);
        z-index: 9998;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        backdrop-filter: blur(2px);
    }

    .modal-overlay.open { display: flex; }

    .modal-box {
        background: var(--clr-surface);
        border-radius: 14px;
        width: 100%;
        max-width: 540px;
        box-shadow: var(--shadow-md);
        animation: slideUp 0.25s ease;
        overflow: hidden;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .modal-head {
        padding: 1.4rem 1.75rem;
        background: var(--clr-dark);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-head h3 {
        font-size: 1rem;
        font-weight: 700;
    }

    .modal-close {
        background: none;
        border: none;
        color: rgba(255,255,255,0.7);
        font-size: 1.5rem;
        cursor: pointer;
        line-height: 1;
        transition: color 0.15s;
    }

    .modal-close:hover { color: white; }

    .modal-body {
        padding: 1.75rem;
    }

    .modal-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .modal-field {
        flex: 1;
        min-width: 160px;
    }

    .modal-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--clr-muted);
        margin-bottom: 0.3rem;
    }

    .modal-value {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--clr-dark);
    }

    .modal-reason-box {
        background: #f8fafd;
        border: 1px solid var(--clr-border);
        border-radius: 8px;
        padding: 1rem;
        font-size: 0.875rem;
        line-height: 1.6;
        color: var(--clr-dark);
        margin-top: 0.5rem;
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        padding: 1.25rem 1.75rem;
        border-top: 1px solid var(--clr-border);
        background: #f8fafd;
    }

    .modal-actions form { flex: 1; }

    .modal-actions .btn-action {
        width: 100%;
        justify-content: center;
        padding: 0.65rem;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .ar-page { padding: 1.25rem 1rem; }
        .ar-table thead th:nth-child(4),
        .ar-table td:nth-child(4) { display: none; }
    }

    @media (max-width: 640px) {
        .ar-table thead th:nth-child(3),
        .ar-table td:nth-child(3),
        .ar-table thead th:nth-child(5),
        .ar-table td:nth-child(5) { display: none; }
        .ar-search input { width: 180px; }
    }
</style>

<div>

    <!-- Header -->
    <div class="ar-header">
        <div class="ar-header-left">
            <h1>Access Requests</h1>
            <p>Manage private collection access requests from users</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="ar-stats">
        <div class="stat-pill">
            <span class="dot dot-all"></span>
            Total: <strong>{{ $requests->total() }}</strong>
        </div>
        <div class="stat-pill">
            <span class="dot dot-pending"></span>
            Pending: <strong>{{ $pendingCount }}</strong>
        </div>
        <div class="stat-pill">
            <span class="dot dot-approved"></span>
            Approved: <strong>{{ $approvedCount }}</strong>
        </div>
        <div class="stat-pill">
            <span class="dot dot-rejected"></span>
            Rejected: <strong>{{ $rejectedCount }}</strong>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="ar-alert ar-alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Filter + Search -->
    <div class="ar-filters">
        <a href="{{ route('admin.access-requests.index') }}"
           class="filter-tab {{ !request('status') ? 'active' : '' }}">All</a>
        <a href="{{ route('admin.access-requests.index', ['status' => 'pending']) }}"
           class="filter-tab {{ request('status') === 'pending' ? 'active' : '' }}">⏳ Pending</a>
        <a href="{{ route('admin.access-requests.index', ['status' => 'approved']) }}"
           class="filter-tab {{ request('status') === 'approved' ? 'active' : '' }}">✅ Approved</a>
        <a href="{{ route('admin.access-requests.index', ['status' => 'rejected']) }}"
           class="filter-tab {{ request('status') === 'rejected' ? 'active' : '' }}">❌ Rejected</a>

        <div class="ar-search">
            <span class="search-icon">🔍</span>
            <input type="text" id="tableSearch" placeholder="Search name or email…"
                   value="{{ request('search') }}"
                   onkeyup="liveSearch(this.value)">
        </div>
    </div>

    <!-- Table Card -->
    <div class="ar-card">
        @if($requests->count() > 0)
        <table class="ar-table" id="requestsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requester</th>
                    <th>Collection</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $i => $req)
                <tr data-name="{{ strtolower($req->name) }}" data-email="{{ strtolower($req->email) }}">
                    <!-- # -->
                    <td style="color:var(--clr-muted); font-size:0.8rem; font-weight:600;">
                        {{ $requests->firstItem() + $i }}
                    </td>

                    <!-- Requester -->
                    <td>
                        <div class="requester-cell">
                            <div>
                                <div class="requester-name">{{ $req->name }}</div>
                                <div class="requester-email">{{ $req->email }}</div>
                                <div class="requester-email">{{ $req->phone }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- Collection -->
                    <td>
                        <div class="collection-name" title="{{ $req->collection->title ?? '—' }}">
                            {{ $req->collection->title ?? '—' }}
                        </div>
                        @if($req->collection)
                        <div class="collection-cat">
                            {{ $req->collection->mainCategory->name ?? '' }}
                            @if($req->collection->subCategory)
                                › {{ $req->collection->subCategory->name }}
                            @endif
                        </div>
                        @endif
                    </td>

                    <!-- Reason -->
                    <td>
                        <span class="reason-text"
                              onclick="openDetailModal(
                                  '{{ addslashes($req->name) }}',
                                  '{{ addslashes($req->email) }}',
                                  '{{ addslashes($req->phone) }}',
                                  '{{ addslashes($req->collection->title ?? '') }}',
                                  '{{ addslashes($req->why) }}',
                                  '{{ $req->status }}',
                                  {{ $req->id }}
                              )"
                              title="{{ $req->why }}">
                            {{ Str::limit($req->why, 60) }}
                        </span>
                    </td>

                    <!-- Date -->
                    <td>
                        <div class="date-main">{{ $req->created_at->format('M d, Y') }}</div>
                        <div class="date-sub">{{ $req->created_at->format('h:i A') }}</div>
                    </td>

                    <!-- Status -->
                    <td>
                        @if($req->status === 'pending')
                            <span class="status-badge badge-pending">
                                <span class="badge-dot"></span> Pending
                            </span>
                        @elseif($req->status === 'approved')
                            <span class="status-badge badge-approved">
                                <span class="badge-dot"></span> Approved
                            </span>
                        @else
                            <span class="status-badge badge-rejected">
                                <span class="badge-dot"></span> Rejected
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td>
                        <div class="actions-cell">
                            <button class="btn-action btn-view"
                                    onclick="openDetailModal(
                                        '{{ addslashes($req->name) }}',
                                        '{{ addslashes($req->email) }}',
                                        '{{ addslashes($req->phone) }}',
                                        '{{ addslashes($req->collection->title ?? '') }}',
                                        '{{ addslashes($req->why) }}',
                                        '{{ $req->status }}',
                                        {{ $req->id }}
                                    )">
                                👁 View
                            </button>

                            <!-- @if($req->status === 'pending')
                                <form method="POST"
                                      action="{{ route('admin.access-requests.status', $req->id) }}"
                                      style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn-action btn-approve"
                                            onclick="return confirm('Approve this request?')">
                                        ✅ Approve
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.access-requests.status', $req->id) }}"
                                      style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn-action btn-reject"
                                            onclick="return confirm('Reject this request?')">
                                        ❌ Reject
                                    </button>
                                </form>
                            @else
                                <button class="btn-action btn-approve" disabled>✅ Approve</button>
                                <button class="btn-action btn-reject"  disabled>❌ Reject</button>
                            @endif -->
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <!-- <div class="ar-pagination">
            <span>
                Showing {{ $requests->firstItem() }}–{{ $requests->lastItem() }}
                of {{ $requests->total() }} requests
            </span>
            <div class="pagination-links">
                {{-- Previous --}}
                @if($requests->onFirstPage())
                    <span>‹</span>
                @else
                    <a href="{{ $requests->previousPageUrl() }}">‹</a>
                @endif

                {{-- Page numbers --}}
                @foreach(range(1, $requests->lastPage()) as $page)
                    @if($page == $requests->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $requests->url($page) }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($requests->hasMorePages())
                    <a href="{{ $requests->nextPageUrl() }}">›</a>
                @else
                    <span>›</span>
                @endif
            </div>
        </div> -->

        @else
        <div class="ar-empty">
            <div class="empty-icon">📭</div>
            <h3>No requests found</h3>
            <p>No access requests match the current filter.</p>
        </div>
        @endif
    </div>
</div>

<!-- ── Detail Modal ── -->
<div class="modal-overlay" id="detailModal">
    <div class="modal-box">
        <div class="modal-head">
            <h3>📋 Request Details</h3>
            <button class="modal-close" onclick="closeDetailModal()">×</button>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="modal-field">
                    <div class="modal-label">Full Name</div>
                    <div class="modal-value" id="md-name"></div>
                </div>
                <div class="modal-field">
                    <div class="modal-label">Phone</div>
                    <div class="modal-value" id="md-phone"></div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-field">
                    <div class="modal-label">Email Address</div>
                    <div class="modal-value" id="md-email"></div>
                </div>
                <div class="modal-field">
                    <div class="modal-label">Collection</div>
                    <div class="modal-value" id="md-collection"></div>
                </div>
            </div>
            <div>
                <div class="modal-label">Reason for Access</div>
                <div class="modal-reason-box" id="md-reason"></div>
            </div>
        </div>
        <div class="modal-actions" id="md-actions"></div>
    </div>
</div>

<script>
    // ── Live Search ──
    function liveSearch(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('#requestsTable tbody tr').forEach(row => {
            const name  = row.dataset.name  || '';
            const email = row.dataset.email || '';
            row.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
        });
    }

    // ── Detail Modal ──
    function openDetailModal(name, email, phone, collection, reason, status, id) {
        document.getElementById('md-name').textContent       = name;
        document.getElementById('md-email').textContent      = email;
        document.getElementById('md-phone').textContent      = phone;
        document.getElementById('md-collection').textContent = collection;
        document.getElementById('md-reason').textContent     = reason;

        const actionsEl = document.getElementById('md-actions');

        if (status === 'pending') {
            actionsEl.innerHTML = `
                <form method="POST" action="/admin/heritage-collections/access-requests/${id}/status" style="flex:1;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="btn-action btn-approve"
                            onclick="return confirm('Approve this request?')">
                        ✅ Approve Request
                    </button>
                </form>
                <form method="POST" action="/admin/heritage-collections/access-requests/${id}/status" style="flex:1;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn-action btn-reject"
                            onclick="return confirm('Reject this request?')">
                        ❌ Reject Request
                    </button>
                </form>
            `;
        } else {
            const label = status === 'approved'
                ? '<span class="status-badge badge-approved"><span class="badge-dot"></span> Approved</span>'
                : '<span class="status-badge badge-rejected"><span class="badge-dot"></span> Rejected</span>';
            actionsEl.innerHTML = `
                <div style="padding:0.5rem; color:var(--clr-muted); font-size:0.875rem;">
                    This request has already been actioned: ${label}
                </div>
            `;
        }

        document.getElementById('detailModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDetailModal();
    });
</script>

@endsection