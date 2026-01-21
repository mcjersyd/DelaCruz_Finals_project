@props([
    'type' => 'info', // success, error, warning, info
    'message' => '',
    'dismissible' => true,
])

@if($message || ($type === 'success' && session('success')) || ($type === 'error' && session('error')) || ($type === 'warning' && session('warning')))
    @php
        $displayMessage = $message ?: match($type) {
            'success' => session('success'),
            'error' => session('error'),
            'warning' => session('warning'),
            default => session('info'),
        };

        $colors = match($type) {
            'success' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-800', 'icon' => 'text-emerald-600'],
            'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800', 'icon' => 'text-red-600'],
            'warning' => ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-800', 'icon' => 'text-amber-600'],
            default => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800', 'icon' => 'text-blue-600'],
        };

        $icons = match($type) {
            'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'error' => 'M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'warning' => 'M12 9v2m0 4v2m0 4v.01M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V9h2v4z',
            default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        };
    @endphp

    <div class="alert alert-{{ $type }} {{ $colors['bg'] }} border {{ $colors['border'] }} rounded-lg shadow-sm p-4 flex items-start gap-3 mb-4 transition-all duration-300" role="alert">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $colors['icon'] }}" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="{{ $icons }}" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="flex-grow">
            <p class="text-sm font-medium {{ $colors['text'] }}">{{ $displayMessage }}</p>
        </div>
        @if($dismissible)
            <button type="button" onclick="this.parentElement.remove()" class="flex-shrink-0 {{ $colors['icon'] }} hover:opacity-75 transition">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        @endif
    </div>
@endif
