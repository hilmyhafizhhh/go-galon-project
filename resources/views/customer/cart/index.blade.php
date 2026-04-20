<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (!$order || $order->items->isEmpty())
                    <div class="p-6 text-gray-900">
                        Belum ada item di keranjang.
                    </div>
                @else
                    @foreach ($order->items as $item)
                        <div>
                            {{ $item->product->name }} - {{ $item->quantity }}
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</x-app-layout>