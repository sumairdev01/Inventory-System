<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Product</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Enter product name" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Price</label>
                <input type="text" name="price" value="{{ old('price', $product->price) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Enter price" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Current Stock</label>
                <input type="number" value="{{ $product->quantity }}"
                    class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>
                <p class="text-sm text-gray-500 mt-1">Stock can only be updated through Purchase or Sales.</p>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Low Stock Alert Threshold</label>
                <input type="number" name="alert_threshold" value="{{ old('alert_threshold', $product->alert_threshold ?? 5) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Enter threshold (default: 5)" min="0">
                <p class="text-sm text-gray-500 mt-1">Admin will receive an email when stock drops to or below this number.</p>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Enter description">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-5 py-2 rounded-md font-semibold shadow-md shadow-emerald-100 transition-all">
                    Update Product
                </button>
                <a href="{{ route('products.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>