<x-app-layout>
<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Customers</h2>
        <a href="{{ route('customers.create') }}"
           class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95">
            + Add Customer
        </a>
    </div>
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm mb-6">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-widest">
                <tr>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($customers as $customer)
                <tr class="hover:bg-slate-50/50 transition duration-150">
                    <td class="p-4 font-bold text-slate-900">{{ $customer->name }}</td>
                    <td class="p-4 text-sm text-slate-600 font-medium">{{ $customer->phone }}</td>
                    <td class="p-4 text-sm text-slate-600 font-medium">{{ $customer->email }}</td>
                    <td class="p-4 text-center space-x-2">
                        <a href="{{ route('customers.edit', $customer->id) }}" class="text-emerald-600 hover:text-emerald-800 font-black text-xs uppercase">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-800 font-black text-xs uppercase">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>