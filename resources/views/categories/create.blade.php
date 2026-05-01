<x-app-layout>
    <div class="p-6 max-w-xl">

        <h2 class="text-xl font-bold mb-4">Add Category</h2>

        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block">Name</label>
                <input type="text" name="name" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block">Description</label>
                <textarea name="description" class="border rounded w-full p-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block">Category Image</label>
                <input type="file" name="image" class="border rounded w-full p-2" accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Allowed formats: JPG, PNG, GIF (Max 2MB)</p>
            </div>

            <button class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-6 py-2 rounded-lg font-bold shadow-md shadow-emerald-100 transition-all">
                Save Category
            </button>

        </form>

    </div>
</x-app-layout>
