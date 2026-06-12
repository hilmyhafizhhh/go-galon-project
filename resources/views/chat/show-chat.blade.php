<x-app-layout>
    <div class="ef-chatshow">

        {{-- ── Header ── --}}
        <div class="ef-chatshow__header">
            <div class="ef-chatshow__header-inner">
                <a href="{{ url()->previous() }}" class="ef-chatshow__back">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                </a>

                <div class="ef-chatshow__peer">
                    <div class="ef-chatshow__avatar">
                        {{ strtoupper(substr($receiver->name, 0, 1)) }}
                        <span class="ef-chatshow__online-dot"></span>
                    </div>
                    <div class="ef-chatshow__peer-text">
                        <p class="ef-chatshow__peer-name">{{ $receiver->name }}</p>
                        <p class="ef-chatshow__peer-status">
                            <span class="ef-chatshow__status-dot"></span>Online
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Chat Area ── --}}
        <div class="ef-chatshow__wrap">
            <div class="ef-chatshow__box-outer">

                {{-- Messages --}}
                <div id="chatBox" class="ef-chatshow__messages">

                    {{-- Date divider (statis, bisa dibuat dinamis) --}}
                    <div class="ef-chatshow__date-divider">
                        <span>Hari ini</span>
                    </div>

                    @foreach ($chats as $chat)
                        @php $mine = $chat->sender_id === auth()->id(); @endphp

                        <div class="ef-msg {{ $mine ? 'ef-msg--mine' : 'ef-msg--theirs' }}" data-chat-id="{{ $chat->id }}">
                            <div class="ef-msg__bubble {{ $mine ? 'ef-msg__bubble--mine' : 'ef-msg__bubble--theirs' }}">
                                <p class="ef-msg__text">{{ $chat->message }}</p>
                                <span class="ef-msg__time">
                                    {{ $chat->created_at->format('H:i') }}
                                    @if($mine)
                                        {{-- Ceklis read receipt --}}
                                        <span class="ef-msg__receipt {{ $chat->read_at ? 'ef-msg__receipt--read' : '' }}"
                                            data-receipt="{{ $chat->id }}">
                                            @if($chat->read_at)
                                                {{-- Double ceklis (sudah dibaca) --}}
                                                <svg width="16" height="10" viewBox="0 0 16 10" fill="none">
                                                    <path d="M1 5l3 3L11 1" stroke="currentColor" stroke-width="1.8"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M5 5l3 3 7-7" stroke="currentColor" stroke-width="1.8"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            @else
                                                {{-- Single ceklis (terkirim, belum dibaca) --}}
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                    <path d="M1 5l3 3 5-6" stroke="currentColor" stroke-width="1.8"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            @endif
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Input --}}
                {{-- Input --}}

                @if($chatLocked)
                    <div style="
                                            padding: 1rem 1.25rem;
                                            background: #f8fafc;
                                            border-top: 1px solid #e8ecf4;
                                            display: flex;
                                            align-items: center;
                                            gap: .75rem;
                                        ">
                        <div style="
                                                width: 36px;
                                                height: 36px;
                                                border-radius: 10px;
                                                background: #f1f5f9;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                flex-shrink: 0;
                                            ">
                            🔒
                        </div>

                        <div>
                            <div style="
                                                    font-size: .78rem;
                                                    font-weight: 600;
                                                    color: #475569;
                                                ">
                                Chat Ditutup
                            </div>

                            <div style="
                                                    font-size: .68rem;
                                                    color: #94a3b8;
                                                    margin-top: 2px;
                                                ">
                                {{ $lockedReason }}
                            </div>
                        </div>
                    </div>

                @else
                    <div class="ef-chatshow__input-bar">
                        <div class="ef-chatshow__input-wrap" style="display:flex;align-items:center;gap:.5rem;">

                            {{-- Quick Reply — hanya untuk kurir --}}
                            @if(auth()->user()->hasRole('courier'))
                                <div class="qr-wrap">
                                    <button class="qr-toggle" id="qrToggle" onclick="toggleQR()" title="Pesan Cepat">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                        </svg>
                                    </button>

                                    <div class="qr-sheet" id="qrSheet">
                                        <div class="qr-header">
                                            <span class="qr-title">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                                </svg>
                                                Pesan Cepat
                                            </span>
                                            <svg class="qr-chevron" id="qrChevron" width="14" height="14" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round" onclick="toggleQR()">
                                                <path d="M18 15l-6-6-6 6" />
                                            </svg>
                                        </div>
                                        <div class="qr-list">
                                            @php
                                                $quickReplies = [
                                                    '👋 Halo! Pesanan Anda sedang saya proses.',
                                                    '🚴 Saya sedang dalam perjalanan menuju lokasi Anda.',
                                                    '📍 Saya sudah tiba di depan lokasi Anda.',
                                                    '⏳ Mohon ditunggu, saya sedang mengambil pesanan galon Anda.',
                                                    '🪣 Galon sudah saya angkat, segera diantar.',
                                                    '🏠 Apakah pesanan bisa saya taruh di depan pintu?',
                                                    '📞 Tidak bisa menemukan lokasi, bisa hubungi saya?',
                                                    '✅ Pesanan sudah diterima, terima kasih sudah memesan!',
                                                    '🔄 Apakah galon lama ingin ditukar sekarang?',
                                                    '💧 Stok galon tersedia, pesanan segera dikirim.',
                                                ];
                                            @endphp

                                            @foreach($quickReplies as $reply)
                                                <div class="qr-item" onclick="useQuickReply({{ json_encode($reply) }})">
                                                    {{ $reply }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @elseif(auth()->user()->hasRole('customer'))
                                <div class="qr-wrap">
                                    <button class="qr-toggle" id="qrToggle" onclick="toggleQR()" title="Pesan Cepat">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                        </svg>
                                    </button>

                                    <div class="qr-sheet" id="qrSheet">
                                        <div class="qr-header">
                                            <span class="qr-title">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                                </svg>
                                                Pesan Cepat
                                            </span>
                                            <svg class="qr-chevron" id="qrChevron" width="14" height="14" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round" onclick="toggleQR()">
                                                <path d="M18 15l-6-6-6 6" />
                                            </svg>
                                        </div>
                                        <div class="qr-list">
                                            @php
                                                $quickReplies = [
                                                    '📍 Saya ada di dalam, tolong taruh di depan pintu ya.',
                                                    '🏠 Titip di depan pintu aja, makasih!',
                                                    '📞 Bisa telepon saya saat sudah sampai?',
                                                    '⏳ Ditunggu ya, saya segera ke bawah.',
                                                    '🔔 Tolong pencet bel kalau sudah sampai.',
                                                    '🗺️ Lokasi saya sudah benar, lanjut aja ya.',
                                                    '💧 Galon lamanya siap untuk ditukar.',
                                                    '🛗 Naik lift lantai 3, unit 302.',
                                                    '🚗 Taruh di depan pos satpam ya bang.',
                                                    '✅ Oke, saya tunggu. Makasih!',
                                                ];
                                            @endphp

                                            @foreach($quickReplies as $reply)
                                                <div class="qr-item" onclick="useQuickReply({{ json_encode($reply) }})">
                                                    {{ $reply }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input id="messageInput" type="text" placeholder="Tulis pesan..." class="ef-chatshow__input"
                                style="flex:1;" onkeydown="if(event.key==='Enter')sendChat()">

                            <button onclick="sendChat()" class="ef-chatshow__send" id="sendBtn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
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
            const authId = @json(auth()->id());
            const orderId = @json($order?->id ?? null);
            const receiverId = @json($receiver->id);
            const [id1, id2] = [authId, receiverId].sort();

            const chatBox = document.getElementById('chatBox');
            const input = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');

            chatBox.scrollTop = chatBox.scrollHeight;

            // ── Send ──────────────────────────────────────────────────
            window.sendChat = function (message = null) {
                const msg = message ?? input.value.trim();
                if (!msg) return;
                sendBtn.disabled = true;

                axios.post(
                    '{{ auth()->user()->hasRole('customer') ? '/customer/chat/send' : '/courier/chat/send' }}',
                    {
                        receiver_id: receiverId,
                        message: msg,
                        order_id: orderId
                    }
                )
                    .then(res => {
                        appendMessage(res.data.chat, true);

                        if (!message) {
                            input.value = '';
                        }
                    })
                    .catch(err => {
                        if (err.response?.status === 403) {
                            alert(err.response.data.message);

                            window.location.reload();
                        }
                    })
                    .finally(() => {
                        sendBtn.disabled = false;

                        if (input) {
                            input.focus();
                        }
                    });
            };

            if (!window.Echo) { console.error('Laravel Echo belum ada'); return; }

            // ── Realtime: pakai channel order kalau ada, fallback ke user-pair ──
            const chatChannel = orderId
                ? window.Echo.private(`order.${orderId}`)
                : window.Echo.private(`chat.${id1}.${id2}`);

            chatChannel.listen('.chat.sent', (e) => {
                // Skip pesan sendiri (karena broadcast toOthers, seharusnya tidak ada)
                // tapi tetap guard untuk keamanan
                if (String(e.chat.sender_id) === String(authId)) return;

                appendMessage(e.chat, false);
                markAsRead([e.chat.id]);
                window.NotifSystem?.playSound();
            });

            // ── Read receipt: listen ke channel user sendiri ──
            window.Echo.private(`user.${authId}`)
                .listen('.chat.read', (e) => {
                    (e.chat_ids ?? []).forEach(chatId => {
                        const receipt = document.querySelector(`[data-receipt="${chatId}"]`);
                        if (!receipt) return;
                        receipt.classList.add('ef-msg__receipt--read');
                        receipt.innerHTML = `
                    <svg width="16" height="10" viewBox="0 0 16 10" fill="none">
                        <path d="M1 5l3 3L11 1" stroke="currentColor" stroke-width="1.8"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 5l3 3 7-7" stroke="currentColor" stroke-width="1.8"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>`;
                    });
                });

            function markAsRead(chatIds) {
                axios.post(
                    '{{ auth()->user()->hasRole('customer') ? '/customer/chat/mark-read' : '/courier/chat/mark-read' }}',
                    { chat_ids: chatIds }
                ).catch(() => { });
            }

            function appendMessage(chat, isMine) {
                const div = document.createElement('div');
                div.className = `ef-msg ${isMine ? 'ef-msg--mine' : 'ef-msg--theirs'} ef-msg--new`;
                div.dataset.chatId = chat.id;

                const receipt = isMine ? `
            <span class="ef-msg__receipt" data-receipt="${chat.id}">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                    <path d="M1 5l3 3 5-6" stroke="currentColor" stroke-width="1.8"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>` : '';

                div.innerHTML = `
            <div class="ef-msg__bubble ${isMine ? 'ef-msg__bubble--mine' : 'ef-msg__bubble--theirs'}">
                <p class="ef-msg__text">${chat.message}</p>
                <span class="ef-msg__time">${chat.created_at}${receipt}</span>
            </div>`;

                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight;
                requestAnimationFrame(() => div.classList.add('ef-msg--visible'));
            }
        });

        // ── Quick Reply ──────────────────────────────────────
        function toggleQR() {
            const sheet = document.getElementById('qrSheet');
            const toggle = document.getElementById('qrToggle');
            const chevron = document.getElementById('qrChevron');
            const isOpen = sheet.classList.contains('open');
            sheet.classList.toggle('open', !isOpen);
            toggle.classList.toggle('active', !isOpen);
            chevron.classList.toggle('rotated', !isOpen);
        }

        function useQuickReply(msg) {
            sendChat(msg);
            document.getElementById('qrSheet').classList.remove('open');
            document.getElementById('qrToggle').classList.remove('active');
            document.getElementById('qrChevron').classList.remove('rotated');
        }

        document.addEventListener('click', (e) => {
            const wrap = document.querySelector('.qr-wrap');
            if (wrap && !wrap.contains(e.target)) {
                document.getElementById('qrSheet')?.classList.remove('open');
                document.getElementById('qrToggle')?.classList.remove('active');
                document.getElementById('qrChevron')?.classList.remove('rotated');
            }
        });
    </script>
</x-app-layout>