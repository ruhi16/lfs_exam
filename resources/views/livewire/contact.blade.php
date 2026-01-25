<div class="flex-1 p-6 overflow-y-auto max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Compact Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">Select</div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">Exam Name</div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Types</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($examNames as $examName)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <input type="checkbox" 
                                   wire:model="selectedExamNames.{{ $examName->id }}"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $examName->name }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{-- @if(isset($selectedExamNames[$examName->id]) && $selectedExamNames[$examName->id]) --}}
                                <div class="space-y-2 ml-4">
                                    @foreach($examTypes as $examType)
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" 
                                                       wire:model="selectedExamTypes.{{ $examName->id }}.{{ $examType->id }}"
                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <span class="ml-2">{{ $examType->name }}</span>
                                            </label>
                                            
                                            {{-- @if(isset($selectedExamTypes[$examName->id][$examType->id]) && $selectedExamTypes[$examName->id][$examType->id]) --}}
                                                <div class="space-y-2 ml-6">
                                                    @foreach($examParts as $examPart)
                                                        <div>
                                                            <label class="inline-flex items-center">
                                                                <input type="checkbox" 
                                                                       wire:model="selectedExamParts.{{ $examName->id }}.{{ $examType->id }}.{{ $examPart->id }}"
                                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                                <span class="ml-2">{{ $examPart->name }}</span>
                                                            </label>
                                                            
                                                            {{-- @if(isset($selectedExamParts[$examName->id][$examType->id][$examPart->id]) && $selectedExamParts[$examName->id][$examType->id][$examPart->id]) --}}
                                                                <div class="space-y-2 ml-8">
                                                                    @foreach($examModes as $examMode)
                                                                        <label class="inline-flex items-center">
                                                                            <input type="checkbox" 
                                                                                   wire:model="selectedExamModes.{{ $examName->id }}.{{ $examType->id }}.{{ $examPart->id }}.{{ $examMode->id }}"
                                                                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                                            <span class="ml-2">{{ $examMode->name }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            {{-- @endif --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            {{-- @endif --}}
                                        </div>
                                    @endforeach
                                </div>
                            {{-- @endif --}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            @if(isset($selectedExamTypes[$examName->id][$examType->id]))
                            <button wire:click="saveExamConfiguration({{ $examName->id }})"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm">
                                Save
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>