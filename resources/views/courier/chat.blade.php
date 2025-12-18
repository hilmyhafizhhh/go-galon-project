<x-app-layout>
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg mx-auto p-5 sm:p-6 md:p-8 mt-6 mb-10">
        <h2 class="text-lg font-bold text-blue-800 mb-3">Chat Custom Orders 💬</h2>

        <div class="bg-gray-100 p-3 rounded-lg text-sm mb-3">
            <p><b>Depot Efata :</b> Hallo Mau pesan galon custom?<br>
                Kami siap bantu merek lain selain Aqua/Le Minerale atau order besar (5+)</p>
        </div>

        <div class="space-y-3">
            <div class="w-full max-w-lg mx-auto mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Merek Galon</label>
                <select
                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 transition">
                    <option>Le Minerale</option>
                    <option>Vite</option>
                    <option>Vika</option>
                    <option>Lainnya...</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Jumlah</label>
                <input type="text" class="w-full border rounded-lg p-2" placeholder="5+">
            </div>

            <div>
                <label class="block text-sm font-medium">Pesan Khusus</label>
                <textarea class="w-full border rounded-lg p-2" placeholder="Silahkan"></textarea>
            </div>

            <div class="space-y-2">
                <button class="w-full bg-sky-500 text-white py-2 rounded-lg flex justify-center items-center gap-2">
                    <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
                </button>
                <button
                    class="w-full border border-gogalon-primary text-gogalon-primary py-2 rounded-lg flex justify-center items-center gap-2">
                    ✈️ Kirim Chat In-App
                </button>
            </div>
        </div>
    </div>


</x-app-layout>