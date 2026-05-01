<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300" 
     x-transition:enter-start="opacity-0" 
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition-opacity ease-linear duration-300" 
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     @click="sidebarOpen = false"
     class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" 
     x-cloak></div>
<div id="sidebar" 
     class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 transition-all duration-300 ease-in-out transform sidebar-bg lg:static lg:translate-x-0"
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     x-cloak>
    <div class="flex items-center h-20 px-6 border-b border-white/20 bg-teal-900/30 backdrop-blur-sm">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 w-full">
            <span class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-teal-100 to-emerald-100">MediStock</span>
        </a>
    </div>
    <div class="flex-1 overflow-y-auto custom-scrollbar px-4 py-6">
        <nav class="space-y-8">
            <div>
                <p class="px-3 mb-3 text-xs font-bold tracking-widest text-teal-200/70 uppercase">Overview</p>
                <a href="{{ route('dashboard') }}" 
                   class="nav-item {{ request()->routeIs('dashboard') ? 'nav-item-active' : '' }}">
                    <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
            </div>
            <div>
                <p class="px-3 mb-3 text-xs font-bold tracking-widest text-teal-200/70 uppercase">Inventory</p>
                <div class="space-y-1">
                    <a href="{{ route('products.index') }}" 
                       class="nav-item {{ request()->routeIs('products.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="nav-item {{ request()->routeIs('categories.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Categories
                    </a>
                    <a href="{{ route('stock.history.index') }}" 
                       class="nav-item {{ request()->routeIs('stock.history.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Stock History
                    </a>
                </div>
            </div>
            <div>
                <p class="px-3 mb-3 text-xs font-bold tracking-widest text-teal-200/70 uppercase">Trading</p>
                <div class="space-y-1">
                    <a href="{{ route('sales.index') }}" 
                       class="nav-item {{ request()->routeIs('sales.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Sales & Billing
                    </a>
                    <a href="{{ route('purchases.index') }}" 
                       class="nav-item {{ request()->routeIs('purchases.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Purchases
                    </a>
                </div>
            </div>
            <div>
                <p class="px-3 mb-3 text-xs font-bold tracking-widest text-teal-200/70 uppercase">Contacts</p>
                <div class="space-y-1">
                    <a href="{{ route('customers.index') }}" 
                       class="nav-item {{ request()->routeIs('customers.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Customers
                    </a>
                    <a href="{{ route('suppliers.index') }}" 
                       class="nav-item {{ request()->routeIs('suppliers.*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Suppliers
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>