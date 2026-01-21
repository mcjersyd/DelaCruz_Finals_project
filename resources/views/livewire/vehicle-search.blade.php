<div class="space-y-6">
    <!-- Search Section -->
    <div class="flex items-center gap-2">
        <input type="text" 
               wire:model.live="search" 
               placeholder="Search by name, plate, color, or brand..." 
               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
    </div>

    <!-- Vehicles Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Photo</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Plate Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Color</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Brand</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-3">
                            @if($vehicle->photo)
                                <img src="{{ asset('storage/' . $vehicle->photo) }}" alt="{{ $vehicle->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-slate-200 flex items-center justify-center">
                                    <span class="text-xs font-bold text-slate-600">{{ $vehicle->getInitials() }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ $vehicle->name }}</td>
                        <td class="px-6 py-3 text-sm text-slate-600">{{ $vehicle->plate_number }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-block w-6 h-6 rounded border border-slate-300" 
                                  style="background-color: {{ $vehicle->color }};" 
                                  title="{{ $vehicle->color }}"></span>
                        </td>
                        <td class="px-6 py-3 text-sm text-slate-600">
                            {{ $vehicle->brand ? $vehicle->brand->name : '-' }}
                        </td>
                        <td class="px-6 py-3 text-sm font-medium space-x-3 flex">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}" 
                               class="text-blue-600 hover:text-blue-800 transition">
                                View
                            </a>
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" 
                               class="text-slate-600 hover:text-slate-800 transition">
                                Edit
                            </a>
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Delete this vehicle?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            No vehicles found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $vehicles->links() }}
    </div>
</div>
