<x-app-layout>
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Edit Customer</h2>
    <form method="POST"
          action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name"
                   value="{{ $customer->name }}"
                   class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label>Phone</label>
            <input type="text" name="phone"
                   value="{{ $customer->phone }}"
                   class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email"
                   value="{{ $customer->email }}"
                   class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label>Address</label>
            <textarea name="address"
                      class="w-full border rounded p-2">
                {{ $customer->address }}
            </textarea>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
</div>
</x-app-layout>