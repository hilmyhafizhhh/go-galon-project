<x-app-layout>
    {{-- Main Content --}}
    <main class="bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-3 gap-6 transition-all duration-300">

            {{-- Kiri: Banner & Produk --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Banner Promosi --}}
                <div
                    class="rounded-xl overflow-hidden shadow-lg opacity-0 translate-y-10 transition-all duration-700 scroll-fade">
                    <img src="{{ asset('assets/icons/luas.png') }}" alt="Banner Promosi"
                        class="w-full h-48 sm:h-52 md:h-64 lg:h-96 object-cover bg-blue-500">
                </div>

                {{-- Produk Populer --}}
                <section>
                    <h2
                        class="text-base sm:text-lg font-bold mb-4 flex items-center gap-1 text-gray-800 dark:text-gray-100 transition duration-700 opacity-0 translate-y-10 scroll-fade">
                        Produk Galon Efata
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-3 gap-3 sm:gap-5 items-stretch">
                        {{-- Produk 1 --}}
                        <div
                            class="product-card bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-700 opacity-0 translate-y-10 scroll-fade flex flex-col justify-between">
                            <div
                                class="bg-white dark:bg-blue-900/30 rounded-lg p-3 mb-2 text-center flex justify-center">
                                <img src="{{ asset('assets/icons/aqua.png') }}" alt="Aqua"
                                    class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 object-contain transition-transform duration-500 ease-in-out hover:scale-125">
                            </div>
                            <div class="text-center flex flex-col justify-between flex-1">
                                <h3 class="font-semibold text-sm sm:text-base mb-1 text-gray-800 dark:text-gray-100">
                                    Aqua</h3>
                                <p class="text-blue-800 dark:text-blue-400 font-bold text-lg sm:text-xl mb-2">Rp6.000
                                </p>
                                <button onclick="splashToCart(this)" data-product="Aqua"
                                    class="btn-pesan w-full bg-blue-800 dark:bg-blue-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-blue-950 dark:hover:bg-blue-500 transition flex items-center justify-center gap-1 sm:gap-2">
                                    Pesan
                                </button>
                            </div>
                        </div>

                        {{-- Produk 2 --}}
                        <div
                            class="product-card bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-700 opacity-0 translate-y-10 scroll-fade flex flex-col justify-between">
                            <div
                                class="bg-white dark:bg-green-900/30 rounded-lg p-3 mb-2 text-center flex justify-center">
                                <img src="{{ asset('assets/icons/minerale.png') }}" alt="Le Minerale"
                                    class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 object-contain transition-transform duration-500 ease-in-out hover:scale-125">
                            </div>
                            <div class="text-center flex flex-col justify-between flex-1">
                                <h3 class="font-semibold text-sm sm:text-base mb-1 text-gray-800 dark:text-gray-100">Le
                                    Minerale</h3>
                                <p class="text-blue-800 dark:text-blue-400 font-bold text-lg sm:text-xl mb-2">Rp6.000
                                </p>
                                <button onclick="splashToCart(this)" data-product="Le Minerale"
                                    class="btn-pesan w-full bg-blue-800 dark:bg-blue-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-blue-950 dark:hover:bg-blue-500 transition flex items-center justify-center gap-1 sm:gap-2">
                                    Pesan
                                </button>
                            </div>
                        </div>

                        {{-- Produk 3 --}}
                        <div
                            class="product-card bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-700 opacity-0 translate-y-10 scroll-fade flex flex-col justify-between">
                            <div
                                class="bg-white dark:bg-blue-900/30 rounded-lg p-3 mb-2 text-center flex justify-center">
                                <img src="{{ asset('assets/icons/vit.png') }}" alt="Vite"
                                    class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 object-contain transition-transform duration-500 ease-in-out hover:scale-125">
                            </div>
                            <div class="text-center flex flex-col justify-between flex-1">
                                <h3 class="font-semibold text-sm sm:text-base mb-1 text-gray-800 dark:text-gray-100">
                                    Vite</h3>
                                <p class="text-blue-800 dark:text-blue-400 font-bold text-lg sm:text-xl mb-2">Rp6.000
                                </p>
                                <button onclick="splashToCart(this)" data-product="Vite"
                                    class="btn-pesan w-full bg-blue-800 dark:bg-blue-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-blue-950 dark:hover:bg-blue-500 transition flex items-center justify-center gap-1 sm:gap-2">
                                    Pesan
                                </button>
                            </div>
                        </div>

                        {{-- Produk 4 --}}
                        <div
                            class="product-card bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-700 opacity-0 translate-y-10 scroll-fade flex flex-col justify-between">
                            <div
                                class="bg-white dark:bg-green-900/30 rounded-lg p-3 mb-2 text-center flex justify-center">
                                <img src="{{ asset('assets/icons/cleo.png') }}" alt="Cleo"
                                    class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 object-contain transition-transform duration-500 ease-in-out hover:scale-125">
                            </div>
                            <div class="text-center flex flex-col justify-between flex-1">
                                <h3 class="font-semibold text-sm sm:text-base mb-1 text-gray-800 dark:text-gray-100">
                                    Cleo</h3>
                                <p class="text-blue-800 dark:text-blue-400 font-bold text-lg sm:text-xl mb-2">Rp6.000
                                </p>
                                <button onclick="splashToCart(this)" data-product="Cleo"
                                    class="btn-pesan w-full bg-blue-800 dark:bg-blue-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-blue-950 dark:hover:bg-blue-500 transition flex items-center justify-center gap-1 sm:gap-2">
                                    Pesan
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Kanan: Info & Status Pesanan --}}
            <aside class="space-y-6">
                {{-- Info Singkat --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700 transition duration-700 opacity-0 translate-y-10 scroll-fade">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Lokasi Pengantaran</p>
                            <p class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-100">Jl. Soekarno
                                No.88</p>
                        </div>
                        <img src="{{ asset('assets/icons/Maps.svg') }}" alt="Lokasi" class="w-6 h-6 sm:w-8 sm:h-8">
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Pesanan Aktif</p>
                            <p class="font-semibold text-blue-800 dark:text-blue-400 text-sm sm:text-base">2 Galon</p>
                        </div>
                        <img src="{{ asset('assets/icons/Shopping Cart.svg') }}" alt="Keranjang"
                            class="w-6 h-6 sm:w-8 sm:h-8">
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Status</p>
                            <p class="font-semibold text-orange-500 text-sm sm:text-base">Sedang Dalam Pengantaran</p>
                        </div>
                        <img src="{{ asset('assets/icons/Delivery Scooter.svg') }}" alt="Pengantaran"
                            class="w-6 h-6 sm:w-8 sm:h-8 animate-pulse">
                    </div>
                </div>

                {{-- Status Pesanan --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700 transition duration-700 opacity-0 translate-y-10 scroll-fade">
                    <h2
                        class="text-base sm:text-lg font-bold mb-3 flex items-center text-orange-500 dark:text-gray-100">
                        Status Pesanan</h2>
                    <div class="border-l-4 border-orange-500 pl-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-100">#00123
                                </p>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Dalam Pengantaran</p>
                            </div>
                            <span
                                class="bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400 px-2 py-1 rounded-full text-[10px] sm:text-xs">Aktif</span>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3">Kurir: Budi</p>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4">Estimasi: 10 menit</p>
                        <button
                            class="w-full bg-orange-500 dark:bg-orange-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-orange-600 dark:hover:bg-orange-500 transition flex items-center justify-center gap-2">
                            Lacak Sekarang
                        </button>
                    </div>
                </div>
            </aside>
        </div>

        {{-- GSAP CDN + SCRIPT --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Scroll Fade
                const elements = document.querySelectorAll(".scroll-fade");
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("opacity-100", "translate-y-0");
                            entry.target.classList.remove("opacity-0", "translate-y-10");
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });
                elements.forEach(el => observer.observe(el));

                // === SPLASH TO CART (TUNGGU .cart-icon) ===
                window.splashToCart = function(btn) {
                    const productCard = btn.closest('.product-card');
                    const img = productCard?.querySelector('img');
                    const productName = btn.dataset.product || "Produk";

                    if (!img) return;

                    let cart = document.querySelector('.cart-icon');
                    if (!cart) {
                        const startTime = Date.now();
                        const wait = setInterval(() => {
                            cart = document.querySelector('.cart-icon');
                            if (cart || Date.now() - startTime > 3000) {
                                clearInterval(wait);
                                if (cart) runSplash(img, cart, productName);
                            }
                        }, 50);
                    } else {
                        runSplash(img, cart, productName);
                    }
                };

                function runSplash(img, cart, productName) {
                    const rectStart = img.getBoundingClientRect();
                    const rectEnd = cart.getBoundingClientRect();

                    const startX = rectStart.left + rectStart.width / 2;
                    const startY = rectStart.top + rectStart.height / 2;
                    const endX = rectEnd.left + rectEnd.width / 2;
                    const endY = rectEnd.top + rectEnd.height / 2;

                    const splash = document.createElement('div');
                    splash.className = 'fixed pointer-events-none z-[99999]';
                    splash.innerHTML = `
                        <div class="absolute w-32 h-32 -ml-16 -mt-16">
                            <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping opacity-80"></div>
                            <div class="absolute inset-2 bg-cyan-400 rounded-full animate-ping delay-100 opacity-70"></div>
                            <div class="absolute inset-4 bg-white rounded-full animate-pulse"></div>
                        </div>
                    `;
                    document.body.appendChild(splash);

                    gsap.set(splash, {
                        x: startX,
                        y: startY,
                        scale: 0.4,
                        opacity: 1
                    });

                    gsap.to(splash, {
                        duration: 0.9,
                        x: endX,
                        y: endY,
                        scale: 0.15,
                        ease: "power2.in",
                        onComplete: () => {
                            splash.remove();
                            gsap.to(cart, {
                                scale: 1.3,
                                duration: 0.15,
                                yoyo: true,
                                repeat: 1,
                                ease: "elastic.out"
                            });
                            tampilkanPopup(productName);
                            updateCartBadge();
                        }
                    });

                    gsap.to(img, {
                        scale: 0.9,
                        duration: 0.15,
                        yoyo: true,
                        repeat: 1
                    });
                }

                function tampilkanPopup(nama) {
                    const popup = document.createElement('div');
                    popup.innerHTML = `
                        <div class="fixed top-6 right-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-3 rounded-xl shadow-2xl z-[9999] flex items-center gap-2 animate-popup font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>${nama} ditambahkan!</span>
                        </div>
                    `;
                    document.body.appendChild(popup);
                    setTimeout(() => popup.remove(), 2200);
                }

                function updateCartBadge() {
                    const badge = document.querySelector('.cart-icon .bg-red-600');
                    if (badge) {
                        let count = parseInt(badge.textContent) || 0;
                        badge.textContent = count + 1;
                        gsap.fromTo(badge, {
                            scale: 1.5
                        }, {
                            scale: 1,
                            duration: 0.3,
                            ease: "bounce.out"
                        });
                    }
                }
            });
        </script>

        <style>
            @keyframes ping {
                0% {
                    transform: scale(1);
                    opacity: 0.8;
                }

                75%,
                100% {
                    transform: scale(2.5);
                    opacity: 0;
                }
            }

            .animate-ping {
                animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
            }

            .delay-100 {
                animation-delay: 0.1s;
            }

            @keyframes popup {
                0% {
                    transform: translateX(100%) scale(0.8);
                    opacity: 0;
                }

                60% {
                    transform: translateX(-10px) scale(1.05);
                }

                100% {
                    transform: translateX(0) scale(1);
                    opacity: 1;
                }
            }

            .animate-popup {
                animation: popup 0.5s ease-out forwards;
            }
        </style>
    </main>
</x-app-layout>
