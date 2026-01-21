<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

    <div class="flex min-h-screen"> 
        <!-- SIDEBAR -->
        <flux:sidebar sticky stashable 
            class="w-64 border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse p-4">
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                        Dashboard
                    </flux:navlist.item>

                    <flux:navlist.item icon="truck" href="#vehicles" :current="request()->routeIs('dashboard')">
                        Vehicles
                    </flux:navlist.item>

                    <flux:navlist.item icon="cube" href="#brands" :current="request()->routeIs('dashboard')">
                        Brands
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Trash & Management')">
                    <flux:navlist.item icon="trash" :href="route('vehicles.trash')" :current="request()->routeIs('vehicles.trash')">
                        Vehicles Trash
                    </flux:navlist.item>

                    <flux:navlist.item icon="trash" :href="route('brands.trash')" :current="request()->routeIs('brands.trash')">
                        Brands Trash
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    Repository
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    Documentation
                </flux:navlist.item>

                <flux:navlist.item icon="arrow-right-start-on-rectangle" x-data @click="document.getElementById('logout-form').submit()">
                    Logout
                </flux:navlist.item>
            </flux:navlist>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>

       

        </flux:sidebar>
        <!-- END SIDEBAR -->

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>

    @fluxScripts
</body>
</html>
