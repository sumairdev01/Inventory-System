<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm mb-6">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">Purchases History</h1>
            <a href="{{ route('purchases.create') }}"
               class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95">
                + New Purchase
            </a>
        </div>
        <div class="bg-white rounded-xl shadow border border-slate-200 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4 text-center">Amount</th>
                        <th class="px-6 py-4 text-center">Date</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($purchases as $purchase)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4"><span class="text-teal-600 font-mono font-bold">{{ $purchase->invoice_number }}</span></td>
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $supplier->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center font-mono font-bold text-slate-900">${{ number_format($purchase->total_amount, 2) }}</td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black border border-green-200 uppercase tracking-wider">
                                    {{ $purchase->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('returns.purchases.create', $purchase->id) }}" class="text-emerald-600 hover:text-emerald-800 font-black text-xs uppercase">Return</a>
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-800 font-black text-xs uppercase">View</a>
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-black text-xs uppercase">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">No purchases found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>