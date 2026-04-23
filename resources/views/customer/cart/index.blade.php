<x-app-layout>
    <div class="ef-cart">

    {{-- ── Header ── --}}
    <div class="ef-cart__header">
        <div class="ef-cart__header-inner">
            <div>
                <h1 class="ef-cart__title">Keranjang</h1>
                <p class="ef-cart__subtitle">
                    @if (!$order || $order->items->isEmpty())
                        Belum ada item
                    @else
                        {{ $order->items->count() }} item dipilih
                    @endif
                </p>
            </div>
            <div class="ef-cart__header-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ── Body ── --}}
    <div class="ef-cart__body">

        @if (!$order || $order->items->isEmpty())

            {{-- ── Empty ── --}}
            <div class="ef-cart__empty" data-reveal>
                <div class="ef-cart__empty-visual">
                    <div class="ef-cart__empty-ring ef-cart__empty-ring--outer"></div>
                    <div class="ef-cart__empty-ring ef-cart__empty-ring--inner"></div>
                    <div class="ef-cart__empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6"/>
                        </svg>
                    </div>
                </div>
                <h3 class="ef-cart__empty-title">Keranjang masih kosong</h3>
                <p class="ef-cart__empty-sub">Yuk tambahkan produk galon favoritmu ke keranjang.</p>
                <a href="{{ route('customer.home') }}" class="ef-cart__empty-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                        <path d="M9 21V12h6v9"/>
                    </svg>
                    Lihat Produk
                </a>
            </div>

        @else

            {{-- ── Item list ── --}}
            <div class="ef-cart__list">
                @foreach ($order->items as $i => $item)
                    <div class="ef-cart__item" data-reveal data-delay="{{ $loop->index * 60 }}">

                        {{-- Checkbox --}}
                        <label class="ef-cart__check-wrap">
                            <input type="checkbox" class="item-checkbox ef-cart__checkbox"
                                   data-price="{{ $item->product->price }}"
                                   data-qty="{{ $item->quantity }}">
                            <span class="ef-cart__checkmark">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white"
                                     stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5"/>
                                </svg>
                            </span>
                        </label>

                        {{-- Image --}}
                        <div class="ef-cart__img-wrap">
                            <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 class="ef-cart__img">
                        </div>

                        {{-- Info --}}
                        <div class="ef-cart__info">
                            <h3 class="ef-cart__name">{{ $item->product->name }}</h3>
                            <p class="ef-cart__meta">Galon premium · Siap antar</p>
                            <p class="ef-cart__price">
                                Rp{{ number_format($item->product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Qty stepper --}}
                        <div class="ef-cart__qty">
                            <button class="ef-cart__qty-btn ef-cart__qty-btn--minus" aria-label="Kurangi">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg>
                            </button>
                            <span class="ef-cart__qty-val">{{ $item->quantity }}</span>
                            <button class="ef-cart__qty-btn ef-cart__qty-btn--plus" aria-label="Tambah">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- spacer agar item terakhir tidak tertutup footer --}}
            <div style="height: 96px"></div>

        @endif

    </div>

    {{-- ── Sticky Footer Checkout ── --}}
    @if ($order && $order->items->isNotEmpty())
        <div class="ef-cart__footer">
            <div class="ef-cart__footer-inner">

                {{-- Select all --}}
                <label class="ef-cart__check-wrap ef-cart__check-wrap--footer">
                    <input type="checkbox" id="checkAll" class="ef-cart__checkbox">
                    <span class="ef-cart__checkmark">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white"
                             stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                    </span>
                    <span class="ef-cart__all-label">Semua</span>
                </label>

                {{-- Total --}}
                <div class="ef-cart__total">
                    <span class="ef-cart__total-label">Total</span>
                    <span id="totalPrice" class="ef-cart__total-val">Rp0</span>
                </div>

                {{-- Checkout --}}
                <button id="checkoutBtn" class="ef-cart__checkout">
                    Checkout
                    <span id="checkoutCount" class="ef-cart__checkout-badge">0</span>
                </button>

            </div>
        </div>
    @endif

