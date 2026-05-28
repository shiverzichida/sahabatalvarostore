@extends('layouts.app')

@section('title', 'Checkout - Sahabat Alvaro Store')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Checkout</h1>
            <p class="mt-3 text-lg text-gray-500">Lengkapi data penerima untuk menyelesaikan pesanan via WhatsApp</p>
        </div>

        <!-- Empty state (shown via JS when cart is empty) -->
        <div id="sa-co-empty" class="hidden">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-500 mb-8">Belum ada produk di keranjang belanja Anda.</p>
                <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-primary-blue text-white font-semibold hover:bg-blue-700 transition">
                    ← Kembali Belanja
                </a>
            </div>
        </div>

        <!-- Checkout content (shown via JS when cart has items) -->
        <div id="sa-co-content" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                
                <!-- Left: Cart Items (3 cols) -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                                Pesanan Anda
                                <span id="sa-co-count" class="text-sm font-normal text-gray-400"></span>
                            </h2>
                        </div>
                        <div id="sa-co-items" class="divide-y divide-gray-50">
                            <!-- Filled by JS -->
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Subtotal</span>
                            <span id="sa-co-subtotal" class="text-xl font-extrabold text-gray-900">Rp 0</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="text-sm text-primary-blue hover:underline">← Lanjut Belanja</a>
                    </div>
                </div>

                <!-- Right: Form (2 cols) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            Data Penerima
                        </h2>
                        
                        <div class="space-y-5">
                            <div>
                                <label for="sa-co-nama" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Penerima <span class="text-red-500">*</span></label>
                                <input type="text" id="sa-co-nama" placeholder="Nama lengkap penerima"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm">
                            </div>
                            <div>
                                <label for="sa-co-telp" class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon Penerima <span class="text-red-500">*</span></label>
                                <input type="tel" id="sa-co-telp" placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm">
                            </div>
                            <div>
                                <label for="sa-co-alamat" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Penerima <span class="text-red-500">*</span></label>
                                <textarea id="sa-co-alamat" rows="3" placeholder="Alamat lengkap, kecamatan, kota, kode pos"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm resize-none"></textarea>
                            </div>
                            <div>
                                <label for="sa-co-jne" class="block text-sm font-semibold text-gray-700 mb-1.5">Layanan Pengiriman (JNE)</label>
                                <select id="sa-co-jne"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm bg-white">
                                    <option value="reg">JNE REG (Reguler)</option>
                                    <option value="yes">JNE YES (Yakin Esok Sampai)</option>
                                    <option value="oke">JNE OKE (Ongkos Kirim Ekonomis)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="flex justify-between items-center mb-5">
                                <span class="text-base font-semibold text-gray-900">Total Pesanan</span>
                                <span id="sa-co-total" class="text-2xl font-extrabold text-primary-blue">Rp 0</span>
                            </div>
                            <button onclick="window.SACart && SACart.checkout()" class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-xl text-white font-bold text-base transition-all hover:shadow-lg" style="background: linear-gradient(135deg, #25D366, #128C7E);">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Checkout via WhatsApp
                            </button>
                            <p class="text-xs text-gray-400 text-center mt-3">Pesanan akan dikirim ke WhatsApp admin untuk konfirmasi</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = window.SACart ? SACart.getItems() : [];
    
    if (items.length === 0) {
        document.getElementById('sa-co-empty').classList.remove('hidden');
        return;
    }
    
    document.getElementById('sa-co-content').classList.remove('hidden');
    
    // Load cached checkout info
    const cached = window.SACheckoutCache ? SACheckoutCache.load() : {};
    if (cached.nama) document.getElementById('sa-co-nama').value = cached.nama;
    if (cached.telp) document.getElementById('sa-co-telp').value = cached.telp;
    if (cached.alamat) document.getElementById('sa-co-alamat').value = cached.alamat;
    if (cached.jne) document.getElementById('sa-co-jne').value = cached.jne;
    
    // Auto-save form fields on change
    ['sa-co-nama', 'sa-co-telp', 'sa-co-alamat', 'sa-co-jne'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function() {
                SACheckoutCache.save({
                    nama: document.getElementById('sa-co-nama').value,
                    telp: document.getElementById('sa-co-telp').value,
                    alamat: document.getElementById('sa-co-alamat').value,
                    jne: document.getElementById('sa-co-jne').value
                });
            });
        }
    });
    
    renderCheckoutItems();
});

function formatRp(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}

function renderCheckoutItems() {
    const items = SACart.getItems();
    const container = document.getElementById('sa-co-items');
    const countEl = document.getElementById('sa-co-count');
    const subtotalEl = document.getElementById('sa-co-subtotal');
    const totalEl = document.getElementById('sa-co-total');
    
    if (items.length === 0) {
        // Switch to empty state
        document.getElementById('sa-co-content').classList.add('hidden');
        document.getElementById('sa-co-empty').classList.remove('hidden');
        return;
    }
    
    countEl.textContent = `(${SACart.getCount()} item)`;
    
    container.innerHTML = items.map(item => `
        <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                ${item.image 
                    ? `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">`
                    : `<div class="w-full h-full flex items-center justify-center text-gray-300"><svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>`
                }
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">${item.name}</p>
                <p class="text-sm text-primary-blue font-bold">${formatRp(item.price)}</p>
            </div>
            <div class="flex items-center gap-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                <button onclick="SACart.updateQty(${item.id}, ${item.qty - 1}); renderCheckoutItems();" class="sa-qty-btn" style="width:32px;height:32px;">−</button>
                <span style="width:32px;text-align:center;font-size:13px;font-weight:600;">${item.qty}</span>
                <button onclick="SACart.updateQty(${item.id}, ${item.qty + 1}); renderCheckoutItems();" class="sa-qty-btn" style="width:32px;height:32px;">+</button>
            </div>
            <div class="text-right w-24 flex-shrink-0">
                <p class="text-sm font-bold text-gray-900">${formatRp(item.price * item.qty)}</p>
            </div>
            <button onclick="SACart.removeItem(${item.id}); renderCheckoutItems();" class="ml-1 text-gray-300 hover:text-red-500 transition" title="Hapus">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `).join('');
    
    const total = SACart.getTotal();
    subtotalEl.textContent = formatRp(total);
    totalEl.textContent = formatRp(total);
}
</script>
@endpush
@endsection
