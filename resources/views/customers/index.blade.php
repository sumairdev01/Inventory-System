<x-app-layout>

<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold">Customers</h2>
        <a href="{{ route('customers.create') }}"
           class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-4 py-2 rounded-lg font-bold shadow-md shadow-emerald-100 transition-all">
            + Add Customer
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Phone</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr class="border-t">
                <td class="p-3">{{ $customer->name }}</td>
                <td class="p-3">{{ $customer->phone }}</td>
                <td class="p-3">{{ $customer->email }}</td>
                <td class="p-3 text-center">
                    <a href="{{ route('customers.edit', $customer->id) }}"
                       class="text-blue-600">Edit</a>

                    <form action="{{ route('customers.destroy', $customer->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 ml-2">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</x-app-layout>
