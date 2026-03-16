@props([
    'id' => '',
    'title' => '',
    'size' => 'md', // sm, md, lg, xl
    'show' => false
])

<div id="{{ $id }}" class="fixed inset-0 z-50 overflow-y-auto {{ $show ? '' : 'hidden' }}">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal('{{ $id }}')"></div>

        <!-- Modal panel -->
        <div class="inline-block w-full {{ $size === 'sm' ? 'max-w-sm' : ($size === 'md' ? 'max-w-md' : ($size === 'lg' ? 'max-w-lg' : ($size === 'xl' ? 'max-w-2xl' : 'max-w-4xl'))) }} p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                <button onclick="closeModal('{{ $id }}')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Content -->
            <div class="mt-4">
                {{ $slot }}
            </div>

            <!-- Footer (if provided) -->
            @if(isset($footer))
            <div class="mt-6 pt-4 border-t border-gray-200">
                {{ $footer }}
            </div>
            @endif

        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('[id$="-modal"]');
        modals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                closeModal(modal.id);
            }
        });
    }
});
</script>
