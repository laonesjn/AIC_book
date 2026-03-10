@extends('layouts.masteradmin')

@section('content')
<style>
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: var(--card-bg);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.5rem;
  position: relative;
  overflow: hidden;
  transition: var(--transition);
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  opacity: 0.1;
  transition: var(--transition);
}

.stat-card.primary::before { background: var(--gradient-primary); }
.stat-card.success::before { background: var(--gradient-success); }
.stat-card.warning::before { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
.stat-card.info::before    { background: var(--gradient-blue); }
.stat-card.purple::before  { background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); }

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.stat-card:hover::before { transform: scale(1.2); opacity: 0.15; }

.stat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: #fff;
  position: relative;
  z-index: 1;
}

.stat-card.primary .stat-icon { background: var(--gradient-primary); box-shadow: 0 4px 15px rgba(196, 30, 58, 0.3); }
.stat-card.success .stat-icon { background: var(--gradient-success); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
.stat-card.warning .stat-icon { background: linear-gradient(135deg,#f59e0b 0%,#fbbf24 100%); box-shadow: 0 4px 15px rgba(245,158,11,.3); }
.stat-card.info    .stat-icon { background: var(--gradient-blue);    box-shadow: 0 4px 15px rgba(59,130,246,.3); }
.stat-card.purple  .stat-icon { background: linear-gradient(135deg,#8b5cf6 0%,#a78bfa 100%); box-shadow: 0 4px 15px rgba(139,92,246,.3); }

.stat-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  position: relative;
  z-index: 1;
}

.stat-badge.success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
.stat-badge.danger  { background: rgba(196, 30, 58, 0.1);  color: var(--primary); }

.stat-content h3 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
  color: var(--text);
}

.stat-content p {
  color: var(--text-muted);
  font-size: 0.9rem;
  margin: 0;
}

.stat-footer {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid var(--border);
  font-size: 0.85rem;
  color: var(--text-muted);
}

/* Chart */
.chart-card {
  background: var(--card-bg);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.5rem;
  height: 100%;
}

.chart-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  gap: .5rem;
}

.chart-header h3 { font-size: 1.1rem; font-weight: 600; margin: 0; }

.chart-tabs { display: flex; gap: 0.5rem; }

.chart-tab {
  padding: 0.5rem 1rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  background: none;
  color: var(--text-muted);
  font-size: 0.85rem;
  cursor: pointer;
  transition: var(--transition);
}

.chart-tab:hover,
.chart-tab.active {
  background: var(--gradient-primary);
  border-color: transparent;
  color: #fff;
}

/* Activity */
.activity-list { display: flex; flex-direction: column; gap: 1.5rem; }

.activity-item {
  display: flex;
  gap: 1rem;
  position: relative;
}

.activity-item:not(:last-child)::after {
  content: '';
  position: absolute;
  left: 19px;
  top: 48px;
  width: 2px;
  height: calc(100% + 0.5rem);
  background: var(--border);
}

.activity-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 1.1rem;
  color: #fff;
  position: relative;
  z-index: 1;
}

.activity-icon.primary { background: var(--gradient-primary); }
.activity-icon.success { background: var(--gradient-success); }
.activity-icon.warning { background: linear-gradient(135deg,#f59e0b 0%,#fbbf24 100%); }
.activity-icon.info    { background: var(--gradient-blue); }
.activity-icon.purple  { background: linear-gradient(135deg,#8b5cf6 0%,#a78bfa 100%); }

.activity-content { flex: 1; padding-top: 0.25rem; }
.activity-content h4 { font-size: 0.95rem; font-weight: 600; margin-bottom: 0.25rem; }
.activity-content p  { font-size: 0.85rem; color: var(--text-muted); margin: 0; }

.activity-time {
  font-size: 0.75rem;
  color: var(--text-muted);
  margin-top: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

/* Quick actions */
.quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }

.quick-action {
  background: var(--card-bg);
  border: 2px dashed var(--border);
  border-radius: var(--radius);
  padding: 1.5rem;
  text-align: center;
  cursor: pointer;
  transition: var(--transition);
  text-decoration: none;
  color: var(--text);
}

.quick-action:hover {
  border-color: var(--primary);
  background: rgba(196,30,58,.05);
  transform: translateY(-3px);
  color: var(--text);
}

.quick-action i { font-size: 2rem; color: var(--primary); margin-bottom: .75rem; display: block; }
.quick-action span { font-weight: 600; font-size: .9rem; }

/* Table */
.pending-table { width: 100%; border-collapse: collapse; }

.pending-table th {
  text-align: left;
  padding: 1rem;
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  background: var(--light);
  border-bottom: 1px solid var(--border);
}

.pending-table td {
  padding: 1rem;
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
}

.pending-table tr:hover { background: var(--light); }

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.35rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.status-badge.pending  { background: rgba(245,158,11,.1); color: #f59e0b; }
.status-badge.approved { background: rgba(16,185,129,.1); color: var(--success); }
.status-badge.rejected { background: rgba(196,30,58,.1);  color: var(--primary); }
.status-badge.paid     { background: rgba(59,130,246,.1); color: #3b82f6; }

.action-btns { display: flex; gap: .5rem; }

.action-btn {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: var(--card-bg);
  color: var(--text);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--transition);
  font-size: .9rem;
}

.action-btn:hover {
  border-color: var(--primary);
  background: rgba(196,30,58,.05);
  color: var(--primary);
}

.action-btn.approve-btn:hover { border-color: var(--success); background: rgba(16,185,129,.05); color: var(--success); }
.action-btn.reject-btn:hover  { border-color: #ef4444;        background: rgba(239,68,68,.05); color: #ef4444; }

/* Enquiry badge on nav */
.enquiry-alert { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #ef4444; margin-left: 4px; vertical-align: middle; }

@media (max-width: 768px) {
  .stats-grid { grid-template-columns: 1fr; }
  .quick-actions { grid-template-columns: repeat(2, 1fr); }
  .pending-table { font-size: .85rem; }
  .pending-table th, .pending-table td { padding: .75rem .5rem; }
}

@media (max-width: 480px) {
  .quick-actions { grid-template-columns: 1fr; }
  .stat-content h3 { font-size: 1.5rem; }
}
</style>

<!-- Dashboard Header -->
<div class="page-header animate-in">
  <div class="page-header-left">
    <h1><i class="bi bi-grid-1x2-fill me-2" style="color:var(--primary)"></i>Dashboard</h1>
    <p><i class="bi bi-house"></i> Welcome back, {{ request()->user()->name ?? 'Admin' }}! Here's what's happening today.</p>
  </div>
  <div class="page-header-right">
    <span style="font-size:.85rem;color:var(--text-muted)">
      <i class="bi bi-calendar3 me-1"></i>{{ now()->format('D, d M Y') }}
    </span>
  </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">

  {{-- Publications --}}
  <div class="stat-card primary animate-in">
    <div class="stat-header">
      <div class="stat-icon"><i class="bi bi-journal-richtext"></i></div>
      <span class="stat-badge {{ $publicationGrowth['direction'] === 'up' ? 'success' : 'danger' }}">
        <i class="bi bi-arrow-{{ $publicationGrowth['direction'] }}"></i> {{ $publicationGrowth['value'] }}%
      </span>
    </div>
    <div class="stat-content">
      <h3>{{ number_format($totalPublications) }}</h3>
      <p>Total Publications</p>
    </div>
    <div class="stat-footer">
      <i class="bi bi-clock"></i>
      <span>{{ $pendingPublications }} pending approval</span>
    </div>
  </div>

  {{-- Orders --}}
  <div class="stat-card success animate-in delay-1">
    <div class="stat-header">
      <div class="stat-icon"><i class="bi bi-cart3"></i></div>
      <span class="stat-badge {{ $ordersGrowth['direction'] === 'up' ? 'success' : 'danger' }}">
        <i class="bi bi-arrow-{{ $ordersGrowth['direction'] }}"></i> {{ $ordersGrowth['value'] }}%
      </span>
    </div>
    <div class="stat-content">
      <h3>{{ number_format($totalOrders) }}</h3>
      <p>Publication Requests</p>
    </div>
    <div class="stat-footer">
      <i class="bi bi-clock"></i>
      <span>{{ $processingOrders }} processing</span>
    </div>
  </div>

  {{-- Collections --}}
  <div class="stat-card warning animate-in delay-2">
    <div class="stat-header">
      <div class="stat-icon"><i class="bi bi-collection"></i></div>
      <span class="stat-badge {{ $collectionsGrowth['direction'] === 'up' ? 'success' : 'danger' }}">
        <i class="bi bi-arrow-{{ $collectionsGrowth['direction'] }}"></i> {{ $collectionsGrowth['value'] }}%
      </span>
    </div>
    <div class="stat-content">
      <h3>{{ number_format($totalCollections) }}</h3>
      <p>Collections</p>
    </div>
    <div class="stat-footer">
      <i class="bi bi-lock"></i>
      <span>{{ $draftCollections }} private</span>
    </div>
  </div>

  {{-- Exhibitions --}}
  <div class="stat-card info animate-in delay-3">
    <div class="stat-header">
      <div class="stat-icon"><i class="bi bi-easel2"></i></div>
      <span class="stat-badge {{ $exhibitionsGrowth['direction'] === 'up' ? 'success' : 'danger' }}">
        <i class="bi bi-arrow-{{ $exhibitionsGrowth['direction'] }}"></i> {{ $exhibitionsGrowth['value'] }}%
      </span>
    </div>
    <div class="stat-content">
      <h3>{{ number_format($totalExhibitions) }}</h3>
      <p>Exhibitions</p>
    </div>
    <div class="stat-footer">
      <i class="bi bi-envelope"></i>
      <span>{{ $pendingEnquiries }} enquiries pending</span>
    </div>
  </div>

</div>


<script>
// ── Chart ───────────────────────────────────────────────────────────────────

const initialData = @json($chartData);

const ctx = document.getElementById('activityChart').getContext('2d');

const primaryColor   = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#c41e3a';
const successColor   = '#10b981';

const chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: initialData.labels,
    datasets: [
      {
        label: 'Publications',
        data: initialData.publications,
        backgroundColor: hexToRgba(primaryColor, 0.7),
        borderColor: primaryColor,
        borderWidth: 1,
        borderRadius: 4,
      },
      {
        label: 'Requests',
        data: initialData.orders,
        backgroundColor: hexToRgba(successColor, 0.7),
        borderColor: successColor,
        borderWidth: 1,
        borderRadius: 4,
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'top' },
      tooltip: { mode: 'index', intersect: false }
    },
    scales: {
      x: { grid: { display: false } },
      y: { beginAtZero: true, ticks: { stepSize: 1 } }
    }
  }
});

// Tab switching with AJAX
document.querySelectorAll('.chart-tab').forEach(tab => {
  tab.addEventListener('click', function () {
    document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
    this.classList.add('active');

    const period = this.dataset.period;

    fetch(`{{ route('admin.dashboard.chart') }}?period=${period}`, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      chart.data.labels            = data.labels;
      chart.data.datasets[0].data  = data.publications;
      chart.data.datasets[1].data  = data.orders;
      chart.update();
    })
    .catch(() => toastr.error('Could not load chart data.'));
  });
});

// ── Approve / Reject Publications ────────────────────────────────────────────

function approveRequest(id) {
  sendAction(`{{ url('admin/dashboard/approve') }}/${id}`, 'POST', function() {
    updateRowStatus('req-status-' + id, 'approved', 'check-circle', 'Approved');
    toastr.success('Request approved!');
  });
}

function rejectRequest(id) {
  if (!confirm('Reject this request?')) return;
  sendAction(`{{ url('admin/dashboard/reject') }}/${id}`, 'POST', function() {
    updateRowStatus('req-status-' + id, 'rejected', 'x-circle', 'Rejected');
    toastr.warning('Request rejected.');
  });
}

function approveCollectionRequest(id) {
  sendAction(`{{ url('admin/dashboard/collection-request') }}/${id}/approve`, 'POST', function() {
    document.getElementById('col-req-' + id)?.remove();
    toastr.success('Collection access approved!');
  });
}

function approveHeritageRequest(id) {
  sendAction(`{{ url('admin/dashboard/heritage-request') }}/${id}/approve`, 'POST', function() {
    document.getElementById('her-req-' + id)?.remove();
    toastr.success('Heritage access approved!');
  });
}

function sendAction(url, method, onSuccess) {
  fetch(url, {
    method,
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json',
    }
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) onSuccess();
    else toastr.error(data.message || 'Something went wrong.');
  })
  .catch(() => toastr.error('Network error.'));
}

function updateRowStatus(badgeId, statusClass, icon, label) {
  const badge = document.getElementById(badgeId);
  if (badge) {
    badge.className = `status-badge ${statusClass}`;
    badge.innerHTML = `<i class="bi bi-${icon}"></i> ${label}`;
  }
}

// ── Utility ──────────────────────────────────────────────────────────────────

function hexToRgba(hex, alpha) {
  hex = hex.replace('#', '');
  if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
  const r = parseInt(hex.substring(0,2), 16);
  const g = parseInt(hex.substring(2,4), 16);
  const b = parseInt(hex.substring(4,6), 16);
  return `rgba(${r},${g},${b},${alpha})`;
}
</script>
@endsection