<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('returns.purchases.index') }}"
                    class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-teal-600 transition-colors flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Returns History
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Process Purchase Return</h1>
                <p class="mt-2 text-slate-500 font-medium">Create a return record for Purchase #{{ $purchase->id }}
                    (Supplier: {{ $purchase->supplier->name }})</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-8 rounded-r-xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-12">
                <form action="{{ route('returns.purchases.store', $purchase->id) }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Product Selection -->
                    <div>
                        <label class="block text-sm font-black text-slate-700 uppercase tracking-widest mb-4">Select
                            Product to Return</label>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($purchase->items as $item)
                                <label
                                    class="relative flex items-center p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition-all border-slate-200 has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/30 group">
                                    <input type="radio" name="product_id" value="{{ $item->product_id }}" class="sr-only"
                                        required data-max="{{ $item->quantity }}" data-price="{{ $item->price }}"
                                        data-stock="{{ $item->product->quantity }}">
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-slate-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-slate-500 font-bold">Purchased: {{ $item->quantity }} units |
                                            Current Stock: {{ $item->product->quantity }} units</p>
                                    </div>
                                    <div class="hidden group-has-[:checked]:block text-teal-600">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Quantity -->
                        <div>
                            <label for="quantity"
                                class="block text-sm font-black text-slate-700 uppercase tracking-widest mb-2">Return
                                Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="1"
                                class="block w-full px-5 py-4 bg-slate-50 border-0 rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-teal-500 transition-all outline-none"
                                required>
                        </div>

                        <!-- Refund Amount -->
                        <div>
                            <label for="refund_amount"
                                class="block text-sm font-black text-slate-700 uppercase tracking-widest mb-2">Expected
                                Refund</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 font-bold">$</span>
                                <input type="number" name="refund_amount" id="refund_amount" step="0.01" min="0"
                                    class="block w-full pl-10 pr-5 py-4 bg-slate-50 border-0 rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-teal-500 transition-all outline-none"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason"
                            class="block text-sm font-black text-slate-700 uppercase tracking-widest mb-2">Reason for
                            Return</label>
                        <textarea name="reason" id="reason" rows="3"
                            class="block w-full px-5 py-4 bg-slate-50 border-0 rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-teal-500 transition-all outline-none"
                            placeholder="e.g. Received expired items, Incorrect batch, etc."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-teal-900 text-white font-black py-5 px-8 rounded-2xl hover:bg-teal-800 transition-all shadow-xl shadow-teal-200 transform hover:-translate-y-1 active:scale-95">
                        CONFIRM PURCHASE RETURN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="product_id"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const purchasedMax = parseInt(this.dataset.max);
                const stockMax = parseInt(this.dataset.stock);
                const price = this.dataset.price;
                const qtyInput = document.getElementById('quantity');
                const refundInput = document.getElementById('refund_amount');


                const absoluteMax = Math.min(purchasedMax, stockMax);

                qtyInput.max = absoluteMax;
                qtyInput.value = 1;
                refundInput.value = price;

                qtyInput.addEventListener('input', function () {
                    if (parseInt(this.value) > absoluteMax) this.value = absoluteMax;
                    refundInput.value = (parseFloat(price) * parseInt(this.value || 0)).toFixed(2);
                });
            });
        });
    </script>
</x-app-layout>