<x-layouts.app :title="'Edit Brand'">
    <div class="p-6 bg-gradient-to-b from-white to-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6 border border-gray-300">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Brand</h2>

            <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Photo Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand Photo</label>
                    <div class="flex items-center gap-4">
                        @if($brand->photo)
                            <img src="{{ asset('storage/' . $brand->photo) }}" alt="{{ $brand->name }}" class="w-16 h-16 rounded-lg object-cover border border-gray-300">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center border border-gray-300">
                                <span class="text-lg font-semibold text-gray-600">{{ $brand->getInitials() }}</span>
                            </div>
                        @endif
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="border border-gray-300 p-2 flex-1 rounded focus:ring-2 focus:ring-gray-400">
                    </div>
                    <small class="text-gray-600">JPG/PNG only, max 2MB</small>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="text" name="name" value="{{ $brand->name }}" class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-gray-400">

                <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 p-2 rounded font-semibold transition">Save Changes</button>
            </form>
        </div>
    </div>
</x-layouts.app>
