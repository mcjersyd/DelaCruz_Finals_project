<x-layouts.app :title="'Brands Trash'">
    <div class="p-4 sm:p-6 bg-gradient-to-b from-white to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Brands Trash</h1>
                <p class="text-gray-600 text-sm sm:text-base">Recover or permanently delete deleted brands</p>
            </div>

            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" class="inline-block mb-4 bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 px-4 py-2 rounded font-semibold transition">
                ← Back to Dashboard
            </a>

            <!-- Brands Trash Table -->
            <div class="overflow-x-auto bg-white p-3 sm:p-4 border border-gray-300 rounded shadow-lg">
                <table class="w-full border border-gray-300 text-sm sm:text-base">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border px-2 sm:px-4 py-2 text-left text-gray-800">Photo</th>
                            <th class="border px-2 sm:px-4 py-2 text-left text-gray-800">Name</th>
                            <th class="border px-2 sm:px-4 py-2 text-left text-gray-800 hidden md:table-cell">Deleted At</th>
                            <th class="border px-2 sm:px-4 py-2 text-left text-gray-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="border px-2 sm:px-4 py-2">
                                    @if($brand->photo)
                                        <img src="{{ asset('storage/' . $brand->photo) }}" alt="{{ $brand->name }}" class="w-10 h-10 rounded object-cover border border-gray-300">
                                    @else
                                        <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center border border-gray-300">
                                            <span class="text-xs font-bold text-gray-600">{{ $brand->getInitials() }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="border px-2 sm:px-4 py-2 font-semibold text-gray-900">{{ $brand->name }}</td>
                                <td class="border px-2 sm:px-4 py-2 text-xs sm:text-sm text-gray-600 hidden md:table-cell">
                                    {{ $brand->deleted_at->format('M d, Y H:i') }}
                                </td>
                                <td class="border px-2 sm:px-4 py-2">
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <!-- Restore Button -->
                                        <form action="{{ route('brands.restore', $brand->id) }}" method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            <button type="submit" class="w-full sm:w-auto text-blue-600 hover:text-blue-800 font-semibold text-sm px-2 py-1 hover:bg-blue-50 rounded transition">
                                                Restore
                                            </button>
                                        </form>

                                        <!-- Permanent Delete Button -->
                                        <button type="button" onclick="openDialog('delete-brand-{{ $brand->id }}')" class="w-full sm:w-auto text-red-600 hover:text-red-800 font-semibold text-sm px-2 py-1 hover:bg-red-50 rounded transition">
                                            Delete
                                        </button>
                                        
                                        <!-- Confirmation Dialog -->
                                        <x-confirm-dialog 
                                            :id="'delete-brand-' . $brand->id"
                                            title="Permanently Delete Brand?"
                                            message="This action cannot be undone. The brand '{{ $brand->name }}' will be permanently removed from the system."
                                            confirmText="Delete Permanently"
                                            cancelText="Cancel"
                                            isDangerous="true"
                                        />
                                        
                                        <form id="form-delete-brand-{{ $brand->id }}" action="{{ route('brands.permanent-delete', $brand->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        
                                        <script>
                                        document.getElementById('delete-brand-{{ $brand->id }}').addEventListener('click', function(e) {
                                            if (e.target.textContent.includes('Delete Permanently')) {
                                                document.getElementById('form-delete-brand-{{ $brand->id }}').submit();
                                            }
                                        });
                                        </script>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                    No deleted brands. All is good!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
