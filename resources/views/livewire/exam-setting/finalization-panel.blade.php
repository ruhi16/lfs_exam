@if($selectedClassId)
<div class="flex justify-between items-center">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Exam Configuration Matrix</h2>
        <p class="text-sm text-gray-600 mt-1">
            Configure subjects for each exam type
            @if($isFinalized)
            <span class="inline-flex items-center px-2 py-1 ml-2 bg-red-100 border border-red-300 rounded-md">
                <svg class="w-4 h-4 mr-1 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-red-800 text-xs font-medium">FINALIZED - Data Locked</span>
            </span>
            @endif
        </p>
    </div>

    @if(!$isFinalized)
    <div class="flex items-center space-x-3">
        {{-- Completion Progress Indicators --}}
        <div class="text-sm text-gray-600">
            @if($canFinalize)
            <span class="inline-flex items-center px-2 py-1 bg-green-100 border border-green-300 rounded-md">
                <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 text-xs font-medium">Ready to Finalize</span>
            </span>
            @else
            <span class="inline-flex items-center px-2 py-1 bg-yellow-100 border border-yellow-300 rounded-md">
                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-yellow-800 text-xs font-medium">Complete All Data to Finalize</span>
            </span>
            @endif
        </div>

        {{-- Subject Type Progress Indicators --}}
        @if(count($completionStatus) > 0)
        <div class="flex items-center space-x-1">
            @foreach($subjectTypes as $subjectType)
            @php
            $status = $completionStatus[$subjectType->id] ?? ['hasData' => false, 'isComplete' => false, 'count' => 0];
            @endphp
            <div class="flex items-center"
                title="{{ $subjectType->name }}: {{ $status['hasData'] ? ($status['isComplete'] ? 'Complete' : 'Incomplete') : 'No data' }} ({{ $status['count'] }} subjects)">
                @if($status['hasData'] && $status['isComplete'])
                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                @elseif($status['hasData'])
                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"></path>
                </svg>
                @else
                <div class="w-4 h-4 border-2 border-gray-300 rounded-full"></div>
                @endif
                <span class="text-xs ml-1 text-gray-600">{{ substr($subjectType->name, 0, 3) }}</span>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Finalize Button --}}
        <button wire:click="finalizeClass" @if(!$canFinalize) disabled @endif class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 
                       disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-sm 
                       font-medium rounded-md transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span wire:loading.remove wire:target="finalizeClass">Finalize Class</span>
            <span wire:loading wire:target="finalizeClass">Finalizing...</span>
        </button>
    </div>
    @endif
</div>

{{-- Detailed Progress Information (expandable) --}}
@if(!$isFinalized && count($completionStatus) > 0)
<div class="mt-4 p-3 bg-gray-50 rounded-lg border" x-data="{ expanded: false }">
    <button @click="expanded = !expanded" class="flex items-center justify-between w-full text-sm text-gray-700">
        <span class="font-medium">Progress Details</span>
        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': expanded }" fill="currentColor"
            viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>

    <div x-show="expanded" x-transition class="mt-3 space-y-2">
        @foreach($subjectTypes as $subjectType)
        @php
        $status = $completionStatus[$subjectType->id] ?? ['hasData' => false, 'isComplete' => false, 'count' => 0];
        @endphp
        <div class="flex items-center justify-between py-1">
            <span class="text-sm text-gray-600">{{ $subjectType->name }}</span>
            <div class="flex items-center space-x-2">
                <span class="text-xs text-gray-500">{{ $status['count'] }} subjects</span>
                @if($status['hasData'] && $status['isComplete'])
                <span
                    class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Complete</span>
                @elseif($status['hasData'])
                <span
                    class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Incomplete</span>
                @else
                <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">No
                    Data</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endif