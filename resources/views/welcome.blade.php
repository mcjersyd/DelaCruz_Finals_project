<x-layouts.app :title="'Dashboard'">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Dashboard</h1>
                <p class="text-slate-600 text-sm sm:text-base mt-2">Manage your vehicles and brands efficiently</p>
            </div>

            <!-- Success Message -->
            <x-alert type="success" dismissible="true" />

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 mb-6 sm:mb-8">
                <!-- Total Vehicles Card -->
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-xs sm:text-sm font-medium">Total Vehicles</p>
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1 sm:mt-2">{{ $vehicles->count() }}</h2>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-2 sm:p-3">
                            <svg class="h-6 sm:h-8 w-6 sm:w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Brands Card -->
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-xs sm:text-sm font-medium">Total Brands</p>
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1 sm:mt-2">{{ $brands->count() }}</h2>
                        </div>
                        <div class="bg-purple-100 rounded-lg p-2 sm:p-3">
                            <svg class="h-6 sm:h-8 w-6 sm:w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Vehicles Assigned Card -->
                @php
                    $totalVehicles = $vehicles->count();
                    $vehiclesWithBrand = $vehicles->whereNotNull('brand_id')->count();
                    $percentage = $totalVehicles > 0 ? round(($vehiclesWithBrand / $totalVehicles) * 100) : 0;
                @endphp
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-xs sm:text-sm font-medium">Assigned to Brand</p>
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1 sm:mt-2">{{ $percentage }}%</h2>
                        </div>
                        <div class="bg-amber-100 rounded-lg p-2 sm:p-3">
                            <svg class="h-6 sm:h-8 w-6 sm:w-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-6 sm:mb-8">
                <!-- Add Vehicle Form -->
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-4 sm:p-8">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-4 sm:mb-6">Add New Vehicle</h3>
                    <form action="{{ route('vehicles.store') }}" method="POST" class="space-y-3 sm:space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Vehicle Name</label>
                            <input type="text" name="name" placeholder="Enter vehicle name" class="w-full px-3 sm:px-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Plate Number</label>
                            <input type="text" name="plate_number" placeholder="e.g., ABC-1234" class="w-full px-3 sm:px-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Color</label>
                            <input type="text" name="color" placeholder="e.g., Black, White" class="w-full px-3 sm:px-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Brand (Optional)</label>
                            <select name="brand_id" class="w-full px-3 sm:px-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Select a brand...</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 text-sm rounded-lg transition">
                            Add Vehicle
                        </button>
                    </form>
                </div>

                <!-- Add Brand Form -->
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-4 sm:p-8">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-4 sm:mb-6">Add New Brand</h3>
                    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 sm:space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Brand Name</label>
                            <input type="text" name="name" placeholder="Enter brand name" class="w-full px-3 sm:px-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Brand Logo/Photo</label>
                            <input type="file" name="photo" accept="image/*" class="w-full px-3 sm:px-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        </div>
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 text-sm rounded-lg transition">
                            Add Brand
                        </button>
                    </form>
                    @if($errors->any())
                        <div class="mt-3 sm:mt-4 bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4">
                            <ul class="list-disc list-inside text-red-700 text-xs sm:text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vehicles Section -->
            <div id="vehicles" class="mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Vehicles</h2>
                    <a href="{{ route('vehicles.export-pdf') }}" class="w-full sm:w-auto inline-flex items-center justify-center sm:justify-start gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2-10h.01" />
                        </svg>
                        Export PDF
                    </a>
                </div>
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-3 sm:p-6 overflow-x-auto">
                    @livewire('vehicle-search')
                </div>
            </div>

            <!-- Brands Section -->
            <div id="brands">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Brands</h2>
                    <a href="{{ route('brands.export-pdf') }}" class="w-full sm:w-auto inline-flex items-center justify-center sm:justify-start gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2-10h.01" />
                        </svg>
                        Export PDF
                    </a>
                </div>
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-3 sm:p-6 overflow-x-auto">
                    @livewire('brand-search')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
