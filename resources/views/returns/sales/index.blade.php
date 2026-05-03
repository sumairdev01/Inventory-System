<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Sales Returns</h1>
                    <p class="mt-2 text-slate-500 font-medium">History of items returned by customers.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('sales.index') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-emerald-100 transition-all transform hover:-translate-y-0.5 active:scale-95">
                        SELECT SALE TO RETURN
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-8 rounded-r-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-5 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Return Date</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Sale Ref</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Customer</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Product</th>
                                <th class="px-8 py-5 text-center text-xs font-black text-slate-400 uppercase tracking-widest">Qty</th>
                                <th class="px-8 py-5 text-right text-xs font-black text-slate-400 uppercase tracking-widest">Refund</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-slate-400 uppercase tracking-widest">Reason</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($returns as $return)
                                <tr class="hover:bg-slate-50/50 transition-all group">
                                    <td class="px-8 py-6 text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($return->return_date)->format('M d, Y') }}</td>
                                    <td class="px-8 py-6 text-sm font-black text-slate-900">#{{ $return->sale_id }}</td>
                                    <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $return->sale->customer->name }}</td>
                                    <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $return->product->name }}</td>
                                    <td class="px-8 py-6 text-center"><span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-black text-xs">{{ $return->quantity }}</span></td>
                                    <td class="px-8 py-6 text-right text-sm font-black text-slate-900">${{ number_format($return->refund_amount, 2) }}</td>
                                    <td class="px-8 py-6 text-sm text-slate-500 italic">{{ $return->reason ?? 'No reason provided' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-8 py-20 text-center text-slate-400 font-bold">No sale returns found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
