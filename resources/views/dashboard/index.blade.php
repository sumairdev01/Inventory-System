<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header with Stats Summary --}}
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Good {{ now()->format('A') == 'AM' ? 'Morning' : 'Afternoon' }}, {{ auth()->user()->name }}</h1>
                        <p class="text-gray-500 text-sm mt-1">Here's what's happening with your inventory today</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('sales.create') }}" class="bg-emerald-50 text-emerald-700 hover:text-emerald-800 px-4 py-2 rounded-lg text-sm font-bold border border-emerald-100 hover:border-emerald-200 transition-all flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Sale
                        </a>
                        <a href="{{ route('purchases.create') }}" class="bg-gradient-to-r from-teal-600 to-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:from-teal-700 hover:to-emerald-700 transition-all flex items-center gap-2 shadow-md shadow-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Purchase
                        </a>
                    </div>
                </div>

                {{-- Quick Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-400">Revenue</span>

                        </div>
                        <div class="text-2xl font-bold text-gray-900">${{ number_format($totalSales, 2) }}</div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-xs text-gray-400">{{ $salesCount }} transactions</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-400">Expenses</span>

                        </div>
                        <div class="text-2xl font-bold text-gray-900">${{ number_format($totalPurchases, 2) }}</div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-xs text-gray-400">{{ $purchasesCount }} purchases</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-400">Inventory Value</span>
                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Active</span>
                        </div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalStock }}</div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-xs text-gray-400">{{ $totalCategories }} categories</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-400">Stock Alerts</span>
                            <span class="text-xs font-medium {{ $lowStockCount > 0 ? 'text-yellow-600 bg-yellow-50' : 'text-green-600 bg-green-50' }} px-2 py-1 rounded-full">
                                {{ $lowStockCount > 0 ? 'Attention' : 'All Good' }}
                            </span>
                        </div>
                        <div class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-yellow-600' : 'text-gray-900' }}">{{ $lowStockCount }}</div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-xs text-gray-400">Items low in stock</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left Column - Charts & Analytics --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Performance Chart Placeholder --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-sm font-semibold text-gray-900">Revenue vs Expenses</h2>
                            <select class="text-xs border border-gray-200 rounded-lg px-2 py-1 text-gray-600">
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>This month</option>
                            </select>
                        </div>
                        <div class="h-64 flex items-end justify-between gap-2">
                            {{-- Simple bar chart representation --}}
                            @foreach(range(1,7) as $day)
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="w-full bg-blue-100 rounded-lg" style="height: {{ rand(40, 120) }}px"></div>
                                <div class="w-full bg-red-100 rounded-lg" style="height: {{ rand(20, 80) }}px"></div>
                                <span class="text-xs text-gray-400">Day {{ $day }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-center gap-6 mt-4">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-100 rounded"></div>
                                <span class="text-xs text-gray-500">Revenue</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-red-100 rounded"></div>
                                <span class="text-xs text-gray-500">Expenses</span>
                            </div>
                        </div>
                    </div>

                    {{-- Top Products --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-6">
                        <h2 class="text-sm font-semibold text-gray-900 mb-4">Top Moving Products</h2>
                        <div class="space-y-4">
                            @foreach(range(1,5) as $i)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-xs font-medium text-gray-600">
                                        #{{ $i }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Product Name {{ $i }}</div>
                                        <div class="text-xs text-gray-400">SKU: PRD00{{ $i }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">{{ rand(50, 200) }} units</div>
                                    <div class="text-xs text-green-600">+{{ rand(5, 20) }}%</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right Column - Activity & Alerts --}}
                <div class="space-y-6">

                    {{-- Recent Transactions --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-semibold text-gray-900">Recent Activity</h2>
                            <a href="{{ route('stock.history.index') }}" class="text-xs text-blue-600 hover:text-blue-700">View all</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentTransactions as $tx)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg {{ $tx->type == 'in' ? 'bg-green-50' : 'bg-red-50' }} flex items-center justify-center flex-shrink-0">
                                    @if($tx->type == 'in')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $tx->product->name }}</p>
                                        <span class="text-xs text-gray-400">{{ $tx->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $tx->type == 'in' ? 'Added' : 'Removed' }} {{ $tx->quantity }} units
                                        @if($tx->note)
                                        <span class="text-gray-400"> • {{ $tx->note }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-6">
                                <p class="text-sm text-gray-400">No recent activity</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Low Stock Alerts --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-6">
                        <h2 class="text-sm font-semibold text-gray-900 mb-4">Low Stock Alerts</h2>
                        @if($lowStockCount > 0)
                        <div class="space-y-3">
                            @foreach(range(1, min(3, $lowStockCount)) as $i)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Product {{ $i }}</div>
                                    <div class="text-xs text-yellow-600 mt-1">Only {{ rand(2, 5) }} units left</div>
                                </div>
                                <a href="#" class="text-xs text-blue-600 hover:text-blue-700">Reorder</a>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-6">
                            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">All stock levels are healthy</p>
                        </div>
                        @endif
                    </div>

                    {{-- Suppliers Summary --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-6">
                        <h2 class="text-sm font-semibold text-gray-900 mb-4">Suppliers</h2>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-900">{{ \App\Models\Supplier::count() }}</span>
                                <span class="text-sm text-gray-500 ml-2">Active</span>
                            </div>
                            <a href="{{ route('suppliers.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Manage →</a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
