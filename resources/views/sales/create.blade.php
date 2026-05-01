<x-app-layout>
    <div class="p-6 max-w-5xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">New Sale</h1>
            <a href="{{ route('sales.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2 rounded-lg font-bold transition-all duration-200">
                View Sales History
            </a>
        </div>
        <div class="bg-white p-8 rounded-xl shadow border border-slate-200">
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('sales.store') }}" class="space-y-6" id="sale-form">
                @csrf
                <div>
                    <label class="block font-medium text-slate-700 mb-2">Customer</label>
                    <select name="customer_id" class="w-full border rounded-lg p-3" required>
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-slate-700 mb-2">Products</label>
                    <table class="w-full border border-slate-200 rounded-lg overflow-hidden">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm">Product</th>
                                <th class="px-4 py-2 text-left text-sm">Quantity</th>
                                <th class="px-4 py-2 text-left text-sm">Price</th>
                                <th class="px-4 py-2 text-left text-sm">Subtotal</th>
                                <th class="px-4 py-2 text-left text-sm">Action</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-body">
                            <tr class="product-row">
                                <td class="px-4 py-2">
                                    <select name="products[0][product_id]" class="product-select w-full border rounded-lg p-2" required>
                                        <option value="">-- Choose Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                                                {{ $product->name }} (Available: {{ $product->quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" name="products[0][quantity]" class="product-qty w-full border rounded-lg p-2" min="1" value="1" required>
                                </td>
                                <td class="px-4 py-2">
                                    $<span class="product-price">0.00</span>
                                </td>
                                <td class="px-4 py-2">
                                    $<span class="product-subtotal">0.00</span>
                                </td>
                                <td class="px-4 py-2">
                                    <button type="button" class="remove-row bg-red-100 text-red-600 px-2 py-1 rounded" disabled>Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="add-product-btn"
                        class="mt-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-semibold border border-emerald-100 transition-all">
                        + Add Product
                    </button>
                </div>
                <div class="flex justify-between items-center bg-slate-50 p-4 rounded-lg mt-4 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <label class="font-bold text-slate-700">Amount Paid:</label>
                        <input type="number" name="paid_amount" id="paid-amount" step="0.01" min="0" class="border rounded-lg p-2 w-32 font-mono text-indigo-600 font-bold" placeholder="0.00">
                    </div>
                    <div class="text-xl font-bold text-slate-800">
                        Total: $<span id="total-amount">0.00</span>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-6 py-4 rounded-lg font-bold shadow-lg shadow-emerald-200 transition-all duration-200 active:scale-[0.98]">
                        Complete Sale & Deduct Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        let productIndex = 1;
        function recalcRow(row) {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.product-qty');
            const priceSpan = row.querySelector('.product-price');
            const subtotalSpan = row.querySelector('.product-subtotal');
            const price = parseFloat(select.selectedOptions[0]?.dataset.price || 0);
            const stock = parseInt(select.selectedOptions[0]?.dataset.stock || 0);
            let qty = parseInt(qtyInput.value) || 0;
            if (qty > stock) qty = stock;
            qtyInput.value = qty;
            priceSpan.textContent = price.toFixed(2);
            subtotalSpan.textContent = (price * qty).toFixed(2);
            recalcTotal();
        }
        function recalcTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                total += parseFloat(row.querySelector('.product-subtotal').textContent) || 0;
            });
            document.getElementById('total-amount').textContent = total.toFixed(2);
            document.getElementById('paid-amount').value = total.toFixed(2);
        }
        function addRow() {
            const tbody = document.getElementById('products-table-body');
            const firstRow = tbody.querySelector('.product-row');
            const newRow = firstRow.cloneNode(true);
            // Clear values
            newRow.querySelector('.product-select').name = `products[${productIndex}][product_id]`;
            newRow.querySelector('.product-select').value = '';
            newRow.querySelector('.product-qty').name = `products[${productIndex}][quantity]`;
            newRow.querySelector('.product-qty').value = 1;
            newRow.querySelector('.product-price').textContent = '0.00';
            newRow.querySelector('.product-subtotal').textContent = '0.00';
            newRow.querySelector('.remove-row').disabled = false;
            tbody.appendChild(newRow);
            productIndex++;
            attachRowEvents(newRow);
        }
        function removeRow(btn) {
            const row = btn.closest('.product-row');
            row.remove();
            recalcTotal();
        }
        function attachRowEvents(row) {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.product-qty');
            const removeBtn = row.querySelector('.remove-row');
            select.addEventListener('change', () => recalcRow(row));
            qtyInput.addEventListener('input', () => recalcRow(row));
            removeBtn.addEventListener('click', () => removeRow(removeBtn));
        }
        document.getElementById('add-product-btn').addEventListener('click', addRow);
        document.querySelectorAll('.product-row').forEach(row => attachRowEvents(row));
        // Initial calculation
        document.querySelectorAll('.product-row').forEach(row => recalcRow(row));
    </script>
</x-app-layout>