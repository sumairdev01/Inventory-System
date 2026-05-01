<x-app-layout>
    <style>
        @media print {
            @page {
                margin: 0;
            }
            html, body {
                height: auto !important;
                margin: 1cm;
                padding: 0;
                overflow: visible !important;
                background-color: white !important;
            }
            body * {
                visibility: hidden;
            }
            /* Explicitly hide the layout components that cause blank pages */
            header, nav, aside, footer {
                display: none !important;
            }
            .h-screen { height: auto !important; }
            .overflow-hidden { overflow: visible !important; }
            .overflow-y-auto { overflow: visible !important; }

            #printable-area, #printable-area * {
                visibility: visible;
                color: #000 !important;
            }
            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                margin: 0;
            }
            .print-hide {
                display: none !important;
            }
            .shadow-sm { box-shadow: none !important; }
            .bg-slate-50 { background-color: transparent !important; }
            .border { border: 1px solid #ddd !important; }
        }
    </style>

    <div class="p-6 max-w-5xl mx-auto space-y-6">

        {{-- Header & Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 print-hide">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-3">
                    Sale #{{ $sale->id }}
                    <span class="px-3 py-1 text-sm rounded-full font-medium 
                        @if($sale->status === 'paid') bg-green-100 text-green-800 
                        @elseif($sale->status === 'partial') bg-yellow-100 text-yellow-800 
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($sale->status) }}
                    </span>
                </h1>
                <p class="text-slate-500 mt-1">{{ $sale->created_at->format('d M, Y h:i A') }}</p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="window.print()"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold transition-all duration-200 flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </button>
                <a href="{{ route('sales.index') }}"
                   class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-5 py-2 rounded-lg font-semibold transition-all duration-200 flex items-center gap-2">
                    &larr; Back to Sales
                </a>
            </div>
        </div>

        {{-- Printable Area --}}
        <div id="printable-area">
            
            <!-- Print Header Only (Hidden on screen) -->
            <div class="hidden print:block text-center mb-8 pb-4 border-b-2 border-slate-800">
                <h1 class="text-3xl font-bold text-slate-800 uppercase tracking-wider">Pharmacy</h1>
                <p class="text-slate-600 mt-1">Official Sale Receipt</p>
                <div class="mt-4 flex justify-between text-left text-sm">
                    <div>
                        <span class="font-bold">Receipt No:</span> #{{ $sale->id }}<br>
                        <span class="font-bold">Date:</span> {{ $sale->created_at->format('d M, Y h:i A') }}
                    </div>
                    <div class="text-right">
                        <span class="font-bold">Status:</span> {{ strtoupper($sale->status) }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Customer Details --}}
                <div class="col-span-1 bg-white shadow-sm rounded-xl border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Customer Info</h2>
                    <div class="space-y-3 text-slate-700">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Name</p>
                            <p class="font-semibold text-slate-900">{{ $sale->customer->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Phone</p>
                            <p>{{ $sale->customer->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Summary Details --}}
                <div class="col-span-1 md:col-span-2 bg-white shadow-sm rounded-xl border border-slate-200 p-6 flex flex-col justify-center">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Payment Summary</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                            <p class="text-sm text-slate-500 font-medium mb-1">Total Amount</p>
                            <p class="text-2xl font-bold text-indigo-600">${{ number_format($sale->total_amount, 2) }}</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                            <p class="text-sm text-slate-500 font-medium mb-1">Paid Amount</p>
                            <p class="text-2xl font-bold text-emerald-600">${{ number_format($sale->paid_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Items Table --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h2 class="text-lg font-bold text-slate-800">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Qty</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($sale->items as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $item->product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-700">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-slate-700">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-slate-900">
                                    ${{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 border-t border-slate-200">
                            <tr>
                                <th scope="row" colspan="3" class="px-6 py-4 text-right text-sm font-bold text-slate-700">Grand Total</th>
                                <td class="px-6 py-4 text-right text-lg font-bold text-indigo-600">${{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
        </div>

    </div>
</x-app-layout>
