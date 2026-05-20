<x-app-layout>
    <div class="ap-root">

        {{-- Header --}}
        <div class="ap-header">
            <div class="ap-header__inner">
                <a href="{{ route('customer.checkout') }}" class="ap-header__back" aria-label="Kembali">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <div class="ap-header__title">Pilih Alamat</div>
                    <div class="ap-header__sub">{{ $addresses->count() }} alamat tersimpan</div>
                </div>
            </div>
        </div>

        <div class="ap-body">

            {{-- Add new address --}}
            <a href="{{ route('customer.address.create') }}" class="ap-add-btn">
                <div class="ap-add-btn__icon">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </div>
                Tambah Alamat Baru
            </a>

            {{-- Address list --}}
            @if ($addresses->isEmpty())
                <div class="ap-empty">
                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p>Belum ada alamat. Tambah sekarang!</p>
                </div>
            @else
                @foreach ($addresses as $address)
                    <div class="ap-addr-card {{ $address->is_default ? 'selected' : '' }}"
                        data-id="{{ $address->id }}"
                        onclick="selectAddress(this, '{{ $address->id }}')">
                        <input type="radio" name="address_id" value="{{ $address->id }}"
                            {{ $address->is_default ? 'checked' : '' }}>
                        <div class="ap-addr-card__inner">
                            <div class="ap-radio">
                                <div class="ap-radio__dot"></div>
                            </div>
                            <div class="ap-addr-info">
                                <div class="ap-addr-top">
                                    <span class="ap-addr-label">{{ $address->label }}</span>
                                    @if ($address->is_default)
                                        <span class="ap-badge ap-badge--blue">Utama</span>
                                    @endif
                                </div>
                                <div class="ap-addr-detail">{{ $address->address }}</div>
                            </div>
                        </div>
                        <div class="ap-addr-card__divider"></div>
                        <div class="ap-addr-card__footer">
                            <a href="{{ route('customer.address.edit', $address->id) }}"
                                class="ap-addr-edit"
                                onclick="event.stopPropagation()">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Ubah
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        {{-- Sticky footer --}}
        <div class="ap-footer">
            <div class="ap-footer__inner">
                <button type="button" class="ap-footer__btn" id="confirmBtn" onclick="confirmAddress()">
                    Gunakan Alamat Ini
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

    </div>

    <script>
        let selectedId = '{{ $addresses->where("is_default", true)->first()?->id ?? $addresses->first()?->id }}';

        function selectAddress(card, id) {
            // Deselect all
            document.querySelectorAll('.ap-addr-card').forEach(c => c.classList.remove('selected'));
            document.querySelectorAll('input[name="address_id"]').forEach(r => r.checked = false);

            // Select clicked
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
            selectedId = id;
        }

        function confirmAddress() {
            if (!selectedId) return;
            // Pass chosen address id back to checkout via sessionStorage
            sessionStorage.setItem('chosen_address_id', selectedId);
            window.history.back();
        }
    </script>

</x-app-layout>