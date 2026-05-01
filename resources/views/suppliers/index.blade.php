<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto space-y-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header + Add Supplier --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">Suppliers Management</h1>
            <a href="{{ route('suppliers.create') }}"
               class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-6 py-2 rounded-lg font-bold shadow-lg shadow-emerald-200/50 transition-all duration-200 active:scale-95">
                + Add Supplier
            </a>
        </div>

        {{-- Suppliers Table --}}
        <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Contact Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Total Purchases</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Balance Due</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900 leading-tight">{{ $supplier->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 font-medium">{{ $supplier->phone ?? 'No Phone' }}</div>
                                <div class="text-xs text-slate-400 italic">{{ $supplier->email ?? 'No Email' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-mono font-bold text-slate-700">
                                    ${{ number_format($supplier->purchases->sum('total_amount'), 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $due = $supplier->purchases->sum('total_amount') - $supplier->purchases->sum('paid_amount');
                                @endphp
                                <span class="text-sm font-mono font-black {{ $due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    ${{ number_format($due, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" 
                                       class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-1.5 rounded-lg text-[10px] font-black transition border border-indigo-100 uppercase tracking-wide">
                                        View
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" 
                                       class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 px-4 py-1.5 rounded-lg text-[10px] font-black transition shadow-sm uppercase tracking-wide">
                                        Edit
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-lg text-[10px] font-black transition shadow-sm uppercase tracking-wide">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                No suppliers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</x-app-layout>
