<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');

:root {
    --co-red: #E8341A;
    --co-red-soft: #FDF1EE;
    --co-red-mid: #FBDDD7;
    --co-ink: #1A1A1A;
    --co-ink2: #4A4A4A;
    --co-ink3: #8A8A8A;
    --co-line: #EBEBEB;
    --co-bg: #F5F4F1;
    --co-white: #FFFFFF;
    --co-green: #1A7A4A;
    --co-green-soft: #EDF7F2;
    --co-green-mid: #C6E8D5;
    --co-amber: #D97706;
    --co-amber-soft: #FFF8ED;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

.os-root {
    font-family: 'DM Sans', sans-serif;
    background: var(--co-bg);
    min-height: 100svh;
    color: var(--co-ink);
    padding-bottom: 40px;
}

/* ── Hero section ── */
.os-hero {
    background: var(--co-white);
    padding: 48px 24px 36px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

/* Lingkaran dekoratif di belakang */
.os-hero::before {
    content: '';
    position: absolute;
    top: -60px; left: 50%;
    transform: translateX(-50%);
    width: 280px; height: 280px;
    border-radius: 50%;
    background: var(--co-green-soft);
    opacity: .5;
    z-index: 0;
}

/* ── Checkmark animasi ── */
.os-check-wrap {
    position: relative;
    z-index: 1;
    margin-bottom: 20px;
}

.os-check-ring {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: var(--co-green-soft);
    border: 2px solid var(--co-green-mid);
    display: flex; align-items: center; justify-content: center;
    animation: os-ring-pop .5s cubic-bezier(.34,1.56,.64,1) forwards;
    opacity: 0;
}
@keyframes os-ring-pop {
    from { opacity: 0; transform: scale(.6); }
    to   { opacity: 1; transform: scale(1); }
}

.os-check-svg {
    animation: os-check-draw .4s ease .35s forwards;
    opacity: 0;
}
@keyframes os-check-draw {
    from { opacity: 0; transform: scale(.5) rotate(-20deg); }
    to   { opacity: 1; transform: scale(1) rotate(0deg); }
}

/* Partikel confetti */
.os-confetti {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.os-dot {
    position: absolute;
    border-radius: 50%;
    animation: os-dot-fall linear forwards;
    opacity: 0;
}
@keyframes os-dot-fall {
    0%   { opacity: 1; transform: translateY(-10px) rotate(0deg); }
    100% { opacity: 0; transform: translateY(120px) rotate(360deg); }
}

.os-hero__title {
    font-size: 22px;
    font-weight: 600;
    color: var(--co-ink);
    letter-spacing: -.4px;
    margin-bottom: 6px;
    position: relative; z-index: 1;
    opacity: 0;
    animation: os-fadein .4s ease .5s forwards;
}
.os-hero__sub {
    font-size: 13px;
    color: var(--co-ink3);
    line-height: 1.6;
    max-width: 260px;
    position: relative; z-index: 1;
    opacity: 0;
    animation: os-fadein .4s ease .65s forwards;
}
@keyframes os-fadein {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Order number chip ── */
.os-order-chip {
    margin-top: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--co-bg);
    border: 1px solid var(--co-line);
    border-radius: 99px;
    padding: 7px 14px;
    position: relative; z-index: 1;
    opacity: 0;
    animation: os-fadein .4s ease .8s forwards;
}
.os-order-chip__label {
    font-size: 11px;
    color: var(--co-ink3);
}
.os-order-chip__num {
    font-size: 13px;
    font-weight: 600;
    color: var(--co-ink);
    font-family: 'DM Mono', monospace;
    letter-spacing: .3px;
}
.os-order-chip__copy {
    background: none;
    border: none;
    cursor: pointer;
    padding: 2px 6px;
    border-radius: 6px;
    font-size: 11px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    color: var(--co-red);
    transition: background .15s;
}
.os-order-chip__copy:hover { background: var(--co-red-soft); }
.os-order-chip__copy.copied { color: var(--co-green); }

/* ── Body ── */
.os-body {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 10px 0;
}

/* ── Card ── */
.os-card {
    background: var(--co-white);
    overflow: hidden;
    opacity: 0;
    transform: translateY(10px);
    animation: os-fadein .36s ease forwards;
}
.os-card:nth-child(1) { animation-delay: .9s; }
.os-card:nth-child(2) { animation-delay: 1.0s; }
.os-card:nth-child(3) { animation-delay: 1.1s; }

/* ── Section label ── */
.os-section-label {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 12px 16px 10px;
    border-bottom: 1px solid var(--co-line);
}
.os-section-icon {
    width: 26px; height: 26px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.os-section-icon--green  { background: var(--co-green-soft); }
.os-section-icon--gray   { background: var(--co-bg); }
.os-section-icon--amber  { background: var(--co-amber-soft); }
.os-section-label__text {
    font-size: 12px;
    font-weight: 600;
    color: var(--co-ink2);
    text-transform: uppercase;
    letter-spacing: .5px;
}

/* ── Info rows ── */
.os-info-list { padding: 4px 0 8px; }
.os-info-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    padding: 9px 16px;
    border-bottom: 1px solid var(--co-bg);
}
.os-info-row:last-child { border-bottom: none; }
.os-info-key   { font-size: 13px; color: var(--co-ink3); flex-shrink: 0; }
.os-info-val   { font-size: 13px; color: var(--co-ink); font-weight: 500; text-align: right; }
.os-info-val--mono { font-family: 'DM Mono', monospace; }
.os-info-val--red  { color: var(--co-red); font-weight: 600; }
.os-info-val--green { color: var(--co-green); font-weight: 600; }

/* ── Status badge ── */
.os-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 600;
}
.os-badge--confirmed {
    background: var(--co-green-soft);
    color: var(--co-green);
}
.os-badge--pending {
    background: var(--co-amber-soft);
    color: var(--co-amber);
}
.os-badge__dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: currentColor;
}

/* ── Product item ── */
.os-product-list { display: flex; flex-direction: column; }
.os-product-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-bottom: 1px solid var(--co-bg);
}
.os-product-item:last-child { border-bottom: none; }
.os-product-img {
    width: 48px; height: 48px;
    border-radius: 9px;
    border: 1px solid var(--co-line);
    background: var(--co-bg);
    object-fit: contain;
    flex-shrink: 0;
}
.os-product-img-placeholder {
    width: 48px; height: 48px;
    border-radius: 9px;
    border: 1px solid var(--co-line);
    background: var(--co-bg);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.os-product-name {
    font-size: 13px;
    font-weight: 500;
    color: var(--co-ink);
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.os-product-right { text-align: right; flex-shrink: 0; }
.os-product-qty   { font-size: 11px; color: var(--co-ink3); font-family: 'DM Mono', monospace; }
.os-product-price { font-size: 13px; font-weight: 600; color: var(--co-red); font-family: 'DM Mono', monospace; }

/* ── Timeline ── */
.os-timeline { padding: 14px 16px; display: flex; flex-direction: column; gap: 0; }
.os-timeline-item {
    display: flex;
    gap: 12px;
    position: relative;
}
.os-timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 10px; top: 22px;
    width: 1px; height: calc(100% + 2px);
    background: var(--co-line);
}
.os-timeline-dot {
    width: 21px; height: 21px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 1px;
    display: flex; align-items: center; justify-content: center;
    z-index: 1;
}
.os-timeline-dot--done   { background: var(--co-green); }
.os-timeline-dot--active { background: var(--co-amber-soft); border: 2px solid var(--co-amber); }
.os-timeline-dot--wait   { background: var(--co-bg); border: 1.5px solid var(--co-line); }
.os-timeline-content { padding-bottom: 18px; }
.os-timeline-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--co-ink);
    margin-bottom: 2px;
}
.os-timeline-sub { font-size: 12px; color: var(--co-ink3); }

