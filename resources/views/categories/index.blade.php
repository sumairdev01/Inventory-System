<x-app-layout>
    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Product Categories</h1>
                    <p class="text-slate-500 mt-1 text-base">Organize and manage your pharmacy inventory groups</p>
                </div>
                <a href="{{ route('categories.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white text-sm font-semibold rounded-lg transition-all shadow-md shadow-emerald-100 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Category
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($categories as $category)
                    <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 overflow-hidden flex flex-col">
                        
                        <div class="relative h-32 w-full bg-slate-100 overflow-hidden">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                </div>
                            @endif
                            



                            <div class="absolute bottom-4 right-4">
                                <div class="px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-full shadow-sm flex items-center space-x-1.5 border border-slate-200">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-xs font-bold text-slate-700">{{ $category->products_count }} Items</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 flex-1 flex flex-col">
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-1">
                                {{ $category->name }}
                            </h3>
                            
                            <p class="mt-1 text-slate-500 text-[10px] line-clamp-2 leading-tight flex-1">
                                {{ $category->description ?: 'No description provided.' }}
                            </p>

                            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">
                                    {{ $category->created_at->format('M d, Y') }}
                                </span>
                                
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('categories.edit', $category->id) }}" 
                                       class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                       title="Edit Category">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category? All products inside will be affected.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                                title="Delete Category">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border-2 border-dashed border-slate-200 p-16 text-center shadow-sm">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">No Categories Found</h3>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">Get started by creating your first category to organize your pharmacy products.</p>
                        <a href="{{ route('categories.create') }}" 
                           class="inline-flex items-center px-8 py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition-all shadow-lg shadow-teal-200">
                            Create First Category
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
