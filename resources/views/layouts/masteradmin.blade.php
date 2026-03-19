<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Admin Dashboard</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Toastr CSS (paste in <head>) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<!-- jQuery (Required for AJAX) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Toastr CSS & JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Bootstrap JS Bundle --->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>




<style>
:root{
   --primary: #2563eb;        /* Royal Blue */
  --primary-light: #60a5fa;
  --secondary: #0f172a;      /* Dark Navy */
  --accent: #38bdf8;         /* Sky Blue */
  --dark: #020617;
  --light: #f8fafc;
  --text: #1e293b;
  --text-muted: #64748b;
  --border: #e2e8f0;

  --gold: #d4af37;
  --blue: #0e2a5a;
  --success: #16a34a;
  --warning: #f59e0b;
  --info: #0ea5e9;
  --card-bg: #ffffff;
  --sidebar-width: 280px;
  --sidebar-mini: 80px;
  --topbar-height: 70px;
  --radius: 16px;
  --radius-sm: 12px;
  --shadow: 0 4px 24px rgba(0,0,0,0.06);
  --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
  --transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    --gradient-primary: linear-gradient(135deg,#2563eb 0%,#60a5fa 100%);
  --gradient-blue: linear-gradient(135deg,#0e2a5a 0%,#3b82f6 100%);
  --gradient-gold: linear-gradient(135deg,#d4af37 0%,#f5d76e 100%);
  --gradient-success: linear-gradient(135deg,#10b981 0%,#34d399 100%);
}

/* Dark theme overrides */
[data-theme="dark"]{
  --light: #0f0f1a;
  --card-bg: #1a1a2e;
  --text: #e8e8f0;
  --text-muted: #8492a6;
  --border: #2d2d44;
  --shadow: 0 4px 24px rgba(0,0,0,0.3);
}

/* Base */
*{box-sizing:border-box;margin:0;padding:0;}
body{
  font-family: 'Inter', system-ui, sans-serif;
  background:var(--light);
  color:var(--text);
  transition:var(--transition);
  overflow-x:hidden;
}

/* Sidebar */
.sidebar{
  position:fixed;
  left:0;
  top:0;
  width:var(--sidebar-width);
  height:100vh;
  background:var(--secondary);
  z-index:1040;
  transition:var(--transition);
  display:flex;
  flex-direction:column;
  overflow:hidden;
}
.sidebar::before{
  content:'';
  position:absolute;
  top:0;left:0;right:0;height:200px;
  background:var(--gradient-primary);
  opacity:0.08;
  pointer-events:none;
}
.sidebar.collapsed{ width:var(--sidebar-mini); }

/* Sidebar header */
.sidebar-header{
  padding:1.5rem;
  display:flex;
  align-items:center;
  gap:14px;
  position:relative;
  z-index:1;
}
.logo{
  width:48px;height:48px;
  background:var(--gradient-primary);
  border-radius:var(--radius-sm);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-weight:800;font-size:1.4rem;flex-shrink:0;
  box-shadow:0 4px 15px rgba(196,30,58,0.4);
}
.brand{
  font-size:1.4rem;font-weight:700;color:#fff;white-space:nowrap;transition:var(--transition);
}
.brand span{ color:var(--accent); }
.sidebar.collapsed .brand{ opacity:0;width:0; }

/* Navigation */
.sidebar-nav{ flex:1; overflow-y:auto; padding:1rem 0.75rem; position:relative; z-index:1; }
.sidebar-nav::-webkit-scrollbar{ width:4px; }
.sidebar-nav::-webkit-scrollbar-thumb{ background:rgba(255,255,255,0.2); border-radius:4px; }

.nav-section { margin-bottom:0.5rem; }
.nav-section-title{
  font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.4);
  text-transform:uppercase;letter-spacing:1.5px;padding:0.75rem 1rem 0.5rem;
}
.sidebar.collapsed .nav-section-title{ display:none; }

/* Nav item */
.nav-item{
  display:flex;align-items:center;padding:0.85rem 1rem;color:rgba(255,255,255,0.7);
  text-decoration:none;border-radius:var(--radius-sm);margin-bottom:4px;transition:var(--transition);
  position:relative;gap:12px;
}
.nav-item:hover{ background:rgba(255,255,255,0.1); color:#fff; }
.nav-item.active{
  background:var(--gradient-primary); color:#fff; box-shadow:0 4px 15px rgba(196,30,58,0.3);
}
.nav-item i{ font-size:1.25rem; width:24px; text-align:center; flex-shrink:0; color:inherit; }
.nav-item span{ white-space:nowrap; font-weight:500; font-size:0.9rem; }
.nav-item .badge-count{
  margin-left:auto;background:var(--accent);color:#fff;font-size:0.7rem;padding:2px 8px;border-radius:20px;font-weight:600;
}
.sidebar.collapsed .nav-item span,
.sidebar.collapsed .nav-item .badge-count{ display:none; }
.sidebar.collapsed .nav-item{ justify-content:center; padding:0.85rem; }

/* Nav groups (collapsible) */
.nav-group-btn{
  display:flex;align-items:center;width:100%;padding:0.85rem 1rem;color:rgba(255,255,255,0.7);
  background:none;border:none;border-radius:var(--radius-sm);cursor:pointer;transition:var(--transition);gap:12px;
}
.nav-group-btn:hover{ background:rgba(255,255,255,0.1); color:#fff; }
.nav-group-btn i{ font-size:1.25rem; width:24px; text-align:center; }
.nav-group-btn span{ font-weight:500; font-size:0.9rem; }
.nav-group-btn .chevron{ margin-left:auto; transition:transform 0.3s; font-size:0.8rem; }
.nav-group.open .nav-group-btn .chevron{ transform:rotate(90deg); }

.nav-group-items{
  max-height:0; overflow:hidden; transition:max-height 0.3s ease; padding-left:1rem;
}
.nav-group.open .nav-group-items{ max-height:300px; }
.nav-group-items .nav-item{ padding:0.65rem 1rem 0.65rem 2.5rem; font-size:0.85rem; }
.nav-group-items .nav-item::before{
  content:'';position:absolute;left:1.25rem;top:50%;width:6px;height:6px;border-radius:50%;
  background:rgba(255,255,255,0.3); transform:translateY(-50%);
}
.nav-group-items .nav-item:hover::before,
.nav-group-items .nav-item.active::before{ background:var(--accent); }

.sidebar.collapsed .nav-group-btn span,
.sidebar.collapsed .nav-group-btn .chevron,
.sidebar.collapsed .nav-group-items{ display:none; }
.sidebar.collapsed .nav-group-btn{ justify-content:center; padding:0.85rem; }

/* Sidebar footer / user */
.sidebar-footer{ padding:1rem; border-top:1px solid rgba(255,255,255,0.1); position:relative; z-index:1; }
.user-card{ display:flex; align-items:center; gap:12px; padding:0.75rem; background:rgba(255,255,255,0.05); border-radius:var(--radius-sm); }
.user-card-avatar{
  width:42px; height:42px; border-radius:10px; background:var(--gradient-primary);
  display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1rem;flex-shrink:0;
}
.user-card-info{ flex:1; min-width:0; }
.user-card-name{ color:#fff; font-weight:600; font-size:0.9rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.user-card-role{ color:rgba(255,255,255,0.5); font-size:0.75rem; }
.sidebar.collapsed .user-card-info{ display:none; }

/* Mobile overlay for sidebar */
.sidebar-overlay{
  position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px);
  z-index:1035; opacity:0; visibility:hidden; transition:var(--transition);
}
.sidebar-overlay.show{ opacity:1; visibility:visible; }

/* Main wrapper (content area offset for sidebar) */
.main-wrapper{ margin-left:var(--sidebar-width); min-height:100vh; transition:var(--transition); }
.main-wrapper.expanded{ margin-left:var(--sidebar-mini); }

/* Topbar */
.topbar{
  position:sticky; top:0; height:var(--topbar-height); background:var(--card-bg);
  border-bottom:1px solid var(--border); display:flex; align-items:center; padding:0 1.5rem; z-index:1030; gap:1rem;
  box-shadow:var(--shadow);
}
.topbar-toggle{
  width:42px;height:42px;border-radius:var(--radius-sm);border:none;background:var(--light);
  color:var(--text);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:var(--transition);font-size:1.3rem;
}
.topbar-toggle:hover{ background:var(--border); transform:scale(1.05); }

.topbar-search{ flex:1; max-width:400px; position:relative; }
.topbar-search input{
  width:100%; padding:0.75rem 1rem 0.75rem 3rem; border:1px solid var(--border); border-radius:var(--radius);
  background:var(--light); color:var(--text); font-size:0.9rem; transition:var(--transition);
}
.topbar-search input:focus{ outline:none; border-color:var(--primary); box-shadow:0 0 0 3px rgba(196,30,58,0.1); }
.topbar-search i{ position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--text-muted); }

/* Topbar actions & buttons */
.topbar-actions{ display:flex; align-items:center; gap:0.5rem; margin-left:auto; }
.topbar-btn{
  width:44px;height:44px;border-radius:var(--radius-sm);border:none;background:var(--light);
  color:var(--text);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:var(--transition);
  font-size:1.2rem;
}
.topbar-btn:hover{ background:var(--border); transform:translateY(-2px); }
.topbar-btn .badge{
  position:absolute; top:6px; right:6px; width:18px;height:18px; background:red; color:#fff; border-radius:50%;
  font-size:0.65rem; display:flex; align-items:center; justify-content:center; font-weight:700; box-shadow:0 2px 8px rgba(196,30,58,0.4);
}
.topbar-divider{ width:1px; height:32px; background:var(--border); margin:0 0.5rem; }

/* User dropdown (profile button + menu) */
.user-dropdown{ position:relative; }
.user-btn{
  display:flex; align-items:center; gap:0.75rem; padding:0.5rem 0.75rem; border-radius:var(--radius-sm);
  border:1px solid var(--border); background:var(--card-bg); cursor:pointer; transition:var(--transition);
}
.user-btn:hover{ border-color:var(--primary); box-shadow:var(--shadow); }
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #E5E7EB; /* fallback */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid #CBD5E1;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.user-info{ text-align:left; }
.user-info .name{ font-size:0.85rem; font-weight:600; color:var(--text); }
.user-info .role{ font-size:0.7rem; color:var(--text-muted); }

.dropdown-menu{
  position:absolute; top:calc(100% + 8px); right:0; min-width:220px; background:var(--card-bg);
  border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-lg); padding:0.5rem;
  opacity:0; visibility:hidden; transform:translateY(10px) scale(0.95); transition:var(--transition); z-index:1050;
}
.dropdown-menu.show{ opacity:1; visibility:visible; transform:translateY(0) scale(1); }

.dropdown-header{ padding:0.75rem 1rem; border-bottom:1px solid var(--border); margin-bottom:0.5rem; }
.dropdown-header .name{ font-weight:600; font-size:0.95rem; }
.dropdown-header .email{ font-size:0.8rem; color:var(--text-muted); }

.dropdown-item{
  display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; color:var(--text);
  text-decoration:none; border-radius:var(--radius-sm); transition:var(--transition); font-size:0.9rem;
  border:none; background:none; width:100%; text-align:left; cursor:pointer;
}
.dropdown-item:hover{ background:var(--light); }
.dropdown-item i{ font-size:1.1rem; color:var(--text-muted); }
.dropdown-item.danger{ color:red }
.dropdown-item.danger:hover{ background:rgba(196,30,58,0.1); }

/* Content area and page header */
.content{ padding:1.5rem; }
.page-header{ display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
.page-header-left h1{ font-size:1.75rem; font-weight:700; margin-bottom:0.25rem; }
.page-header-left p{ color:var(--text-muted); font-size:0.9rem; }

/* Cards (used by loadPage) */
.card{
  background:var(--card-bg); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow);
  transition:var(--transition); overflow:hidden;
}
.card:hover{ box-shadow:var(--shadow-lg); }
.card-header{ padding:1.25rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:1rem; }
.card-title{ font-size:1.1rem; font-weight:600; display:flex; align-items:center; gap:0.5rem; }
.card-body{ padding:1.5rem; }

/* Buttons used in templates */
.btn-primary-custom{
  background:var(--gradient-primary); color:#fff; border:none; padding:0.75rem 1.5rem; border-radius:var(--radius-sm);
  font-weight:600; font-size:0.9rem; transition:var(--transition); display:inline-flex; align-items:center; gap:0.5rem;
  box-shadow:0 4px 15px rgba(196,30,58,0.3);
}
.btn-primary-custom:hover{ transform:translateY(-2px); box-shadow:0 6px 20px rgba(196,30,58,0.4); color:#fff; }

.btn-secondary-custom{
  background:var(--card-bg); color:var(--text); border:1px solid var(--border); padding:0.75rem 1.5rem; border-radius:var(--radius-sm);
  font-weight:600; font-size:0.9rem; transition:var(--transition); display:inline-flex; align-items:center; gap:0.5rem;
}
.btn-secondary-custom:hover{ border-color:var(--primary); color:var(--primary); }

.btn-icon{
  width:40px;height:40px;border-radius:var(--radius-sm);border:1px solid var(--border); background:var(--card-bg);
  color:var(--text); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:var(--transition);
}
.btn-icon:hover{ border-color:var(--primary); color:var(--primary); background:rgba(196,30,58,0.05); }

/* Minimal table styles (kept in case you inject tables) */
.table-wrapper{ overflow-x:auto; }
.modern-table{ width:100%; border-collapse:collapse; }
.modern-table th{
  text-align:left; padding:1rem 1.25rem; font-size:0.75rem; font-weight:700; color:var(--text-muted);
  text-transform:uppercase; letter-spacing:0.5px; background:var(--light); border-bottom:1px solid var(--border);
}
.modern-table td{ padding:1rem 1.25rem; border-bottom:1px solid var(--border); vertical-align:middle; }

/* Small utilities */
.animate-in{ animation:fadeInUp 0.4s ease forwards; }
.delay-1{ animation-delay:0.1s; }
.delay-2{ animation-delay:0.2s; }
.delay-3{ animation-delay:0.3s; }
.delay-4{ animation-delay:0.4s; }

@keyframes fadeInUp{
  from{ opacity:0; transform:translateY(20px); }
  to{ opacity:1; transform:translateY(0); }
}

/* Focus */
button:focus-visible, a:focus-visible, input:focus-visible{
  outline:2px solid var(--primary); outline-offset:2px;
}

/* Responsive adjustments (keeps the same responsive behavior) */
@media (max-width:1200px){
  .sidebar{ width:var(--sidebar-mini); }
  .sidebar .brand, .sidebar .nav-section-title, .sidebar .nav-item span, .sidebar .nav-item .badge-count,
  .sidebar .nav-group-btn span, .sidebar .nav-group-btn .chevron, .sidebar .nav-group-items, .sidebar .user-card-info { display:none; }
  .sidebar .nav-item, .sidebar .nav-group-btn{ justify-content:center; padding:0.85rem; }
  .main-wrapper{ margin-left:var(--sidebar-mini); }
}
@media (max-width:768px){
  .sidebar{ width:var(--sidebar-width); transform:translateX(-100%); }
  .sidebar.mobile-open{ transform:translateX(0); }
  .sidebar.mobile-open .brand, .sidebar.mobile-open .nav-section-title, .sidebar.mobile-open .nav-item span,
  .sidebar.mobile-open .nav-item .badge-count, .sidebar.mobile-open .nav-group-btn span, .sidebar.mobile-open .nav-group-btn .chevron,
  .sidebar.mobile-open .nav-group-items, .sidebar.mobile-open .user-card-info { display:block; }
  .sidebar.mobile-open .nav-item, .sidebar.mobile-open .nav-group-btn{ justify-content:flex-start; padding:0.85rem 1rem; }
  .main-wrapper, .main-wrapper.expanded{ margin-left:0; }
  .content{ padding:1rem; }
  .topbar-search{ display:none; }
  .user-info{ display:none; }
  .page-header h1{ font-size:1.4rem; }
}
@media (max-width:480px){
  .topbar{ padding:0 1rem; }
  .topbar-btn{ width:38px; height:38px; }
}

.modal-backdrop.show {
    display: none !important;
}

</style>

</head>
<body>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="logo"><i class="bi bi-lightning-charge-fill"></i></div>
    <span class="brand"> The TIC Achives</span>
  </div>
  
  <nav class="sidebar-nav">
    <div class="nav-section">
      <div class="nav-section-title">Main Menu</div>
      <a href="{{ route('admin.dashboard') }}" class="nav-item active" onclick="showDashboard()">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
      </a>
    </div>

    <div class="nav-section">
      <div class="nav-section-title">Content</div>
      <!-- <div class="nav-group">
        <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-globe2"></i>
          <span>Site Manager</span>
          <i class="bi bi-chevron-right chevron"></i>
        </button>
      </div> -->

      @if(request()->user() && request()->user()->hasPermission('Collection'))
      <div class="nav-group">
        <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-newspaper"></i>
          <span>Collection</span>
          @if(isset($pendingCollectionRequestsCount) && $pendingCollectionRequestsCount > 0)
            <span class="badge-count" style="margin-left: auto; margin-right: 10px;">{{ $pendingCollectionRequestsCount }}</span>
          @endif
          <i class="bi bi-chevron-right chevron"></i>
        </button>
        <div class="nav-group-items">
          <a href="{{ route('admin.collections.create') }}" class="nav-item"><span>Add Collection</span></a>
          <a href="{{ route('admin.collections.index') }}" class="nav-item"><span>View Collection</span></a>
          <a href="{{ route('admin.main.index') }}" class="nav-item"><span>Mange Catogry</span></a>
          <a href="{{ route('admin.access-requests.index') }}" class="nav-item {{ request()->routeIs('admin.access-requests.index') ? 'active' : '' }}">
            <span>Collection Request</span>
            @if(isset($pendingCollectionRequestsCount) && $pendingCollectionRequestsCount > 0)
              <span class="badge-count">{{ $pendingCollectionRequestsCount }}</span>
            @endif
          </a>
        </div>
      </div>
      @endif

      @if(request()->user() && request()->user()->hasPermission('Heritage'))
      <div class="nav-group">
       <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-building"></i> <span>Heritage Collection</span>
          @if(isset($pendingHeritageRequestsCount) && $pendingHeritageRequestsCount > 0)
            <span class="badge-count" style="margin-left: auto; margin-right: 10px;">{{ $pendingHeritageRequestsCount }}</span>
          @endif
          <i class="bi bi-chevron-right chevron"></i>
        </button>

        <div class="nav-group-items">
          <a href="{{ route('admin.heritagecollections.create') }}" class="nav-item"><span>Add Heritage Collection</span></a>
          <a href="{{ route('admin.heritagecollections.index') }}" class="nav-item"><span>View Heritage Collections</span></a>
          <a href="{{ route('admin.heritage.indexadmin') }}"class="nav-item"><span>Mange Main Catogry</span></a>
          <a href="{{ route('admin.heritage.access-requests.index') }}" class="nav-item {{ request()->routeIs('admin.heritage.access-requests.index') ? 'active' : '' }}">
            <span>Heritage Collection Request</span>
            @if(isset($pendingHeritageRequestsCount) && $pendingHeritageRequestsCount > 0)
              <span class="badge-count">{{ $pendingHeritageRequestsCount }}</span>
            @endif
          </a>
        </div>
      </div>
      @endif

      @if(request()->user() && request()->user()->hasPermission('Publications'))
      <div class="nav-group">
        <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-journal-richtext"></i>
          <span>Publications</span>
          @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
            <span class="badge-count" style="margin-left: auto; margin-right: 10px;">{{ $pendingOrdersCount }}</span>
          @endif
          <i class="bi bi-chevron-right chevron"></i>
        </button>
        <div class="nav-group-items">
          <a href="{{ route('admin.publications.create') }}" class="nav-item"><span>Add Publication</span></a>
          <a href="{{ route('admin.publications.view') }}" class="nav-item"><span>View All</span></a>
          <a href="{{ route('admin.categories.main.index') }}" class="nav-item"><span>Publications Categories</span></a>
          <a href="{{ route('admin.publicationorders') }}" class="nav-item {{ request()->routeIs('admin.publicationorders') ? 'active' : '' }}">
            <span>Orders</span>
            @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
              <span class="badge-count">{{ $pendingOrdersCount }}</span>
            @endif
          </a>
        </div>
      </div>
      @endif

      @if(request()->user() && request()->user()->hasPermission('Virtual Exhibition'))
      <div class="nav-group">
        <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-bank"></i>
          <span>Virtual Exhibition</span>
          <i class="bi bi-chevron-right chevron"></i>
        </button>
        <div class="nav-group-items">
          <a href="{{ route('admin.exhibitions.create') }}" class="nav-item"><span>Add Virtual Exhibition</span></a>
          <a href="{{ route('admin.exhibitions.index') }}" class="nav-item"><span>View Virtual Exhibition</span></a>
          <a href="{{ route('admin.exhibitions.categories.index') }}" class="nav-item"><span>Mange Exhibition Catogry</span></a>
        </div>
      </div>
      @endif

     
    </div>

    <div class="nav-section">
      <div class="nav-section-title">Management</div>
      @if(request()->user() && request()->user()->isAdmin())
      <div class="nav-group">
        <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-person-badge-fill"></i>
          <span>Staff Management</span>
          <i class="bi bi-chevron-right chevron"></i>
        </button>
        <div class="nav-group-items">
          <a href="{{ route('admin.staff.index') }}" class="nav-item"><span>Staff List</span></a>
          <a href="{{ route('admin.staff.history.index') }}" class="nav-item"><span>Staff History</span></a>
        </div>
      </div>
      @endif

      @if(request()->user() && request()->user()->hasPermission('Members'))
      <div class="nav-group">
        <button class="nav-group-btn" onclick="toggleNav(this)">
          <i class="bi bi-people-fill"></i>
          <span>Members</span>
          <i class="bi bi-chevron-right chevron"></i>
        </button>
        <div class="nav-group-items">
          <a href="{{ route('admin.members.index') }}" class="nav-item"><span>Membership List</span></a>
          <a href="{{ route('admin.committee.create') }}" class="nav-item"><span>Add Member</span></a>
          <a href="{{ route('admin.committee.index') }}" class="nav-item"><span>View Team List</span></a>
        </div>
      </div>
      <a href="{{ route('admin.archives.index') }}" class="nav-item {{ request()->routeIs('admin.archives.index') ? 'active' : '' }}">
        <i class="bi bi-archive-fill"></i>
        <span>View Submissions</span>
        @if(isset($pendingArchivesCount) && $pendingArchivesCount > 0)
          <span class="badge-count">{{ $pendingArchivesCount }}</span>
        @endif
      </a>
      @endif
      <a href="{{ route('admin.enquiries') }}" class="nav-item">
        <i class="bi bi-envelope-fill"></i>
        <span>Enquiries</span>
      </a>
      <!--<a href="#" class="nav-item" onclick="loadPage('support')">-->
      <!--  <i class="bi bi-headset"></i>-->
      <!--  <span>Support</span>-->
      <!--  <span class="badge-count">5</span>-->
      <!--</a>-->
    </div>

    <!-- <div class="nav-section">
      <div class="nav-section-title">System</div>
      <a href="#" class="nav-item" onclick="loadPage('settings')">
        <i class="bi bi-gear-fill"></i>
        <span>Settings</span>
      </a>
      <a href="#" class="nav-item" onclick="loadPage('logs')">
        <i class="bi bi-terminal-fill"></i>
        <span>System Logs</span>
      </a>
    </div> -->
  </nav>


</aside>

<div class="main-wrapper" id="mainWrapper">
  <header class="topbar">
    <button class="topbar-toggle" id="sidebarToggle" aria-label="Toggle menu">
      <i class="bi bi-list"></i>
    </button>
    
    <!-- <div class="topbar-search">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Search anything...">
    </div> -->

    <div class="topbar-actions">
      <button class="topbar-btn" id="themeToggle" aria-label="Toggle theme">
        <!-- <i class="bi bi-moon-stars-fill"></i> -->
      </button>
     <!-- Notification Bell -->


     
      <div class="topbar-divider"></div>
      
      <div class="user-dropdown">
        <button class="user-btn" id="userDropdownBtn">
          <div class="user-avatar">
            <img src="/images/admin.png" alt="User Avatar">
          </div>

          <div class="user-info">
            <div class="role text-capitalize">{{ request()->user()->role ?? 'Admin' }}</div>
          </div>
          <i class="bi bi-chevron-down" style="color: var(--text-muted); font-size: 0.8rem;"></i>
        </button>
        <div class="dropdown-menu" id="userDropdown">
          <div class="dropdown-header">
    <div class="name" id="admin-name">Loading...</div>
    <div class="email" id="admin-email">Loading...</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch("{{ route('admin.profile') }}", {
        method: 'GET',
        credentials: 'include' // important to send cookies (access_token)
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('admin-name').textContent = data.role;
        document.getElementById('admin-email').textContent = data.email;
    })
    .catch(err => {
        console.error(err);
        document.getElementById('admin-name').textContent = "Guest";
        document.getElementById('admin-email').textContent = "";
    });
});
</script>

          <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="bi bi-shield-lock"></i> Change Password
          </a>
          <!-- <a href="#" class="dropdown-item"><i class="bi bi-gear"></i> Settings</a>
          <a href="#" class="dropdown-item"><i class="bi bi-question-circle"></i> Help Center</a> -->
          <hr style="margin: 0.5rem 0; border-color: var(--border);">

          <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
             <button type="submit" class="dropdown-item danger">
             <i class="bi bi-box-arrow-right"></i> Logout
             </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <main class="content" id="mainContent">

    
  
    @yield('content')



  </main>
</div>


<script>
const sidebar=document.getElementById('sidebar'),mainWrapper=document.getElementById('mainWrapper'),sidebarToggle=document.getElementById('sidebarToggle'),sidebarOverlay=document.getElementById('sidebarOverlay'),themeToggle=document.getElementById('themeToggle'),userDropdownBtn=document.getElementById('userDropdownBtn'),userDropdown=document.getElementById('userDropdown'),mainContent=document.getElementById('mainContent');

sidebarToggle.addEventListener('click',()=>{if(window.innerWidth<=768){sidebar.classList.toggle('mobile-open');sidebarOverlay.classList.toggle('show');}else{sidebar.classList.toggle('collapsed');mainWrapper.classList.toggle('expanded');}});
sidebarOverlay.addEventListener('click',()=>{sidebar.classList.remove('mobile-open');sidebarOverlay.classList.remove('show');});

function toggleNav(btn){
  const g = btn.parentElement;
  const key = g.querySelector('span')?.textContent || 'nav';

  const isOpen = g.classList.toggle('open');
  localStorage.setItem('openNavGroup', isOpen ? key : '');
}

document.addEventListener('DOMContentLoaded', () => {
  const saved = localStorage.getItem('openNavGroup');
  if (!saved) return;

  document.querySelectorAll('.nav-group').forEach(g => {
    const label = g.querySelector('span')?.textContent;
    if (label === saved) {
      g.classList.add('open');
    }
  });
});


themeToggle.addEventListener('click',()=>{const d=document.documentElement,isDark=d.getAttribute('data-theme')==='dark';d.setAttribute('data-theme',isDark?'light':'dark');themeToggle.innerHTML=isDark?'<i class="bi bi-moon-stars-fill"></i>':'<i class="bi bi-sun-fill"></i>';});

userDropdownBtn.addEventListener('click',e=>{e.stopPropagation();userDropdown.classList.toggle('show');});
document.addEventListener('click',()=>userDropdown.classList.remove('show'));

function closeMobile(){if(window.innerWidth<=768){sidebar.classList.remove('mobile-open');sidebarOverlay.classList.remove('show');}}
function showDashboard(){document.getElementById('dashboardView').style.display='block';closeMobile();}

function loadPage(p){
  closeMobile();
  const titles={sliders:'Slider Management',announcements:'Announcements',addNews:'Add News',viewNews:'View News',categories:'News Categories',addPub:'Add Publication',viewPub:'View Publications',orders:'Publication Orders',addEvent:'Add Event',viewEvents:'View Events',calendar:'Event Calendar',founders:'Founders',partners:'Partners',viewMembers:'All Members',enquiries:'Enquiries',support:'Support Tickets',settings:'Settings',logs:'System Logs'};
  const icons={sliders:'bi-images',announcements:'bi-megaphone',addNews:'bi-file-earmark-plus',viewNews:'bi-newspaper',categories:'bi-tags',addPub:'bi-journal-plus',viewPub:'bi-journal-richtext',orders:'bi-cart3',addEvent:'bi-calendar-plus',viewEvents:'bi-calendar-event',calendar:'bi-calendar3',founders:'bi-award',partners:'bi-building',viewMembers:'bi-people',enquiries:'bi-envelope',support:'bi-headset',settings:'bi-gear',logs:'bi-terminal'};
  
  if(p==='addNews'||p==='addEvent'||p==='addPub'){showAddForm(p,titles[p],icons[p]);return;}
  if(p==='viewEvents'){showEventsPage();return;}
  if(p==='orders'){showOrdersPage();return;}
  if(p==='enquiries'){showEnquiriesPage();return;}
  
  document.getElementById('dashboardView').style.display='none';
  mainContent.innerHTML=`
    <div class="page-header animate-in">
      <div class="page-header-left">
        <h1><i class="${icons[p]} me-2" style="color:var(--primary)"></i>${titles[p]}</h1>
        <p><i class="bi bi-house"></i> Dashboard / ${titles[p]}</p>
      </div>
      <div class="page-header-right">
        <button class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Add New</button>
      </div>
    </div>
    <div class="card animate-in delay-1">
      <div class="card-body text-center py-5">
        <div style="width:100px;height:100px;margin:0 auto 1.5rem;background:var(--light);border-radius:50%;display:flex;align-items:center;justify-content:center;">
          <i class="${icons[p]}" style="font-size:2.5rem;color:var(--primary)"></i>
        </div>
        <h3 style="margin-bottom:0.5rem">${titles[p]}</h3>
        <p style="color:var(--text-muted);margin-bottom:1.5rem">This section is ready for your content.</p>
        <button class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Create First Item</button>
      </div>
    </div>`;
}

window.addEventListener('resize',()=>{if(window.innerWidth>768){sidebar.classList.remove('mobile-open');sidebarOverlay.classList.remove('show');}});
</script>


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Toastr flash from Laravel session -->
<script>
// Global Toastr Configuration
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

// Laravel Session Messages to Toastr
@if(session('success'))
    toastr.success("{{ session('success') }}");
@endif

@if(session('error'))
    toastr.error("{{ session('error') }}");
@endif

@if(session('warning'))
    toastr.warning("{{ session('warning') }}");
@endif

@if(session('info'))
    toastr.info("{{ session('info') }}");
@endif
</script>

<script>
  // auto handle forms with data-loading attribute
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-loading]').forEach(form => {
      form.addEventListener('submit', function (e) {
        const btn = form.querySelector('[type="submit"]');
        if (!btn) return;
        // Save original content
        if (!btn.dataset.originalHtml) btn.dataset.originalHtml = btn.innerHTML;
        // Disable and set loading text
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + (btn.dataset.loadingText || 'Saving...');
      });
    });
  });