/* ── CTA buttons ── */
.os-cta {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 16px;
    opacity: 0;
    animation: os-fadein .4s ease 1.3s forwards;
}
.os-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    border-radius: 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: background .15s, transform .1s, opacity .15s;
    letter-spacing: -.1px;
}
.os-btn:active { transform: scale(.97); }
.os-btn--primary {
    background: var(--co-red);
    color: white;
}
.os-btn--primary:hover { background: #CC2D17; }
.os-btn--secondary {
    background: var(--co-white);
    color: var(--co-ink);
    border: 1.5px solid var(--co-line);
}
.os-btn--secondary:hover { background: var(--co-bg); }
</style>

<div class="os-root">

    {{-- ── Hero ── --}}
    <div class="os-hero">

        {{-- Confetti dots (JS inject) --}}
        <div class="os-confetti" id="confetti"></div>

        {{-- Animated checkmark --}}
        <div class="os-check-wrap">
            <div class="os-check-ring">
                <svg class="os-check-svg" width="36" height="36" viewBox="0 0 24 24"
                    fill="none" stroke="#1A7A4A" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>
        </div>

        <h1 class="os-hero__title">Pesanan Berhasil! 🎉</h1>
        <p class="os-hero__sub">
            Pesananmu sudah kami terima dan sedang diproses.<br>
            Terima kasih sudah belanja!
        </p>

        {{-- Order number --}}
        <div class="os-order-chip">
            <span class="os-order-chip__label">No. Pesanan</span>
            <span class="os-order-chip__num" id="orderNum">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
            <button class="os-order-chip__copy" id="copyOrderNum"
                data-num="#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}">
                Salin
            </button>
        </div>
    </div>

    <div class="os-body">

        {{-- ── Detail Pesanan ── --}}
        <div class="os-card">
            <div class="os-section-label">
                <div class="os-section-icon os-section-icon--green">
                    <svg width="14" height="14" fill="none" stroke="#1A7A4A" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                        <path d="M9 12h6M9 16h4"/>
                    </svg>
                </div>
                <span class="os-section-label__text">Detail Pesanan</span>
            </div>
            <div class="os-info-list">
                <div class="os-info-row">
                    <span class="os-info-key">Status</span>
                    @if ($order->payment_method === 'cod')
                        <span class="os-badge os-badge--confirmed">
                            <span class="os-badge__dot"></span>Dikonfirmasi
                        </span>
                    @else
                        <span class="os-badge os-badge--pending">
                            <span class="os-badge__dot"></span>Menunggu Pembayaran
                        </span>
                    @endif
                </div>
                <div class="os-info-row">
                    <span class="os-info-key">Tanggal</span>
                    <span class="os-info-val os-info-val--mono">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
                <div class="os-info-row">
                    <span class="os-info-key">Metode Bayar</span>
                    <span class="os-info-val">
                        {{ $order->payment_method === 'cod' ? 'Bayar di Tempat (COD)' : 'Transfer Bank' }}
                    </span>
                </div>
                <div class="os-info-row">
                    <span class="os-info-key">Alamat</span>
                    <span class="os-info-val" style="max-width:180px">
                        {{ $order->address->address ?? '-' }}
                    </span>
                </div>
                <div class="os-info-row">
                    <span class="os-info-key">Total Bayar</span>
                    <span class="os-info-val os-info-val--mono os-info-val--red">
                        Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Produk yang Dipesan ── --}}
        <div class="os-card">
            <div class="os-section-label">
                <div class="os-section-icon os-section-icon--gray">
                    <svg width="14" height="14" fill="none" stroke="#4A4A4A" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path d="M9 22V12h6v10"/>
                    </svg>
                </div>
                <span class="os-section-label__text">Produk Dipesan</span>
                <span style="margin-left:auto;font-size:11px;color:var(--co-ink3);font-family:'DM Mono',monospace">
                    {{ $order->items->count() }} item
                </span>
            </div>
            <div class="os-product-list">
                @foreach ($order->items as $item)
                    <div class="os-product-item">
                        @if ($item->product->image)
                            <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                                alt="{{ $item->product->name }}" class="os-product-img">
                        @else
                            <div class="os-product-img-placeholder">
                                <svg width="18" height="18" fill="none" stroke="#CCCCCC" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="os-product-name">{{ $item->product->name }}</span>
                        <div class="os-product-right">
                            <p class="os-product-qty">× {{ $item->quantity }}</p>
                            <p class="os-product-price">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Timeline Status ── --}}
        <div class="os-card">
            <div class="os-section-label">
                <div class="os-section-icon os-section-icon--amber">
                    <svg width="14" height="14" fill="none" stroke="#D97706" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <span class="os-section-label__text">Status Pengiriman</span>
            </div>
            <div class="os-timeline">

                <div class="os-timeline-item">
                    <div class="os-timeline-dot os-timeline-dot--done">
                        <svg width="10" height="10" fill="none" stroke="white" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                    </div>
                    <div class="os-timeline-content">
                        <p class="os-timeline-label">Pesanan Diterima</p>
                        <p class="os-timeline-sub">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="os-timeline-item">
                    @if ($order->payment_method === 'cod')
                        <div class="os-timeline-dot os-timeline-dot--active"></div>
                        <div class="os-timeline-content">
                            <p class="os-timeline-label">Sedang Diproses</p>
                            <p class="os-timeline-sub">Pesanan sedang disiapkan</p>
                        </div>
                    @else
                        <div class="os-timeline-dot os-timeline-dot--active"></div>
                        <div class="os-timeline-content">
                            <p class="os-timeline-label">Menunggu Pembayaran</p>
                            <p class="os-timeline-sub">Transfer sebelum 24 jam</p>
                        </div>
                    @endif
                </div>

                <div class="os-timeline-item">
                    <div class="os-timeline-dot os-timeline-dot--wait"></div>
                    <div class="os-timeline-content">
                        <p class="os-timeline-label" style="color:var(--co-ink3)">Dalam Pengiriman</p>
                        <p class="os-timeline-sub">Menunggu konfirmasi</p>
                    </div>
                </div>

                <div class="os-timeline-item">
                    <div class="os-timeline-dot os-timeline-dot--wait"></div>
                    <div class="os-timeline-content" style="padding-bottom:4px">
                        <p class="os-timeline-label" style="color:var(--co-ink3)">Pesanan Tiba</p>
                        <p class="os-timeline-sub">—</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── CTA Buttons ── --}}
        <div class="os-cta">
            @if ($order->payment_method === 'transfer')
                <a href="{{ route('customer.payment.instruction', $order->id) }}"
                    class="os-btn os-btn--primary">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <path d="M2 10h20"/>
                    </svg>
                    Lihat Instruksi Pembayaran
                </a>
            @endif
            <a href="{{ route('customer.orders.show', $order->id) }}"
                class="os-btn os-btn--{{ $order->payment_method === 'transfer' ? 'secondary' : 'primary' }}">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                </svg>
                Lihat Detail Pesanan
            </a>
            <a href="{{ route('customer.home') }}"
                class="os-btn os-btn--secondary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                    <path d="M9 21V12h6v9"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Confetti dots ───────────────────────────────────────────
    const confetti = document.getElementById('confetti');
    const colors = ['#E8341A','#1A7A4A','#D97706','#1A4A8A','#C026D3'];
    const sizes  = [5, 7, 9, 6, 8];

    for (let i = 0; i < 22; i++) {
        const dot = document.createElement('div');
        dot.className = 'os-dot';
        const size  = sizes[Math.floor(Math.random() * sizes.length)];
        const color = colors[Math.floor(Math.random() * colors.length)];
        const left  = Math.random() * 100;
        const delay = .5 + Math.random() * .8;
        const dur   = .8 + Math.random() * .6;

        dot.style.cssText = `
            width:${size}px; height:${size}px;
            background:${color};
            left:${left}%;
            top:${10 + Math.random() * 40}%;
            animation-duration:${dur}s;
            animation-delay:${delay}s;
        `;
        confetti.appendChild(dot);
    }

    // ── Salin nomor pesanan ─────────────────────────────────────
    const copyBtn = document.getElementById('copyOrderNum');
    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(copyBtn.dataset.num).then(() => {
                copyBtn.textContent = '✓ Tersalin';
                copyBtn.classList.add('copied');
                setTimeout(() => {
                    copyBtn.textContent = 'Salin';
                    copyBtn.classList.remove('copied');
                }, 2000);
            });
        });
    }

});
</script>

</x-app-layout>