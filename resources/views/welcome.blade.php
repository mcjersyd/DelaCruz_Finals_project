<x-layouts.app :title="'Dashboard'">
    <div class="p-6 space-y-6">

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
        @endif

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-3 gap-4">
            <div class="p-4 bg-white border rounded shadow">
                <p>Total Vehicles</p>
                <h2>{{ $vehicles->count() }}</h2>
            </div>
            <div class="p-4 bg-white border rounded shadow">
                <p>Total Brands</p>
                <h2>{{ $brands->count() }}</h2>
            </div>
            @php
                $totalVehicles = $vehicles->count();
                $vehiclesWithBrand = $vehicles->whereNotNull('brand_id')->count();
                $percentage = $totalVehicles > 0 ? round(($vehiclesWithBrand / $totalVehicles) * 100) : 0;
            @endphp
            <div class="p-4 bg-white border rounded shadow">
                <p>Vehicles Assigned to Brand</p>
                <h2>{{ $percentage }}%</h2>
            </div>
        </div>

        <!-- Add Vehicle Form -->
        <div class="p-4 bg-gray-50 border rounded">
            <h3>Add New Vehicle</h3>
            <form action="{{ route('vehicles.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Vehicle Name" class="border p-2 rounded" required>
                <input type="text" name="plate_number" placeholder="Plate Number" class="border p-2 rounded" required>
                <input type="text" name="color" placeholder="Color" class="border p-2 rounded" required>
                <select name="brand_id" class="border p-2 rounded">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded md:col-span-2">Add Vehicle</button>
            </form>
        </div>

        <!-- Vehicles Table -->
        <div class="overflow-x-auto">
            <h3 class="font-bold mb-2">Vehicles</h3>
            <table class="w-full border rounded">
                <thead>
                    <tr class="bg-gray-200">
                        <th>#</th>
                        <th>Name</th>
                        <th>Plate Number</th>
                        <th>Color</th>
                        <th>Brand</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr class="border-t">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->plate_number }}</td>
                            <td>{{ $vehicle->color }}</td>
                            <td>{{ $vehicle->brand ? $vehicle->brand->name : '-' }}</td>
                            <td class="space-x-2">
                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add Brand Form -->
        <div class="p-4 bg-gray-50 border rounded mt-6">
            <h3>Add New Brand</h3>
            <form action="{{ route('brands.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Brand Name" class="border p-2 rounded" required>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded md:col-span-2">Add Brand</button>
            </form>
        </div>

        <!-- Brands Table -->
        <div class="overflow-x-auto mt-4">
            <h3 class="font-bold mb-2">Brands</h3>
            <table class="w-full border rounded">
                <thead>
                    <tr class="bg-gray-200">
                        <th>#</th>
                        <th>Name</th>
                        <th>Vehicle Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr class="border-t">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->vehicles()->count() }}</td>
                            <td class="space-x-2">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
