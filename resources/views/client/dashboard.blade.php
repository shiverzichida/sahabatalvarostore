<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Client - Sahabat Alvaro Store</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Sahabat Steroid flat transparent.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FullCalendar CDN -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <!-- Tippy.js -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.7);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary: #10b981;
            --primary-hover: #059669;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --accent-blue: #3b82f6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.12) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.1) 0, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-main);
            padding: 40px 20px;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 20px;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }

        .brand-logo img {
            height: 44px;
        }

        .brand-logo span {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
        }

        .user-info h2 {
            font-size: 16px;
            font-weight: 700;
        }

        .user-info p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: #ef4444;
            color: #fff;
        }

        /* Dashboard Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Calendar Card */
        .calendar-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 30px;
            backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.1s;
        }

        /* Sidebar Panel */
        .sidebar-panel {
            display: flex;
            flex-direction: column;
            gap: 24px;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s;
        }

        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 24px;
            backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .glass-card h3 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.2px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        .input-control {
            width: 100%;
            padding: 10px 14px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-btn:hover {
            background: var(--primary-hover);
        }

        /* Tables & Lists */
        .request-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .request-item:last-child {
            border-bottom: none;
        }

        .request-info h4 {
            font-size: 14px;
            font-weight: 600;
        }

        .request-info p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        /* FullCalendar Custom CSS */
        .fc {
            --fc-border-color: rgba(255, 255, 255, 0.08);
            --fc-page-bg-color: transparent;
            --fc-event-bg-color: #10b981;
            --fc-event-border-color: #10b981;
            --fc-today-bg-color: rgba(16, 185, 129, 0.08);
            color: var(--text-main);
        }

        .fc .fc-toolbar-title {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .fc .fc-button-primary {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: var(--card-border);
            color: var(--text-main);
        }

        .fc .fc-button-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .fc-event {
            border-radius: 6px;
            padding: 3px 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Navigation Bar */
        .main-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(16px);
            padding: 14px 28px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            flex-wrap: wrap;
            gap: 16px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-item {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.3s, transform 0.2s;
            cursor: pointer;
        }

        .nav-item:hover, .nav-item.active {
            color: var(--primary);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-brand img {
            height: 32px;
        }

        .nav-brand span {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #ef4444;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #ef4444;
            color: #fff;
            transform: translateY(-1px);
        }

        @media (max-width: 992px) {
            .progress-grid-layout {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Main Navbar -->
    <nav class="main-navbar">
        <div style="display: flex; align-items: center; gap: 30px;">
            <a href="{{ url('/') }}" class="nav-brand">
                <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Sahabat Alvaro Logo">
                <span>Sahabat Alvaro</span>
            </a>
            <div class="nav-links">
                <a href="#section-calendar" class="nav-item">Jadwal Vitamin</a>
                <a href="#section-progress" class="nav-item">Progres Fisik</a>
                <a href="#section-request" class="nav-item">Minta Vitamin</a>
            </div>
        </div>

        <div class="user-nav">
            <div class="user-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p style="font-size: 11px; color: var(--text-muted);">{{ Auth::user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </nav>

    <!-- Profil Fisik Summary & Stats Row -->
    @php
        $latestProgress = $progressLogs->last();
        $initialWeight = $profile->initial_weight;
        $currentWeight = $latestProgress ? $latestProgress->weight : $initialWeight;
        $weightDiff = $currentWeight - $initialWeight;

        $initialBodyFat = $profile->initial_body_fat;
        $currentBodyFat = $latestProgress && $latestProgress->body_fat ? $latestProgress->body_fat : $initialBodyFat;
        $bodyFatDiff = ($currentBodyFat && $initialBodyFat) ? ($currentBodyFat - $initialBodyFat) : null;
    @endphp
    
    <div class="stats-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; animation: fadeIn 0.9s ease-out;">
        <!-- Tinggi Badan -->
        <div class="glass-card" style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tinggi Badan</span>
            <div style="display: flex; align-items: baseline; gap: 4px;">
                <span style="font-size: 26px; font-weight: 800; color: #fff;">{{ number_format($latestProgress ? $latestProgress->height : $profile->initial_height, 1) }}</span>
                <span style="font-size: 14px; color: var(--text-muted);">cm</span>
            </div>
        </div>
        
        <!-- Berat Badan -->
        <div class="glass-card" style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Berat Badan</span>
            <div style="display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap;">
                <span style="font-size: 26px; font-weight: 800; color: #fff;">{{ number_format($currentWeight, 1) }}</span>
                <span style="font-size: 14px; color: var(--text-muted);">kg</span>
                @if($weightDiff != 0)
                    <span style="font-size: 12px; font-weight: 700; color: {{ $weightDiff < 0 ? '#10b981' : '#3b82f6' }}; padding: 2px 6px; background: {{ $weightDiff < 0 ? 'rgba(16,185,129,0.1)' : 'rgba(59,130,246,0.1)' }}; border-radius: 4px;">
                        {{ $weightDiff > 0 ? '+' : '' }}{{ number_format($weightDiff, 1) }} kg
                    </span>
                @endif
            </div>
        </div>

        <!-- Body Fat -->
        <div class="glass-card" style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Lemak Tubuh (Body Fat)</span>
            <div style="display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap;">
                <span style="font-size: 26px; font-weight: 800; color: #fff;">{{ $currentBodyFat ? number_format($currentBodyFat, 1) . '%' : '-' }}</span>
                @if($bodyFatDiff !== null && $bodyFatDiff != 0)
                    <span style="font-size: 12px; font-weight: 700; color: {{ $bodyFatDiff < 0 ? '#10b981' : '#ef4444' }}; padding: 2px 6px; background: {{ $bodyFatDiff < 0 ? 'rgba(16,185,129,0.1)' : 'rgba(239,68,68,0.1)' }}; border-radius: 4px;">
                        {{ $bodyFatDiff > 0 ? '+' : '' }}{{ number_format($bodyFatDiff, 1) }}%
                    </span>
                @endif
            </div>
        </div>

        <!-- Target & Kelamin -->
        <div class="glass-card" style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Profil & Target Gym</span>
            <div>
                <span style="font-size: 15px; font-weight: 700; color: #fff; display: block;">{{ $profile->gender }}</span>
                <span style="font-size: 13px; color: var(--primary); font-weight: 600; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $profile->goal ?? 'Kebugaran Umum' }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-card" style="margin-bottom: 24px; padding: 16px 24px; border-color: rgba(16, 185, 129, 0.3); color: #10b981; background: rgba(16, 185, 129, 0.08);">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <!-- Layout Grid -->
    <div class="dashboard-grid">
        <!-- Kalender -->
        <div class="calendar-card" id="section-calendar" style="scroll-margin-top: 20px;">
            <div id="calendar"></div>
        </div>

        <!-- Sidebar Panel -->
        <div class="sidebar-panel" id="section-request" style="scroll-margin-top: 20px;">
            <!-- Form Minta Jadwal -->
            <div class="glass-card">
                <h3>Minta Jadwal Vitamin</h3>
                <form action="{{ route('client.request.store') }}" method="POST">
                    @csrf
                    
                    <div id="request-items-container">
                        <div class="request-row mb-3" data-index="0" style="background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; position: relative;">
                            <button type="button" class="remove-row-btn" style="position: absolute; right: 12px; top: 12px; background: none; border: none; color: #ef4444; cursor: pointer; font-size: 20px; font-weight: 700; line-height: 1; display: none;">&times;</button>
                            
                            <div class="form-group mb-3" style="position: relative;">
                                <label class="form-label">Nama Vitamin / Suplemen</label>
                                <input type="text" name="items[0][vitamin_select]" class="input-control search-vitamin-input" placeholder="Ketik untuk mencari/mengisi..." autocomplete="off" required>
                                <div class="suggestions-dropdown d-none" style="position: absolute; left: 0; right: 0; top: 100%; background: #1f2937; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; z-index: 999; max-height: 180px; overflow-y: auto; box-shadow: 0 10px 20px rgba(0,0,0,0.5); margin-top: 4px;"></div>
                                <input type="hidden" name="items[0][vitamin_manual]" value="">
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Catatan Tambahan (Optional)</label>
                                <textarea name="items[0][notes]" class="input-control" rows="2" placeholder="Contoh: Tiap pagi sesudah makan"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-row-btn" class="submit-btn" style="background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); color: #60a5fa; margin-bottom: 16px; font-weight: 600;">
                        + Tambah Vitamin Lain
                    </button>

                    <button type="submit" class="submit-btn">Kirim Permintaan</button>
                </form>
            </div>

            <!-- List Request -->
            <div class="glass-card">
                <h3>Permintaan Terkini</h3>
                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse($requests as $req)
                        <div class="request-item">
                            <div class="request-info">
                                <h4>{{ $req->vitamin_name }} @if($req->dosage)<span style="font-weight: 500; opacity: 0.8; font-size: 13px;">({{ $req->dosage }})</span>@endif</h4>
                                <p>{{ $req->created_at->format('d M Y - H:i') }}</p>
                            </div>
                            <span class="status-badge {{ $req->status === 'approved' ? 'status-approved' : 'status-pending' }}">
                                {{ $req->status === 'approved' ? 'Disetujui' : 'Pending' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted" style="text-align: center; font-size: 13px; padding: 12px 0;">Belum ada riwayat permintaan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Section Progres Fisik -->
    <div id="section-progress" style="margin-top: 32px; margin-bottom: 24px; animation: fadeIn 1.1s ease-out; scroll-margin-top: 20px;">
        <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px; background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Progres & Statistik Fisik</h2>
        
        <div class="progress-grid-layout" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">
            
            <!-- Chart.js Trend Line -->
            <div class="glass-card" style="padding: 24px; display: flex; flex-direction: column; min-height: 400px; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Grafik Trend Perkembangan</h3>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px;">Visualisasi perubahan berat badan dan kadar lemak tubuh (body fat) Anda dari waktu ke waktu.</p>
                </div>
                <div style="flex-grow: 1; min-height: 280px; position: relative;">
                    <canvas id="progressChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>

            <!-- Log Form & History -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <!-- Input Progres Baru -->
                <div class="glass-card" style="padding: 24px;">
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Catat Progres Baru</h3>
                    <form action="{{ route('client.progress.store') }}" method="POST">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                            <div class="form-group mb-0">
                                <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Tanggal Log</label>
                                <input type="date" name="log_date" class="input-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Tinggi (cm)</label>
                                <input type="number" step="0.1" name="height" class="input-control" value="{{ $latestProgress ? number_format($latestProgress->height, 1, '.', '') : number_format($profile->initial_height, 1, '.', '') }}" required>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                            <div class="form-group mb-0">
                                <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Berat (kg)</label>
                                <input type="number" step="0.1" name="weight" class="input-control" value="{{ $latestProgress ? number_format($latestProgress->weight, 1, '.', '') : number_format($profile->initial_weight, 1, '.', '') }}" required>
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Body Fat % (Optional)</label>
                                <input type="number" step="0.1" name="body_fat" class="input-control" value="{{ $latestProgress && $latestProgress->body_fat ? number_format($latestProgress->body_fat, 1, '.', '') : ($profile->initial_body_fat ? number_format($profile->initial_body_fat, 1, '.', '') : '') }}">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Catatan (Optional)</label>
                            <input type="text" name="notes" class="input-control" placeholder="Contoh: Perut terasa lebih ramping" style="font-size: 14px;">
                        </div>
                        <button type="submit" class="submit-btn" style="background: linear-gradient(135deg, var(--accent-blue) 0%, #1e40af 100%); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2); width:100%; border:none; padding:12px; border-radius:10px; color:#fff; font-weight:700; cursor:pointer; font-size: 14px; transition: all 0.3s;">Simpan Progres</button>
                    </form>
                </div>

                <!-- Riwayat Catatan -->
                <div class="glass-card" style="padding: 20px;">
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">Riwayat Log Progres</h3>
                    <div style="max-height: 200px; overflow-y: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); color: var(--text-muted);">
                                    <th style="padding: 8px 4px;">Tanggal</th>
                                    <th style="padding: 8px 4px;">BB (kg)</th>
                                    <th style="padding: 8px 4px;">TB (cm)</th>
                                    <th style="padding: 8px 4px;">Fat %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progressLogs->reverse() as $log)
                                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                        <td style="padding: 8px 4px; color: #cbd5e1;">{{ date('d/m/Y', strtotime($log->log_date)) }}</td>
                                        <td style="padding: 8px 4px; font-weight:700; color: #fff;">{{ number_format($log->weight, 1) }}</td>
                                        <td style="padding: 8px 4px; color: #cbd5e1;">{{ number_format($log->height, 1) }}</td>
                                        <td style="padding: 8px 4px; color: #cbd5e1;">{{ $log->body_fat ? number_format($log->body_fat, 1) . '%' : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var eventsData = @json($events);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            firstDay: 1,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: eventsData,
            eventDidMount: function(info) {
                tippy(info.el, {
                    content: `
                        <div style="padding: 8px; text-align: left;">
                            <strong style="display:block; margin-bottom:4px; font-size:13px;">${info.event.title}</strong>
                            <p style="font-size:12px; color:#cbd5e1; line-height:1.4;">${info.event.extendedProps.description || 'Tidak ada catatan tambahan.'}</p>
                        </div>
                    `,
                    allowHTML: true,
                    theme: 'dark',
                    placement: 'top',
                    arrow: true
                });
            }
        });
        calendar.render();

        // Autocomplete Catalog & Repeater logic
        const catalogProducts = @json($products->pluck('name'));
        let rowIndex = 0;

        function initAutocomplete(row) {
            const input = row.querySelector('.search-vitamin-input');
            const dropdown = row.querySelector('.suggestions-dropdown');

            input.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                dropdown.innerHTML = '';
                
                if (!query) {
                    dropdown.classList.add('d-none');
                    return;
                }

                const matches = catalogProducts.filter(p => p.toLowerCase().includes(query));

                if (matches.length === 0) {
                    dropdown.innerHTML = `
                        <div class="suggestion-item" style="padding: 10px 14px; color: var(--text-muted); font-size: 13px; cursor: pointer;">
                            Tidak ada di katalog (Ketik kustom)
                        </div>
                    `;
                } else {
                    matches.forEach(match => {
                        const item = document.createElement('div');
                        item.className = 'suggestion-item';
                        item.style.padding = '10px 14px';
                        item.style.fontSize = '13px';
                        item.style.cursor = 'pointer';
                        item.style.transition = 'background 0.2s';
                        item.style.borderBottom = '1px solid rgba(255,255,255,0.03)';
                        item.innerHTML = match.replace(new RegExp(query, 'gi'), m => `<strong>${m}</strong>`);
                        
                        item.addEventListener('mouseenter', () => item.style.backgroundColor = 'rgba(255,255,255,0.05)');
                        item.addEventListener('mouseleave', () => item.style.backgroundColor = 'transparent');
                        
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            input.value = match;
                            dropdown.classList.add('d-none');
                            dropdown.innerHTML = '';
                        });
                        dropdown.appendChild(item);
                    });
                }
                dropdown.classList.remove('d-none');
            });

            // Sembunyikan dropdown saat klik di luar
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('d-none');
                }
            });

            input.addEventListener('focus', function() {
                if (this.value.trim().length > 0) {
                    dropdown.classList.remove('d-none');
                }
            });
        }

        // Jalankan untuk baris pertama
        const firstRow = document.querySelector('.request-row');
        if (firstRow) initAutocomplete(firstRow);

        // Tambah baris baru
        document.getElementById('add-row-btn').addEventListener('click', function() {
            rowIndex++;
            const container = document.getElementById('request-items-container');
            const newRow = document.createElement('div');
            newRow.className = 'request-row mb-3';
            newRow.setAttribute('data-index', rowIndex);
            newRow.style.cssText = 'background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; position: relative;';
            
            newRow.innerHTML = `
                <button type="button" class="remove-row-btn" style="position: absolute; right: 12px; top: 12px; background: none; border: none; color: #ef4444; cursor: pointer; font-size: 20px; font-weight: 700; line-height: 1;">&times;</button>
                
                <div class="form-group mb-3" style="position: relative;">
                    <label class="form-label">Nama Vitamin / Suplemen</label>
                    <input type="text" name="items[${rowIndex}][vitamin_select]" class="input-control search-vitamin-input" placeholder="Ketik untuk mencari/mengisi..." autocomplete="off" required>
                    <div class="suggestions-dropdown d-none" style="position: absolute; left: 0; right: 0; top: 100%; background: #1f2937; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; z-index: 999; max-height: 180px; overflow-y: auto; box-shadow: 0 10px 20px rgba(0,0,0,0.5); margin-top: 4px;"></div>
                    <input type="hidden" name="items[${rowIndex}][vitamin_manual]" value="">
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Catatan Tambahan (Optional)</label>
                    <textarea name="items[${rowIndex}][notes]" class="input-control" rows="2" placeholder="Contoh: Tiap pagi sesudah makan"></textarea>
                </div>
            `;
            
            container.appendChild(newRow);
            initAutocomplete(newRow);
            updateRemoveButtons();
        });

        // Hapus baris
        document.getElementById('request-items-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row-btn')) {
                const row = e.target.closest('.request-row');
                row.remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.request-row');
            rows.forEach(row => {
                const btn = row.querySelector('.remove-row-btn');
                if (rows.length > 1) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        }

        // Setup Chart.js untuk Progres Fisik
        const progressData = @json($progressLogs);
        const chartLabels = progressData.map(log => {
            const date = new Date(log.log_date);
            return date.getDate().toString().padStart(2, '0') + '/' + (date.getMonth() + 1).toString().padStart(2, '0');
        });
        const weightData = progressData.map(log => parseFloat(log.weight));
        const bodyFatData = progressData.map(log => log.body_fat ? parseFloat(log.body_fat) : null);

        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Berat Badan (kg)',
                        data: weightData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Body Fat (%)',
                        data: bodyFatData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        borderWidth: 2,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        yAxisID: 'y1',
                        spanGaps: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#cbd5e1',
                            font: {
                                family: "'Outfit', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        padding: 10,
                        titleFont: { family: "'Outfit', sans-serif" },
                        bodyFont: { family: "'Outfit', sans-serif" }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.03)'
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: { family: "'Outfit', sans-serif" }
                        }
                    },
                    y: {
                        position: 'left',
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#3b82f6',
                            font: { family: "'Outfit', sans-serif" }
                        },
                        title: {
                            display: true,
                            text: 'Berat (kg)',
                            color: '#3b82f6',
                            font: { family: "'Outfit', sans-serif", weight: 'bold' }
                        }
                    },
                    y1: {
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: '#10b981',
                            font: { family: "'Outfit', sans-serif" }
                        },
                        title: {
                            display: true,
                            text: 'Body Fat (%)',
                            color: '#10b981',
                            font: { family: "'Outfit', sans-serif", weight: 'bold' }
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>
