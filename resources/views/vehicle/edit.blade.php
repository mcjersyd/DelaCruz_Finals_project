<x-layouts.app :title="'Edit Vehicle'">
    <div class="p-6 bg-gradient-to-b from-white to-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6 border border-gray-300">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Vehicle</h2>

            <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Photo Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Photo</label>
                    <div class="flex items-center gap-4">
                        @if($vehicle->photo)
                            <img src="{{ asset('storage/' . $vehicle->photo) }}" alt="{{ $vehicle->name }}" class="w-16 h-16 rounded-lg object-cover border border-gray-300">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center border border-gray-300">
                                <span class="text-lg font-semibold text-gray-600">{{ $vehicle->getInitials() }}</span>
                            </div>
                        @endif
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="border border-gray-300 p-2 flex-1 rounded focus:ring-2 focus:ring-gray-400">
                    </div>
                    <small class="text-gray-600">JPG/PNG only, max 2MB</small>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="text" name="name" value="{{ $vehicle->name }}" class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-gray-400">

                <input type="text" name="plate_number" value="{{ $vehicle->plate_number }}" class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-gray-400">

                <input type="text" name="color" value="{{ $vehicle->color }}" class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-gray-400">

                <select name="brand_id" class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-gray-400">
                    <option value="">No Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $vehicle->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 px-4 py-2 rounded font-semibold transition">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
