<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Category</h2>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium text-gray-700 mb-1">Category Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Enter category name"
                    required
                >
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea
                    name="description"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Enter description"
                >{{ old('description', $category->description) }}</textarea>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Category Image</label>
                @if($category->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-20 w-20 object-cover rounded border">
                    </div>
                @endif
                <input type="file" name="image"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Allowed formats: JPG, PNG, GIF (Max 2MB). Leave blank to keep current image.</p>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit"
                    class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white px-6 py-2 rounded-lg font-bold shadow-md shadow-emerald-100 transition-all">
                    Update Category
                </button>
                <a href="{{ route('categories.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>