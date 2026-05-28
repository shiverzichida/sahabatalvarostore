/**
 * Sahabat Alvaro Store — Shopping Cart Module
 * localStorage-based cart with WhatsApp checkout
 */
(function () {
    'use strict';

    const CART_KEY = 'sa_cart';
    const CHECKOUT_KEY = 'sa_checkout_info';

    // ─── Cart Data Layer ────────────────────────────────────────────────
    const Cart = {
        _items: [],

        load() {
            try {
                this._items = JSON.parse(localStorage.getItem(CART_KEY)) || [];
            } catch { this._items = []; }
            return this;
        },

        save() {
            localStorage.setItem(CART_KEY, JSON.stringify(this._items));
            Cart.UI.updateBadge();
            Cart.UI.renderDrawer();
            return this;
        },

        getItems() { return this._items; },

        getCount() {
            return this._items.reduce((sum, i) => sum + i.qty, 0);
        },

        getTotal() {
            return this._items.reduce((sum, i) => sum + (i.price * i.qty), 0);
        },

        addItem(product) {
            const existing = this._items.find(i => i.id === product.id);
            if (existing) {
                existing.qty += (product.qty || 1);
            } else {
                this._items.push({
                    id: product.id,
                    name: product.name,
                    slug: product.slug,
                    price: Number(product.price),
                    image: product.image || '',
                    qty: product.qty || 1
                });
            }
            this.save();
            Cart.UI.showAddFeedback();
        },

        removeItem(id) {
            this._items = this._items.filter(i => i.id !== id);
            this.save();
        },

        updateQty(id, qty) {
            const item = this._items.find(i => i.id === id);
            if (item) {
                item.qty = Math.max(1, qty);
                this.save();
            }
        },

        clear() {
            this._items = [];
            this.save();
        }
    };

    // ─── Format Helpers ─────────────────────────────────────────────────
    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    // ─── Checkout Info Cache ────────────────────────────────────────────
    const CheckoutCache = {
        load() {
            try { return JSON.parse(localStorage.getItem(CHECKOUT_KEY)) || {}; }
            catch { return {}; }
        },
        save(data) {
            localStorage.setItem(CHECKOUT_KEY, JSON.stringify(data));
        }
    };

    // ─── UI Layer ───────────────────────────────────────────────────────
    Cart.UI = {
        updateBadge() {
            const badges = document.querySelectorAll('.sa-cart-badge');
            const count = Cart.getCount();
            badges.forEach(b => {
                b.textContent = count;
                b.style.display = count > 0 ? 'flex' : 'none';
            });
        },

        showAddFeedback() {
            const el = document.getElementById('sa-cart-feedback');
            if (!el) return;
            el.classList.add('sa-feedback-show');
            setTimeout(() => el.classList.remove('sa-feedback-show'), 1800);
        },

        toggleDrawer() {
            const drawer = document.getElementById('sa-cart-drawer');
            const overlay = document.getElementById('sa-cart-overlay');
            if (!drawer) return;
            const isOpen = drawer.classList.contains('sa-drawer-open');
            if (isOpen) {
                drawer.classList.remove('sa-drawer-open');
                overlay.classList.remove('sa-overlay-show');
                document.body.style.overflow = '';
            } else {
                Cart.UI.renderDrawer();
                drawer.classList.add('sa-drawer-open');
                overlay.classList.add('sa-overlay-show');
                document.body.style.overflow = 'hidden';
            }
        },

        renderDrawer() {
            const container = document.getElementById('sa-cart-drawer-items');
            const totalEl = document.getElementById('sa-cart-drawer-total');
            const emptyEl = document.getElementById('sa-cart-drawer-empty');
            const footerEl = document.getElementById('sa-cart-drawer-footer');
            if (!container) return;

            const items = Cart.getItems();
            if (items.length === 0) {
                container.innerHTML = '';
                if (emptyEl) emptyEl.style.display = 'flex';
                if (footerEl) footerEl.style.display = 'none';
                return;
            }

            if (emptyEl) emptyEl.style.display = 'none';
            if (footerEl) footerEl.style.display = 'block';

            container.innerHTML = items.map(item => `
                <div class="sa-drawer-item" data-id="${item.id}">
                    <div class="sa-drawer-item-img">
                        ${item.image
                            ? `<img src="${item.image}" alt="${item.name}">`
                            : `<div class="sa-drawer-item-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>`
                        }
                    </div>
                    <div class="sa-drawer-item-info">
                        <p class="sa-drawer-item-name">${item.name}</p>
                        <p class="sa-drawer-item-price">${formatRupiah(item.price)}</p>
                        <div class="sa-drawer-item-qty">
                            <button class="sa-qty-btn" onclick="window.SACart.updateQty(${item.id}, ${item.qty - 1})">−</button>
                            <span>${item.qty}</span>
                            <button class="sa-qty-btn" onclick="window.SACart.updateQty(${item.id}, ${item.qty + 1})">+</button>
                        </div>
                    </div>
                    <button class="sa-drawer-item-remove" onclick="window.SACart.removeItem(${item.id})" title="Hapus">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            `).join('');

            if (totalEl) {
                totalEl.textContent = formatRupiah(Cart.getTotal());
            }
        }
    };

    // ─── WhatsApp Checkout ──────────────────────────────────────────────
    Cart.checkout = function () {
        const items = Cart.getItems();
        if (items.length === 0) {
            alert('Keranjang kosong!');
            return;
        }

        const nama = document.getElementById('sa-co-nama')?.value?.trim();
        const telp = document.getElementById('sa-co-telp')?.value?.trim();
        const alamat = document.getElementById('sa-co-alamat')?.value?.trim();
        const jne = document.getElementById('sa-co-jne')?.value || 'reg';

        if (!nama || !telp || !alamat) {
            alert('Mohon lengkapi semua data penerima.');
            return;
        }

        // Cache checkout info
        CheckoutCache.save({ nama, telp, alamat, jne });

        // Build order text
        const pesanan = items.map(i =>
            `- ${i.name} x${i.qty} = ${formatRupiah(i.price * i.qty)}`
        ).join('\n');

        const total = formatRupiah(Cart.getTotal());

        const msg = `Resi : \nNama pengirim : sahabatandrialvaro\nNo. Tlp : 085389726874\nNama penerima : ${nama}\nNo. Tlp penerima : ${telp}\nAlamat Penerima : ${alamat}\nJNE : ${jne}\nPesanan :\n${pesanan}\nTotal :\n${total}`;

        const waUrl = 'https://wa.me/6285389726874?text=' + encodeURIComponent(msg);
        window.open(waUrl, '_blank');
    };

    // ─── Init ───────────────────────────────────────────────────────────
    Cart.load();

    // Expose to global
    window.SACart = Cart;
    window.SACheckoutCache = CheckoutCache;

    // Update UI on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            Cart.UI.updateBadge();
        });
    } else {
        Cart.UI.updateBadge();
    }
})();
