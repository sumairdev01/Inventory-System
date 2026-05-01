<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">Stock Transactions History</h1>
        </div>

        {{-- Transactions Table --}}
        <div class="bg-white rounded-xl shadow border border-slate-200 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Type</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Quantity</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $tx->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-slate-900 font-bold text-sm">
                                {{ $tx->product->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($tx->type == 'in')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black border border-green-200 uppercase tracking-wider">In</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-black border border-red-200 uppercase tracking-wider">Out</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-black text-slate-900">
                                {{ $tx->quantity }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 italic">
                                {{ $tx->note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                No transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>

    </div>
</x-app-layout>
