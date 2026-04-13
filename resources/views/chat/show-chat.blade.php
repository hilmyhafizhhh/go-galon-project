<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-blue-100 flex items-center justify-center rounded-full font-semibold text-blue-600">
                {{ strtoupper(substr($receiver->name, 0, 1)) }}
            </div>
            <h2 class="font-semibold text-xl text-gray-800">{{ $receiver->name }}</h2>
        </div>
    </x-slot>

    <div
        class="flex flex-col h-[75vh] max-w-2xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">

        <!-- CHAT MESSAGES -->
        <div id="chatBox" class="flex-1 overflow-y-auto p-5 space-y-3 bg-gradient-to-b from-gray-50 to-white">
            @foreach ($chats as $chat)
                @if ($chat->sender_id === auth()->id())
                    <div class="flex justify-end">
                        <div class="bg-blue-600 text-white px-4 py-2.5 rounded-2xl rounded-br-sm max-w-xs shadow-sm">
                            <p class="text-sm leading-relaxed">{{ $chat->message }}</p>
                            <span class="text-[10px] text-white/70 block text-right mt-1">
                                {{ $chat->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start">
                        <div class="bg-gray-100 px-4 py-2.5 rounded-2xl rounded-bl-sm max-w-xs shadow-sm">
                            <p class="text-sm leading-relaxed text-gray-800">{{ $chat->message }}</p>
                            <span class="text-[10px] text-gray-500 block text-right mt-1">
                                {{ $chat->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- CHAT INPUT -->
        <div class="border-t bg-white/90 backdrop-blur-sm p-4 flex items-center gap-3">
            <input id="messageInput" type="text" placeholder="Tulis pesan..."
                class="flex-1 border border-gray-300 rounded-full px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <button onclick="sendChat()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full text-sm font-medium shadow-md transition-all duration-200">
                Kirim
            </button>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // const authId = Number(@json(auth()->id()));
        // const receiverId = Number(@json($receiver->id));

        const authId = @json(auth()->id());
        const receiverId = @json($receiver->id);

        // const id1 = Math.min(authId, receiverId);
        // const id2 = Math.max(authId, receiverId);

        const [id1, id2] = [authId, receiverId].sort();

        const chatBox = document.getElementById("chatBox");
        const input = document.getElementById("messageInput");

        // ===============================
        // SEND CHAT
        // ===============================
        window.sendChat = function () {
            const msg = input.value.trim();
            if (!msg) return;

            axios.post(
                '{{ auth()->user()->hasRole('customer') ? route('customer.chat.send') : route('courier.chat.send') }}',
                {
                    receiver_id: receiverId,
                    message: msg
                }
            ).then(res => {
                appendMessage(res.data.chat, true);
                input.value = "";
            }).catch(err => {
                console.error("Send chat error:", err);
            });
        };

        // ===============================
        // REALTIME LISTENER
        // ===============================
        if (!window.Echo) {
            console.error("Laravel Echo belum ada");
            return;
        }

        window.Echo.private(`chat.${id1}.${id2}`)
            .subscribed(() => {
                console.log("✅ Subscribed to chat channel");
            })
            .error(err => {
                console.error("❌ Channel auth error:", err);
            })
            .listen('.chat.sent', (e) => {
                console.log("📩 Incoming chat:", e.chat);

                // JANGAN filter sender di awal debugging
                appendMessage(e.chat, e.chat.sender_id === authId);
            });

        // ===============================
        // HELPER
        // ===============================
        function appendMessage(chat, isMine) {
            chatBox.innerHTML += `
                                    <div class="flex ${isMine ? 'justify-end' : 'justify-start'}">
                                        <div class="${isMine ? 'bg-blue-600 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm'}
                                            px-4 py-2.5 rounded-2xl max-w-xs shadow-sm">
                                            <p class="text-sm leading-relaxed">${chat.message}</p>
                                            <span class="text-[10px] ${isMine ? 'text-white/70' : 'text-gray-500'} block text-right mt-1">
                                                ${chat.created_at}
                                            </span>
                                        </div>
                                    </div>
                                `;

            chatBox.scrollTop = chatBox.scrollHeight;
        }


    });
</script>