</script>

  <!-- Change Password Modal -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius);">
        <div class="modal-header border-bottom-0 pb-0">
          <h5 class="modal-title fw-bold" id="changePasswordModalLabel">Change Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="changePasswordForm">
          <div class="modal-body p-4">
            <div class="mb-3">
              <label for="old_password" class="form-label small fw-semibold">Current Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control bg-light border-start-0" id="old_password" name="old_password" required placeholder="Enter current password">
              </div>
            </div>
            <div class="mb-3">
              <label for="new_password" class="form-label small fw-semibold">New Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                <input type="password" class="form-control bg-light border-start-0" id="new_password" name="new_password" required placeholder="Min 12 characters, A-z, 0-9, symbol">
              </div>
              <div id="password-strength-info" class="form-text small mt-1"></div>
            </div>
            <div class="mb-3">
              <label for="new_password_confirmation" class="form-label small fw-semibold">Confirm New Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-check2-circle"></i></span>
                <input type="password" class="form-control bg-light border-start-0" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Confirm your new password">
              </div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn-primary-custom" id="changePassSubmitBtn">
              Update Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('changePassSubmitBtn');
        const originalHtml = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
        
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        fetch("{{ route('admin.change-password') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(async res => {
            const result = await res.json();
            if (res.ok) {
                toastr.success(result.message || 'Password changed successfully.');
                setTimeout(() => {
                    const logoutForm = document.createElement('form');
                    logoutForm.method = 'POST';
                    logoutForm.action = "{{ route('admin.logout') }}";
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    logoutForm.appendChild(csrfInput);
                    document.body.appendChild(logoutForm);
                    logoutForm.submit();
                }, 1500);
            } else {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                
                if (result.errors) {
                    Object.values(result.errors).forEach(err => {
                        if (Array.isArray(err)) err.forEach(m => toastr.error(m));
                        else toastr.error(err);
                    });
                } else {
                    toastr.error(result.message || 'An error occurred.');
                }
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            toastr.error('Failed to update password. Please try again.');
        });
    });
  </script>


@yield('scripts')
</body>
</html>