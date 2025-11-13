<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Pesan</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 px-3">

        @if($chats->isEmpty())
            <!-- EMPTY STATE -->
            <div
                class="flex flex-col items-center justify-center bg-white rounded-2xl shadow-lg p-10 text-center border border-gray-100">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center rounded-full shadow-inner">
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>

                <h3 class="mt-6 text-lg font-semibold text-gray-800">Belum ada percakapan</h3>
                <p class="text-gray-500 text-sm mt-1">
                    Kamu belum memiliki riwayat chat saat ini.
                </p>

                <a href="/"
                    class="mt-6 px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-full shadow-md hover:bg-blue-700 transition-all duration-200">
                    Mulai Order
                </a>
            </div>
        @else
            <!-- CHAT LIST -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                @foreach($chats as $chat)
                    <a href="{{ route('customer.realtime-chat.show', $chat->receiver_id) }}"
                        class="flex items-center gap-4 px-6 py-4 hover:bg-blue-50/50 transition-all duration-150">
                        <!-- Avatar -->
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-inner">
                            <span class="text-blue-700 font-semibold text-lg">
                                {{ strtoupper(substr($chat->receiver->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>

                        <!-- Chat Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center">
                                <h4 class="font-semibold text-gray-800 truncate">
                                    {{ $chat->receiver->name ?? 'Unknown User' }}
                                </h4>
                                <span class="text-xs text-gray-400 whitespace-nowrap ml-2">
                                    {{ $chat->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 truncate mt-0.5">
                                {{ $chat->message }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>