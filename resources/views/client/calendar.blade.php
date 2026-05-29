@extends('layouts.client')

@section('title', 'Jadwal Vitamin')

@section('content')
<div style="animation: fadeIn 0.8s ease-out;">
    <div class="glass-card" style="padding: 24px; min-height: 500px;">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('scripts')
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
    });
</script>
@endsection
