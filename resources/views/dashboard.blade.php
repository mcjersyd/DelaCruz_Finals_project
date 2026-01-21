<x-layouts.app :title="'Vehicles Dashboard'">
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
                <h2>{{ \App\Models\Brand::count() }}</h2>
            </div>
            <div class="p-4 bg-white border rounded shadow">
                <p>Static Info</p>
                <h2>94%</h2>
            </div>
        </div>

        <!-- Add Vehicle Form -->
        <div class="p-4 bg-gray-50 border rounded">
            <h3>Add New Vehicle</h3>
            <form action="{{ route('vehicles.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Vehicle Name" class="border p-2 rounded">
                <input type="text" name="plate_number" placeholder="Plate Number" class="border p-2 rounded">
                <input type="text" name="color" placeholder="Color" class="border p-2 rounded">
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
                            <td>{{ $vehicle->brand ? $vehicle->brand->name : 'N/A' }}</td>
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
<x-layouts.app :title="'Brands Dashboard'">
    <div class="p-6 space-y-6">

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
        @endif

        <!-- Add Brand Form -->
        <div class="p-4 bg-gray-50 border rounded">
            <h3>Add New Brand</h3>
            <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Brand Name" class="border p-2 rounded" required>
                <input type="file" name="photo" placeholder="Brand Photo" class="border p-2 rounded" accept="image/*">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded md:col-span-2">Add Brand</button>
            </form>
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-3">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Brands Table -->
        <div class="overflow-x-auto">
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
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
