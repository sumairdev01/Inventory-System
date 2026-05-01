<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1000)"
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
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold shadow transition-all duration-200 active:scale-95">
                + New Purchase
            </a>
        </div>
        <div class="bg-white rounded-xl shadow border border-slate-200 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Supplier</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Amount</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Date</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Status</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($purchases as $purchase)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4">
                                <span class="text-indigo-600 font-mono font-bold text-sm">{{ $purchase->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-900 font-bold text-sm">
                                {{ $purchase->supplier->name ?? 'N/A' }}
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
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('purchases.show', $purchase->id) }}" 
                                       class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-3 py-1.5 rounded-lg text-[10px] font-black transition border border-indigo-100 uppercase tracking-wide">
                                        View
                                    </a>
                                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-[10px] font-black transition border border-red-100 uppercase tracking-wide">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-2 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span>No purchases found</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $purchases->links() }}
        </div>
    </div>
</x-app-layout>