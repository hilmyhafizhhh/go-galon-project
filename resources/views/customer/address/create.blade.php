<x-app-layout>
    <div class="max-w-md mx-auto py-6 px-4">

        <h2 class="text-xl font-semibold mb-4">Tambah Alamat</h2>

        @if ($errors->any())
            <div class="mb-3 text-red-500 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('customer.address.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-gray-600">Label</label>
                <input type="text" name="label"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                    placeholder="Contoh: Rumah / Kantor">
            </div>

            <div>
                <label class="text-sm text-gray-600">Alamat Lengkap</label>
                <textarea name="address"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                    rows="3"
                    placeholder="Masukkan alamat lengkap..."></textarea>
            </div>

            <button type="submit"
                class="w-full bg-blue-800 text-white py-2 rounded-lg hover:bg-blue-900">
                Simpan Alamat
            </button>
        </form>
    </div>
</x-app-layout>