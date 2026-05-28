<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Planner Vitamin - {{ $client_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Sahabat Steroid flat transparent.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FullCalendar CDN -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <!-- Tippy.js (for beautiful tooltips) -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
    
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.7);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --accent-success: #10b981;
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
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.15) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-main);
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Area */
        .planner-header {
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
            height: 48px;
            width: auto;
        }

        .brand-logo span {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .client-info-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 16px 24px;
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .client-info-card h2 {
            font-size: 18px;
            font-weight: 700;
        }

        .client-info-card p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .client-badge {
            background: rgba(59, 130, 246, 0.15);
            color: var(--primary);
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }

        /* Layout Grid */
        .planner-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .planner-grid {
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

        /* FullCalendar Customizations */
        .fc {
            --fc-border-color: rgba(255, 255, 255, 0.08);
            --fc-page-bg-color: transparent;
            --fc-event-bg-color: #3b82f6;
            --fc-event-border-color: #3b82f6;
            --fc-today-bg-color: rgba(59, 130, 246, 0.08);
            color: var(--text-main);
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .fc .fc-button-primary {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: var(--card-border);
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .fc .fc-button-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .fc .fc-button-primary:disabled {
            background-color: rgba(255, 255, 255, 0.02);
            border-color: var(--card-border);
            color: var(--text-muted);
        }

        .fc-daygrid-day-number {
            font-weight: 500;
            color: #cbd5e1;
            padding: 6px !important;
        }

        .fc-col-header-cell-cushion {
            font-weight: 600;
            color: var(--text-muted);
            padding: 10px 0 !important;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .fc-event {
            border-radius: 6px;
            padding: 4px 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
        }

        .fc-event:hover {
            transform: scale(1.02);
        }

        /* Sidebar Info & Action Card */
        .sidebar-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
            backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s;
        }

        .sidebar-card h3 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.2px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 12px;
            margin-bottom: 4px;
        }

        .vitamin-item-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
        }

        .vitamin-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary);
            flex-shrink: 0;
        }

        .vitamin-name-text {
            font-weight: 600;
            font-size: 14px;
        }

        .vitamin-desc-text {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .action-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .action-button:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
        }

        .action-button:active {
            transform: translateY(1px);
        }

        .action-button-outline {
            background: transparent;
            border: 1px solid var(--card-border);
            box-shadow: none;
        }

        .action-button-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            transform: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <header class="planner-header">
        <a href="{{ url('/') }}" class="brand-logo">
            <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Sahabat Alvaro Logo">
            <span>Sahabat Alvaro</span>
        </a>

        <div class="client-info-card">
            <div>
                <p>Nama Client</p>
                <h2>{{ $client_name }}</h2>
            </div>
            <div class="client-badge">
                {{ $code }}
            </div>
        </div>
    </header>

    <!-- Grid -->
    <div class="planner-grid">
        <!-- Calendar Card -->
        <div class="calendar-card">
            <div id="calendar"></div>
        </div>

        <!-- Sidebar Info -->
        <div class="sidebar-card">
            <div>
                <h3>Daftar Vitamin / Suplemen</h3>
                <div style="margin-top: 8px;">
                    @foreach($schedules as $sched)
                        <div class="vitamin-item-row">
                            <div class="vitamin-indicator"></div>
                            <div>
                                <div class="vitamin-name-text">{{ $sched->vitamin_name }} ({{ $sched->dosage }})</div>
                                <div class="vitamin-desc-text">
                                    {{ date('j M', strtotime($sched->start_date)) }} - {{ date('j M Y', strtotime($sched->end_date)) }}
                                    <br>
                                    @if($sched->frequency === 'daily')
                                        Setiap Hari
                                    @elseif($sched->frequency === 'every_other_day')
                                        2 Hari Sekali
                                    @elseif($sched->frequency === 'twice_weekly')
                                        2x Seminggu ({{ str_replace(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'], ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'], $sched->days_of_week) }})
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="margin-top: auto; display: flex; flex-direction: column; gap: 12px;">
                <h3>Ekspor Kalender</h3>
                <a href="{{ route('planner.export', $code) }}" class="action-button">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download File .ics (iCal)
                </a>
                
                <a href="https://support.google.com/calendar/answer/37118" target="_blank" class="action-button action-button-outline">
                    Cara Impor ke Google Calendar &rarr;
                </a>
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
            firstDay: 1, // Start week on Monday
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: eventsData,
            eventDidMount: function(info) {
                // Initialize beautiful Tippy.js tooltip for each event
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
    });
</script>

</body>
</html>
