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
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <header class="dashboard-header">
        <a href="{{ url('/') }}" class="brand-logo">
            <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Sahabat Alvaro Logo">
            <span>Sahabat Alvaro</span>
        </a>

        <div class="user-nav">
            <div class="user-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </header>

    @if(session('success'))
        <div class="glass-card" style="margin-bottom: 24px; padding: 16px 24px; border-color: rgba(16, 185, 129, 0.3); color: #10b981; background: rgba(16, 185, 129, 0.08);">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <!-- Layout Grid -->
    <div class="dashboard-grid">
        <!-- Kalender -->
        <div class="calendar-card">
            <div id="calendar"></div>
        </div>

        <!-- Sidebar Panel -->
        <div class="sidebar-panel">
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
    });
</script>

</body>
</html>
