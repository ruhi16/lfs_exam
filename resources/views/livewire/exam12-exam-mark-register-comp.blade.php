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
            @if(isset($classes) && count($classes) > 0)
                @foreach($classes as $index => $class)
                    <button wire:click="setActiveTab({{ $index }})"
                        class="py-4 px-1 border-b-2 font-medium text-sm @if($activeTab === $index) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                        {{ $class->name ?? 'Class ' . ($index + 1) }}
                    </button>
                @endforeach
            @else
                <div class="py-4 text-gray-500">No classes available</div>
            @endif
        </div>
    </div>

    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(isset($classes[$activeTab]) && $classes[$activeTab])
            @php
                $activeClass = $classes[$activeTab];
                // Get sections for the active class
                $classSections = $sections->where('myclass_id', $activeClass->id ?? 0);
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
                                    
                                    // Get subjects for the active class ordered by subject_type_id descending
                                    $classSubjects = \App\Models\MyclassSubject::where('myclass_id', $activeClass->id ?? 0)
                                        ->with(['subject.subjectType'])
                                        ->get()
                                        ->sortByDesc(function($myclassSubject) {
                                            return $myclassSubject->subject->subject_type_id ?? 0;
                                        });
                                @endphp

                                @if($studentsInSection->count() > 0)
                                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Student Details
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Exam Name
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Exam Part
                                                </th>
                                                <!-- Dynamic Subject Columns -->
                                                @foreach($classSubjects as $myclassSubject)
                                                    @php
                                                        $subjectType = $myclassSubject->subject->subjectType->name ?? 'Unknown';
                                                        $isFormative = $subjectType === 'Formative';
                                                        $headerClass = $isFormative ? 'bg-yellow-50 border-yellow-200' : 'bg-blue-50 border-blue-200';
                                                        $textClass = $isFormative ? 'text-yellow-700' : 'text-blue-700';
                                                    @endphp
                                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l border-gray-300 {{ $headerClass }}">
                                                        <div class="space-y-1">
                                                            <div class="font-semibold {{ $textClass }}">{{ $myclassSubject->subject->name ?? 'Subject' }}</div>
                                                            <div class="text-xs {{ $isFormative ? 'text-yellow-600' : 'text-blue-600' }}">
                                                                Type: {{ $subjectType }}
                                                            </div>
                                                            {{-- <div class="text-xs text-gray-500 italic">
                                                                {{ $isFormative ? 'Formative Assessment' : 'Summative Assessment' }}
                                                            </div> --}}
                                                        </div>
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach($studentsInSection as $student)
                                                @php
                                                    // Calculate total rows for this student (sum of all exam parts across all exams)
                                                    $totalRowsForStudent = 0;
                                                    foreach($examDetailsGrouped as $examParts) {
                                                        $totalRowsForStudent += count($examParts);
                                                    }
                                                    $firstRow = true;
                                                @endphp
                                                
                                                @foreach($examDetailsGrouped as $examNameId => $examParts)
                                                    @php
                                                        $examName = \App\Models\Exam01Name::find($examNameId);
                                                        $examPartsCount = count($examParts);
                                                        $firstPartInExam = true;
                                                    @endphp
                                                    
                                                    @foreach($examParts as $examPartId => $details)
                                                        @php
                                                            $detail = $details[0];
                                                        @endphp
                                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                                            <!-- Student Details Column (only show for first row) -->
                                                            @if($firstRow)
                                                                <td rowspan="{{ $totalRowsForStudent }}" class="px-6 py-4 text-sm bg-gray-50 border-r border-gray-200 align-top">
                                                                    <div class="space-y-1">
                                                                        <div class="font-semibold text-gray-800">{{ $student->studentdb->name ?? 'N/A' }}</div>
                                                                        <div class="text-gray-600">Roll: {{ $student->roll_no ?? 'N/A' }}</div>
                                                                        <div class="text-gray-500 text-xs">ID: {{ $student->id }}</div>
                                                                    </div>
                                                                </td>
                                                                @php $firstRow = false; @endphp
                                                            @endif
                                                            
                                                            <!-- Exam Name Column (only show for first part of each exam) -->
                                                            @if($firstPartInExam)
                                                                <td rowspan="{{ $examPartsCount }}" class="px-6 py-4 text-sm font-medium text-blue-600 bg-blue-50 border-r border-gray-200 align-top">
                                                                    {{ $examName->name ?? 'Exam' }}
                                                                </td>
                                                                @php $firstPartInExam = false; @endphp
                                                            @endif
                                                            
                                                            <!-- Exam Part Column -->
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50 border-r border-gray-200">
                                                                {{ $detail->examPart->name ?? 'Part' }}
                                                            </td>
                                                            
                                                            <!-- Subject Columns -->
                                                            @foreach($classSubjects as $myclassSubject)
                                                                @php
                                                                    // Find the exam_class_subject for this detail and subject
                                                                    $examClassSubject = \App\Models\Exam06ClassSubject::where('exam_detail_id', $detail->id)
                                                                        ->where('subject_id', $myclassSubject->subject_id)
                                                                        ->first();
                                                                    
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
                                                                @php
                                                                    $subjectType = $myclassSubject->subject->subjectType->name ?? 'Unknown';
                                                                    $isFormative = $subjectType === 'Formative';
                                                                    $cellClass = $isFormative ? 'bg-yellow-50' : 'bg-blue-50';
                                                                @endphp
                                                                <td class="px-4 py-4 {{ $cellClass }} border-l border-gray-200">
                                                                    <div class="space-y-2">
                                                                        <!-- Subject Type Indicator -->
                                                                        <div class="text-center">
                                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $isFormative ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                                                                {{ $isFormative ? 'FORMATIVE' : 'SUMMATIVE' }}
                                                                            </span>
                                                                        </div>
                                                                        
                                                                        <!-- Exam Detail ID and Class Subject ID (show for all subjects) -->
                                                                        <div class="flex flex-wrap gap-1 text-xs justify-center">
                                                                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                                                                Detail: {{ $detail->id }}
                                                                            </span>
                                                                            @if($examClassSubject)
                                                                                <span class="{{ $isFormative ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }} px-2 py-1 rounded">
                                                                                    Subject: {{ $examClassSubject->id }}
                                                                                </span>
                                                                            @else
                                                                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded">
                                                                                    No Class Subject
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                        
                                                                        <!-- Marks Input/Display -->
                                                                        <div class="text-center">
                                                                            @if($examClassSubject)
                                                                                @if($isEditing)
                                                                                    <div class="space-y-1">
                                                                                        <input type="number" 
                                                                                               step="0.01" 
                                                                                               min="0"
                                                                                               max="{{ $examClassSubject->full_marks ?? 100 }}"
                                                                                               wire:model="marksData.{{$key}}.exam_marks"
                                                                                               class="w-16 text-center border border-blue-300 rounded px-1 py-1 text-sm focus:ring-2 focus:ring-blue-200"
                                                                                               placeholder="Marks"
                                                                                               {{ $marksEntry && $marksEntry['is_absent'] ? 'disabled' : '' }}>
                                                                                        <div class="text-xs text-gray-500">
                                                                                            /{{ $examClassSubject->full_marks ?? 100 }}
                                                                                        </div>
                                                                                        <label class="flex items-center justify-center text-xs text-gray-500">
                                                                                            <input type="checkbox" 
                                                                                                   wire:model="marksData.{{$key}}.is_absent"
                                                                                                   class="mr-1 h-3 w-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                                                            AB
                                                                                        </label>
                                                                                    </div>
                                                                                @else
                                                                                    <div>
                                                                                        <span class="text-lg font-semibold {{ $displayValue !== '-' ? 'text-gray-900' : 'text-gray-400' }}">
                                                                                            {{ $displayValue }}
                                                                                        </span>
                                                                                        @if($displayValue !== '-' && $displayValue !== 'AB')
                                                                                            <div class="text-xs text-gray-500">
                                                                                                /{{ $examClassSubject->full_marks ?? 100 }}
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <div class="text-center">
                                                                                    <div class="text-gray-400 text-sm italic mb-1">
                                                                                        Not Configured
                                                                                    </div>
                                                                                    <div class="text-xs text-gray-500">
                                                                                        {{ $isFormative ? 'Formative' : 'Summative' }} subject not linked to this exam
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endforeach
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
            'sectionCount' => isset($classes[$activeTab]) ? $sections->where('myclass_id', $classes[$activeTab]->id ?? 0)->count() : 0,
            'studentCount' => isset($classes[$activeTab]) ? $students->where('myclass_id', $classes[$activeTab]->id ?? 0)->count() : 0,
        ], JSON_PRETTY_PRINT) }}</pre>
    </div>
    @endif
</div>