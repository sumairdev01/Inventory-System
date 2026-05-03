<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create New Customer</h2>
                    <p class="mt-2 text-sm text-gray-600">Add a new customer to your database for faster billing and relationship management.</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                    <form method="POST" action="{{ route('customers.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <input type="text" name="name" id="name" required placeholder="John Doe"
                                           class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </div>
                                    <input type="text" name="phone" id="phone" placeholder="+1 (555) 000-0000"
                                           class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                                @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10" /></svg>
                                    </div>
                                    <input type="email" name="email" id="email" placeholder="john@example.com"
                                           class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-gray-700 placeholder-gray-400">
                                </div>
                                @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-span-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                                <div class="relative group">
                                    <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <textarea name="address" id="address" rows="3" placeholder="Enter full address here..."
                                              class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-gray-700 placeholder-gray-400"></textarea>
                                </div>
                                @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-6 flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Save Customer
                            </button>
                            <a href="{{ route('customers.index') }}" 
                               class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-2xl transition-all flex items-center justify-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>