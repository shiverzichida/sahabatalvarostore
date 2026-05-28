@extends('admin.layouts.app')

@section('title', 'Manajemen Jadwal Vitamin Client')

@section('css')
<style>
    .client-link-copy {
        cursor: pointer;
        color: #2563eb;
        text-decoration: underline;
        font-weight: 600;
    }
    .client-link-copy:hover {
        color: #1d4ed8;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Form Tambah Jadwal -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Jadwal Baru</h3>
            </div>
            <form action="{{ route('admin.planner.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="client_name">Nama Client</label>
                        <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Nama lengkap client" required>
                    </div>

                    <div class="form-group">
                        <label for="client_code">Kode Client (Optional)</label>
                        <input type="text" name="client_code" id="client_code" class="form-control" placeholder="Kosongkan untuk auto-generate (misal: SA-G2K89)">
                    </div>

                    <div class="form-group">
                        <label for="vitamin_name">Nama Vitamin / Suplemen</label>
                        <input type="text" name="vitamin_name" id="vitamin_name" class="form-control" placeholder="Contoh: Vitamin C, Vitamin D3, Fish Oil" required>
                    </div>

                    <div class="form-group">
                        <label for="dosage">Dosis</label>
                        <input type="text" name="dosage" id="dosage" class="form-control" placeholder="Contoh: 500mg, 1 tablet, 1000 IU" required>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="frequency">Frekuensi Konsumsi</label>
                        <select name="frequency" id="frequency" class="form-control" required>
                            <option value="daily">Setiap Hari (Daily)</option>
                            <option value="every_other_day">Dua Hari Sekali (Every Other Day)</option>
                            <option value="twice_weekly">Dua Kali Seminggu (Twice Weekly)</option>
                        </select>
                    </div>

                    <!-- Pilihan Hari (Hanya muncul jika twice_weekly dipilih) -->
                    <div class="form-group d-none" id="days-selector">
                        <label>Pilih 2 Hari Preferensi</label>
                        <div class="row">
                            @foreach(['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'] as $eng => $indo)
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input day-checkbox" type="checkbox" name="days_of_week[]" id="day-{{ $eng }}" value="{{ $eng }}">
                                        <label class="custom-control-label" for="day-{{ $eng }}">{{ $indo }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan Tambahan</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Contoh: Diminum sesudah makan pagi"></textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Jadwal Client -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Jadwal Vitamin Client</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Nama Client</th>
                            <th>Kode Link (Click to Copy)</th>
                            <th>Vitamin</th>
                            <th>Dosis</th>
                            <th>Periode</th>
                            <th>Frekuensi</th>
                            <th style="width: 40px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $sched)
                            <tr>
                                <td class="align-middle"><strong>{{ $sched->client_name }}</strong></td>
                                <td class="align-middle">
                                    <span class="client-link-copy" onclick="copyPlannerLink('{{ $sched->client_code }}', this)">
                                        {{ $sched->client_code }}
                                    </span>
                                </td>
                                <td class="align-middle">{{ $sched->vitamin_name }}</td>
                                <td class="align-middle"><span class="badge badge-info">{{ $sched->dosage }}</span></td>
                                <td class="align-middle">
                                    <small>{{ date('d/m/Y', strtotime($sched->start_date)) }} - {{ date('d/m/Y', strtotime($sched->end_date)) }}</small>
                                </td>
                                <td class="align-middle">
                                    @if($sched->frequency === 'daily')
                                        Setiap Hari
                                    @elseif($sched->frequency === 'every_other_day')
                                        2 Hari Sekali
                                    @elseif($sched->frequency === 'twice_weekly')
                                        2x Seminggu ({{ str_replace(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'], ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'], $sched->days_of_week) }})
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <form action="{{ route('admin.planner.destroy', $sched) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada jadwal yang dimasukkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Show/hide selector hari berdasarkan pilihan frekuensi
    $('#frequency').change(function() {
        if ($(this).val() === 'twice_weekly') {
            $('#days-selector').removeClass('d-none');
        } else {
            $('#days-selector').addClass('d-none');
            $('.day-checkbox').prop('checked', false);
        }
    });

    // Batasi checkbox hari maksimal 2 pilihan
    $('.day-checkbox').change(function() {
        if ($('.day-checkbox:checked').length > 2) {
            $(this).prop('checked', false);
            alert('Maksimal memilih 2 hari.');
        }
    });
});

// Salin link planner client ke clipboard
function copyPlannerLink(code, element) {
    const url = "{{ url('/planner') }}/" + code;
    navigator.clipboard.writeText(url).then(() => {
        const originalText = $(element).text();
        $(element).text('Copied!').addClass('text-success');
        setTimeout(() => {
            $(element).text(originalText).removeClass('text-success');
        }, 1500);
    }).catch(err => {
        alert('Gagal menyalin link: ' + err);
    });
}
</script>
@endsection
