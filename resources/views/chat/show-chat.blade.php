<x-app-layout>
    <div class="ef-chatshow">

        {{-- ── Header ── --}}
        <div class="ef-chatshow__header">
            <div class="ef-chatshow__header-inner">
                <a href="{{ auth()->user()->hasRole('customer') ? route('customer.chat') : route('courier.chat') }}"
                    class="ef-chatshow__back">
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

                        <div class="ef-msg {{ $mine ? 'ef-msg--mine' : 'ef-msg--theirs' }}">
                            <div class="ef-msg__bubble {{ $mine ? 'ef-msg__bubble--mine' : 'ef-msg__bubble--theirs' }}">
                                <p class="ef-msg__text">{{ $chat->message }}</p>
                                <span class="ef-msg__time">{{ $chat->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Input --}}
                <div class="ef-chatshow__input-bar">
                    <div class="ef-chatshow__input-wrap">
                        <input id="messageInput" type="text" placeholder="Tulis pesan..." class="ef-chatshow__input"
                            onkeydown="if(event.key==='Enter')sendChat()">
                        <button onclick="sendChat()" class="ef-chatshow__send" id="sendBtn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13" />
                                <polygon points="22 2 15 22 11 13 2 9 22 2" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const authId = @json(auth()->id());
            const receiverId = @json($receiver->id);
            const [id1, id2] = [authId, receiverId].sort();

            const chatBox = document.getElementById('chatBox');
            const input = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');

            // Scroll ke bawah saat load
            chatBox.scrollTop = chatBox.scrollHeight;

            // ── Send ──────────────────────────────────────────────────
            window.sendChat = function () {
                const msg = input.value.trim();
                if (!msg) return;

                sendBtn.disabled = true;
                sendBtn.classList.add('ef-chatshow__send--loading');

                axios.post(
                    '{{ auth()->user()->hasRole('customer') ? route('customer.chat.send') : route('courier.chat.send') }}',
                    { receiver_id: receiverId, message: msg }
                ).then(res => {
                    appendMessage(res.data.chat, true);
                    input.value = '';
                }).catch(err => {
                    console.error('Send chat error:', err);
                }).finally(() => {
                    sendBtn.disabled = false;
                    sendBtn.classList.remove('ef-chatshow__send--loading');
                    input.focus();
                });
            };

            // ── Realtime ──────────────────────────────────────────────
            if (!window.Echo) { console.error('Laravel Echo belum ada'); return; }

            window.Echo.private(`chat.${id1}.${id2}`)
                .listen('.chat.sent', (e) => {
                    appendMessage(e.chat, e.chat.sender_id === authId);
                });

            // ── Append ────────────────────────────────────────────────
            function appendMessage(chat, isMine) {
                const div = document.createElement('div');
                div.className = `ef-msg ${isMine ? 'ef-msg--mine' : 'ef-msg--theirs'} ef-msg--new`;
                div.innerHTML = `
            <div class="ef-msg__bubble ${isMine ? 'ef-msg__bubble--mine' : 'ef-msg__bubble--theirs'}">
                <p class="ef-msg__text">${chat.message}</p>
                <span class="ef-msg__time">${chat.created_at}</span>
            </div>
        `;
                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight;
                // Trigger animasi
                requestAnimationFrame(() => div.classList.add('ef-msg--visible'));
            }
        });
    </script>
</x-app-layout>