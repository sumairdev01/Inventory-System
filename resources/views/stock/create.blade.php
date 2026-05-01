<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Stock Transaction - {{ $product->name }}
        </h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <p><strong>Current Stock:</strong>
                <span class="text-blue-600 font-bold">
                    {{ $product->quantity }}
                </span>
            </p>
        </div>

        <form action="{{ route('stock.store') }}" method="POST" class="space-y-5">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            {{-- Type --}}
            <div>
                <label class="block font-medium mb-1">Transaction Type</label>
                <select name="type" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select Type</option>
                    <option value="in">Stock In</option>
                    <option value="out">Stock Out</option>
                </select>
            </div>

            {{-- Quantity --}}
            <div>
                <label class="block font-medium mb-1">Quantity</label>
                <input type="number" name="quantity"
                       class="w-full border rounded px-3 py-2"
                       min="1" required>
            </div>

            {{-- Note --}}
            <div>
                <label class="block font-medium mb-1">Note (Optional)</label>
                <textarea name="note"
                          rows="3"
                          class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="flex gap-3">
                <button class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-5 py-2 rounded-lg font-bold shadow-md shadow-emerald-100 transition-all">
                    Submit
                </button>
                <a href="{{ route('products.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">
                    Back
                </a>
            </div>

        </form>

    </div>
</x-app-layout>
