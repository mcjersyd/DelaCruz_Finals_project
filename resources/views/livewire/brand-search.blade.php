<div class="space-y-6">
    <!-- Search Bar -->
    <div class="flex flex-col sm:flex-row gap-3">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Search brands by name..." 
            class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm"
        />
        @if($search)
            <button 
                wire:click="clearFilters" 
                class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition text-sm"
            >
                Clear
            </button>
        @endif
    </div>

    <!-- Brands Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Logo</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Vehicles</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-3">
                            @if($brand->photo)
                                <img src="{{ asset('storage/' . $brand->photo) }}" alt="{{ $brand->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-slate-200 flex items-center justify-center">
                                    <span class="text-xs font-bold text-slate-600">{{ $brand->getInitials() }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ $brand->name }}</td>
                        <td class="px-6 py-3 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                {{ $brand->vehicles_count }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm font-medium space-x-3 flex">
                            <a href="{{ route('brands.show', $brand->id) }}" 
                               class="text-blue-600 hover:text-blue-800 transition">
                                View
                            </a>
                            <a href="{{ route('brands.edit', $brand->id) }}" 
                               class="text-slate-600 hover:text-slate-800 transition">
                                Edit
                            </a>
                            <form action="{{ route('brands.destroy', $brand->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Delete this brand?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            @if($search)
                                No brands found matching "{{ $search }}"
                            @else
                                No brands found
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $brands->links() }}
    </div>
</div>
