<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Add New Supplier</h1>
            <p class="text-slate-500 mt-2 font-medium">Register a new vendor or company in your system.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form action="{{ route('suppliers.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Company / Supplier Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Enter company name"
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium"
                           required>
                    @error('name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Contact Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="+92 XXX XXXXXXX"
                               class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium">
                        @error('phone') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="example@mail.com"
                               class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium">
                        @error('email') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Physical Address</label>
                    <textarea name="address" rows="3"
                              placeholder="Full office or warehouse address"
                              class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium">{{ old('address') }}</textarea>
                    @error('address') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 flex items-center justify-between border-t border-slate-50">
                    <a href="{{ route('suppliers.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                        Go Back
                    </a>
                    <button type="submit"
                            class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all active:scale-95">
                        Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
