@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center justify-between bg-white text-gray-800 p-6 rounded-lg shadow-lg border border-gray-300">
        <div>
            <h1 class="text-3xl font-bold">{{ $brand->name }} Vehicles</h1>
            <p class="text-gray-600 mt-2">Showing all motors of {{ $brand->name }}</p>
        </div>
        <a href="{{ route('brands.index') }}" 
           class="bg-white text-gray-800 border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 transition font-semibold">
            ← Back to Brands
        </a>
    </div>

    <!-- Vehicles Table -->
    <div class="overflow-x-auto bg-white p-4 border border-gray-300 rounded shadow-lg">
        <table class="w-full border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-4 py-2 text-left text-gray-800">ID</th>
                    <th class="border px-4 py-2 text-left text-gray-800">Name</th>
                    <th class="border px-4 py-2 text-left text-gray-800">Plate Number</th>
                    <th class="border px-4 py-2 text-left text-gray-800">Color</th>
                    <th class="border px-4 py-2 text-left text-gray-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="border px-4 py-2">{{ $vehicle->id }}</td>
                        <td class="border px-4 py-2">{{ $vehicle->name }}</td>
                        <td class="border px-4 py-2">{{ $vehicle->plate_number }}</td>
                        <td class="border px-4 py-2">
                            <span class="inline-block w-6 h-6 rounded border border-gray-300" 
                                  style="background-color: {{ $vehicle->color }};" 
                                  title="{{ $vehicle->color }}"></span>
                            {{ $vehicle->color }}
                        </td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" 
                               class="text-gray-600 hover:text-gray-800 font-semibold">
                                Edit
                            </a>
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Delete this vehicle?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-center text-gray-500 py-8">
                            No vehicles found for this brand.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($vehicles->hasPages())
        <div class="mt-4">
            {{ $vehicles->links() }}
        </div>
    @endif
</div>
@endsection
