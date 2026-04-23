<x-app-layout>
<div class="ef-chat">

    {{-- ── Header ── --}}
    <div class="ef-chat__header">
        <div class="ef-chat__header-inner">
            <div>
                <h1 class="ef-chat__title">Pesan</h1>
                <p class="ef-chat__subtitle">Percakapan dengan kurir & toko</p>
            </div>
            <div class="ef-chat__header-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ── Content ── --}}
    <div class="ef-chat__body">

        @if ($chats->isEmpty())

            {{-- ── Empty State ── --}}
            <div class="ef-chat__empty" data-reveal>
                <div class="ef-chat__empty-visual">
                    <div class="ef-chat__empty-ring ef-chat__empty-ring--outer"></div>
                    <div class="ef-chat__empty-ring ef-chat__empty-ring--inner"></div>
                    <div class="ef-chat__empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="ef-chat__empty-title">Belum ada percakapan</h3>
                <p class="ef-chat__empty-sub">Pesan dari kurir atau toko akan muncul di sini setelah kamu melakukan order.</p>
                <a href="{{ route('customer.home') }}" class="ef-chat__empty-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6"/>
                    </svg>
                    Mulai Order
                </a>
            </div>

        @else

            {{-- ── Chat List ── --}}
            <div class="ef-chat__list">
                @foreach ($chats as $chat)
                    <a href="{{ auth()->user()->hasRole('customer')
                        ? route('customer.chat.show', ['receiver' => $chat->other_user_id])
                        : route('courier.chat.show', $chat->other_user_id) }}"
                       class="ef-chat__item" data-reveal data-delay="{{ $loop->index * 50 }}">

                        {{-- Avatar --}}
                        <div class="ef-chat__avatar">
                            {{ strtoupper(substr($chat->other_user->name ?? 'U', 0, 1)) }}
                            {{-- Online dot — opsional, bisa dihapus kalau tidak ada data online status --}}
                            {{-- <span class="ef-chat__avatar-dot"></span> --}}
                        </div>

                        {{-- Info --}}
                        <div class="ef-chat__info">
                            <div class="ef-chat__info-top">
                                <span class="ef-chat__name">
                                    {{ $chat->other_user->name ?? 'Unknown User' }}
                                </span>
                                <span class="ef-chat__time">
                                    {{ $chat->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="ef-chat__preview">
                                {{ $chat->message }}
                            </p>
                        </div>

                        {{-- Chevron --}}
                        <svg class="ef-chat__chevron" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>

                    </a>
                @endforeach
            </div>

        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
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
});
</script>

</x-app-layout>