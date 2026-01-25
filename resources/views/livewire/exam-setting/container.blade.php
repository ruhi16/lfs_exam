<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Header Section --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Exam Setting with Full Marks, Pass Marks & Time</h1>
            <p class="text-sm text-gray-600 mt-1">Configure exam subjects with marks and time allocation (Modular
                Version)</p>
        </div>

        {{-- Class Selection Section --}}
        <div class="p-6">
            @livewire('exam-setting.class-selector')
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if (session()->has('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- Main Content Section --}}
    @if($selectedClassId)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            {{-- Finalization Panel --}}
            @livewire('exam-setting.finalization-panel', [
            'selectedClassId' => $selectedClassId,
            'isFinalized' => $isFinalized
            ], key('finalization-' . $selectedClassId))
        </div>

        <div class="p-6">
            {{-- Exam Configuration Matrix --}}
            @livewire('exam-setting.exam-config-matrix', [
            'selectedClassId' => $selectedClassId
            ], key('matrix-' . $selectedClassId))
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 text-center">
            <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Select a Class</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Please select a class from the dropdown above to configure exam settings.
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- Loading States --}}
    <div wire:loading.class.remove="hidden" wire:target="handleClassChange"
        class="hidden fixed inset-0 bg-gray-500 bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-gray-900">Loading exam configuration...</span>
            </div>
        </div>
    </div>

    {{-- Success Notification Handler --}}
    <script>
        document.addEventListener('livewire:load', function () {
            // Global notification handler for modular components
            Livewire.on('showNotification', function (data) {
                const type = data.type || 'success';
                const message = data.message || 'Operation completed successfully';
                
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto z-50 transition-all duration-300 transform translate-x-full`;
                
                const bgColor = type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
                const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
                const iconColor = type === 'success' ? 'text-green-400' : 'text-red-400';
                
                notification.innerHTML = `
                    <div class="rounded-lg border ${bgColor} p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 ${iconColor}" viewBox="0 0 20 20" fill="currentColor">
                                    ${type === 'success' 
                                        ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />'
                                        : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />'
                                    }
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium ${textColor}">${message}</p>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Auto dismiss after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            });
        });
    </script>
</div>