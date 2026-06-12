<x-app-layout>
    <div class="ef-chat">

        {{-- Header --}}
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
                    <button onclick="window.NotifSystem?.requestPermission()"
                        title="Aktifkan notifikasi"
                        style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:4px;border-radius:8px;display:flex;align-items:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.73 21a2 2 0 01-3.46 0"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="ef-chat__body">

            @if ($chats->isEmpty())
                {{-- Empty state --}}
                <div class="ef-chat__empty" data-reveal>
                    <div class="ef-chat__empty-visual">
                        <div class="ef-chat__empty-ring ef-chat__empty-ring--outer"></div>
                        <div class="ef-chat__empty-ring ef-chat__empty-ring--inner"></div>
                        <div class="ef-chat__empty-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                            </svg>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('courier'))
                        <h3 class="ef-chat__empty-title">Belum ada percakapan</h3>
                        <p class="ef-chat__empty-sub">Tunggu pesan masuk dari customer, atau hubungi depot.</p>
                        @if(isset($depotContact))
                            <a href="{{ route('courier.chat.show', $depotContact->id) }}" class="ef-chat__empty-btn" style="margin-top:1rem;">
                                Chat dengan Depot
                            </a>
                        @endif
                    @else
                        <h3 class="ef-chat__empty-title">Belum ada percakapan</h3>
                        <p class="ef-chat__empty-sub">Pesan dari kurir akan muncul di sini setelah kamu order.</p>
                        <a href="{{ route('customer.home') }}" class="ef-chat__empty-btn">Mulai Order</a>
                    @endif
                </div>

            @else
                <div class="ef-chat__list">
                    @foreach ($chats as $chat)
                        @php
                            $hasUnread  = $chat->unread_count > 0;
                            $isOrderChat = !is_null($chat->order_id);

                            // Bangun URL room — selalu sertakan order_id kalau ada
                            $roomUrl = auth()->user()->hasRole('customer')
                                ? route('customer.chat.show', ['receiver' => $chat->other_user_id])
                                : route('courier.chat.show', $chat->other_user_id);

                            if ($isOrderChat) {
                                $roomUrl .= '?order_id=' . $chat->order_id;
                            }
                        @endphp

                        {{-- data-room dipakai JS untuk match real-time event --}}
                        <a href="{{ $roomUrl }}"
                           class="ef-chat__item {{ $hasUnread ? 'ef-chat__item--unread' : '' }}"
                           data-room="{{ $isOrderChat ? 'order_' . $chat->order_id : 'user_' . $chat->other_user_id }}"
                           data-reveal
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
                                        {{ $chat->other_user->name ?? 'Unknown' }}
                                    </span>
                                    <span class="ef-chat__time {{ $hasUnread ? 'ef-chat__time--unread' : '' }}">
                                        {{ $chat->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                {{-- Order label — pembeda kalau ada beberapa order dengan orang yang sama --}}
                                @if($isOrderChat && $chat->order)
                                    <div style="font-size:.62rem;color:#94a3b8;font-weight:600;
                                                margin-bottom:2px;display:flex;align-items:center;gap:.3rem;">
                                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        {{ $chat->order->order_code }}
                                    </div>
                                @endif

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
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/>
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
            if (hiddenAt && Date.now() - hiddenAt > 3000) window.location.reload();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {

        // Scroll reveal
        const ro = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                setTimeout(() => e.target.classList.add('ef-revealed'), parseInt(e.target.dataset.delay || 0));
                ro.unobserve(e.target);
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('[data-reveal]').forEach(el => ro.observe(el));

        const authId = @json(auth()->id());

        function waitForEcho(cb) {
            let n = 0;
            const iv = setInterval(() => {
                if (window.Echo) { clearInterval(iv); cb(); }
                if (++n > 50) clearInterval(iv);
            }, 100);
        }

        /*
         * Cari item di list berdasarkan room key.
         * room key = "order_<id>" atau "user_<id>"
         * sesuai data-room attribute yang kita set di blade.
         */
        function findRoomItem(chat) {
            const roomKey = chat.order_id
                ? `order_${chat.order_id}`
                : `user_${chat.sender_id}`;
            return document.querySelector(`[data-room="${roomKey}"]`);
        }

        function addUnreadToItem(item, message) {
            if (!item) return;
            item.classList.add('ef-chat__item--unread');

            const preview = item.querySelector('.ef-chat__preview');
            if (preview) {
                preview.textContent = message;
                preview.classList.add('ef-chat__preview--unread');
            }
            item.querySelector('.ef-chat__name')?.classList.add('ef-chat__name--unread');
            item.querySelector('.ef-chat__time')?.classList.add('ef-chat__time--unread');

            // Dot avatar
            const avatar = item.querySelector('.ef-chat__avatar');
            if (avatar && !avatar.querySelector('.ef-chat__avatar-unread-dot')) {
                const dot = document.createElement('span');
                dot.className = 'ef-chat__avatar-unread-dot';
                avatar.appendChild(dot);
            }

            // Unread pill
            const existingPill = item.querySelector('.ef-chat__unread-pill');
            if (existingPill) {
                const cur = parseInt(existingPill.textContent) || 0;
                existingPill.textContent = cur + 1 > 99 ? '99+' : cur + 1;
            } else {
                const pill = document.createElement('span');
                pill.className = 'ef-chat__unread-pill';
                pill.textContent = '1';
                const previewRow = item.querySelector('.ef-chat__info > div:last-child');
                if (previewRow) previewRow.appendChild(pill);
            }
        }

        function clearUnreadFromItem(item) {
            if (!item) return;
            item.classList.remove('ef-chat__item--unread');
            item.querySelector('.ef-chat__name')?.classList.remove('ef-chat__name--unread');
            item.querySelector('.ef-chat__preview')?.classList.remove('ef-chat__preview--unread');
            item.querySelector('.ef-chat__time')?.classList.remove('ef-chat__time--unread');
            item.querySelector('.ef-chat__avatar-unread-dot')?.remove();
            item.querySelector('.ef-chat__unread-pill')?.remove();
        }

        waitForEcho(() => {
            window.Echo.private(`user.${authId}`)
                .listen('.chat.sent', e => {
                    if (String(e.chat.receiver_id) !== String(authId)) return;
                    const item = findRoomItem(e.chat);
                    addUnreadToItem(item, e.chat.message);
                    window.NotifSystem?.notify(
                        `Pesan dari ${e.chat.sender?.name ?? 'Seseorang'}`,
                        e.chat.message ?? ''
                    );
                })
                .listen('.chat.read', e => {
                    if (String(e.reader_id) !== String(authId)) return;
                    // Kalau kita yang baca (misal buka room di tab lain) → reset badge
                    const fakeChat = { order_id: e.order_id, sender_id: e.sender_id };
                    const item = findRoomItem(fakeChat);
                    clearUnreadFromItem(item);
                });
        });
    });
    </script>
</x-app-layout>