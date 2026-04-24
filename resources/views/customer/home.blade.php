<x-app-layout>
    <main class="ef-root">

        {{-- ============================================================
        NOISE TEXTURE OVERLAY
        ============================================================ --}}
        <div class="ef-noise" aria-hidden="true"></div>

        <div class="ef-wrap">

            {{-- ============================================================
            LEFT COLUMN
            ============================================================ --}}
            <div class="ef-left">

                {{-- ── HERO BANNER ── --}}
                <div class="ef-hero" data-reveal>
                    <div class="ef-hero__inner">
                        <img src="{{ asset('assets/icons/luas.png') }}" alt="Banner Promosi" class="ef-hero__img">
                        <div class="ef-hero__overlay">
                            <span class="ef-hero__eyebrow">Promo Hari Ini</span>
                            <h1 class="ef-hero__title">Air Bersih,<br>Langsung ke Pintu Anda</h1>
                            <p class="ef-hero__sub">Galon premium Efata — segar, higienis, cepat sampai.</p>
                        </div>
                        <div class="ef-hero__badge">🔥 Gratis Ongkir</div>
                    </div>
                </div>

                {{-- ── REKOMENDASI ── --}}
                <section class="ef-section" data-reveal>
                    <div class="ef-section__head">
                        <div class="ef-section__label">
                            <span class="ef-section__dot"></span>
                            Rekomendasi untuk Anda
                        </div>
                        <span class="ef-section__hint">Berdasarkan preferensi Anda</span>
                    </div>

                    <div class="ef-grid ef-grid--3">
                        @for ($i = 0; $i < 3; $i++)
                            <article class="ef-card ef-card--featured" data-reveal data-delay="{{ $i * 80 }}">
                                <div class="ef-card__badges">
                                    <span class="ef-badge ef-badge--primary">⭐ Rekomendasi</span>
                                    <span class="ef-badge ef-badge--hot">Paling Laris 🔥</span>
                                </div>
                                <div class="ef-card__img-wrap">
                                    <img src="{{ asset('assets/icons/aqua-removebg-preview.png') }}" alt="Aqua Galon 19L"
                                        class="ef-card__img">
                                    <div class="ef-card__img-glow"></div>
                                </div>
                                <div class="ef-card__body">
                                    <h3 class="ef-card__name">Aqua Galon 19L</h3>
                                    <p class="ef-card__price">Rp9.000</p>
                                    <button class="ef-btn ef-btn--primary" onclick="addToCart(this)" data-id="1"
                                        data-product="Aqua Galon 19L">
                                        Pesan Sekarang
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </article>
                        @endfor
                    </div>
                </section>

                {{-- ── SEMUA PRODUK ── --}}
                <section class="ef-section" data-reveal>
                    <div class="ef-section__head">
                        <div class="ef-section__label">
                            <span class="ef-section__dot ef-section__dot--gray"></span>
                            Produk Galon Efata
                        </div>
                    </div>

                    <div class="ef-grid ef-grid--3">
                        @foreach ($products as $i => $product)
                            <article class="ef-card" data-reveal data-delay="{{ $i * 60 }}">
                                <div class="ef-card__img-wrap">
                                    <img src="{{ asset('assets/icons/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="ef-card__img">
                                </div>
                                <div class="ef-card__body">
                                    <h3 class="ef-card__name">{{ $product->name }}</h3>
                                    <p class="ef-card__price">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <button class="ef-btn ef-btn--outline" onclick="addToCart(this)"
                                        data-id="{{ $product->id }}" data-product="{{ $product->name }}">
                                        Pesan
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- ============================================================
            RIGHT SIDEBAR
            ============================================================ --}}
            <aside class="ef-sidebar">

                {{-- ── INFO CARD ── --}}
                <div class="ef-panel" data-reveal>
                    <div class="ef-panel__title">Ringkasan</div>

                    <div class="ef-inforow">
                        <div class="ef-inforow__icon ef-inforow__icon--blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div>
                            <p class="ef-inforow__label">Lokasi Pengantaran</p>
                            <p class="ef-inforow__value">Jl. Soekarno No.88</p>
                        </div>
                    </div>

                    <div class="ef-divider"></div>

                    <div class="ef-inforow">
                        <div class="ef-inforow__icon ef-inforow__icon--teal">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 001.99 1.61h9.72a2 2 0 001.99-1.61L23 6H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="ef-inforow__label">Pesanan Aktif</p>
                            <p class="ef-inforow__value ef-inforow__value--accent">2 Galon</p>
                        </div>
                    </div>

                    <div class="ef-divider"></div>

                    <div class="ef-inforow">
                        <div class="ef-inforow__icon ef-inforow__icon--orange">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="1" y="3" width="15" height="13" />
                                <path d="M16 8h4l3 3v5h-7V8zM5.5 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                <circle cx="18.5" cy="21" r="1.5" />
                            </svg>
                        </div>
                        <div>
                            <p class="ef-inforow__label">Status</p>
                            <p class="ef-inforow__value ef-inforow__value--orange">Dalam Pengantaran</p>
                        </div>
                    </div>
                </div>

                {{-- ── STATUS PESANAN ── --}}
                <div class="ef-panel ef-panel--order" data-reveal>
                    <div class="ef-panel__title">Status Pesanan</div>

                    <div class="ef-order">
                        <div class="ef-order__header">
                            <div>
                                <span class="ef-order__id">#00123</span>
                                <span class="ef-badge ef-badge--active">Aktif</span>
                            </div>
                            <p class="ef-order__status">Dalam Pengantaran</p>
                        </div>

                        <div class="ef-order__track">
                            <div class="ef-track__step ef-track__step--done">
                                <div class="ef-track__dot"></div>
                                <span>Pesanan Dikonfirmasi</span>
                            </div>
                            <div class="ef-track__line ef-track__line--done"></div>
                            <div class="ef-track__step ef-track__step--done">
                                <div class="ef-track__dot"></div>
                                <span>Sedang Dikemas</span>
                            </div>
                            <div class="ef-track__line ef-track__line--active"></div>
                            <div class="ef-track__step ef-track__step--active">
                                <div class="ef-track__dot ef-track__dot--pulse"></div>
                                <span>Di Perjalanan</span>
                            </div>
                            <div class="ef-track__line"></div>
                            <div class="ef-track__step">
                                <div class="ef-track__dot ef-track__dot--empty"></div>
                                <span>Tiba</span>
                            </div>
                        </div>

                        <div class="ef-order__meta">
                            <div class="ef-order__meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Kurir: <strong>Budi</strong>
                            </div>
                            <div class="ef-order__meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                                Estimasi: <strong>~10 mnt</strong>
                            </div>
                        </div>

                        <button class="ef-btn ef-btn--track">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            Lacak Sekarang
                        </button>
                    </div>
                </div>

                {{-- ── QUICK TIPS ── --}}
                <div class="ef-panel ef-panel--tip" data-reveal>
                    <div class="ef-tip__icon">💧</div>
                    <p class="ef-tip__text">Minum 8 gelas air per hari untuk tubuh yang sehat & prima.</p>
                </div>

            </aside>
        </div>

        {{-- ============================================================
        TOAST CONTAINER
        ============================================================ --}}
        <div id="ef-toast-container" aria-live="polite"></div>

        {{-- ============================================================
        SCRIPTS
        ============================================================ --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                // ── Scroll Reveal ──────────────────────────────────────────
                const revealEls = document.querySelectorAll('[data-reveal]');
                const ro = new IntersectionObserver((entries) => {
                    entries.forEach(e => {
                        if (!e.isIntersecting) return;
                        const delay = parseInt(e.target.dataset.delay || 0);
                        setTimeout(() => e.target.classList.add('ef-revealed'), delay);
                        ro.unobserve(e.target);
                    });
                }, { threshold: 0.12 });
                revealEls.forEach(el => ro.observe(el));

                // ── Cart Badge ─────────────────────────────────────────────
                function updateCartBadge() {
                    fetch('/customer/cart/count')
                        .then(r => r.json())
                        .then(data => {
                            document.querySelectorAll('.cart-icon').forEach(icon => {
                                let badge = icon.querySelector('.cart-count');
                                if (!badge && data.count > 0) {
                                    badge = document.createElement('span');
                                    badge.className = 'cart-count';
                                    icon.appendChild(badge);
                                }
                                if (badge) {
                                    badge.textContent = data.count;
                                    gsap.fromTo(badge, { scale: 1.6 }, { scale: 1, duration: 0.3, ease: 'back.out(2)' });
                                    if (data.count === 0) badge.remove();
                                }
                            });
                        });
                }

                // ── Splash Animation ───────────────────────────────────────
                function splashToCart(btn) {
                    const img = btn.closest('.ef-card')?.querySelector('.ef-card__img');
                    if (!img) return;

                    const tryRun = () => {
                        const cart = document.querySelector('.cart-icon');
                        if (cart) runSplash(img, cart);
                        else setTimeout(tryRun, 60);
                    };
                    tryRun();
                }

                function runSplash(img, cart) {
                    const rs = img.getBoundingClientRect();
                    const re = cart.getBoundingClientRect();
                    const sx = rs.left + rs.width / 2, sy = rs.top + rs.height / 2;
                    const ex = re.left + re.width / 2, ey = re.top + re.height / 2;

                    const dot = document.createElement('div');
                    dot.className = 'ef-splash';
                    document.body.appendChild(dot);

                    gsap.set(dot, { x: sx, y: sy, scale: 0.5, opacity: 1 });
                    gsap.to(dot, {
                        duration: 0.75, x: ex, y: ey, scale: 0.1, ease: 'power3.in',
                        onComplete: () => {
                            dot.remove();
                            gsap.fromTo(cart, { scale: 1 }, { scale: 1.35, yoyo: true, repeat: 1, duration: 0.12, ease: 'power2.out' });
                        }
                    });
                    gsap.to(img, { scale: 0.88, duration: 0.12, yoyo: true, repeat: 1 });
                }

                // ── Toast ──────────────────────────────────────────────────
                function showToast(name) {
                    const container = document.getElementById('ef-toast-container');
                    const t = document.createElement('div');
                    t.className = 'ef-toast';
                    t.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                <span>${name} ditambahkan ke keranjang</span>
            `;
                    container.prepend(t);
                    requestAnimationFrame(() => t.classList.add('ef-toast--show'));
                    setTimeout(() => {
                        t.classList.remove('ef-toast--show');
                        setTimeout(() => t.remove(), 400);
                    }, 2500);
                }

                // ── Add to Cart ────────────────────────────────────────────
                window.addToCart = function (btn) {
                    const id = btn.dataset.id;
                    const name = btn.dataset.product;

                    btn.disabled = true;
                    btn.classList.add('ef-btn--loading');

                    fetch('/customer/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ product_id: id, quantity: 1 })
                    })
                        .then(r => { if (!r.ok) throw new Error(); return r.json(); })
                        .then(() => {
                            updateCartBadge();
                            splashToCart(btn);
                            showToast(name);
                        })
                        .catch(() => alert('Gagal menambahkan ke keranjang'))
                        .finally(() => {
                            btn.disabled = false;
                            btn.classList.remove('ef-btn--loading');
                        });
                };
            });
        </script>

        {{-- ============================================================
        STYLES
        ============================================================ --}}


    </main>
</x-app-layout>