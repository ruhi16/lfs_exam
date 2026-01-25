<div class="mb-4">
    <label for="class-select" class="block text-sm font-medium text-gray-700 mb-2">
        Select Class
    </label>
    <div class="relative">
        <select id="class-select" wire:model="selectedClassId" class="w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                   {{ $isFinalized ? 'bg-gray-100 cursor-not-allowed' : '' }}">
            <option value="">Choose a class...</option>
            @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        {{-- Loading indicator --}}
        <div wire:loading.class.remove="hidden" wire:target="selectedClassId" class="hidden absolute right-3 top-3">
            <svg class="w-4 h-4 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>

    {{-- Finalization status indicator --}}
    @if($selectedClassId && $isFinalized)
    <div class="mt-2">
        <span class="inline-flex items-center px-2 py-1 bg-red-100 border border-red-300 rounded-md">
            <svg class="w-4 h-4 mr-1 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-red-800 text-xs font-medium">This class configuration is finalized</span>
        </span>
    </div>
    @endif
</div>