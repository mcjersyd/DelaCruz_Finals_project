<x-layouts.app :title="'Vehicles'">
    <div class="p-6 space-y-6 bg-gradient-to-b from-white to-gray-100 min-h-screen">

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Vehicles List</h2>

        <!-- Add New Vehicle Button -->
        <a href="{{ route('vehicles.create') }}"
           class="bg-white text-gray-800 border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 transition font-semibold inline-block">
           + Add New Vehicle
        </a>

        <!-- Vehicles Table -->
        <div class="mt-6 overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-300">
            <table class="w-full border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border px-4 py-2 text-left text-gray-800">ID</th>
                        <th class="border px-4 py-2 text-left text-gray-800">Name</th>
                        <th class="border px-4 py-2 text-left text-gray-800">Plate Number</th>
                        <th class="border px-4 py-2 text-left text-gray-800">Color</th>
                        <th class="border px-4 py-2 text-left text-gray-800">Brand</th>
                        <th class="border px-4 py-2 text-left text-gray-800">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vehicles as $vehicle)
                    <tr class="border-t hover:bg-gray-50 transition">
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
                                class="text-orange-600 hover:text-orange-800 font-semibold">
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
                                        class="text-red-600 hover:text-red-800 font-semibold">
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
