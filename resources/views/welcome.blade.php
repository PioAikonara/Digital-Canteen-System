<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Canteen Digital</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --navy: #2D336B;
      --periwinkle: #7886C7;
      --light-periwinkle: #A9B4E8;
      --pale: #E8EBFA;
      --white: #FAFBFF;
      --text-dark: #1A1D3A;
      --text-mid: #4A5080;
      --accent: #F5A623;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--white);
      color: var(--text-dark);
      overflow-x: hidden;
    }

    /* ── NAV ── */
    nav {
      position: fixed; top: 0; left: 0; right: 0; z-index: 100;
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.1rem 5vw;
      background: rgba(250,251,255,0.85);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(45,51,107,0.08);
    }
    .nav-logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800; font-size: 1.15rem;
      color: var(--navy); letter-spacing: -.02em;
      display: flex; align-items: center; gap: .5rem;
    }
    .nav-logo span { color: var(--periwinkle); }
    .nav-pill {
      background: var(--navy); color: #fff;
      font-family: 'Syne', sans-serif; font-weight: 600;
      font-size: .82rem; letter-spacing: .04em;
      padding: .55rem 1.4rem; border-radius: 100px;
      text-decoration: none; transition: background .2s, transform .2s;
    }
    .nav-pill:hover { background: var(--periwinkle); transform: translateY(-1px); }

    /* ── HERO ── */
    .hero {
      min-height: 100vh; display: grid;
      grid-template-columns: 1fr;
      align-items: center; gap: 4rem;
      padding: 7rem 8vw 5rem;
      position: relative; overflow: hidden;
    }
    .hero-bg {
      position: absolute; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse 60% 70% at 75% 40%, rgba(120,134,199,0.18) 0%, transparent 70%),
        radial-gradient(ellipse 50% 60% at 10% 80%, rgba(45,51,107,0.08) 0%, transparent 65%);
    }
    .hero-dot-grid {
      position: absolute; inset: 0; z-index: 0;
      background-image: radial-gradient(circle, rgba(120,134,199,0.25) 1.2px, transparent 1.2px);
      background-size: 28px 28px;
      mask-image: radial-gradient(ellipse 70% 80% at 80% 30%, black 20%, transparent 80%);
    }
    .hero-left { position: relative; z-index: 1; }
    .hero-badge {
      display: inline-flex; align-items: center; gap: .5rem;
      background: var(--pale); border: 1px solid var(--light-periwinkle);
      color: var(--navy); font-size: .78rem; font-weight: 500;
      padding: .35rem .9rem; border-radius: 100px; margin-bottom: 1.6rem;
      animation: fadeUp .6s ease both;
    }
    .hero-badge-dot {
      width: 7px; height: 7px; border-radius: 50%;
      background: var(--periwinkle); animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%,100% { opacity:1; transform:scale(1); }
      50% { opacity:.5; transform:scale(1.3); }
    }
    .hero h1 {
      font-family: 'DM Sans', sans-serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      font-weight: 700; line-height: 1.35; letter-spacing: -.01em;
      color: var(--navy); margin-bottom: 1.4rem;
      animation: fadeUp .7s .1s ease both;
      max-width: 900px;
    }
    .hero h1 em {
      font-style: normal; color: var(--periwinkle);
      background: linear-gradient(135deg, var(--periwinkle), var(--navy));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .hero-desc {
      font-size: 1.05rem; color: var(--text-mid); line-height: 1.7;
      max-width: 580px; margin-bottom: 2.2rem;
      animation: fadeUp .7s .2s ease both;
    }
    .hero-cta {
      display: flex; gap: 1rem; flex-wrap: wrap;
      animation: fadeUp .7s .3s ease both;
    }
    .btn-primary {
      background: var(--navy); color: #fff;
      font-family: 'Syne', sans-serif; font-weight: 600; font-size: .9rem;
      padding: .85rem 2rem; border-radius: 12px; text-decoration: none;
      transition: all .25s; box-shadow: 0 4px 20px rgba(45,51,107,0.3);
      display: flex; align-items: center; gap: .5rem;
    }
    .btn-primary:hover {
      background: #1e2248; transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(45,51,107,0.35);
    }
    .btn-secondary {
      background: transparent; color: var(--navy);
      font-family: 'Syne', sans-serif; font-weight: 600; font-size: .9rem;
      padding: .85rem 2rem; border-radius: 12px; text-decoration: none;
      border: 2px solid var(--periwinkle); transition: all .25s;
    }
    .btn-secondary:hover {
      background: var(--pale); transform: translateY(-2px);
    }
    .hero-stats {
      display: flex; gap: 2rem; margin-top: 2.8rem;
      animation: fadeUp .7s .4s ease both;
    }
    .stat { }
    .stat-num {
      font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.6rem;
      color: var(--navy); line-height: 1;
    }
    .stat-label { font-size: .78rem; color: var(--text-mid); margin-top: .25rem; }

    /* ── HERO VISUAL ── */
    .hero-right {
      position: relative; z-index: 1;
      display: flex; justify-content: center; align-items: center;
      animation: fadeLeft .8s .2s ease both;
    }
    .mockup-card {
      background: #fff; border-radius: 24px;
      box-shadow: 0 24px 80px rgba(45,51,107,0.15), 0 4px 20px rgba(0,0,0,0.06);
      width: 100%; max-width: 380px; overflow: hidden;
      border: 1px solid rgba(120,134,199,0.2);
    }
    .mockup-header {
      background: linear-gradient(135deg, var(--navy), #404a8f);
      padding: 1.4rem 1.6rem;
      display: flex; align-items: center; gap: 1rem;
    }
    .mockup-avatar {
      width: 42px; height: 42px; border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem;
    }
    .mockup-header-text h4 {
      font-family: 'Syne', sans-serif; color: #fff;
      font-size: .95rem; font-weight: 700;
    }
    .mockup-header-text p { color: rgba(255,255,255,.6); font-size: .75rem; margin-top: 2px; }
    .mockup-body { padding: 1.4rem 1.6rem; }
    .mockup-label {
      font-size: .72rem; font-weight: 500; text-transform: uppercase;
      letter-spacing: .08em; color: var(--text-mid); margin-bottom: .8rem;
    }
    .menu-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .7rem; margin-bottom: 1.2rem; }
    .menu-item {
      background: var(--pale); border-radius: 14px; padding: .8rem;
      border: 1px solid transparent; transition: all .2s; cursor: pointer;
    }
    .menu-item:hover { border-color: var(--periwinkle); background: #edf0f9; }
    .menu-item-emoji { font-size: 1.5rem; margin-bottom: .3rem; }
    .menu-item-name { font-size: .78rem; font-weight: 500; color: var(--navy); }
    .menu-item-price {
      font-family: 'Syne', sans-serif; font-size: .82rem;
      font-weight: 700; color: var(--periwinkle); margin-top: .15rem;
    }
    .mockup-divider { height: 1px; background: var(--pale); margin: 1rem 0; }
    .mockup-order-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: .6rem 0;
    }
    .order-info { display: flex; align-items: center; gap: .7rem; }
    .order-dot {
      width: 8px; height: 8px; border-radius: 50%;
    }
    .order-dot.green { background: #4CAF50; }
    .order-dot.yellow { background: var(--accent); }
    .order-dot.blue { background: var(--periwinkle); }
    .order-name { font-size: .82rem; font-weight: 500; color: var(--text-dark); }
    .order-status {
      font-size: .72rem; padding: .25rem .65rem; border-radius: 100px; font-weight: 500;
    }
    .status-ready { background: #E8F5E9; color: #2E7D32; }
    .status-process { background: #FFF8E1; color: #F57F17; }
    .status-queue { background: var(--pale); color: var(--periwinkle); }
    .mockup-pay-btn {
      width: 100%; background: linear-gradient(135deg, var(--periwinkle), var(--navy));
      color: #fff; border: none; border-radius: 12px; padding: .85rem;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: .88rem;
      cursor: pointer; margin-top: 1rem; transition: opacity .2s;
    }
    .mockup-pay-btn:hover { opacity: .88; }

    /* floating chips */
    .chip {
      position: absolute;
      background: #fff; border-radius: 12px;
      box-shadow: 0 8px 30px rgba(45,51,107,0.12);
      padding: .55rem .9rem;
      display: flex; align-items: center; gap: .5rem;
      font-size: .78rem; font-weight: 500; color: var(--navy);
      border: 1px solid rgba(120,134,199,0.2);
      white-space: nowrap;
    }
    .chip-1 { top: -18px; right: 20px; animation: float 4s ease-in-out infinite; }
    .chip-2 { bottom: 10px; left: -40px; animation: float 4s 1.5s ease-in-out infinite; }
    @keyframes float {
      0%,100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeLeft {
      from { opacity: 0; transform: translateX(32px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* ── FEATURES ── */
    .features {
      padding: 6rem 8vw;
      background: linear-gradient(180deg, var(--white) 0%, var(--pale) 100%);
    }
    .section-label {
      font-size: .78rem; font-weight: 600; letter-spacing: .12em;
      text-transform: uppercase; color: var(--periwinkle);
      margin-bottom: .75rem;
    }
    .section-title {
      font-family: 'DM Sans', sans-serif; font-weight: 700;
      font-size: clamp(1.8rem, 3vw, 2.5rem); color: var(--navy);
      letter-spacing: -.01em; line-height: 1.25;
      margin-bottom: 1rem;
    }
    .section-sub { color: var(--text-mid); font-size: 1rem; line-height: 1.65; max-width: 500px; }

    .features-top { display: flex; flex-direction: column; align-items: flex-start; gap: .75rem; margin-bottom: 3.5rem; }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.2rem;
    }
    .feature-card {
      background: #fff; border-radius: 20px; padding: 1.8rem 1.5rem;
      border: 1.5px solid rgba(120,134,199,0.15);
      transition: all .3s; position: relative; overflow: hidden;
    }
    .feature-card::before {
      content: ''; position: absolute;
      top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--periwinkle), var(--navy));
      transform: scaleX(0); transform-origin: left;
      transition: transform .35s ease;
    }
    .feature-card:hover { transform: translateY(-5px); box-shadow: 0 16px 48px rgba(45,51,107,0.12); border-color: var(--light-periwinkle); }
    .feature-card:hover::before { transform: scaleX(1); }
    .feature-icon {
      width: 48px; height: 48px; border-radius: 14px;
      background: var(--pale); display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem; margin-bottom: 1.2rem;
      transition: background .3s;
    }
    .feature-card:hover .feature-icon { background: #dde2f5; }
    .feature-card h3 {
      font-family: 'Syne', sans-serif; font-weight: 700;
      font-size: 1rem; color: var(--navy); margin-bottom: .5rem;
    }
    .feature-card p { font-size: .84rem; color: var(--text-mid); line-height: 1.6; }

    /* ── ADVANTAGES ── */
    .advantages { padding: 6rem 8vw; background: #fff; }
    .adv-inner {
      display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
    }
    .adv-visual {
      position: relative;
      background: linear-gradient(135deg, var(--navy) 0%, #404a8f 100%);
      border-radius: 28px; padding: 2.5rem;
      min-height: 420px; display: flex; flex-direction: column; justify-content: flex-end;
      overflow: hidden;
    }
    .adv-visual-bg {
      position: absolute; inset: 0; z-index: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
      background-size: 22px 22px;
    }
    .adv-big-num {
      font-family: 'Syne', sans-serif; font-weight: 800;
      font-size: 5rem; color: rgba(255,255,255,0.08);
      line-height: 1; position: absolute; top: 1.5rem; right: 1.5rem;
    }
    .adv-card-grid {
      display: grid; grid-template-columns: 1fr 1fr; gap: .9rem;
      position: relative; z-index: 1;
    }
    .adv-mini-card {
      background: rgba(255,255,255,0.1); border-radius: 14px;
      padding: 1rem; border: 1px solid rgba(255,255,255,0.15);
      backdrop-filter: blur(8px);
    }
    .adv-mini-icon { font-size: 1.4rem; margin-bottom: .4rem; }
    .adv-mini-title { font-family: 'Syne', sans-serif; font-weight: 700; color: #fff; font-size: .88rem; }
    .adv-mini-sub { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: .2rem; line-height: 1.4; }

    .adv-list-title { font-family: 'Syne', sans-serif; font-weight: 800; font-size: clamp(1.7rem,2.8vw,2.3rem); color: var(--navy); letter-spacing: -.025em; line-height: 1.15; margin-bottom: .75rem; }
    .adv-list-sub { color: var(--text-mid); font-size: .95rem; line-height: 1.65; margin-bottom: 2.5rem; }
    .adv-items { display: flex; flex-direction: column; gap: 1.2rem; }
    .adv-item {
      display: flex; gap: 1rem; align-items: flex-start;
      padding: 1.1rem 1.3rem; border-radius: 16px;
      background: var(--pale); border: 1px solid transparent;
      transition: all .25s;
    }
    .adv-item:hover { border-color: var(--light-periwinkle); background: #e8ecf8; transform: translateX(4px); }
    .adv-item-icon {
      width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
      background: var(--periwinkle); display: flex; align-items: center;
      justify-content: center; font-size: 1rem;
    }
    .adv-item h4 { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--navy); font-size: .9rem; margin-bottom: .2rem; }
    .adv-item p { font-size: .8rem; color: var(--text-mid); line-height: 1.55; }

    /* ── CTA BANNER ── */
    .cta-section {
      margin: 0 6vw 5rem;
      background: linear-gradient(135deg, var(--navy) 0%, #4a55a0 100%);
      border-radius: 28px; padding: 4rem 5vw;
      display: flex; align-items: center; justify-content: space-between; gap: 2rem;
      position: relative; overflow: hidden;
    }
    .cta-section-bg {
      position: absolute; inset: 0; z-index: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
      background-size: 24px 24px;
    }
    .cta-glow {
      position: absolute; right: -60px; top: -60px;
      width: 280px; height: 280px; border-radius: 50%;
      background: rgba(120,134,199,0.25); filter: blur(60px);
    }
    .cta-text { position: relative; z-index: 1; }
    .cta-text h2 { font-family: 'Syne', sans-serif; font-weight: 800; font-size: clamp(1.6rem,3vw,2.2rem); color: #fff; letter-spacing: -.02em; margin-bottom: .6rem; }
    .cta-text p { color: rgba(255,255,255,.7); font-size: .95rem; line-height: 1.6; }
    .cta-actions { position: relative; z-index: 1; display: flex; gap: 1rem; flex-shrink: 0; flex-wrap: wrap; }
    .btn-white {
      background: #fff; color: var(--navy);
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: .9rem;
      padding: .9rem 2rem; border-radius: 12px; text-decoration: none;
      transition: all .25s; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .btn-white:hover { background: var(--pale); transform: translateY(-2px); }
    .btn-outline-white {
      background: transparent; color: #fff;
      font-family: 'Syne', sans-serif; font-weight: 600; font-size: .9rem;
      padding: .9rem 2rem; border-radius: 12px; text-decoration: none;
      border: 2px solid rgba(255,255,255,.4); transition: all .25s;
    }
    .btn-outline-white:hover { background: rgba(255,255,255,.1); transform: translateY(-2px); }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
      .features-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
      .hero { grid-template-columns: 1fr; padding: 6rem 6vw 4rem; gap: 3rem; }
      .hero-right { display: none; }
      .features-grid { grid-template-columns: 1fr; }
      .adv-inner { grid-template-columns: 1fr; gap: 3rem; }
      .adv-visual { min-height: 280px; }
      .cta-section { flex-direction: column; text-align: center; }
      .cta-actions { justify-content: center; }
      .features-top { flex-direction: column; }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-logo">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
      <rect width="24" height="24" rx="6" fill="#2D336B"/>
      <path d="M6 8h12M8 12h8M10 16h4" stroke="white" stroke-width="2" stroke-linecap="round"/>
    </svg>
    Cantenn <span>Digital</span>
  </div>
  <div style="display:flex;gap:.75rem;align-items:center;">
    <a href="{{ route('login') }}" style="font-family:'Syne',sans-serif;font-weight:600;font-size:.82rem;color:var(--navy);text-decoration:none;letter-spacing:.02em;">Masuk</a>
    <a href="{{ route('register') }}" class="nav-pill">Daftar Sekarang →</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-dot-grid"></div>

  <div class="hero-left">
    <div class="hero-badge">
      <div class="hero-badge-dot"></div>
      Sistem Kantin Digital Terpadu
    </div>
    <h1>Solusi Kantin Sekolah yang Lebih <em>Praktis & Modern</em></h1>
    <p class="hero-desc">Pesan makanan, bayar cashless, dan pantau transaksi — semua dalam satu platform yang dirancang khusus untuk lingkungan sekolah.</p>
    <div class="hero-cta">
      <a href="{{ route('register') }}" class="btn-primary">
        Daftar Sekarang
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <a href="{{ route('login') }}" class="btn-secondary">Sudah Punya Akun? Masuk</a>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features" id="features">
  <div class="features-top">
    <div>
      <div class="section-label">Fitur Utama</div>
      <h2 class="section-title">Semua yang Kamu Butuhkan<br>dalam Satu Platform</h2>
    </div>
    <p class="section-sub">Dirancang untuk memudahkan siswa, guru, dan pengelola kantin dalam satu ekosistem digital yang terintegrasi.</p>
  </div>
  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">🛒</div>
      <h3>Pemesanan Online</h3>
      <p>Pesan menu favoritmu kapan saja dan dari mana saja. Tidak perlu antri panjang di kantin lagi.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">💳</div>
      <h3>Pembayaran Digital</h3>
      <p>Transaksi cashless yang aman dan cepat. Dukung berbagai metode pembayaran elektronik.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🗂️</div>
      <h3>Manajemen Menu</h3>
      <p>Admin dapat mengelola menu, stok, dan harga secara real-time dengan mudah dari dashboard.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📈</div>
      <h3>Laporan Transaksi</h3>
      <p>Pantau riwayat transaksi dan laporan keuangan harian, mingguan, hingga bulanan secara otomatis.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="cta">
  <div class="cta-section-bg"></div>
  <div class="cta-glow"></div>
  <div class="cta-text">
    <h2>Siap Mengubah Kantin Sekolahmu?</h2>
    <p>Bergabung dengan 50+ sekolah yang sudah merasakan kemudahan Digital Canteen System.</p>
  </div>
  <div class="cta-actions">
    <a href="{{ route('register') }}" class="btn-white">Daftar Sekarang →</a>
    <a href="{{ route('login') }}" class="btn-outline-white">Sudah punya akun? Masuk</a>
  </div>
</section>

</body>
</html>