<div class="bg-white rounded-lg shadow overflow-hidden" wire:key="main-container">
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
                    Subject to Exam Mapping for: {{ $activeClass->name ?? 'N/A' }}
                </h2>
                <div class="flex space-x-2">
                    @if(!$isEditing)
                        <button wire:click="startEditing" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Configure Mapping
                        </button>
                    @else
                        <button wire:click="saveChanges" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            Save All
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
                <div class="overflow-auto max-h-[75vh] p-2">
                    <table class="min-w-[1200px] w-full divide-y divide-gray-200" wire:key="exam-subject-table">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                @php
                                    $examNameColors = [
                                        'bg-blue-100','bg-green-100','bg-yellow-100','bg-pink-100',
                                        'bg-purple-100','bg-indigo-100','bg-red-100','bg-teal-100'
                                    ];
                                @endphp
                                <th rowspan="3" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase bg-gray-100 border-r">
                                    Subject
                                </th>
                                @foreach($examStructure as $examNameId => $examNameData)
                                    @php
                                        $typeSpan = 0;
                                        foreach($examNameData['types'] as $typeData) { $typeSpan += count($typeData['parts']); }
                                        $examNameBg = $examNameColors[$loop->index % count($examNameColors)];
                                    @endphp
                                    <th colspan="{{ $typeSpan }}" class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider {{ $examNameBg }} border-b" wire:key="header-examname-{{ $examNameId }}">
                                        {{ $examNameData['name'] }}
                                    </th>
                                @endforeach
                                <th rowspan="3" class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-gray-100 border-l">
                                    Actions
                                </th>
                            </tr>
                            <tr>
                                @foreach($examStructure as $examNameId => $examNameData)
                                    @foreach($examNameData['types'] as $examTypeId => $typeData)
                                        <th colspan="{{ count($typeData['parts']) }}" class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase border-b" wire:key="header-examtype-{{ $examTypeId }}">
                                            {{ $typeData['name'] }}
                                        </th>
                                    @endforeach
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($examStructure as $examNameId => $examNameData)
                                    @foreach($examNameData['types'] as $examTypeId => $typeData)
                                        @foreach($typeData['parts'] as $examPartId => $partData)
                                            <th class="px-2 py-1 text-center text-[11px] font-medium text-gray-600 uppercase" wire:key="header-exampart-{{ $examPartId }}">
                                                {{ $partData['name'] }}
                                            </th>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        
                        <!-- Table Body with Subjects Only -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $grouped = collect($classSubjects)->groupBy(function($cs){
                                    return strtolower($cs->subject->subjectType->name ?? 'unknown');
                                });
                                $subjectTypeColors = [
                                    'summative' => 'bg-blue-50',
                                    'formative' => 'bg-yellow-50',
                                    'unknown' => 'bg-gray-50'
                                ];
                            @endphp
                            @forelse($grouped as $typeName => $subjectsGroup)
                                @php
                                    $rowSpan = count($subjectsGroup);
                                    $typeBg = $subjectTypeColors[$typeName] ?? 'bg-gray-50';
                                    $typeLabel = ucfirst($typeName);
                                @endphp
                                @foreach($subjectsGroup as $groupIndex => $classSubject)
                                    @php
                                        $subject = $classSubject->subject ?? null;
                                        $subjectType = $subject ? $subject->subjectType : null;
                                        $subjectTypeName = $subjectType ? $subjectType->name : 'Unknown';
                                    @endphp
                                    <tr class="hover:bg-gray-50" wire:key="subject-row-{{ $classSubject->id }}">
                                        @if($groupIndex === 0)
                                            <td rowspan="{{ $rowSpan }}" class="px-2 py-2 text-center border-r border-gray-200 {{ $typeBg }}">
                                                <div style="writing-mode: vertical-rl; transform: rotate(180deg);" class="text-xs font-semibold text-gray-700">
                                                    {{ $typeLabel }}
                                                </div>
                                            </td>
                                        @endif
                                        <td class="px-3 py-2 whitespace-nowrap border-r border-gray-200">
                                            <div class="text-sm font-medium text-gray-900">{{ $subject ? $subject->name : 'Unnamed' }}</div>
                                            <div class="text-[11px] text-gray-500">{{ $subjectTypeName }}</div>
                                        </td>
                                        @foreach($examStructure as $examNameId => $examNameData)
                                            @foreach($examNameData['types'] as $examTypeId => $typeData)
                                                @foreach($typeData['parts'] as $examPartId => $partData)
                                                    @php
                                                        $examDetail = isset($partData['details'][0]) ? $partData['details'][0] : null;
                                                        $examDetailId = $examDetail->id ?? null;
                                                        $examTypeName = $typeData['name'] ?? '';
                                                        $isTypeMatch = (strtolower(trim($subjectTypeName)) === strtolower(trim($examTypeName)));
                                                    @endphp
                                                    <td class="px-2 py-2 text-center border-r border-gray-100" wire:key="cell-{{ $classSubject->id }}-{{ $examPartId }}">
                                                        @if(!$isTypeMatch)
                                                            <span class="text-[11px] text-gray-400">N/A</span>
                                                        @else
                                                            @if($examDetailId)
                                                                @if($isEditing)
                                                                    <div class="flex flex-col items-center space-y-1">
                                                                        <div class="flex items-center justify-center space-x-1">
                                                                            <input type="checkbox" 
                                                                                wire:model.defer="selectedMappings.{{ $classSubject->subject_id }}.{{ $examDetailId }}.checked"
                                                                                class="h-4 w-4 rounded border-gray-300 text-blue-600">
                                                                        </div>
                                                                        <div x-data="{ checked: @entangle('selectedMappings.'.$classSubject->subject_id.'.'.$examDetailId.'.checked').defer }" 
                                                                            x-show="checked" 
                                                                            class="flex flex-col space-y-1 w-full">
                                                                            <input type="number" placeholder="FM" 
                                                                                wire:model.defer="selectedMappings.{{ $classSubject->subject_id }}.{{ $examDetailId }}.full_marks"
                                                                                class="text-[11px] w-16 px-1 py-0.5 border rounded border-gray-300">
                                                                            <input type="number" placeholder="PM" 
                                                                                wire:model.defer="selectedMappings.{{ $classSubject->subject_id }}.{{ $examDetailId }}.pass_marks"
                                                                                class="text-[11px] w-16 px-1 py-0.5 border rounded border-gray-300">
                                                                            <input type="number" placeholder="Time" 
                                                                                wire:model.defer="selectedMappings.{{ $classSubject->subject_id }}.{{ $examDetailId }}.time_in_minutes"
                                                                                class="text-[11px] w-16 px-1 py-0.5 border rounded border-gray-300">
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    @if(isset($selectedMappings[$classSubject->subject_id][$examDetailId]['checked']) && $selectedMappings[$classSubject->subject_id][$examDetailId]['checked'])
                                                                        <div class="flex items-center justify-center space-x-1">
                                                                            <span class="text-green-600 text-sm">✓</span>
                                                                            <span class="text-[10px] text-gray-600">FM {{ $selectedMappings[$classSubject->subject_id][$examDetailId]['full_marks'] ?? '-' }}</span>
                                                                            <span class="text-[10px] text-gray-600">PM {{ $selectedMappings[$classSubject->subject_id][$examDetailId]['pass_marks'] ?? '-' }}</span>
                                                                            <span class="text-[10px] text-gray-600">T {{ $selectedMappings[$classSubject->subject_id][$examDetailId]['time_in_minutes'] ?? '-' }}</span>
                                                                        </div>
                                                                    @else
                                                                        <span class="text-gray-200">-</span>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <span class="text-[11px] text-gray-400">N/A</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        <td class="px-4 py-4 text-center border-l border-gray-200">
                                            @if($isEditing && isset($classes[$activeTab]))
                                                <button wire:click="saveClassData({{ $classes[$activeTab]->id }})"
                                                    class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                                    Save Class
                                                </button>
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="100" class="px-6 py-12 text-center">
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
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Visual Guide:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Each <strong>Exam Name</strong> has a unique background color</li>
                        <li>• Each <strong>Exam Type</strong> within an exam name has a unique lighter shade</li>
                        <li>• Each <strong>Exam Part</strong> has a unique very light shade</li>
                        <li>• Subjects are ordered by subject_type (descending)</li>
                        <li>• Green checkmark indicates matching subject/exam types</li>
                        <li>• Yellow warning indicates type mismatch</li>
                    </ul>
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
