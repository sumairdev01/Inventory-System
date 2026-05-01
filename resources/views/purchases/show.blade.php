<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Invoice: {{ $purchase->invoice_number }}</h1>
                <p class="text-slate-500">Purchase Details & Item List</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('purchases.index') }}"
                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2 rounded-lg font-bold transition-all duration-200">
                    Back to List
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-1 space-y-4">
                <div class="bg-white p-6 rounded-xl shadow border border-slate-200">
                    <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Summary</h2>
                    <div class="space-y-4 text-sm">
                        <div>
                            <label class="text-xs text-slate-400 block">Supplier</label>
                            <span class="text-slate-900 font-bold">{{ $purchase->supplier->name }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block">Purchase Date</label>
                            <span class="text-slate-900 font-bold">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block">Total Amount</label>
                            <span class="text-lg font-black text-indigo-600">${{ number_format($purchase->total_amount, 2) }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block">Status</label>
                            <span class="bg-green-100 text-green-700 px-3 py-0.5 rounded-full text-[10px] font-black border border-green-200 uppercase tracking-wider">
                                {{ $purchase->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:col-span-3">
                <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800">Purchased Items</h2>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Unit Price</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Quantity</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($purchase->items as $item)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-900 leading-tight">{{ $item->product->name }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-tight">{{ $item->product->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-mono text-slate-600">
                                        ${{ number_format($item->cost_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-slate-900">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-mono font-bold text-indigo-600">
                                        ${{ number_format($item->subtotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50/50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-slate-500">Total Amount</td>
                                <td class="px-6 py-4 text-center text-lg font-black text-indigo-600">
                                    ${{ number_format($purchase->total_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>