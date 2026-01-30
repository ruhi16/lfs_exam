<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Class-Subject Configuration</h1>
        <p class="text-gray-600 mt-2">Configure subjects for each exam structure</p>
    </div>

    <!-- Status Messages -->
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    @if($isEditing)
        <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-md">
            <strong>Edit Mode Active:</strong> Configure subject mappings and exam parameters.
        </div>
    @endif

    <!-- Class Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex space-x-8" aria-label="Tabs">
            @if(isset($classes) && count($classes) > 0)
                @foreach($classes as $index => $class)
                    <button wire:click="setActiveTab({{ $index }})"
                        class="py-4 px-1 border-b-2 font-medium text-sm @if($activeTab === $index) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                        {{ $class->name ?? 'Class ' . ($index + 1) }}
                    </button>
                @endforeach
            @else
                <div class="py-4 text-gray-500">No active classes available</div>
            @endif
        </div>
    </div>

    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(isset($classes[$activeTab]) && $classes[$activeTab])
            @php
                $activeClass = $classes[$activeTab];
            @endphp

            <div class="p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Exam Structure for Class: {{ $activeClass->name ?? 'N/A' }}
                    </h2>
                    <div class="flex space-x-2">
                        @if(!$isEditing)
                            <button wire:click="startEditing()"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition-colors">
                                Configure Subjects
                            </button>
                        @else
                            <button wire:click="saveChanges()"
                                class="px-4 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition-colors">
                                Save Changes
                            </button>
                            <button wire:click="cancelEditing()"
                                class="px-4 py-2 bg-gray-500 text-white text-sm rounded hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                        @endif
                    </div>
                </div>

                @if(count($examStructure) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <!-- Header Section -->
                            <thead class="bg-gray-100">
                                <!-- First Header Row: Subject Names -->
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-300">
                                        Subjects
                                    </th>

                                    @foreach($examStructure as $examNameId => $examNameData)
                                        @php
                                            // Calculate total columns for this exam name
                                            $totalColumns = 0;
                                            foreach ($examNameData['types'] as $typeData) {
                                                $totalColumns += count($typeData['parts']);
                                            }
                                        @endphp
                                        <th colspan="{{ $totalColumns }}"
                                            class="px-4 py-3 text-center text-xs font-medium text-blue-600 uppercase tracking-wider border-l border-gray-300 bg-blue-50">
                                            {{ $examNameData['name'] }}
                                        </th>
                                    @endforeach
                                </tr>

                                <!-- Second Header Row: Exam Types -->
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-300">
                                    </th>

                                    @foreach($examStructure as $examNameId => $examNameData)
                                        @foreach($examNameData['types'] as $examTypeId => $typeData)
                                            <th colspan="{{ count($typeData['parts']) }}"
                                                class="px-3 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-l border-gray-200 bg-gray-50">
                                                {{ $typeData['name'] }}
                                            </th>
                                        @endforeach
                                    @endforeach
                                </tr>

                                <!-- Third Header Row: Exam Parts -->
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-300">
                                    </th>

                                    @foreach($examStructure as $examNameId => $examNameData)
                                        @foreach($examNameData['types'] as $examTypeId => $typeData)
                                            @foreach($typeData['parts'] as $examPartId => $partData)
                                                <th
                                                    class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
                                                    {{ $partData['name'] }}
                                                </th>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>

                            <!-- Body Section -->
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($classSubjects as $classSubject)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150"
                                        wire:key="subject-{{ $classSubject->id }}">
                                        <!-- Subject Information Column -->
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 bg-gray-50">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $classSubject->subject->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $classSubject->subject->subjectType->name ?? 'Unknown' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Exam Structure Columns -->
                                        @foreach($examStructure as $examNameId => $examNameData)
                                            @foreach($examNameData['types'] as $examTypeId => $typeData)
                                                @foreach($typeData['parts'] as $examPartId => $partData)
                                                    @php
                                                        // Find the first exam detail for this combination
                                                        $examDetail = null;
                                                        $examDetailId = null;

                                                        if (isset($partData['details']) && !empty($partData['details'])) {
                                                            $examDetail = $partData['details'][0];
                                                            $examDetailId = $examDetail->id ?? null;
                                                        }

                                                        $isSelected = false;
                                                        $subjectData = null;
                                                        $key = null;

                                                        if ($examDetailId && isset($classSubject->subject_id)) {
                                                            $key = $examDetailId . '_' . $classSubject->subject_id;
                                                            $isSelected = isset($selectedSubjects[$key]) && $selectedSubjects[$key]['is_selected'];
                                                            $subjectData = $selectedSubjects[$key] ?? null;
                                                        }
                                                    @endphp

                                                    <td class="px-2 py-3 text-center border-l border-gray-200 {{ $isSelected ? 'bg-green-50' : 'bg-white' }}"
                                                        wire:key="cell-{{ $classSubject->id }}-{{ $examDetailId }}">
                                                        @if($examDetail)
                                                            <div class="space-y-2">
                                                                <!-- Checkbox for selection -->
                                                                <div class="flex justify-center">
                                                                    @if($examDetailId && isset($classSubject->subject_id))
                                                                        <input type="checkbox"
                                                                            wire:click="toggleSubject({{ $examDetailId }}, {{ $classSubject->subject_id }})"
                                                                            {{ $isSelected ? 'checked' : '' }} {{ !$isEditing ? 'disabled' : '' }}
                                                                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                                    @else
                                                                        <div class="text-xs text-gray-300">No data</div>
                                                                    @endif
                                                                </div>

                                                                @if($isSelected && $isEditing)
                                                                    <!-- Editable fields when selected and in edit mode -->
                                                                    @if($key)
                                                                        <div class="space-y-1 text-xs">
                                                                            <input type="number" wire:model="selectedSubjects.{{ $key }}.full_marks"
                                                                                wire:key="full_marks_{{ $key }}"
                                                                                class="w-16 px-1 py-0.5 border border-gray-300 rounded text-center text-xs"
                                                                                placeholder="Full">
                                                                            <input type="number" wire:model="selectedSubjects.{{ $key }}.pass_marks"
                                                                                wire:key="pass_marks_{{ $key }}"
                                                                                class="w-16 px-1 py-0.5 border border-gray-300 rounded text-center text-xs"
                                                                                placeholder="Pass">
                                                                            <div class="flex items-center justify-center">
                                                                                <input type="checkbox" wire:model="selectedSubjects.{{ $key }}.is_optional"
                                                                                    wire:key="optional_{{ $key }}" class="h-3 w-3 text-blue-600 rounded">
                                                                                <span class="ml-1 text-gray-500">Opt</span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @elseif($isSelected)
                                                                    <!-- Display mode for selected subjects -->
                                                                    <div class="text-xs text-gray-600 space-y-0.5">
                                                                        <div>Full: {{ $subjectData['full_marks'] ?? 'N/A' }}</div>
                                                                        <div>Pass: {{ $subjectData['pass_marks'] ?? 'N/A' }}</div>
                                                                        @if($subjectData['is_optional'] ?? false)
                                                                            <div class="text-blue-600">Optional</div>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="text-xs text-gray-400">
                                                                        Not mapped
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="text-xs text-gray-300">
                                                                No exam detail
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="px-6 py-12 text-center">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">No subjects configured</h3>
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
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Legend:</h4>
                        <div class="flex flex-wrap gap-4 text-xs text-gray-600">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-100 rounded mr-2"></div>
                                <span>Selected Subject Mapping</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-white border rounded mr-2"></div>
                                <span>Unselected Subject</span>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" class="h-3 w-3 text-blue-600 rounded mr-2" checked disabled>
                                <span>Active Mapping</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-400 mr-2">Full/Pass</span>
                                <span>Marks Configuration</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No exam structure found</h3>
                        <p class="mt-1 text-sm text-gray-500">No exam details are configured for this class.</p>
                        <div class="mt-4">
                            <a href="#" class="text-blue-600 hover:text-blue-500 text-sm">
                                Configure exam structure first
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-12">
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Classes Found</h3>
                <p class="text-gray-500">Please configure classes in the system first.</p>
            </div>
        @endif
    </div>

    <!-- Debug Information -->
    @if(false) {{-- Keep this commented for production, uncomment for debugging --}}
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
            <h4 class="font-medium text-yellow-800 mb-2">Debug Information:</h4>
            <pre class="text-xs text-yellow-700">{{ json_encode([
            'activeTab' => $activeTab,
            'activeClass' => $classes[$activeTab]->name ?? 'None',
            'examStructure' => array_keys($examStructure),
            'selectedSubjectsCount' => count($selectedSubjects),
            'isEditing' => $isEditing
        ], JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
</div>