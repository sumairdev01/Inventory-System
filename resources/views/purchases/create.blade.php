<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Create Purchase Order</h1>
                <p class="text-sm text-gray-500 mt-1">Record a new purchase from supplier</p>
            </div>
            <form action="{{ route('purchases.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Supplier Information</h3>
                    <div class="max-w-md">
                        <label for="supplier_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                            Select Supplier <span class="text-red-500">*</span>
                        </label>
                        <select name="supplier_id"
                                id="supplier_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                                required>
                            <option value="">Choose a supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-700">Products</h3>
                            <span class="text-xs text-gray-500">Add products to purchase</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-12 gap-4 mb-3 px-3">
                            <div class="col-span-5 text-xs font-medium text-gray-500 uppercase tracking-wide">Product</div>
                            <div class="col-span-2 text-xs font-medium text-gray-500 uppercase tracking-wide text-right">Quantity</div>
                            <div class="col-span-2 text-xs font-medium text-gray-500 uppercase tracking-wide text-right">Unit Cost</div>
                            <div class="col-span-2 text-xs font-medium text-gray-500 uppercase tracking-wide text-right">Subtotal</div>
                            <div class="col-span-1"></div>
                        </div>
                        <div id="product-wrapper" class="space-y-3">
                            <div class="product-row grid grid-cols-12 gap-4 items-center bg-gray-50 p-3 rounded-lg">
                                <div class="col-span-5">
                                    <select name="products[0][product_id]"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-white"
                                            required>
                                        <option value="">Select product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} (Stock: {{ $product->quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <input type="number"
                                           name="products[0][quantity]"
                                           class="quantity w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-right"
                                           placeholder="0"
                                           min="1"
                                           required>
                                </div>
                                <div class="col-span-2">
                                    <input type="number"
                                           name="products[0][price]"
                                           class="price w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-right"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0"
                                           required>
                                </div>
                                <div class="col-span-2">
                                    <input type="text"
                                           class="subtotal w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm text-right text-gray-700 font-medium"
                                           placeholder="0.00"
                                           readonly>
                                </div>
                                <div class="col-span-1 text-right">
                                    <button type="button"
                                            class="remove-row w-8 h-8 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Remove product">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                id="add-row"
                                class="mt-4 inline-flex items-center px-4 py-2 border border-emerald-200 rounded-lg text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Product
                        </button>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex justify-end">
                        <div class="w-72">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Subtotal:</span>
                                <span class="text-sm font-medium text-gray-900">$<span id="subtotal">0.00</span></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Tax (10%):</span>
                                <span class="text-sm font-medium text-gray-900">$<span id="tax">0.00</span></span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-base font-semibold text-gray-900">Grand Total:</span>
                                <span class="text-xl font-bold text-gray-900">$<span id="grand-total">0.00</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                              placeholder="Add any remarks, payment details or delivery notes here..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('purchases.index') }}"
                       class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white text-sm font-bold rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-md shadow-emerald-100">
                        Create Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
    let index = 1;
    // Add new row
    document.getElementById('add-row').addEventListener('click', function() {
        let wrapper = document.getElementById('product-wrapper');
        let row = `
        <div class="product-row grid grid-cols-12 gap-4 items-center bg-gray-50 p-3 rounded-lg">
            <div class="col-span-5">
                <select name="products[${index}][product_id]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-white"
                        required>
                    <option value="">Select product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (Stock: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <input type="number"
                       name="products[${index}][quantity]"
                       class="quantity w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-right"
                       placeholder="0"
                       min="1"
                       required>
            </div>
            <div class="col-span-2">
                <input type="number"
                       name="products[${index}][price]"
                       class="price w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-right"
                       placeholder="0.00"
                       step="0.01"
                       min="0"
                       required>
            </div>
            <div class="col-span-2">
                <input type="text"
                       class="subtotal w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm text-right text-gray-700 font-medium"
                       placeholder="0.00"
                       readonly>
            </div>
            <div class="col-span-1 text-right">
                <button type="button"
                        class="remove-row w-8 h-8 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Remove product">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', row);
        index++;
    });
    // Calculate subtotals and grand total
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
            let row = e.target.closest('.product-row');
            if (row) {
                let qty = parseFloat(row.querySelector('.quantity').value) || 0;
                let price = parseFloat(row.querySelector('.price').value) || 0;
                let subtotal = qty * price;
                row.querySelector('.subtotal').value = subtotal.toFixed(2);
                calculateTotals();
            }
        }
    });
    // Auto-fill price when product is selected
    document.addEventListener('change', function(e) {
        if (e.target.name && e.target.name.includes('[product_id]')) {
            let selected = e.target.options[e.target.selectedIndex];
            let price = selected.dataset.price;
            let row = e.target.closest('.product-row');
            if (row && price) {
                row.querySelector('.price').value = price;
                // Trigger calculation
                let event = new Event('input', { bubbles: true });
                row.querySelector('.price').dispatchEvent(event);
            }
        }
    });
    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('.product-row').remove();
            calculateTotals();
        }
    });
    // Calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.subtotal').forEach(function(input) {
            subtotal += parseFloat(input.value) || 0;
        });
        let tax = subtotal * 0.10; // 10% tax
        let grandTotal = subtotal + tax;
        document.getElementById('subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('tax').innerText = tax.toFixed(2);
        document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
    }
    </script>
</x-app-layout>