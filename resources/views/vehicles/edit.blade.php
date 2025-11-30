<x-layouts.app :title="'Edit Vehicle'">
    <div class="p-6">

        <h2 class="text-2xl font-bold mb-4">Edit Vehicle</h2>

        <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ $vehicle->name }}" class="border p-2 w-full rounded">

            <input type="text" name="plate_number" value="{{ $vehicle->plate_number }}" class="border p-2 w-full rounded">

            <input type="text" name="color" value="{{ $vehicle->color }}" class="border p-2 w-full rounded">

            <select name="brand_id" class="border p-2 w-full rounded">
                <option value="">No Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $vehicle->brand_id == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Changes
            </button>
        </form>

    </div>
</x-layouts.app>
