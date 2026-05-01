<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">{{ $supplier->name }}</h1>
                <p class="text-slate-500">Supplier Details & Purchase History</p>
            </div>
            <a href="{{ route('suppliers.index') }}"
               class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2 rounded-lg font-bold transition-all duration-200">
                Back to List
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow border border-slate-200">
                    <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Contact Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs text-slate-400 block">Phone</label>
                            <span class="text-slate-900 font-bold">{{ $supplier->phone ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block">Email</label>
                            <span class="text-slate-900 font-bold">{{ $supplier->email ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block">Address</label>
                            <span class="text-slate-900">{{ $supplier->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-indigo-600 p-6 rounded-xl shadow-lg shadow-indigo-600/20 text-white">
                    <h2 class="text-sm font-bold opacity-70 uppercase tracking-widest mb-4">Financial Summary</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs opacity-70 block">Total Purchased</label>
                            <span class="text-2xl font-black">${{ number_format($supplier->purchases->sum('total_amount'), 2) }}</span>
                        </div>
                        <div>
                            <label class="text-xs opacity-70 block">Current Balance Due</label>
                            @php
                                $due = $supplier->purchases->sum('total_amount') - $supplier->purchases->sum('paid_amount');
                            @endphp
                            <span class="text-2xl font-black text-white">${{ number_format($due, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800">Recent Purchases</h2>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Invoice</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Amount</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Date</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($supplier->purchases as $purchase)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <span class="text-indigo-600 font-mono font-bold text-sm">{{ $purchase->invoice_number }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-mono font-bold text-slate-900">
                                        ${{ number_format($purchase->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black border border-green-200 uppercase tracking-wider">
                                            {{ $purchase->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                        No purchases found for this supplier.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>