@if($isEnabled)
<div class="space-y-1 relative">
    {{-- Full Marks Input --}}
    <div class="relative">
        <input type="number" wire:model.lazy="fullMarks" placeholder="Full Marks" {{ $isFinalized ? 'disabled' : '' }}
            class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 
                   {{ $isFinalized ? 'bg-gray-100 cursor-not-allowed' : '' }}
                   {{ $errors->has('fullMarks') ? 'border-red-500' : '' }}" min="0" max="1000">

        {{-- Full Marks Error --}}
        @error('fullMarks')
        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Pass Marks Input --}}
    <div class="relative">
        <input type="number" wire:model.lazy="passMarks" placeholder="Pass Marks" {{ $isFinalized ? 'disabled' : '' }}
            class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 
                   {{ $isFinalized ? 'bg-gray-100 cursor-not-allowed' : '' }}
                   {{ $errors->has('passMarks') ? 'border-red-500' : '' }}" min="0" max="1000">

        {{-- Pass Marks Error --}}
        @error('passMarks')
        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Time Allotted Input --}}
    <div class="relative">
        <input type="number" wire:model.lazy="timeAllotted" placeholder="Time (min)" {{ $isFinalized ? 'disabled' : ''
            }} class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 
                   {{ $isFinalized ? 'bg-gray-100 cursor-not-allowed' : '' }}
                   {{ $errors->has('timeAllotted') ? 'border-red-500' : '' }}" min="0" max="600">

        {{-- Time Allotted Error --}}
        @error('timeAllotted')
        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Auto-save indicators --}}
    <div class="absolute -right-6 top-1">
        {{-- Loading indicator --}}
        <div wire:loading.class.remove="hidden" wire:target="fullMarks,passMarks,timeAllotted" class="hidden">
            <svg class="w-3 h-3 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>

        {{-- Success indicator (shown via JavaScript) --}}
        <div id="save-indicator-{{ $key }}" class="hidden">
            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
    </div>
</div>

{{-- JavaScript for save indicator --}}
<script>
    document.addEventListener('livewire:load', function () {
    Livewire.on('showSaveIndicator', function (key) {
        const indicator = document.getElementById('save-indicator-' + key);
        if (indicator) {
            indicator.classList.remove('hidden');
            setTimeout(() => {
                indicator.classList.add('hidden');
            }, 1000);
        }
    });
});
</script>
@else
<div class="text-xs text-gray-400 py-2">
    <span class="inline-block px-2 py-1 bg-gray-200 rounded text-gray-600">Not Available</span>
</div>
@endif