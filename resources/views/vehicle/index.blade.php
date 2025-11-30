<x-layouts.app :title="'Vehicles'">
    <div class="p-6 space-y-6">

        <h2 class="text-2xl font-bold mb-4">Vehicles List</h2>

        <!-- Add New Vehicle Button -->
        <a href="{{ route('vehicles.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           + Add New Vehicle
        </a>

        <!-- Vehicles Table -->
        <div class="mt-6 overflow-x-auto">
            <table class="w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Plate Number</th>
                        <th class="border px-4 py-2">Color</th>
                        <th class="border px-4 py-2">Brand</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <td class="border px-4 py-2">{{ $vehicle->id }}</td>
                        <td class="border px-4 py-2">{{ $vehicle->name }}</td>
                        <td class="border px-4 py-2">{{ $vehicle->plate_number }}</td>
                        <td class="border px-4 py-2">{{ $vehicle->color }}</td>
                        <td class="border px-4 py-2">
                            {{ $vehicle->brand ? $vehicle->brand->name : 'No Brand' }}
                        </td>

                        <td class="border px-4 py-2 space-x-2">

                            <!-- Edit Button -->
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete this vehicle?')"
                                        class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</x-layouts.app>
