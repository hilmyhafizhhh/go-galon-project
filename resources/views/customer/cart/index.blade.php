 <x-app-layout>
     <x-slot name="header">
         <h2 class="font-semibold text-lg text-gray-800 leading-tight">
             Keranjang Saya
         </h2>
     </x-slot>

     <div class="max-w-3xl mx-auto py-6 px-4">

         @if (!$order || $order->items->isEmpty())
             <div class="text-center text-gray-500 py-10">
                 Belum ada item di keranjang
             </div>
         @else
             <div class="space-y-4">
                 @foreach ($order->items as $item)
                     <div class="flex items-center bg-white rounded-xl shadow-sm p-3 border">

                         {{-- chexbox --}}
                         <input type="checkbox" class="item-checkbox rounded-md mr-3 w-5 h-5"
                             data-price="{{ $item->product->price }}" data-qty="{{ $item->quantity }}">

                         {{-- Gambar --}}
                         <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                             class="w-20 h-20 object-contain rounded-lg border">

                         {{-- Info Produk --}}
                         <div class="ml-3 flex-1">
                             <h3 class="text-sm font-semibold text-gray-800 line-clamp-2">
                                 {{ $item->product->name }}
                             </h3>

                             {{-- Variasi (optional) --}}
                             <p class="text-xs text-gray-500 mt-1">
                                 Size: L
                             </p>

                             {{-- Harga --}}
                             <div class="mt-1">
                                 <span class="text-red-500 font-bold text-base">
                                     Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                 </span>
                             </div>
                         </div>

                         {{-- Qty --}}
                         <div class="flex items-center border rounded-lg overflow-hidden">
                             <button class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                             <span class="px-3 text-sm">{{ $item->quantity }}</span>
                             <button class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                         </div>
                     </div>
                 @endforeach
             </div>

             {{-- Footer Checkout --}}
             <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 flex items-center justify-between">
                 <div>
                     <input type="checkbox" id="checkAll" class="rounded-md mr-3 w-5 h-5">
                     All
                 </div>
                 <div>
                     <p class="text-sm text-gray-500">Total</p>
                     <p id="totalPrice" class="font-bold text-lg text-gray-800">
                         Rp0
                     </p>
                 </div>

                 <button id="checkoutBtn"
                     class="bg-blue-800 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-900">
                     Checkout (0)
                 </button>
             </div>

         @endif

     </div>
 </x-app-layout>


 <script>
     const checkAll = document.getElementById('checkAll');

     if (checkAll) {
         const itemCheckboxes = document.querySelectorAll('.item-checkbox');
         const totalPriceEl = document.getElementById('totalPrice');
         const checkoutBtn = document.getElementById('checkoutBtn');

         function updateCart() {
             let total = 0;
             let count = 0;

             itemCheckboxes.forEach(cb => {
                 if (cb.checked) {
                     const price = parseInt(cb.dataset.price);
                     const qty = parseInt(cb.dataset.qty);

                     total += price * qty;
                     count += qty; // 🔥 pakai qty
                 }
             });

             totalPriceEl.innerText = 'Rp' + total.toLocaleString('id-ID');
             checkoutBtn.innerText = `Checkout (${count})`;
         }

         // Select All
         checkAll.addEventListener('change', function() {
             itemCheckboxes.forEach(cb => cb.checked = this.checked);
             updateCart();
         });

         // Per item
         itemCheckboxes.forEach(cb => {
             cb.addEventListener('change', function() {
                 const allChecked = [...itemCheckboxes].every(i => i.checked);
                 checkAll.checked = allChecked;
                 updateCart();
             });
         });
     }
 </script>
