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
    .request-badge {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<!-- Panel Permintaan Masuk -->
@if($pendingRequests->isNotEmpty())
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title text-warning font-weight-bold">
                    <i class="fas fa-exclamation-triangle"></i> Permintaan Jadwal Dari Client ({{ $pendingRequests->count() }})
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Nama Client</th>
                            <th>Email / WA</th>
                            <th>Vitamin Yang Diminta</th>
                            <th>Catatan Tambahan</th>
                            <th>Waktu Kirim</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $req)
                            <tr>
                                <td class="align-middle"><strong>{{ $req->user->name }}</strong></td>
                                <td class="align-middle">
                                    {{ $req->user->email }}
                                    @if($req->user->whatsapp)
                                        <br>
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $req->user->whatsapp) }}" target="_blank" class="badge badge-success">
                                            <i class="fab fa-whatsapp"></i> {{ $req->user->whatsapp }}
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle"><span class="badge badge-warning">{{ $req->vitamin_name }}</span></td>
                                <td class="align-middle">{{ $req->notes ?? '-' }}</td>
                                <td class="align-middle"><small>{{ $req->created_at->diffForHumans() }}</small></td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.planner.index', [
                                        'request_id' => $req->id,
                                        'user_id' => $req->user_id,
                                        'client_name' => $req->user->name,
                                        'vitamin_name' => $req->vitamin_name,
                                        'notes' => $req->notes
                                    ]) }}" class="btn btn-xs btn-primary font-weight-bold">
                                        <i class="fas fa-check"></i> Proses
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <!-- Form Tambah Jadwal -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    @if($prefill['request_id'])
                        Proses Permintaan Jadwal
                    @else
                        Tambah Jadwal Baru
                    @endif
                </h3>
                @if($prefill['request_id'])
                    <div class="card-tools">
                        <a href="{{ route('admin.planner.index') }}" class="btn btn-xs btn-default text-dark font-weight-bold">Batal</a>
                    </div>
                @endif
            </div>
            <form action="{{ route('admin.planner.store') }}" method="POST">
                @csrf
                
                @if($prefill['request_id'])
                    <input type="hidden" name="request_id" value="{{ $prefill['request_id'] }}">
                @endif

                <div class="card-body">
                    <!-- Tipe Input Client -->
                    <div class="form-group">
                        <label for="client_type">Tipe Client</label>
                        <select name="client_type" id="client_type" class="form-control" required>
                            <option value="registered" {{ ($prefill['user_id'] || old('client_type') === 'registered') ? 'selected' : '' }}>Client Terdaftar (Akun Website)</option>
                            <option value="manual" {{ (!$prefill['user_id'] && old('client_type') === 'manual') ? 'selected' : '' }}>Input Nama Manual</option>
                        </select>
                    </div>

                    <!-- Pilihan Client Terdaftar -->
                    <div class="form-group" id="registered-client-group">
                        <label for="user_id">Pilih Akun Client</label>
                        <select name="user_id" id="user_id" class="form-control select2">
                            <option value="">-- Pilih Akun Client --</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ ($prefill['user_id'] == $c->id || old('user_id') == $c->id) ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->email }} - WA: {{ $c->whatsapp ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Nama Manual -->
                    <div class="form-group d-none" id="manual-client-group">
                        <label for="client_name">Nama Client</label>
                        <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Nama lengkap client" value="{{ $prefill['client_name'] ?? old('client_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="client_code">Kode Client (Optional)</label>
                        <input type="text" name="client_code" id="client_code" class="form-control" placeholder="Kosongkan untuk auto-generate">
                    </div>

                    <div class="form-group">
                        <label for="admin_vitamin_select">Pilih Vitamin / Produk Catalog</label>
                        <select id="admin_vitamin_select" class="form-control select2">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->name }}" {{ (isset($prefill['vitamin_name']) && $prefill['vitamin_name'] == $prod->name) ? 'selected' : '' }}>
                                    {{ $prod->name }}
                                </option>
                            @endforeach
                            <option value="__manual__">Lainnya (Tulis manual...)</option>
                        </select>
                    </div>

                    <div class="form-group" id="admin-manual-vitamin-group">
                        <label for="vitamin_name">Nama Vitamin / Suplemen (Detail/Manual)</label>
                        <input type="text" name="vitamin_name" id="vitamin_name" class="form-control" placeholder="Contoh: Vitamin C" value="{{ $prefill['vitamin_name'] ?? old('vitamin_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="dosage">Dosis</label>
                        <input type="text" name="dosage" id="dosage" class="form-control" placeholder="Contoh: 500mg, 1 tablet" value="{{ old('dosage') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai / Tanggal Konsumsi</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="frequency">Frekuensi Konsumsi</label>
                        <select name="frequency" id="frequency" class="form-control" required>
                            <option value="once" {{ old('frequency') === 'once' ? 'selected' : '' }}>Hanya Sekali (Sekali Saja)</option>
                            <option value="daily" {{ old('frequency') === 'daily' ? 'selected' : '' }}>Setiap Hari (Daily)</option>
                            <option value="every_other_day" {{ old('frequency') === 'every_other_day' ? 'selected' : '' }}>Dua Hari Sekali (Every Other Day)</option>
                            <option value="twice_weekly" {{ old('frequency') === 'twice_weekly' ? 'selected' : '' }}>Dua Kali Seminggu (Twice Weekly)</option>
                        </select>
                    </div>

                    <!-- Tanggal Selesai (Disembunyikan jika frekuensi 'once') -->
                    <div class="form-group" id="end-date-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', date('Y-m-d', strtotime('+30 days'))) }}">
                    </div>

                    <!-- Pilihan Hari (Hanya muncul jika twice_weekly) -->
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
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Contoh: Diminum sesudah makan pagi">{{ $prefill['notes'] ?? old('notes') }}</textarea>
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
                            <th>Periode / Tanggal</th>
                            <th>Frekuensi</th>
                            <th style="width: 40px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $sched)
                            <tr>
                                <td class="align-middle">
                                    <strong>{{ $sched->client_name }}</strong>
                                    @if($sched->user_id)
                                        <br><small class="text-success"><i class="fas fa-user-check"></i> Akun Terdaftar</small>
                                        @if($sched->user && $sched->user->whatsapp)
                                            <br>
                                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $sched->user->whatsapp) }}" target="_blank" class="text-success" style="font-size: 12px; font-weight: 500;">
                                                <i class="fab fa-whatsapp"></i> Chat ({{ $sched->user->whatsapp }})
                                            </a>
                                        @endif
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="client-link-copy" onclick="copyPlannerLink('{{ $sched->client_code }}', this)">
                                        {{ $sched->client_code }}
                                    </span>
                                </td>
                                <td class="align-middle">{{ $sched->vitamin_name }}</td>
                                <td class="align-middle"><span class="badge badge-info">{{ $sched->dosage }}</span></td>
                                <td class="align-middle">
                                    @if($sched->frequency === 'once')
                                        <small>{{ date('d/m/Y', strtotime($sched->start_date)) }}</small>
                                    @else
                                        <small>{{ date('d/m/Y', strtotime($sched->start_date)) }} - {{ date('d/m/Y', strtotime($sched->end_date)) }}</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($sched->frequency === 'once')
                                        Sekali Saja
                                    @elseif($sched->frequency === 'daily')
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
    // Toggle input berdasarkan Tipe Client
    function toggleClientType() {
        if ($('#client_type').val() === 'registered') {
            $('#registered-client-group').removeClass('d-none');
            $('#user_id').prop('required', true);
            
            $('#manual-client-group').addClass('d-none');
            $('#client_name').prop('required', false);
        } else {
            $('#registered-client-group').addClass('d-none');
            $('#user_id').prop('required', false);
            
            $('#manual-client-group').removeClass('d-none');
            $('#client_name').prop('required', true);
        }
    }

    // Toggle input Tanggal Selesai & Hari
    function toggleFrequency() {
        const freq = $('#frequency').val();
        if (freq === 'once') {
            $('#end-date-group').addClass('d-none');
            $('#days-selector').addClass('d-none');
            $('.day-checkbox').prop('checked', false);
        } else if (freq === 'twice_weekly') {
            $('#end-date-group').removeClass('d-none');
            $('#days-selector').removeClass('d-none');
        } else {
            $('#end-date-group').removeClass('d-none');
            $('#days-selector').addClass('d-none');
            $('.day-checkbox').prop('checked', false);
        }
    }

    // Toggle input Vitamin/Catalog
    function toggleVitaminSelect() {
        const val = $('#admin_vitamin_select').val();
        if (val === '__manual__') {
            $('#admin-manual-vitamin-group').removeClass('d-none');
            $('#vitamin_name').prop('readonly', false);
            // Don't clear if it was prefilled by code
        } else if (val === '') {
            $('#admin-manual-vitamin-group').removeClass('d-none');
            $('#vitamin_name').val('');
            $('#vitamin_name').prop('readonly', false);
        } else {
            $('#admin-manual-vitamin-group').addClass('d-none');
            $('#vitamin_name').val(val);
            $('#vitamin_name').prop('readonly', true);
        }
    }

    $('#admin_vitamin_select').change(toggleVitaminSelect);

    $('#client_type').change(toggleClientType);
    $('#frequency').change(toggleFrequency);

    // Jalankan inisialisasi awal
    toggleClientType();
    toggleFrequency();

    // Cek prefill vitamin untuk kesesuaian dengan opsi select
    const prefillVit = "{{ $prefill['vitamin_name'] ?? '' }}";
    if (prefillVit) {
        let exists = false;
        $('#admin_vitamin_select option').each(function() {
            if ($(this).val() === prefillVit) {
                exists = true;
            }
        });

        if (exists) {
            $('#admin_vitamin_select').val(prefillVit);
        } else {
            $('#admin_vitamin_select').val('__manual__');
            $('#vitamin_name').val(prefillVit);
        }
    }
    toggleVitaminSelect();

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
