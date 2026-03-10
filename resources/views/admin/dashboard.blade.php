<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Digital Canteen System — Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --primary:   #2D336B;
    --primary-light: #3a4285;
    --primary-dark:  #1e2249;
    --secondary: #7886C7;
    --secondary-light: #a0abdb;
    --accent:    #A9B5EB;
    --bg:        #F4F6FB;
    --surface:   #FFFFFF;
    --border:    #E4E8F4;
    --text:      #1a1d2e;
    --muted:     #7a82a8;
    --success:   #22c55e;
    --warning:   #f59e0b;
    --danger:    #ef4444;
    --sidebar-w: 220px;
    --topbar-h:  60px;
    --radius:    10px;
    --font: 'Plus Jakarta Sans', sans-serif;
  }

  html, body { height: 100%; font-family: var(--font); background: var(--bg); color: var(--text); font-size: 14px; }

  /* ── LAYOUT ── */
  .layout { display: flex; height: 100vh; overflow: hidden; }

  /* ── SIDEBAR ── */
  .sidebar {
    width: var(--sidebar-w);
    min-width: var(--sidebar-w);
    background: var(--primary);
    display: flex;
    flex-direction: column;
    transition: width .28s cubic-bezier(.4,0,.2,1), min-width .28s cubic-bezier(.4,0,.2,1);
    position: relative;
    z-index: 200;
    overflow: hidden;
  }
  .sidebar.collapsed { width: 62px; min-width: 62px; }

  .sidebar-logo {
    height: var(--topbar-h);
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 16px;
    border-bottom: 1px solid rgba(255,255,255,.08);
    flex-shrink: 0;
    overflow: hidden;
    white-space: nowrap;
  }
  .logo-icon {
    width: 30px; height: 30px; min-width: 30px;
    background: var(--secondary);
    border-radius: 8px;
    display: grid; place-items: center;
  }
  .logo-icon svg { width: 16px; height: 16px; stroke: #fff; }
  .logo-text { font-weight: 800; font-size: 13px; color: #fff; letter-spacing: -.2px; line-height: 1.2; }
  .logo-text span { color: var(--accent); }

  .nav { flex: 1; padding: 12px 8px; display: flex; flex-direction: column; gap: 2px; overflow: hidden; }
  .nav-section { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.3); letter-spacing: 1px; text-transform: uppercase; padding: 10px 10px 4px; white-space: nowrap; overflow: hidden; }
  .sidebar.collapsed .nav-section { opacity: 0; }

  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 10px;
    border-radius: 8px;
    color: rgba(255,255,255,.65);
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
    transition: background .18s, color .18s;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    position: relative;
  }
  .nav-item svg { width: 16px; height: 16px; min-width: 16px; stroke: currentColor; }
  .nav-item:hover { background: rgba(255,255,255,.09); color: #fff; }
  .nav-item.active { background: rgba(120,134,199,.25); color: #fff; }
  .nav-item.active::before {
    content: '';
    position: absolute; left: 0; top: 50%; transform: translateY(-50%);
    width: 3px; height: 60%; background: var(--accent); border-radius: 0 3px 3px 0;
  }
  .nav-item.logout { color: rgba(255,100,100,.7); margin-top: auto; }
  .nav-item.logout:hover { background: rgba(239,68,68,.15); color: #ff7070; }
  .nav-label { opacity: 1; transition: opacity .2s; }
  .sidebar.collapsed .nav-label { opacity: 0; width: 0; }

  .nav-badge {
    margin-left: auto; font-size: 10px; font-weight: 700;
    background: var(--secondary); color: #fff;
    padding: 1px 6px; border-radius: 20px; min-width: 18px; text-align: center;
  }
  .sidebar.collapsed .nav-badge { opacity: 0; width: 0; }

  .sidebar-footer { padding: 12px 8px; border-top: 1px solid rgba(255,255,255,.08); }

  /* ── MAIN ── */
  .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

  /* ── TOPBAR ── */
  .topbar {
    height: var(--topbar-h); background: var(--surface);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    padding: 0 24px; gap: 16px; flex-shrink: 0;
  }
  .toggle-btn {
    width: 34px; height: 34px; border-radius: 8px;
    border: 1px solid var(--border); background: transparent;
    display: grid; place-items: center; cursor: pointer;
    color: var(--muted); transition: background .15s, color .15s;
  }
  .toggle-btn:hover { background: var(--bg); color: var(--primary); }
  .toggle-btn svg { width: 16px; height: 16px; }
  .page-title { font-size: 15px; font-weight: 700; color: var(--text); flex: 1; }
  .page-title span { color: var(--muted); font-weight: 400; font-size: 13px; }

  .topbar-right { display: flex; align-items: center; gap: 12px; }

  .icon-btn {
    position: relative; width: 34px; height: 34px;
    border-radius: 8px; border: 1px solid var(--border);
    background: transparent; display: grid; place-items: center;
    cursor: pointer; color: var(--muted); transition: background .15s;
  }
  .icon-btn:hover { background: var(--bg); }
  .icon-btn svg { width: 15px; height: 15px; }
  .notif-dot {
    position: absolute; top: 6px; right: 6px;
    width: 7px; height: 7px; background: #ef4444; border-radius: 50%;
    border: 1.5px solid #fff;
  }

  .profile-wrap { position: relative; }
  .profile-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 4px 8px; border-radius: 8px;
    border: 1px solid var(--border); background: transparent;
    cursor: pointer; transition: background .15s;
  }
  .profile-btn:hover { background: var(--bg); }
  .avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    display: grid; place-items: center;
    font-weight: 700; font-size: 11px; color: #fff; letter-spacing: .5px;
  }
  .profile-info { text-align: left; }
  .profile-name { font-weight: 600; font-size: 12px; color: var(--text); line-height: 1.2; }
  .profile-role { font-size: 10px; color: var(--muted); }
  .chevron { width: 12px; height: 12px; color: var(--muted); stroke: currentColor; }

  .dropdown {
    position: absolute; top: calc(100% + 6px); right: 0;
    width: 160px; background: var(--surface);
    border: 1px solid var(--border); border-radius: var(--radius);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
    padding: 4px; z-index: 999;
    display: none; flex-direction: column;
    animation: fadeDown .15s ease;
  }
  .dropdown.open { display: flex; }
  @keyframes fadeDown { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
  .dropdown a {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 10px; border-radius: 7px;
    text-decoration: none; color: var(--text); font-size: 13px; font-weight: 500;
    transition: background .15s;
  }
  .dropdown a svg { width: 13px; height: 13px; stroke: currentColor; color: var(--muted); }
  .dropdown a:hover { background: var(--bg); }
  .dropdown .divider { height: 1px; background: var(--border); margin: 3px 0; }
  .dropdown a.red { color: var(--danger); }
  .dropdown a.red svg { color: var(--danger); }

  /* ── CONTENT ── */
  .content { flex: 1; overflow-y: auto; padding: 24px; }

  /* ── STAT BOXES ── */
  .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
  .stat-box {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
    transition: box-shadow .2s, border-color .2s;
  }
  .stat-box:hover { box-shadow: 0 4px 16px rgba(45,51,107,.07); border-color: var(--secondary-light); }
  .stat-icon {
    width: 38px; height: 38px; border-radius: 9px;
    display: grid; place-items: center; flex-shrink: 0;
  }
  .stat-icon svg { width: 18px; height: 18px; }
  .si-blue   { background: #eef0fc; color: var(--primary); }
  .si-green  { background: #dcfce7; color: #16a34a; }
  .si-orange { background: #fff7ed; color: #ea580c; }
  .si-purple { background: #f3f0ff; color: #7c3aed; }
  .stat-info { flex: 1; min-width: 0; }
  .stat-label { font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 3px; }
  .stat-value { font-size: 20px; font-weight: 800; color: var(--text); line-height: 1; }
  .stat-sub { font-size: 10px; color: var(--success); font-weight: 600; margin-top: 3px; }

  /* ── TABLE SECTION ── */
  .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
  .section-title { font-size: 14px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 7px; }
  .section-title svg { width: 15px; height: 15px; color: var(--secondary); stroke: currentColor; }
  .btn-sm {
    padding: 6px 14px; border-radius: 7px; font-size: 12px; font-weight: 600;
    border: 1px solid var(--border); background: var(--surface);
    color: var(--text); cursor: pointer; transition: background .15s;
    display: flex; align-items: center; gap: 5px; font-family: var(--font);
    text-decoration: none;
  }
  .btn-sm:hover { background: var(--bg); }
  .btn-primary { background: var(--primary); color: #fff; border-color: var(--primary); }
  .btn-primary:hover { background: var(--primary-light); }

  .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }

  table { width: 100%; border-collapse: collapse; }
  thead th {
    padding: 10px 14px;
    font-size: 11px; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .5px;
    border-bottom: 1px solid var(--border); text-align: left;
    background: #fafbff;
  }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: #f8f9fe; }
  td { padding: 10px 14px; font-size: 13px; color: var(--text); }

  .user-cell { display: flex; align-items: center; gap: 8px; }
  .user-avatar {
    width: 26px; height: 26px; border-radius: 50%;
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    display: grid; place-items: center;
    font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
  }

  .badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 9px; border-radius: 20px;
    font-size: 11px; font-weight: 600;
  }
  .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
  .badge-success { background: #dcfce7; color: #15803d; }
  .badge-warning { background: #fef9c3; color: #a16207; }
  .badge-danger  { background: #fee2e2; color: #b91c1c; }
  .badge-info    { background: #e0f2fe; color: #0369a1; }

  .action-btns { display: flex; gap: 5px; }
  .act-btn {
    padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;
    border: 1px solid; cursor: pointer; font-family: var(--font); transition: opacity .15s;
    text-decoration: none; display: inline-block;
  }
  .act-btn:hover { opacity: .8; }
  .act-detail { background: #eef0fc; color: var(--primary); border-color: #d4d8f5; }
  .act-confirm { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
  .act-cancel  { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }

  /* ── MENU GRID ── */
  .menu-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 28px; }
  .menu-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); overflow: hidden;
    transition: box-shadow .2s, border-color .2s;
  }
  .menu-card:hover { box-shadow: 0 4px 18px rgba(45,51,107,.1); border-color: var(--secondary-light); }
  .menu-card-img { position: relative; width: 100%; height: 130px; background: var(--bg); overflow: hidden; }
  .menu-card-img img { width: 100%; height: 100%; object-fit: cover; }
  .menu-card-img .no-img { display: flex; align-items: center; justify-content: center; height: 100%; color: var(--muted); font-size: 12px; }
  .menu-card-img .avail-badge {
    position: absolute; top: 8px; right: 8px;
    font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px;
  }
  .menu-card-body { padding: 10px 12px; }
  .menu-card-name { font-weight: 700; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 3px; }
  .menu-cat { font-size: 10px; color: var(--muted); margin-bottom: 6px; }
  .menu-card-footer { display: flex; justify-content: space-between; align-items: center; }
  .menu-price { font-weight: 700; font-size: 13px; color: var(--primary); }
  @media (max-width: 900px) { .menu-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 480px) { .menu-grid { grid-template-columns: repeat(2, 1fr); } }

  /* ── SCROLLBAR ── */
  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #d0d5ec; border-radius: 4px; }

  /* ── MOBILE ── */
  .overlay { display: none; }
  @media (max-width: 768px) {
    .sidebar { position: fixed; left: 0; top: 0; height: 100%; z-index: 300; transform: translateX(-100%); transition: transform .28s; width: var(--sidebar-w) !important; min-width: var(--sidebar-w) !important; }
    .sidebar.mobile-open { transform: translateX(0); }
    .overlay { display: block; position: fixed; inset: 0; background: rgba(0,0,0,.35); z-index: 299; display: none; }
    .overlay.show { display: block; }
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
    .sidebar.collapsed { transform: translateX(-100%); }
    table { font-size: 12px; }
    .profile-info { display: none; }
    .page-title span { display: none; }
    td:nth-child(4) { display: none; }
    th:nth-child(4) { display: none; }
  }
  @media (max-width: 480px) {
    .stat-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .content { padding: 16px; }
    .stat-value { font-size: 17px; }
  }
</style>
</head>
<body>

<div class="overlay" id="overlay" onclick="closeMobile()"></div>

<div class="layout">

  <!-- ── SIDEBAR ── -->
  <aside class="sidebar" id="sidebar">
    <a class="sidebar-logo" href="{{ route('admin.dashboard') }}" style="text-decoration:none;">
      <div class="logo-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
      </div>
      <div class="logo-text">Digital<br/><span>Canteen</span></div>
    </a>

    <nav class="nav">
      <div class="nav-section">Main</div>

      <a class="nav-item active" href="{{ route('admin.dashboard') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="nav-label">Dashboard</span>
      </a>

      <a class="nav-item" href="{{ route('admin.menus.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <span class="nav-label">Kelola Menu</span>
      </a>

      <a class="nav-item" href="{{ route('admin.orders.index') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span class="nav-label">Pesanan Masuk</span>
        @if($pendingCount > 0)
          <span class="nav-badge">{{ $pendingCount }}</span>
        @endif
      </a>

      <a class="nav-item" href="{{ route('admin.orders.history') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="nav-label">Riwayat Pesanan</span>
      </a>

      <div style="flex:1"></div>
      <a class="nav-item" href="{{ route('profile.edit') }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="nav-label">Profil Saya</span>
      </a>
      <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
      <button class="nav-item logout" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-family:inherit;" onclick="document.getElementById('logout-form').submit()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        <span class="nav-label">Logout</span>
      </button>
    </nav>
  </aside>

  <!-- ── MAIN ── -->
  <div class="main">

    <!-- Topbar -->
    <header class="topbar">
      <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle sidebar">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
      </button>
      <div class="page-title">Dashboard Admin <span>/ Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}</span></div>

      <div class="topbar-right">
        <a href="{{ route('admin.orders.index') }}" class="icon-btn" title="Pesanan Pending">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
          @if($pendingCount > 0)<span class="notif-dot"></span>@endif
        </a>

        <div class="profile-wrap">
          <button class="profile-btn" onclick="toggleDropdown()">
            <div class="avatar" style="overflow:hidden;">
              @if(Auth::user()->profile_photo)
                <img src="{{ Auth::user()->getAvatarUrl() }}" alt="" style="width:100%;height:100%;object-fit:cover;">
              @else
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
              @endif
            </div>
            <div class="profile-info">
              <div class="profile-name">{{ explode(' ', Auth::user()->name)[0] }}</div>
              <div class="profile-role">Administrator</div>
            </div>
            <svg class="chevron" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="dropdown" id="dropdown">
            <a href="{{ route('profile.edit') }}">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Profil Saya
            </a>
            <div class="divider"></div>
            <a href="#" class="red" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
              Logout
            </a>
          </div>
        </div>
      </div>
    </header>

    <!-- Content -->
    <div class="content">

      <!-- Stat Boxes -->
      <div class="stat-grid">
        <a href="{{ route('admin.menus.index') }}" class="stat-box" style="text-decoration:none;color:inherit;">
          <div class="stat-icon si-blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-label">Total Menu</div>
            <div class="stat-value">{{ $totalMenus }}</div>
            <div class="stat-sub">
              {{ $availableMenus }} tersedia
              @if($lowStockMenus > 0)
                &bull; <span style="color:#ea580c;">{{ $lowStockMenus }} stok menipis</span>
              @endif
            </div>
          </div>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="stat-box" style="text-decoration:none;color:inherit;">
          <div class="stat-icon si-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-label">Pesanan Hari Ini</div>
            <div class="stat-value">{{ $todayOrders }}</div>
            <div class="stat-sub">{{ $pendingCount }} menunggu konfirmasi</div>
          </div>
        </a>
        <div class="stat-box">
          <div class="stat-icon si-orange">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-label">Total Customer</div>
            <div class="stat-value">{{ $totalCustomers }}</div>
            <div class="stat-sub">Pengguna terdaftar</div>
          </div>
        </div>
        <a href="{{ route('admin.orders.history') }}" class="stat-box" style="text-decoration:none;color:inherit;">
          <div class="stat-icon si-purple">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="stat-info">
            <div class="stat-label">Pendapatan Hari Ini</div>
            <div class="stat-value">Rp {{ number_format($todayRevenue/1000, 0, ',', '.') }}K</div>
            <div class="stat-sub">Total: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
          </div>
        </a>
      </div>

      <!-- Menu Terbaru Grid -->
      <div class="section-header">
        <div class="section-title">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          Menu Terbaru
        </div>
        <a href="{{ route('admin.menus.index') }}" class="btn-sm">Lihat Semua</a>
      </div>

      <div class="menu-grid">
        @forelse($dashboardMenus as $menu)
        <div class="menu-card">
          <div class="menu-card-img">
            @if($menu->photo)
              <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}">
            @else
              <div class="no-img">No Image</div>
            @endif
            <span class="avail-badge {{ $menu->is_available ? 'badge-success' : 'badge-danger' }}">
              {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
            </span>
          </div>
          <div class="menu-card-body">
            <div class="menu-card-name">{{ $menu->name }}</div>
            <div class="menu-cat">{{ ucfirst($menu->category) }}</div>
            <div class="menu-card-footer">
              <span class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
              <a href="{{ route('admin.menus.edit', $menu) }}" class="act-btn act-detail" style="font-size:10px;padding:3px 8px;">Edit</a>
            </div>
          </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:24px;text-align:center;color:var(--muted);background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);">
          Belum ada menu. <a href="{{ route('admin.menus.create') }}" style="color:var(--primary);font-weight:600;">Tambah sekarang</a>
        </div>
        @endforelse
      </div>

      <!-- Divider -->
      <div style="border-top:1px solid var(--border);margin:8px 0 28px;"></div>

      <!-- Orders Table -->
      <div class="section-header">
        <div class="section-title">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          Pesanan Terbaru
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-sm btn-primary">Lihat Semua</a>
      </div>

      <div class="card">
        <table>
          <thead>
            <tr>
              <th style="width:36px;">#</th>
              <th>Customer</th>
              <th>Menu</th>
              <th>Waktu</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentOrders as $order)
            <tr>
              <td style="color:var(--muted);font-size:11px;font-weight:600;">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
              <td>
                <div class="user-cell">
                  <div class="user-avatar">{{ strtoupper(substr($order->user->name ?? '?', 0, 2)) }}</div>
                  <span style="max-width:90px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $order->user->name ?? '–' }}</span>
                </div>
              </td>
              <td style="max-width:130px;">
                <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $order->menu->name ?? '–' }}</span>
                <span style="color:var(--muted);font-size:11px;">×{{ $order->quantity }} &bull; Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
              </td>
              <td style="color:var(--muted);font-size:11px;white-space:nowrap;">{{ $order->created_at->format('d M, H:i') }}</td>
              <td>
                @if($order->status === 'pending')
                  <span class="badge badge-info">Menunggu</span>
                @elseif($order->status === 'preparing')
                  <span class="badge badge-warning">Diproses</span>
                @elseif($order->status === 'ready')
                  <span class="badge" style="background:#f3e8ff;color:#7c3aed;">Siap</span>
                @else
                  <span class="badge badge-success">Selesai</span>
                @endif
              </td>
              <td>
                <div class="action-btns">
                  <a href="{{ route('admin.orders.index') }}" class="act-btn act-detail">Detail</a>
                  @if($order->status === 'pending')
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" style="display:inline;">
                      @csrf <input type="hidden" name="status" value="preparing">
                      <button type="submit" class="act-btn" style="background:#e0f2fe;color:#0369a1;border-color:#bae6fd;">Proses</button>
                    </form>
                  @elseif($order->status === 'preparing')
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" style="display:inline;">
                      @csrf <input type="hidden" name="status" value="ready">
                      <button type="submit" class="act-btn" style="background:#f3e8ff;color:#7c3aed;border-color:#e9d5ff;">Siap</button>
                    </form>
                  @elseif($order->status === 'ready')
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" style="display:inline;">
                      @csrf <input type="hidden" name="status" value="completed">
                      <button type="submit" class="act-btn act-confirm">Selesai</button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" style="padding:32px;text-align:center;color:var(--muted);font-size:13px;">Belum ada pesanan</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /layout -->

<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const isMobile = () => window.innerWidth <= 768;

  function toggleSidebar() {
    if (isMobile()) {
      sidebar.classList.toggle('mobile-open');
      overlay.classList.toggle('show');
    } else {
      sidebar.classList.toggle('collapsed');
    }
  }

  function closeMobile() {
    sidebar.classList.remove('mobile-open');
    overlay.classList.remove('show');
  }

  const dropdown = document.getElementById('dropdown');
  function toggleDropdown() { dropdown.classList.toggle('open'); }
  document.addEventListener('click', e => {
    if (!e.target.closest('.profile-wrap')) dropdown.classList.remove('open');
  });
</script>
</body>
</html>