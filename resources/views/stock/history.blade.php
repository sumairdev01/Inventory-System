<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Stock History - {{ $product->name }}
        </h2>

        <div class="mb-4">
            <p><strong>Current Stock:</strong>
                <span class="text-blue-600 font-bold">
                    {{ $product->quantity }}
                </span>
            </p>
        </div>

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">Date</th>
                    <th class="p-3 border">Type</th>
                    <th class="p-3 border">Quantity</th>
                    <th class="p-3 border">Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse($product->transactions as $transaction)
                    <tr>
                        <td class="p-3 border">
                            {{ $transaction->created_at->format('d M Y, h:i A') }}
                        </td>

                        <td class="p-3 border">
                            @if($transaction->type == 'in')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                    Stock In
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                    Stock Out
                                </span>
                            @endif
                        </td>

                        <td class="p-3 border font-bold">
                            {{ $transaction->quantity }}
                        </td>

                        <td class="p-3 border">
                            {{ $transaction->note ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">
                            No stock transactions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ route('products.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                Back to Products
            </a>
        </div>

    </div>
</x-app-layout>
