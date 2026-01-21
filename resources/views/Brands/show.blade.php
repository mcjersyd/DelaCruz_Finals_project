<x-layouts.app :title="'Brand Details'">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-3xl font-bold mb-6">{{ $brand->name }}</h1>

            @if($brand->photo)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $brand->photo) }}" alt="{{ $brand->name }}" class="max-w-md rounded-lg">
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                    <p class="mt-1 text-lg">{{ $brand->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                    <p class="mt-1 text-lg">{{ $brand->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('brands.edit', $brand) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit Brand
                </a>
                <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Are you sure?')">
                        Delete Brand
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
