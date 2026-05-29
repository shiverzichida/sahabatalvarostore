<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor Client') - Sahabat Alvaro Store</title>
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
            --sidebar-width: 260px;
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
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.08) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.07) 0, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-main);
            display: flex;
        }

        /* Layout wrapper */
        .layout-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(17, 24, 39, 0.85);
            border-right: 1px solid var(--card-border);
            backdrop-filter: blur(20px);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            padding: 24px;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 32px;
        }

        .sidebar-brand img {
            height: 38px;
        }

        .sidebar-brand span {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* User profile widget in sidebar */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent-blue) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .user-meta {
            overflow: hidden;
        }

        .user-meta h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-meta p {
            font-size: 11px;
            color: var(--text-muted);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Sidebar Menu Links */
        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .menu-item a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .menu-item.active a {
            color: #fff;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .logout-btn-sidebar {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #f87171;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            margin-top: auto;
        }

        .logout-btn-sidebar:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Main Content Panel */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            padding: 40px;
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Mobile top header */
        .mobile-header {
            display: none;
            height: 60px;
            background: rgba(17, 24, 39, 0.85);
            border-bottom: 1px solid var(--card-border);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99;
        }

        .hamburger-btn {
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 98;
        }

        /* Responsive Grid & Containers */
        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(16px);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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

        .input-control {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            background: rgba(15, 23, 42, 0.8);
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary) 0%, #059669 100%);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            text-align: center;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile Adjustments */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 80px 16px 40px 16px; /* Top padding is large to avoid overlaps with the mobile header */
            }

            .mobile-header {
                display: flex;
            }

            .stats-row {
                grid-template-columns: 1fr 1fr !important;
            }
        }

        @media (max-width: 576px) {
            .stats-row {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
    @yield('head_extra')
</head>
<body>

    <div class="layout-wrapper">
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Left Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/') }}" class="sidebar-brand">
                <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Logo">
                <span>Sahabat Alvaro</span>
            </a>

            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-meta">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item {{ Route::is('client.calendar') ? 'active' : '' }}">
                    <a href="{{ route('client.calendar') }}">
                        <span>📅</span> Jadwal Vitamin
                    </a>
                </li>
                <li class="menu-item {{ Route::is('client.progress') ? 'active' : '' }}">
                    <a href="{{ route('client.progress') }}">
                        <span>📈</span> Progres Fisik
                    </a>
                </li>
                <li class="menu-item {{ Route::is('client.request') ? 'active' : '' }}">
                    <a href="{{ route('client.request') }}">
                        <span>📥</span> Minta Vitamin
                    </a>
                </li>
            </ul>

            <form action="{{ route('logout') }}" method="POST" id="logout-sidebar-form">
                @csrf
                <button type="submit" class="logout-btn-sidebar">
                    <span>🚪</span> Keluar / Logout
                </button>
            </form>
        </aside>

        <!-- Mobile Header -->
        <header class="mobile-header">
            <button class="hamburger-btn" id="menuToggle">☰</button>
            <div style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Logo" style="height: 30px;">
                <span style="font-weight: 800; font-size: 15px;">Sahabat Alvaro</span>
            </div>
            <div style="width: 38px;"></div> <!-- Spacer to center the logo -->
        </header>

        <!-- Main Content Pane -->
        <main class="main-content">
            
            <!-- Global Stats Widget Row -->
            @php
                $latestProgress = $progressLogs->last();
                $initialWeight = $profile->initial_weight;
                $currentWeight = $latestProgress ? $latestProgress->weight : $initialWeight;
                $weightDiff = $currentWeight - $initialWeight;

                $initialBodyFat = $profile->initial_body_fat;
                $currentBodyFat = $latestProgress && $latestProgress->body_fat ? $latestProgress->body_fat : $initialBodyFat;
                $bodyFatDiff = ($currentBodyFat && $initialBodyFat) ? ($currentBodyFat - $initialBodyFat) : null;
            @endphp
            
            <div class="stats-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; animation: fadeIn 0.8s ease-out;">
                <!-- Tinggi Badan -->
                <div class="glass-card" style="padding: 16px 20px; display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tinggi Badan</span>
                    <div style="display: flex; align-items: baseline; gap: 4px;">
                        <span style="font-size: 24px; font-weight: 800; color: #fff;">{{ number_format($latestProgress ? $latestProgress->height : $profile->initial_height, 1) }}</span>
                        <span style="font-size: 13px; color: var(--text-muted);">cm</span>
                    </div>
                </div>
                
                <!-- Berat Badan -->
                <div class="glass-card" style="padding: 16px 20px; display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Berat Badan</span>
                    <div style="display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap;">
                        <span style="font-size: 24px; font-weight: 800; color: #fff;">{{ number_format($currentWeight, 1) }}</span>
                        <span style="font-size: 13px; color: var(--text-muted);">kg</span>
                        @if($weightDiff != 0)
                            <span style="font-size: 11px; font-weight: 700; color: {{ $weightDiff < 0 ? '#10b981' : '#3b82f6' }}; padding: 1px 5px; background: {{ $weightDiff < 0 ? 'rgba(16,185,129,0.1)' : 'rgba(59,130,246,0.1)' }}; border-radius: 4px;">
                                {{ $weightDiff > 0 ? '+' : '' }}{{ number_format($weightDiff, 1) }} kg
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Body Fat -->
                <div class="glass-card" style="padding: 16px 20px; display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Body Fat</span>
                    <div style="display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap;">
                        <span style="font-size: 24px; font-weight: 800; color: #fff;">{{ $currentBodyFat ? number_format($currentBodyFat, 1) . '%' : '-' }}</span>
                        @if($bodyFatDiff !== null && $bodyFatDiff != 0)
                            <span style="font-size: 11px; font-weight: 700; color: {{ $bodyFatDiff < 0 ? '#10b981' : '#ef4444' }}; padding: 1px 5px; background: {{ $bodyFatDiff < 0 ? 'rgba(16,185,129,0.1)' : 'rgba(239,68,68,0.1)' }}; border-radius: 4px;">
                                {{ $bodyFatDiff > 0 ? '+' : '' }}{{ number_format($bodyFatDiff, 1) }}%
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Target -->
                <div class="glass-card" style="padding: 16px 20px; display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Target Gym</span>
                    <span style="font-size: 14px; font-weight: 700; color: var(--primary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $profile->goal ?? 'Kebugaran Umum' }}
                    </span>
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="glass-card" style="margin-bottom: 24px; padding: 16px 24px; border-color: rgba(16, 185, 129, 0.3); color: #10b981; background: rgba(16, 185, 129, 0.08); font-size: 14px; animation: fadeIn 0.5s ease;">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif

            <!-- Main Content Yield -->
            @yield('content')
        </main>
    </div>

    <!-- Toggle Sidebar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
