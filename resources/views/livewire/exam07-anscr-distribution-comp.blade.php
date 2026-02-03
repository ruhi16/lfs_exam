<div class="container mx-auto py-6">
    <div class="flex flex-col space-y-6">
        <!-- Tabs for Classes -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-2 overflow-x-auto" aria-label="Classes">
                @if(isset($classes) && $classes instanceof \Illuminate\Database\Eloquent\Collection)
                    @foreach($classes as $index => $class)
                        @if($class instanceof \App\Models\Myclass)
                            <button wire:click="setActiveTab({{ $index }})"
                                class="whitespace-nowrap py-2 px-4 text-sm font-medium rounded-t-lg transition-colors duration-200 {{ $activeTab == $index ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700' }}">
                                {{ $class->name }}
                            </button>
                        @endif
                    @endforeach
                @endif
            </nav>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Class Content -->
        @if(isset($classes[$activeTab]) && $classes[$activeTab] instanceof \App\Models\Myclass)
            @php
                $activeClass = $classes[$activeTab];
                $classSections = $this->getClassSections($activeClass->id);

                // Organize exam details: ExamName -> ExamType -> ExamPart
                // Using the $examDetails collection passed from render
                $organizedExamDetails = collect([]);
                foreach ($examDetails as $detail) {
                    $examNameId = $detail->exam_name_id;
                    $examTypeId = $detail->exam_type_id;
                    $examPartId = $detail->exam_part_id;

                    if (!$organizedExamDetails->has($examNameId)) {
                        $organizedExamDetails->put($examNameId, collect([]));
                    }
                    if (!$organizedExamDetails[$examNameId]->has($examTypeId)) {
                        $organizedExamDetails[$examNameId]->put($examTypeId, collect([]));
                    }
                    
                    // We just need to know this part exists for this type/name
                    if (!$organizedExamDetails[$examNameId][$examTypeId]->contains($detail)) {
                        $organizedExamDetails[$examNameId][$examTypeId]->push($detail);
                    }
                }
            @endphp

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Answer Script Distribution - {{ $activeClass->name }}
                    </h3>
                </div>

                <!-- Toggle Edit Button -->
                <div class="px-4 py-3 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <button wire:click="toggleEditEnable"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $isEditingEnabled ? 'Disable Editing' : 'Enable Editing' }}
                        @if($isEditingEnabled)
                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Editing Enabled</span>
                        @endif
                    </button>
                </div>

                @forelse($classSections as $section)
                    <div class="mb-8 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-800">
                                Section: {{ $section->section->name ?? 'N/A' }}
                                <span class="text-xs text-gray-500 ml-2">(ID: {{ $section->id }})</span>
                            </h4>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th rowspan="3"
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border border-gray-200 w-64">
                                            Subject
                                        </th>

                                        <!-- Exam Name Headers -->
                                        @foreach($organizedExamDetails as $examNameId => $examTypes)
                                            @php
                                                $examName = $examNames->firstWhere('id', $examNameId);
                                                $totalCols = 0;
                                                foreach ($examTypes as $examType) {
                                                    $totalCols += $examType->count(); // Each detail is a column
                                                }
                                            @endphp
                                            @if($examName && $totalCols > 0)
                                                <th colspan="{{ $totalCols }}"
                                                    class="px-4 py-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-blue-100 border border-gray-300">
                                                    {{ $examName->name }}
                                                </th>
                                            @endif
                                        @endforeach
                                    </tr>

                                    <!-- Exam Type Headers -->
                                    <tr>
                                        @foreach($organizedExamDetails as $examNameId => $examTypes)
                                            @foreach($examTypes as $examTypeId => $details)
                                                @php
                                                    $examType = $examTypes[$examTypeId]->first()->examType;
                                                    $colSpan = $details->count();
                                                @endphp
                                                <th colspan="{{ $colSpan }}"
                                                    class="px-3 py-1 text-center text-xs font-medium text-blue-800 uppercase tracking-wider bg-blue-50 border border-gray-200">
                                                    {{ $examType->name ?? 'N/A' }}
                                                </th>
                                            @endforeach
                                        @endforeach
                                    </tr>

                                    <!-- Exam Part Headers -->
                                    <tr>
                                        @foreach($organizedExamDetails as $examNameId => $examTypes)
                                            @foreach($examTypes as $examTypeId => $details)
                                                @foreach($details as $detail)
                                                     <th class="px-2 py-1 text-center text-xs font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200 min-w-[200px]">
                                                        <div class="flex flex-col">
                                                            <span>{{ $detail->examPart->name ?? 'Part N/A' }}</span>
                                                            <span class="text-[10px] text-gray-500">{{ $detail->examMode->name ?? 'Mode N/A' }}</span>
                                                        </div>
                                                    </th>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if($classSubjects && $classSubjects->count() > 0)
                                        @foreach($classSubjects as $classSubject)
                                            <tr class="hover:bg-gray-50">
                                                <!-- Subject Column -->
                                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200 border-b">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                            <span class="text-gray-600 text-xs font-medium">
                                                                {{ substr($classSubject->subject->name ?? '?', 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div class="ml-2">
                                                            <div class="font-medium text-gray-900 text-sm">
                                                                {{ $classSubject->subject->name ?? 'N/A' }}
                                                            </div>
                                                            <div class="text-gray-500 text-xs flex flex-col">
                                                                <span>Code: {{ $classSubject->subject->code ?? 'N/A' }}</span>
                                                                <span class="text-[10px] text-gray-400">
                                                                    {{ $classSubject->subject->subjectType->name ?? 'Type N/A' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Data Cells -->
                                                @foreach($organizedExamDetails as $examNameId => $examTypes)
                                                    @foreach($examTypes as $examTypeId => $details)
                                                        @foreach($details as $detail)
                                                            @php
                                                                // Find the ECS for this subject + detail combination
                                                                // We need to check if this subject is applicable for this exam detail
                                                                // We can look into examClassSubjects collection
                                                                
                                                                $ecs = $examClassSubjects->first(function($item) use ($classSubject, $detail) {
                                                                    return $item->subject_id == $classSubject->subject_id 
                                                                        && $item->exam_detail_id == $detail->id;
                                                                });

                                                                $isValidCell = !is_null($ecs);
                                                                
                                                                $cellKey = '';
                                                                $teacherId = '';
                                                                
                                                                if ($isValidCell) {
                                                                    $cellKey = $section->id . '_' . $ecs->id . '_' . $detail->id;
                                                                    
                                                                    // Check if we have form data, otherwise try to load from existing
                                                                    if (isset($formData[$cellKey])) {
                                                                        $teacherId = $formData[$cellKey]['teacher_id'];
                                                                    } else {
                                                                         // Fallback check in existing distributions if not in formData yet
                                                                         $existing = $existingDistributions->first(function ($dist) use ($section, $ecs) {
                                                                             return $dist->myclass_section_id == $section->id &&
                                                                                 $dist->exam_class_subject_id == $ecs->id;
                                                                         });
                                                                         $teacherId = $existing ? $existing->teacher_id : '';
                                                                    }
                                                                }
                                                            @endphp
                                                            
                                                            <td class="px-2 py-2 text-center border border-gray-200 align-middle {{ $isValidCell ? '' : 'bg-gray-100' }}">
                                                                @if($isValidCell)
                                                                    <div class="text-[10px] text-gray-400 mb-1 flex flex-col space-y-0.5">
                                                                        <span>ED: {{ $detail->id }}</span>
                                                                        <span>ECS: {{ $ecs->id }}</span>
                                                                        <span>T: {{ $teacherId ?: 'None' }}</span>
                                                                    </div>
                                                                    @if($isEditingEnabled)
                                                                        <div class="flex flex-col space-y-2">
                                                                            <select wire:model.defer="formData.{{ $cellKey }}.teacher_id"
                                                                                class="block w-full pl-3 pr-10 py-1 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md shadow-sm">
                                                                                <option value="">Select Teacher</option>
                                                                                @foreach($teachers as $teacher)
                                                                                    <option value="{{ $teacher->id }}">
                                                                                        {{ $teacher->user->name ?? $teacher->name ?? 'Unknown' }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            
                                                                            <button wire:click="saveDistribution({{ $section->id }}, {{ $detail->id }}, {{ $ecs->id }})"
                                                                                class="inline-flex justify-center items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="text-xs text-gray-700">
                                                                            @php
                                                                                $tName = 'Not Assigned';
                                                                                if($teacherId) {
                                                                                    $t = $teachers->firstWhere('id', $teacherId);
                                                                                    $tName = $t ? ($t->user->name ?? $t->name ?? 'Unknown') : 'Unknown ID: '.$teacherId;
                                                                                }
                                                                            @endphp
                                                                            {{ $tName }}
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <span class="text-gray-400 text-xs">-</span>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No subjects found for this class.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 text-center text-gray-500">
                        No sections found for this class.
                    </div>
                @endforelse
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 text-center text-gray-500">
                Please select a class to view distribution.
            </div>
        @endif
    </div>
</div>
