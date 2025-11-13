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
                @if($chat->sender_id === auth()->id())
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
    window.onload = function () {
        window.sendChat = function () {
            const input = document.getElementById("messageInput");
            const msg = input.value.trim();
            if (!msg) return;

            axios.post('{{ route('customer.chat.send') }}', {
                receiver_id: @json($receiver->id),
                receiver_role: @json($receiver->getRoleNames()->first()),
                message: msg
            }).then(res => {
                document.getElementById("chatBox").innerHTML += `
                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-2.5 rounded-2xl rounded-br-sm max-w-xs shadow-sm">
                        <p class="text-sm leading-relaxed">${res.data.chat.message}</p>
                        <span class="text-[10px] text-white/70 block text-right mt-1">${res.data.chat.created_at}</span>
                    </div>
                </div>`;
                input.value = "";
                document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
            });
        };

        window.Echo.channel("chat.channel")
            .listen(".chat.sent", (e) => {
                if (e.chat.receiver_id != @json(auth()->id())) return;
                document.getElementById("chatBox").innerHTML += `
                <div class="flex justify-start">
                    <div class="bg-gray-100 px-4 py-2.5 rounded-2xl rounded-bl-sm max-w-xs shadow-sm">
                        <p class="text-sm leading-relaxed text-gray-800">${e.chat.message}</p>
                        <span class="text-[10px] text-gray-500 block text-right mt-1">${e.chat.created_at}</span>
                    </div>
                </div>`;
                document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
            });
    };
</script>