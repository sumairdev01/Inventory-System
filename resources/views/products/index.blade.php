<x-app-layout>
    <div class="py-8" x-data="{
        selectedProduct: null,
        activeCategory: {{ request('search') ? 'null' : 'null' }},
        selectProduct(product, qrSvg, qrData) {
            this.selectedProduct = { ...product, qrSvg: qrSvg, qrData: qrData };
        },
        toggleCategory(id) {
            this.activeCategory = this.activeCategory === id ? null : id;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1 min-w-0">
                    <div class="mb-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-semibold text-gray-900">Products by Category</h1>
                                <p class="text-sm text-gray-500 mt-1">Manage your product catalog grouped by categories</p>
                            </div>
                            <a href="{{ route('products.create') }}"
                               class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white text-sm font-semibold rounded-lg transition-all shadow-md shadow-emerald-100 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add New Product
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Products</p>
                                <p class="text-xl font-semibold text-gray-900 mt-1">{{ $totalProductsCount }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Categories</p>
                                <p class="text-xl font-semibold text-gray-900 mt-1">{{ \App\Models\Category::count() }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Value</p>
                                <p class="text-xl font-semibold text-gray-900 mt-1">${{ number_format($totalValue, 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Low Stock Items</p>
                                <p class="text-xl font-semibold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">
                                    {{ $lowStockCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <label for="search" class="sr-only">Search products</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" placeholder="Search products..."
                                           value="{{ request('search') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold rounded-lg transition-all shadow-md shadow-emerald-100">Search</button>
                                @if(request('search'))
                                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="space-y-4">
                        @forelse($categories as $category)
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:border-blue-300">
                                <div @click="toggleCategory({{ $category->id }})" class="p-5 cursor-pointer flex justify-between items-center group {{ request('search') ? 'bg-blue-50/50' : '' }}">
                                    <div class="flex items-center gap-4">
                                        @if($category->image)
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-100">
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-900">{{ $category->name }}</h2>
                                            <p class="text-sm text-gray-500 font-medium mt-0.5">{{ $category->products->count() }} Products Available</p>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-2 rounded-full text-gray-600 transition-transform duration-300" :class="{ 'rotate-180 bg-blue-100 text-blue-600': activeCategory === {{ $category->id }} }">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                <div x-show="{{ request('search') ? 'true' : 'activeCategory === ' . $category->id }}" x-collapse x-cloak class="border-t border-gray-100">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($category->products as $product)
                                                @php
                                                    $qrData = "Product: {$product->name}\n"
                                                           . "Price: $" . number_format($product->price, 2) . "\n"
                                                           . "Category: {$category->name}\n"
                                                           . "Manage: " . route('products.edit', $product->id);
                                                    $qrSvg = QrCode::size(200)->generate($qrData);
                                                @endphp
                                                <tr
                                                    @click="selectProduct({{ json_encode($product) }}, document.getElementById('qr-data-{{ $product->id }}').innerHTML, {{ json_encode($qrData) }}, '{{ $category->image }}')"
                                                    class="hover:bg-blue-50 cursor-pointer transition-colors group"
                                                    :class="selectedProduct && selectedProduct.id === {{ $product->id }} ? 'bg-blue-50' : ''"
                                                >
                                                    <td class="px-6 py-4">
                                                        <div id="qr-data-{{ $product->id }}" class="hidden">{!! $qrSvg !!}</div>
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                                                <span class="text-xs font-medium text-gray-600 group-hover:text-blue-600 uppercase">{{ substr($product->name, 0, 2) }}</span>
                                                            </div>
                                                            <div class="ml-3 font-medium text-gray-900 group-hover:text-blue-600">{{ $product->name }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                                        ${{ number_format($product->price, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->quantity <= 5 ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-green-100 text-green-800 border border-green-200' }}">
                                                            {{ $product->quantity }} units
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <div class="flex justify-end space-x-2" @click.stop>
                                                            <a href="{{ route('products.edit', $product->id) }}" class="p-1.5 bg-gray-50 text-gray-500 rounded hover:text-blue-600 hover:bg-blue-100 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="p-1.5 bg-gray-50 text-gray-500 rounded hover:text-red-600 hover:bg-red-100 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">No products in this category</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
    </div>
</x-app-layout>