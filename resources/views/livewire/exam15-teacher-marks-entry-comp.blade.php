<div class="container mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Teacher Marks Entry</h1>

        <!-- Teacher Selection -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Teacher</label>
            <select wire:model="selectedTeacherId"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Select Teacher --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">
                        {{ $teacher->user ? $teacher->user->name : ($teacher->name ?? 'N/A') }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Answer Scripts Table -->
        @if($selectedTeacherId && count($answerScripts) > 0)
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Assigned Answer Scripts</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Class-Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Part</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Mode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">
                                    Exam Detail ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">
                                    Class Section ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">
                                    Class Subject ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-50">
                                    Individual View</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($answerScripts as $script)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ ($script['myclass_section']['myclass']['name'] ?? 'N/A') . ' - ' . ($script['myclass_section']['section']['name'] ?? 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $script['exam_detail']['exam_type']['name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $script['exam_detail']['exam_name']['name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $script['exam_class_subject']['subject']['name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $script['exam_detail']['exam_part']['name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $script['exam_detail']['exam_mode']['name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-yellow-50 font-mono">
                                        {{ $script['exam_detail_id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-yellow-50 font-mono">
                                        {{ $script['myclass_section_id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-yellow-50 font-mono">
                                        {{ $script['exam_class_subject_id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <a href="{{ route('marksEntryOld', [
                                            'exam_detail_id' => $script['exam_detail']['id'] ?? '',
                                            'myclass_section_id' => $script['myclass_section_id'] ?? '',
                                            'myclass_subject_id' => $script['exam_class_subject_id'] ?? ''
                                        ]) }}"
                                            target="_blank"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs inline-block">
                                            Enter Marks
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-green-50">
                                        <a href="{{ route('marksEntryOld', [
                                            'exam_detail_id' => $script['exam_detail']['id'] ?? '',
                                            'myclass_section_id' => $script['myclass_section_id'] ?? '',
                                            'myclass_subject_id' => $script['exam_class_subject_id'] ?? '',
                                            'teacher_id' => $script['teacher']['id'] ?? ''
                                        ]) }}"
                                           target="_blank"
                                           class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs inline-block">
                                            Individual View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($selectedTeacherId)
            <div class="mt-8 text-center py-8 text-gray-500">
                No answer scripts assigned to this teacher.
            </div>
        @endif
        
        <!-- Individual View Component -->
        @if($showIndividualView)
            <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Individual Subject View</h3>
                    <button 
                        wire:click="closeIndividualView"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Close
                    </button>
                </div>
                <livewire:exam10-exam-marks-entry-indv2-comp 
                    :exam_class_subject_id="$individualExamClassSubjectId"
                    :exam_detail_id="$individualExamDetailId"
                    :myclass_section_id="$individualMyclassSectionId"
                    :myclass_subject_id="$individualMyclassSubjectId"
                    :key="'individual-' . $individualExamClassSubjectId"
                />
            </div>
        @endif
    </div>
</div>