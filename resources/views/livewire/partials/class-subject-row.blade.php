<tr class="hover:bg-gray-50">
    <td class="px-4 py-3 text-sm text-gray-900">
        <div class="flex items-center space-x-1">
            <span class="font-medium">{{ $classSubject['order_index'] }}</span>
            <div class="flex flex-col space-y-1">
                @if($classSubject['order_index'] > 1)
                    <button wire:click="moveUp({{ $classSubject['id'] }})" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @endif
                @php
                    $totalSubjects = count($classSubjects['summative']) + count($classSubjects['formative']) + count($classSubjects['others']);
                @endphp
                @if($classSubject['order_index'] < $totalSubjects)
                    <button wire:click="moveDown({{ $classSubject['id'] }})" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </td>
    <td class="px-4 py-3 text-sm text-gray-900">
        <div class="font-medium">{{ $classSubject['subject_name'] }}</div>
        @if($classSubject['subject_code'])
            <div class="text-xs text-gray-500">{{ $classSubject['subject_code'] }}</div>
        @endif
        @if($classSubject['is_optional'])
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                Optional
            </span>
        @endif
    </td>
    <td class="px-4 py-3 text-sm text-gray-500">
        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
            @if($typeColor === 'blue') bg-blue-100 text-blue-800
            @elseif($typeColor === 'green') bg-green-100 text-green-800
            @else bg-gray-100 text-gray-800
            @endif">
            {{ $classSubject['subject_type_name'] }}
        </span>
    </td>
    <td class="px-4 py-3 text-sm text-gray-900">
        <div class="font-medium">{{ $classSubject['name'] }}</div>
    </td>
    <td class="px-4 py-3 text-sm text-gray-500">
        {{ $classSubject['description'] ?: 'No description' }}
    </td>
    <td class="px-4 py-3 text-sm">
        <div class="flex flex-col space-y-1">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                {{ $classSubject['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $classSubject['is_active'] ? 'Active' : 'Inactive' }}
            </span>
            @if($classSubject['is_finalized'])
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                    Finalized
                </span>
            @endif
        </div>
    </td>
    <td class="px-4 py-3 text-sm text-gray-500">
        <div>{{ $classSubject['created_by'] }}</div>
        <div class="text-xs">{{ $classSubject['created_at'] }}</div>
        @if($classSubject['approved_by'])
            <div class="text-xs text-green-600">Approved by: {{ $classSubject['approved_by'] }}</div>
        @endif
    </td>
    <td class="px-4 py-3 text-sm text-center">
        <div class="flex justify-center space-x-2">
            <button wire:click="editClassSubject({{ $classSubject['id'] }})"
                class="text-indigo-600 hover:text-indigo-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </button>

            <button wire:click="toggleStatus({{ $classSubject['id'] }})"
                class="{{ $classSubject['is_active'] ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                @if($classSubject['is_active'])
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </button>

            @if(!$classSubject['is_finalized'])
                <button wire:click="finalizeClassSubject({{ $classSubject['id'] }})"
                    class="text-blue-600 hover:text-blue-900" title="Finalize">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            @endif

            <button wire:click="deleteClassSubject({{ $classSubject['id'] }})"
                onclick="return confirm('Are you sure you want to delete this class subject?')"
                class="text-red-600 hover:text-red-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>
    </td>
</tr>