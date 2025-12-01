<x-layouts.app :title="'Dashboard'">
    <div class="p-6 space-y-8">

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg shadow-md border border-green-300 flex items-center gap-2">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards -->
       <div class="grid md:grid-cols-3 gap-6">
    <div class="p-6 bg-white border rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
        <span class="text-5xl">🚗</span> <!-- Malaking icon -->
        <div>
            <p class="text-gray-500">Total Vehicles</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-1">{{ $vehicles->count() }}</h2>
        </div>
    </div>

              <div class="p-6 bg-white border rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
        <span class="text-5xl">🏷️</span> <!-- Malaking icon -->
        <div>
            <p class="text-gray-500">Total Brands</p>
            <h2 class="text-3xl font-bold text-indigo-600 mt-1">{{ $brands->count() }}</h2>
        </div>
    </div>
            @php
                $totalVehicles = $vehicles->count();
                $vehiclesWithBrand = $vehicles->whereNotNull('brand_id')->count();
                $percentage = $totalVehicles > 0 ? round(($vehiclesWithBrand / $totalVehicles) * 100) : 0;
            @endphp
           <div class="p-6 bg-white border rounded-xl shadow hover:shadow-lg transition flex items-center gap-4">
        <span class="text-5xl">📊</span> <!-- Malaking icon -->
        <div>
            <p class="text-gray-500">Vehicles Assigned to Brand</p>
            <h2 class="text-3xl font-bold text-green-600 mt-1">{{ $percentage }}%</h2>
        </div>
    </div>
        </div>

        <!-- Add Vehicle Form -->
        <div class="p-6 bg-white border rounded-xl shadow space-y-4">
            <h3 class="text-xl font-semibold border-b pb-2">Add New Vehicle</h3>

            <form action="{{ route('vehicles.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Vehicle Name" class="border p-3 rounded focus:ring focus:ring-blue-200" required>
                <input type="text" name="plate_number" placeholder="Plate Number" class="border p-3 rounded focus:ring focus:ring-blue-200" required>
                <input type="text" name="color" placeholder="Color" class="border p-3 rounded focus:ring focus:ring-blue-200" required>
                <select name="brand_id" class="border p-3 rounded focus:ring focus:ring-blue-200">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded md:col-span-2 transition">
                    ➕ Add Vehicle
                </button>
            </form>
        </div>

        <!-- Vehicles Table -->
        <div class="overflow-x-auto">
            <h3 class="font-bold text-xl mb-3">🚗 Vehicles</h3>
            <table class="w-full border rounded-lg shadow">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Plate Number</th>
                        <th class="p-3">Color</th>
                        <th class="p-3">Brand</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3 text-center">{{ $loop->iteration }}</td>
                            <td class="p-3">🚗 {{ $vehicle->name }}</td>
                            <td class="p-3">{{ $vehicle->plate_number }}</td>
                            <td class="p-3">{{ $vehicle->color }}</td>
                            <td class="p-3">{{ $vehicle->brand ? $vehicle->brand->name : '-' }}</td>
                            <td class="p-3 space-x-2">
                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-blue-600 hover:underline">✏️ Edit</a>
                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this vehicle?')">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add Brand Form -->
        <div class="p-6 bg-white border rounded-xl shadow mt-6 space-y-4">
            <h3 class="text-xl font-semibold border-b pb-2">➕ Add New Brand</h3>
            <form action="{{ route('brands.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Brand Name" class="border p-3 rounded focus:ring focus:ring-blue-200" required>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded md:col-span-2 transition">➕ Add Brand</button>
            </form>
        </div>

        <!-- Brands Table -->
        <div class="overflow-x-auto mt-4">
            <h3 class="font-bold text-xl mb-3">🏷️ Brands</h3>
            <table class="w-full border rounded-lg shadow">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Vehicle Count</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3 text-center">{{ $loop->iteration }}</td>
                            <td class="p-3">🏷️ {{ $brand->name }}</td>
                            <td class="p-3">{{ $brand->vehicles()->count() }}</td>
                            <td class="p-3 space-x-2">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="text-blue-600 hover:underline">✏️ Edit</a>
                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete brand?')">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
