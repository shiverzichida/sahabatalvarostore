@extends('layouts.client')

@section('title', 'Minta Vitamin & Suplemen')

@section('content')
<div style="animation: fadeIn 0.8s ease-out;">
    <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px; background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Permohonan Vitamin / Suplemen Baru</h2>
    
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; flex-wrap: wrap;" class="progress-grid-layout">
        
        <!-- Form Minta Jadwal -->
        <div class="glass-card" style="padding: 24px;">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Minta Jadwal Vitamin</h3>
            <form action="{{ route('client.request.store') }}" method="POST">
                @csrf
                
                <div id="request-items-container">
                    <div class="request-row mb-3" data-index="0" style="background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; position: relative; margin-bottom: 16px;">
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

                <div style="display: flex; gap: 12px; margin-top: 20px;">
                    <button type="button" id="add-row-btn" class="submit-btn" style="background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); color: #60a5fa; font-weight: 600; flex-grow: 1;">
                        + Tambah Vitamin Lain
                    </button>
                    <button type="submit" class="submit-btn" style="flex-grow: 1;">Kirim Permintaan</button>
                </div>
            </form>
        </div>

        <!-- List Request -->
        <div class="glass-card" style="padding: 24px; display: flex; flex-direction: column; max-height: 520px;">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Permintaan Terkini</h3>
            <div style="flex-grow: 1; overflow-y: auto; padding-right: 4px;">
                @forelse($requests as $req)
                    <div style="padding: 16px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 12px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                        <div style="overflow: hidden;">
                            <h4 style="font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $req->vitamin_name }}
                            </h4>
                            <p style="font-size: 11px; color: var(--text-muted);">
                                {{ $req->created_at->format('d M Y - H:i') }}
                            </p>
                            @if($req->notes)
                                <p style="font-size: 12px; color: #cbd5e1; margin-top: 4px; font-style: italic;">
                                    "{{ $req->notes }}"
                                </p>
                            @endif
                        </div>
                        <span class="status-badge {{ $req->status === 'approved' ? 'status-approved' : 'status-pending' }}" style="flex-shrink: 0;">
                            {{ $req->status === 'approved' ? 'Disetujui' : 'Pending' }}
                        </span>
                    </div>
                @empty
                    <p style="text-align: center; font-size: 13px; color: var(--text-muted); padding: 24px 0;">Belum ada riwayat permintaan.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            newRow.style.cssText = 'background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); padding: 16px; border-radius: 12px; position: relative; margin-bottom: 16px;';
            
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
@endsection
