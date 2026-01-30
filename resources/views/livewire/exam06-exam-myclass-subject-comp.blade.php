<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex space-x-8" aria-label="Tabs">
            @if(isset($classes) && count($classes) > 0)
                @foreach($classes as $index => $class)
                    <button wire:click="setActiveTab({{ $index }})"
                        class="py-4 px-1 border-b-2 font-medium text-sm @if($activeTab === $index) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                        {{ $class->name ?? 'Class ' . ($index + 1) }}
                    </button>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Content Area -->
    <div class="px-6 py-4">
        @if(isset($classes[$activeTab]) && $classes[$activeTab])
            @php
                $activeClass = $classes[$activeTab];
            @endphp
            
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    Map Subjects to Exam Options for: {{ $activeClass->name ?? 'N/A' }}
                </h2>
                <div class="flex space-x-2">
                    @if(!$isEditing)
                        <button wire:click="startEditing" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Configure Subject Mapping
                        </button>
                    @else
                        <button wire:click="saveChanges" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            Save Mapping
                        </button>
                        <button wire:click="cancelEditing" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
                    @endif
                </div>
            </div>

            @if(!empty($examStructure))
                <!-- Subject Mapping Table -->
                <div class="overflow-x-auto max-h-screen">
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Three-level Headers -->
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <!-- Exam Names Level -->
                            <tr>
                                <th rowspan="3" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 border-r">
                                    Subject
                                </th>
                                {{-- <th rowspan="3" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 border-r">
                                    Subject Type
                                </th> --}}
                                
                                @foreach($examStructure as $examNameId => $examNameData)
                                    @php
                                        // Count total exam types for this exam name
                                        $typeSpan = 0;
                                        foreach($examNameData['types'] as $examTypeId => $typeData) {
                                            $typeSpan += count($typeData['parts']);
                                        }
                                    @endphp
                                    <th colspan="{{ $typeSpan }}" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-blue-100 border-b">
                                        {{ $examNameData['name'] }}
                                    </th>
                                @endforeach
                            </tr>
                            
                            <!-- Exam Types Level -->
                            <tr>
                                @foreach($examStructure as $examNameId => $examNameData)
                                    @foreach($examNameData['types'] as $examTypeId => $typeData)
                                        @php
                                            $partSpan = count($typeData['parts']);
                                        @endphp
                                        <th colspan="{{ $partSpan }}" class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider bg-blue-50 border-b">
                                            {{ $typeData['name'] }}
                                        </th>
                                    @endforeach
                                @endforeach
                            </tr>
                            
                            <!-- Exam Parts Level -->
                            <tr>
                                @foreach($examStructure as $examNameId => $examNameData)
                                    @foreach($examNameData['types'] as $examTypeId => $typeData)
                                        @foreach($typeData['parts'] as $examPartId => $partData)
                                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-25">
                                                {{ $partData['name'] }}
                                            </th>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($classSubjects as $classSubject)
                                @php
                                    $subject = $classSubject->subject ?? null;
                                    $subjectType = $subject ? $subject->subjectType : null;
                                    $subjectTypeName = $subjectType ? $subjectType->name : 'Unknown';
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $subject ? $subject->name : 'Unnamed Subject' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $subjectTypeName }}
                                        </div>
                                    </td>
                                    
                                    <!-- Exam Part Columns with Type Matching -->
                                    @foreach($examStructure as $examNameId => $examNameData)
                                        @foreach($examNameData['types'] as $examTypeId => $typeData)
                                            @foreach($typeData['parts'] as $examPartId => $partData)
                                                @php
                                                    // Get the exam detail for this specific part
                                                    $examDetail = $partData['details'][0] ?? null;
                                                    $examDetailId = $examDetail ? $examDetail->id : null;
                                                    
                                                    // Check if subject type matches exam type
                                                    $examTypeName = $typeData['name'] ?? '';
                                                    $isTypeMatch = (strtolower(trim($subjectTypeName)) === strtolower(trim($examTypeName)));
                                                    
                                                    // Create mapping key only if examDetailId and subject_id exist
                                                    $key = $examDetailId && $classSubject->subject_id ? $examDetailId . '_' . $classSubject->subject_id : null;
                                                    $isSelected = $examDetailId && $isTypeMatch && $key && isset($selectedSubjects[$key]) && $selectedSubjects[$key]['is_selected'];
                                                @endphp
                                                <td class="px-3 py-4 text-center {{ $isTypeMatch ? ($examDetailId ? 'bg-green-50' : 'bg-yellow-50') : 'bg-gray-50' }} border-r border-gray-100">
                                                    @if($examDetailId && $isTypeMatch && $classSubject->subject_id)
                                                        <input type="checkbox"
                                                               wire:click="toggleSubject({{ $examDetailId }}, {{ $classSubject->subject_id }})"
                                                               {{ $isSelected ? 'checked' : '' }}
                                                               {{ !$isEditing ? 'disabled' : '' }}
                                                               class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 {{ !$isEditing ? 'cursor-not-allowed' : '' }}">
                                                        <div class="text-xs text-gray-500 mt-1">{{ $examTypeName }}</div>
                                                    @elseif($examDetailId)
                                                        <div class="text-xs text-gray-400">Type mismatch</div>
                                                        <div class="text-xs text-gray-400 mt-1">({{ $examTypeName }})</div>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="50" class="px-6 py-12 text-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h.01M15 7h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No subjects found</h3>
                                            <p class="mt-1 text-sm text-gray-500">No subjects are configured for this class.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Legend -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">How to use:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Click "Configure Subject Mapping" to enable editing</li>
                        <li>• Only subjects with matching types can be selected (green background)</li>
                        <li>• Check boxes to map subjects to compatible exam options</li>
                        <li>• Click "Save Mapping" to save your configuration</li>
                    </ul>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <h5 class="text-xs font-medium text-gray-700 mb-1">Color Guide:</h5>
                        <div class="flex flex-wrap gap-3 text-xs">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-100 rounded mr-1"></div>
                                <span>Matching subject/exam types</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-100 rounded mr-1"></div>
                                <span>Type mismatch</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-gray-100 rounded mr-1"></div>
                                <span>No exam detail</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No exam structure found</h3>
                    <p class="mt-1 text-sm text-gray-500">No exam details are configured for this class.</p>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Classes Found</h3>
                <p class="text-gray-500">Please configure classes in the system first.</p>
            </div>
        @endif
    </div>
</div>