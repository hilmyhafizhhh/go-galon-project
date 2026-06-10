<x-app-layout>
    <div class="ef-chat">

        {{-- ── Header ── --}}
        <div class="ef-chat__header">
            <div class="ef-chat__header-inner">
                <div>
                    <h1 class="ef-chat__title">Pesan</h1>
                    <p class="ef-chat__subtitle">
                        @if(auth()->user()->hasRole('courier'))
                            Percakapan dengan customer & depot
                        @else
                            Percakapan dengan kurir & toko
                        @endif
                    </p>
                </div>
                <div class="ef-chat__header-icon">
                    {{-- Tombol aktifkan notifikasi --}}
                    <button onclick="window.NotifSystem?.requestPermission()" id="notifPermBtn"
                        title="Aktifkan notifikasi" style="background:none;border:none;cursor:pointer;
                                color:#94a3b8;padding:4px;border-radius:8px;
                                transition:color .15s;display:flex;align-items:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 01-3.46 0" />
                        </svg>
                    </button>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- ── Content ── --}}
        <div class="ef-chat__body">


            {{-- ── Empty State ── --}}
            @if ($chats->isEmpty())
                <div class="ef-chat__empty" data-reveal>
                    <div class="ef-chat__empty-visual">
                        <div class="ef-chat__empty-ring ef-chat__empty-ring--outer"></div>
                        <div class="ef-chat__empty-ring ef-chat__empty-ring--inner"></div>
                        <div class="ef-chat__empty-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('courier'))
                        <h3 class="ef-chat__empty-title">Belum ada percakapan</h3>
                        <p class="ef-chat__empty-sub">Hubungi depot atau tunggu pesan masuk dari customer.</p>

                        {{-- Tombol chat dengan depot --}}
                        @if(isset($depotContact))
                            <a href="{{ route('courier.chat.show', $depotContact->id) }}" class="ef-chat__empty-btn"
                                style="margin-top:1rem;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                </svg>
                                Chat dengan Depot
                            </a>
                        @endif

                    @else
                        <h3 class="ef-chat__empty-title">Belum ada percakapan</h3>
                        <p class="ef-chat__empty-sub">Pesan dari kurir atau toko akan muncul di sini setelah kamu melakukan
                            order.</p>
                        <a href="{{ route('customer.home') }}" class="ef-chat__empty-btn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6" />
                            </svg>
                            Mulai Order
                        </a>
                    @endif
                </div>

            @else

                {{-- ── Chat List ── --}}
                <div class="ef-chat__list">
                    @foreach ($chats as $chat)
                            @php $hasUnread = $chat->unread_count > 0; @endphp

                            <a href="{{ auth()->user()->hasRole('customer')
                        ? route('customer.chat.show', ['receiver' => $chat->other_user_id])
                        : route('courier.chat.show', $chat->other_user_id) }}"
                                class="ef-chat__item {{ $hasUnread ? 'ef-chat__item--unread' : '' }}" data-reveal
                                data-delay="{{ $loop->index * 50 }}">

                                {{-- Avatar --}}
                                <div class="ef-chat__avatar" style="position:relative;">
                                    {{ strtoupper(substr($chat->other_user->name ?? 'U', 0, 1)) }}
                                    @if($hasUnread)
                                        <span class="ef-chat__avatar-unread-dot"></span>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="ef-chat__info">
                                    <div class="ef-chat__info-top">
                                        <span class="ef-chat__name {{ $hasUnread ? 'ef-chat__name--unread' : '' }}">
                                            {{ $chat->other_user->name ?? 'Unknown User' }}
                                        </span>
                                        <span class="ef-chat__time {{ $hasUnread ? 'ef-chat__time--unread' : '' }}">
                                            {{ $chat->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">
                                        <p class="ef-chat__preview {{ $hasUnread ? 'ef-chat__preview--unread' : '' }}">
                                            {{ Str::limit($chat->message, 45) }}
                                        </p>
                                        @if($hasUnread)
                                            <span class="ef-chat__unread-pill">
                                                {{ $chat->unread_count > 99 ? '99+' : $chat->unread_count }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Chevron --}}
                                <svg class="ef-chat__chevron" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>

                            </a>
                    @endforeach
                </div>

            @endif

        </div>
    </div>
    <script>
        let hiddenAt = null;

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                hiddenAt = Date.now();
            } else if (document.visibilityState === 'visible') {
                // Reload kalau sudah lebih dari 3 detik meninggalkan halaman
                if (hiddenAt && Date.now() - hiddenAt > 3000) {
                    window.location.reload();
                }
            }
        });
        
        document.addEventListener('DOMContentLoaded', () => {

            // ── Scroll Reveal ──
            const els = document.querySelectorAll('[data-reveal]');
            const ro = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    const delay = parseInt(e.target.dataset.delay || 0);
                    setTimeout(() => e.target.classList.add('ef-revealed'), delay);
                    ro.unobserve(e.target);
                });
            }, { threshold: 0.08 });
            els.forEach(el => ro.observe(el));

            // ── Realtime unread badge di list chat ──
            const authId = @json(auth()->id());

            function waitForEcho(cb) {
                let attempts = 0;
                const iv = setInterval(() => {
                    attempts++;
                    if (window.Echo) { clearInterval(iv); cb(); }
                    if (attempts > 50) clearInterval(iv);
                }, 100);
            }

            waitForEcho(() => {

                // Pesan baru masuk → tambah unread indicator
                window.Echo.private(`user.${authId}`)
                    .listen('.chat.sent', (e) => {
                        if (e.chat.receiver_id !== authId) return;
                        const senderId = String(e.chat.sender_id);
                        const item = document.querySelector(`a[href*="${senderId}"].ef-chat__item`);
                        if (!item) return;

                        item.classList.add('ef-chat__item--unread');

                        const preview = item.querySelector('.ef-chat__preview');
                        if (preview) {
                            preview.textContent = e.chat.message;
                            preview.classList.add('ef-chat__preview--unread');
                        }

                        item.querySelector('.ef-chat__name')?.classList.add('ef-chat__name--unread');
                        item.querySelector('.ef-chat__time')?.classList.add('ef-chat__time--unread');

                        // Dot di avatar
                        const avatar = item.querySelector('.ef-chat__avatar');
                        if (avatar && !avatar.querySelector('.ef-chat__avatar-unread-dot')) {
                            const dot = document.createElement('span');
                            dot.className = 'ef-chat__avatar-unread-dot';
                            avatar.appendChild(dot);
                        }

                        // Pill unread count
                        let pillWrap = item.querySelector('.ef-chat__unread-row');
                        if (!pillWrap) {
                            pillWrap = document.createElement('div');
                            pillWrap.className = 'ef-chat__unread-row';
                            pillWrap.style.cssText = 'display:flex;align-items:center;justify-content:space-between;gap:.5rem;';
                            const existingPreview = item.querySelector('.ef-chat__preview');
                            if (existingPreview) {
                                existingPreview.parentNode.insertBefore(pillWrap, existingPreview);
                                pillWrap.appendChild(existingPreview);
                                const pill = document.createElement('span');
                                pill.className = 'ef-chat__unread-pill';
                                pill.textContent = '1';
                                pillWrap.appendChild(pill);
                            }
                        } else {
                            const pill = pillWrap.querySelector('.ef-chat__unread-pill');
                            if (pill) {
                                const current = parseInt(pill.textContent) || 0;
                                pill.textContent = current + 1 > 99 ? '99+' : current + 1;
                                pill.style.display = 'inline-flex';
                            }
                        }
                    });

                // Read event → reset unread indicator kalau kita yang baca
                window.Echo.private(`user.${authId}`)
                    .listen('.chat.read', (e) => {
                        if (String(e.reader_id) !== String(authId)) return;
                        const senderId = String(e.sender_id);
                        const item = document.querySelector(`a[href*="${senderId}"].ef-chat__item`);
                        if (!item) return;

                        const senderName = e.chat.sender?.name ?? 'Seseorang';

                        // Sound + push
                        window.NotifSystem?.notify(
                            `Pesan dari ${senderName}`,
                            e.chat.message ?? '',
                        );


                        item.classList.remove('ef-chat__item--unread');
                        item.querySelector('.ef-chat__name')?.classList.remove('ef-chat__name--unread');
                        item.querySelector('.ef-chat__preview')?.classList.remove('ef-chat__preview--unread');
                        item.querySelector('.ef-chat__time')?.classList.remove('ef-chat__time--unread');
                        item.querySelector('.ef-chat__avatar-unread-dot')?.remove();
                        item.querySelector('.ef-chat__unread-pill')?.remove();
                    });
            });
        });
    </script>

</x-app-layout>