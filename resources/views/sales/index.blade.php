<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">Sales History</h1>
            <a href="{{ route('sales.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition-all duration-200">
               New Sale
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white shadow rounded-lg border border-slate-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-4 py-4 font-medium text-gray-900">#{{ $sale->id }}</td>
                            <td class="px-4 py-4 text-gray-700">{{ $sale->customer->name }}</td>
                            <td class="px-4 py-4">
                                @foreach($sale->items as $item)
                                    <div class="mb-2">
                                        <span class="text-gray-900 font-semibold">{{ $item->product->name }}</span>
                                        <span class="text-gray-500 text-xs">Qty: {{ $item->quantity }}</span>
                                        <span class="text-gray-500 text-xs">Price: ${{ number_format($item->price, 2) }}</span>
                                        <span class="text-gray-500 text-xs">Subtotal: ${{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900">${{ number_format($sale->total_amount, 2) }}</td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 rounded text-xs font-medium 
                                    @if($sale->status === 'pending') bg-yellow-100 text-yellow-800 
                                    @elseif($sale->status === 'completed') bg-green-100 text-green-800 
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right flex justify-end space-x-2">
                                <a href="{{ route('sales.show', $sale->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                   View
                                </a>
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No sales found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($sales->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $sales->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>