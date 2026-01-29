<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Marks Register</h1>
        <p class="text-gray-600 mt-2">Organized by class tabs and section tables</p>
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
            <strong>Edit Mode Active:</strong> Enter marks for students. Use the checkboxes to mark students as absent.
        </div>
    @endif

    <!-- Class Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex space-x-8" aria-label="Tabs">
            @foreach($classes as $index => $class)
                <button wire:click="setActiveTab({{ $index }})"
                    class="py-4 px-1 border-b-2 font-medium text-sm @if($activeTab === $index) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                    {{ $class->name }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(isset($classes[$activeTab]))
            @php
                $activeClass = $classes[$activeTab];
                // Get sections for the active class
                $classSections = $sections->where('myclass_id', $activeClass->id);
            @endphp

            @if($classSections->count() > 0)
                <div class="p-6">
                    <!-- Sections Loop -->
                    @foreach($classSections as $section)
                        <div class="border border-gray-200 rounded-lg mb-6">
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Section: {{ $section->section->name ?? 'N/A' }}
                                </h3>
                                <div class="flex space-x-2">
                                    @if(!$isEditing)
                                        <button wire:click="updateMarks({{ $section->id }}, 0, 0)" 
                                                class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition-colors">
                                            Edit Marks
                                        </button>
                                    @else
                                        <button wire:click="saveMarks({{ $section->id }}, 0, 0)" 
                                                class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition-colors">
                                            Save All
                                        </button>
                                        <button wire:click="cancelEdit" 
                                                class="px-3 py-1 bg-gray-500 text-white text-sm rounded hover:bg-gray-600 transition-colors">
                                            Cancel
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                @php
                                    // Get students for this section
                                    $studentsInSection = $students->where('myclass_id', $section->myclass_id)
                                        ->where('section_id', $section->section_id);
                                @endphp

                                @if($studentsInSection->count() > 0)
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Roll No
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Student Name
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Student ID
                                                </th>
                                                
                                                <!-- Dynamic columns based on exam_name count -->
                                                @foreach($examDetailsGrouped as $examNameId => $examParts)
                                                    @php
                                                        $examName = \App\Models\Exam01Name::find($examNameId);
                                                        // Count total exam details for this exam name across all parts
                                                        $totalExamsForName = 0;
                                                        foreach($examParts as $examPartId => $details) {
                                                            $totalExamsForName += count($details);
                                                        }
                                                    @endphp
                                                    <th colspan="{{ $totalExamsForName }}"
                                                        class="px-6 py-3 text-center text-xs font-medium text-blue-500 uppercase tracking-wider border-l border-gray-200">
                                                        {{ $examName->name ?? 'Exam' }} ({{ $totalExamsForName }} exams)
                                                    </th>
                                                @endforeach
                                            </tr>
                                            
                                            <!-- Second header row for individual exam details -->
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                                
                                                @foreach($examDetailsGrouped as $examNameId => $examParts)
                                                    @foreach($examParts as $examPartId => $details)
                                                        @foreach($details as $detail)
                                                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
                                                                {{ $detail->examPart->name ?? 'Part' }}-{{ $detail->id }}
                                                            </th>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($studentsInSection as $student)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $student->roll_no ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $student->studentdb->name ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $student->id }}
                                                    </td>
                                                    
                                                    <!-- Exam detail cells -->
                                                    @foreach($examDetailsGrouped as $examNameId => $examParts)
                                                        @foreach($examParts as $examPartId => $details)
                                                            @foreach($details as $detail)
                                                                @php
                                                                    $key = "{$section->id}_{$detail->id}_{$student->id}";
                                                                    $marksEntry = $marksData[$key] ?? null;
                                                                    $displayValue = '-';
                                                                    
                                                                    if ($marksEntry) {
                                                                        if ($marksEntry['is_absent']) {
                                                                            $displayValue = 'AB';
                                                                        } elseif ($marksEntry['exam_marks'] !== null) {
                                                                            $displayValue = $marksEntry['exam_marks'];
                                                                        }
                                                                    }
                                                                @endphp
                                                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 text-center border-l border-gray-200 relative">
                                                                    @if($isEditing)
                                                                        <div class="flex flex-col items-center space-y-1">
                                                                            <input type="number" 
                                                                                   step="0.01" 
                                                                                   min="0"
                                                                                   wire:model="marksData.{{$key}}.exam_marks"
                                                                                   class="w-16 text-center border border-gray-300 rounded px-1 py-0.5 text-xs"
                                                                                   placeholder="Marks"
                                                                                   {{ $marksEntry && $marksEntry['is_absent'] ? 'disabled' : '' }}>
                                                                            <label class="flex items-center text-xs text-gray-500">
                                                                                <input type="checkbox" 
                                                                                       wire:model="marksData.{{$key}}.is_absent"
                                                                                       class="mr-1 h-3 w-3">
                                                                                AB
                                                                            </label>
                                                                        </div>
                                                                    @else
                                                                        <span class="{{ $displayValue !== '-' ? 'font-medium' : '' }}">{{ $displayValue }}</span>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center py-8">
                                        <p class="text-gray-500">No students found in this section.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Sections Found</h3>
                    <p class="text-gray-500">No sections are configured for this class.</p>
                </div>
            @endif
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
            'sectionCount' => $sections->where('myclass_id', $classes[$activeTab]->id ?? 0)->count(),
            'studentCount' => $students->where('myclass_id', $classes[$activeTab]->id ?? 0)->count(),
        ], JSON_PRETTY_PRINT) }}</pre>
    </div>
    @endif
</div>