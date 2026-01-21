@props([
    'id' => 'confirm-dialog',
    'title' => 'Confirm Action',
    'message' => 'Are you sure?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'isDangerous' => false,
])

<div id="{{ $id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeDialog(event, '{{ $id }}')">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4 transform transition-all" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
            @if($isDangerous)
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.75 15H4.5a2.25 2.25 0 01-2.25-2.25V6.75a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0120.25 6.75v8.25a2.25 2.25 0 01-2.25 2.25h-2.25" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-red-900">{{ $title }}</h3>
            @else
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            @endif
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <p class="text-gray-600 text-sm">{{ $message }}</p>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 flex gap-3 justify-end">
            <button type="button" onclick="closeDialog(null, '{{ $id }}')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                {{ $cancelText }}
            </button>
            <button type="button" onclick="confirmAction('{{ $id }}')" class="px-4 py-2 text-sm font-medium text-white @if($isDangerous) bg-red-600 hover:bg-red-700 @else bg-blue-600 hover:bg-blue-700 @endif rounded-lg transition">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>

<script>
function openDialog(dialogId) {
    document.getElementById(dialogId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDialog(event, dialogId) {
    if (event && event.target.id !== dialogId) return;
    document.getElementById(dialogId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmAction(dialogId) {
    const dialog = document.getElementById(dialogId);
    const form = dialog.closest('form') || document.querySelector(`[data-dialog-target="${dialogId}"]`);
    closeDialog(null, dialogId);
    if (form) form.submit();
}

// Close dialog with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id$="-dialog"]').forEach(dialog => {
            if (!dialog.classList.contains('hidden')) {
                dialog.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }
});
</script>
