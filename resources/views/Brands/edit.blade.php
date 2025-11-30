<x-layouts.app :title="'Edit Brand'">
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Edit Brand</h2>

        <form action="{{ route('brands.update', $brand->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ $brand->name }}" class="border p-2 w-full rounded">

            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Save Changes</button>
        </form>
    </div>
</x-layouts.app>