</div>

{{-- ── Scroll reveal ── --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Reveal
    const els = document.querySelectorAll('[data-reveal]');
    const ro = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const d = parseInt(e.target.dataset.delay || 0);
            setTimeout(() => e.target.classList.add('ef-revealed'), d);
            ro.unobserve(e.target);
        });
    }, { threshold: 0.06 });
    els.forEach(el => ro.observe(el));

    // Cart logic
    const checkAll      = document.getElementById('checkAll');
    if (!checkAll) return;

    const itemCBs       = document.querySelectorAll('.item-checkbox');
    const totalPriceEl  = document.getElementById('totalPrice');
    const checkoutBtn   = document.getElementById('checkoutBtn');
    const checkoutCount = document.getElementById('checkoutCount');

    function updateCart() {
        let total = 0, count = 0;
        itemCBs.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.price) * parseInt(cb.dataset.qty);
                count += parseInt(cb.dataset.qty);
            }
        });
        totalPriceEl.textContent = 'Rp' + total.toLocaleString('id-ID');
        checkoutCount.textContent = count;
        checkoutBtn.disabled = count === 0;
        checkoutBtn.classList.toggle('ef-cart__checkout--disabled', count === 0);
    }

    checkAll.addEventListener('change', function () {
        itemCBs.forEach(cb => cb.checked = this.checked);
        updateCart();
    });

    itemCBs.forEach(cb => {
        cb.addEventListener('change', function () {
            checkAll.checked = [...itemCBs].every(i => i.checked);
            updateCart();
        });
    });

    updateCart();
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ── Root ──────────────────────────────────────────────────── */
.ef-cart {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f0f6ff;
    min-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
}
.dark .ef-cart { background: #0b1120; }

/* ── Header ────────────────────────────────────────────────── */
.ef-cart__header {
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border-bottom: 1px solid rgba(37,99,235,.1);
    box-shadow: 0 2px 16px rgba(37,99,235,.06);
}
.dark .ef-cart__header {
    background: rgba(15,23,42,.92);
    border-bottom-color: rgba(255,255,255,.06);
}
.ef-cart__header-inner {
    max-width: 720px;
    margin: 0 auto;
    padding: 16px 16px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
@media (min-width: 640px) { .ef-cart__header-inner { padding: 20px 24px 16px; } }

.ef-cart__title {
    font-size: 1.2rem; font-weight: 800;
    color: #1e293b; line-height: 1;
}
.dark .ef-cart__title { color: #f1f5f9; }
.ef-cart__subtitle {
    font-size: .74rem; color: #94a3b8;
    margin-top: 3px; font-weight: 500;
}
.ef-cart__header-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: #eff6ff;
    border: 1px solid rgba(37,99,235,.15);
    display: flex; align-items: center; justify-content: center;
    color: #2563eb;
}
.dark .ef-cart__header-icon {
    background: rgba(37,99,235,.12);
    border-color: rgba(37,99,235,.25);
    color: #60a5fa;
}

/* ── Body ──────────────────────────────────────────────────── */
.ef-cart__body {
    flex: 1;
    max-width: 720px;
    width: 100%;
    margin: 0 auto;
    padding: 16px 14px 0;
}
@media (min-width: 640px) { .ef-cart__body { padding: 20px 24px 0; } }

/* ── Reveal ────────────────────────────────────────────────── */
[data-reveal] {
    opacity: 0; transform: translateY(16px);
    transition: opacity .42s cubic-bezier(.22,1,.36,1), transform .42s cubic-bezier(.22,1,.36,1);
}
[data-reveal].ef-revealed { opacity: 1; transform: none; }

/* ── Empty ─────────────────────────────────────────────────── */
.ef-cart__empty {
    display: flex; flex-direction: column;
    align-items: center; text-align: center;
    padding: 60px 24px; gap: 12px;
}
.ef-cart__empty-visual {
    position: relative; width: 100px; height: 100px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 8px;
}
.ef-cart__empty-ring {
    position: absolute; border-radius: 50%;
    border: 1.5px solid rgba(37,99,235,.15);
}
.ef-cart__empty-ring--outer { inset: 0; animation: efRingPulse 3s ease-in-out infinite; }
.ef-cart__empty-ring--inner { inset: 12px; animation: efRingPulse 3s ease-in-out infinite .5s; }
@keyframes efRingPulse {
    0%,100% { opacity:.6; transform:scale(1); }
    50%      { opacity:.2; transform:scale(1.04); }
}
.ef-cart__empty-icon {
    width: 64px; height: 64px; border-radius: 20px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid rgba(37,99,235,.15);
    display: flex; align-items: center; justify-content: center;
    color: #3b82f6; position: relative; z-index: 1;
}
.dark .ef-cart__empty-icon { background: rgba(37,99,235,.12); border-color: rgba(37,99,235,.25); color: #60a5fa; }
.ef-cart__empty-title { font-size: 1rem; font-weight: 700; color: #1e293b; }
.dark .ef-cart__empty-title { color: #f1f5f9; }
.ef-cart__empty-sub { font-size: .82rem; color: #94a3b8; max-width: 260px; line-height: 1.6; }
.ef-cart__empty-btn {
    display: inline-flex; align-items: center; gap: 8px;
    margin-top: 6px; padding: 10px 22px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: .85rem; font-weight: 700;
    border-radius: 12px; text-decoration: none;
    box-shadow: 0 4px 14px rgba(37,99,235,.35);
    transition: box-shadow .2s, transform .2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.ef-cart__empty-btn:hover { box-shadow: 0 6px 20px rgba(37,99,235,.45); transform: translateY(-1px); }

/* ── Item list ─────────────────────────────────────────────── */
.ef-cart__list { display: flex; flex-direction: column; gap: 10px; }

/* ── Cart item ─────────────────────────────────────────────── */
.ef-cart__item {
    background: rgba(255,255,255,.96);
    border: 1px solid rgba(37,99,235,.08);
    border-radius: 16px;
    padding: 12px 12px 12px 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 1px 6px rgba(37,99,235,.05);
    transition: box-shadow .2s, transform .2s;
}
.ef-cart__item:hover { box-shadow: 0 4px 16px rgba(37,99,235,.1); transform: translateY(-1px); }
.dark .ef-cart__item {
    background: rgba(17,24,39,.95);
    border-color: rgba(255,255,255,.07);
}
@media (min-width: 640px) { .ef-cart__item { padding: 14px 16px; gap: 14px; } }

/* ── Custom checkbox ───────────────────────────────────────── */
.ef-cart__check-wrap {
    position: relative;
    display: flex; align-items: center;
    cursor: pointer; flex-shrink: 0;
}
.ef-cart__check-wrap--footer { gap: 8px; }

.ef-cart__checkbox {
    position: absolute; opacity: 0; width: 0; height: 0;
}
.ef-cart__checkmark {
    width: 20px; height: 20px;
    border-radius: 6px;
    border: 2px solid rgba(37,99,235,.3);
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all .18s;
    flex-shrink: 0;
}
.dark .ef-cart__checkmark { background: #1e293b; border-color: rgba(255,255,255,.2); }
.ef-cart__checkmark svg { opacity: 0; transition: opacity .15s; }

.ef-cart__checkbox:checked + .ef-cart__checkmark {
    background: #2563eb;
    border-color: #2563eb;
    box-shadow: 0 2px 8px rgba(37,99,235,.35);
}
.ef-cart__checkbox:checked + .ef-cart__checkmark svg { opacity: 1; }

/* ── Product image ─────────────────────────────────────────── */
.ef-cart__img-wrap {
    width: 68px; height: 68px; flex-shrink: 0;
    background: #f0f6ff;
    border-radius: 12px;
    border: 1px solid rgba(37,99,235,.1);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.dark .ef-cart__img-wrap { background: #1e293b; border-color: rgba(255,255,255,.08); }
@media (min-width: 640px) { .ef-cart__img-wrap { width: 76px; height: 76px; } }
.ef-cart__img {
    width: 52px; height: 52px;
    object-fit: contain;
    transition: transform .3s;
}
.ef-cart__item:hover .ef-cart__img { transform: scale(1.07); }

/* ── Info ──────────────────────────────────────────────────── */
.ef-cart__info { flex: 1; min-width: 0; }
.ef-cart__name {
    font-size: .88rem; font-weight: 700;
    color: #1e293b; line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.dark .ef-cart__name { color: #f1f5f9; }
.ef-cart__meta {
    font-size: .7rem; color: #94a3b8;
    margin-top: 3px; font-weight: 500;
}
.ef-cart__price {
    font-size: 1rem; font-weight: 800;
    color: #2563eb; margin-top: 5px;
}
.dark .ef-cart__price { color: #60a5fa; }

/* ── Qty stepper ───────────────────────────────────────────── */
.ef-cart__qty {
    display: flex; align-items: center; gap: 0;
    border: 1.5px solid rgba(37,99,235,.15);
    border-radius: 10px; overflow: hidden;
    flex-shrink: 0;
}
.dark .ef-cart__qty { border-color: rgba(255,255,255,.12); }
.ef-cart__qty-btn {
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    background: transparent; border: none;
    color: #64748b; cursor: pointer;
    transition: background .15s, color .15s;
}
.ef-cart__qty-btn:hover { background: #eff6ff; color: #2563eb; }
.dark .ef-cart__qty-btn:hover { background: rgba(37,99,235,.12); color: #60a5fa; }
.ef-cart__qty-val {
    min-width: 28px; text-align: center;
    font-size: .82rem; font-weight: 700;
    color: #1e293b;
    border-left: 1px solid rgba(37,99,235,.1);
    border-right: 1px solid rgba(37,99,235,.1);
    padding: 0 4px;
    line-height: 30px;
}
.dark .ef-cart__qty-val {
    color: #f1f5f9;
    border-color: rgba(255,255,255,.08);
}

/* ── Footer ────────────────────────────────────────────────── */
.ef-cart__footer {
    position: fixed; bottom: 0; left: 0; right: 0;
    z-index: 50;
    background: rgba(255,255,255,.97);
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border-top: 1px solid rgba(37,99,235,.1);
    box-shadow: 0 -4px 24px rgba(37,99,235,.1);
    padding: 12px 14px;
    padding-bottom: max(12px, env(safe-area-inset-bottom));
}
.dark .ef-cart__footer {
    background: rgba(15,23,42,.97);
    border-top-color: rgba(255,255,255,.07);
}
.ef-cart__footer-inner {
    max-width: 720px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 12px;
}

.ef-cart__all-label {
    font-size: .8rem; font-weight: 600;
    color: #64748b; white-space: nowrap;
}
.dark .ef-cart__all-label { color: #94a3b8; }

.ef-cart__total {
    flex: 1; min-width: 0;
    display: flex; flex-direction: column;
    gap: 1px;
}
.ef-cart__total-label {
    font-size: .7rem; color: #94a3b8; font-weight: 500;
}
.ef-cart__total-val {
    font-size: 1.05rem; font-weight: 800;
    color: #2563eb;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.dark .ef-cart__total-val { color: #60a5fa; }

.ef-cart__checkout {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 18px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .86rem; font-weight: 700;
    border: none; border-radius: 12px; cursor: pointer;
    box-shadow: 0 4px 14px rgba(37,99,235,.35);
    transition: box-shadow .2s, transform .15s, opacity .2s;
    white-space: nowrap; flex-shrink: 0;
}
.ef-cart__checkout:hover:not(:disabled) {
    box-shadow: 0 6px 20px rgba(37,99,235,.45);
    transform: translateY(-1px);
}
.ef-cart__checkout--disabled {
    opacity: .45; cursor: not-allowed;
}

.ef-cart__checkout-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 20px; height: 20px;
    background: rgba(255,255,255,.25);
    border-radius: 999px;
    font-size: .72rem; font-weight: 800;
    padding: 0 5px; line-height: 1;
}
</style>

</x-app-layout>