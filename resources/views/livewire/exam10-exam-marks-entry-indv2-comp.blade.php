<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Individual Exam Marks Entry</h1>
        <p class="text-gray-600 mt-2">
            Entering marks for: 
            <strong>{{ $examDetail->examName->name ?? 'N/A' }}</strong> - 
            <strong>{{ $examDetail->examType->name ?? 'N/A' }}</strong> | 
            Class: <strong>{{ $myclassSection->myclass->name ?? 'N/A' }}</strong> | 
            Section: <strong>{{ $myclassSection->section->name ?? 'N/A' }}</strong>
        </p>
        @if($teacher)
            <p class="text-gray-600 mt-1">
                Assigned Teacher: <strong>{{ $teacher->user ? $teacher->user->name : ($teacher->name ?? 'N/A') }}</strong>
            </p>
        @endif
        <p class="text-gray-600 mt-1 bg-blue-50 p-2 rounded">
            Subject: <strong>{{ $examClassSubject->subject->name ?? 'N/A' }}</strong> 
            (Full Marks: {{ $examClassSubject->full_marks ?? 'N/A' }})
        </p>
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
    
    <!-- Action Buttons -->
    <div class="mb-6 flex justify-end space-x-2">
        <button 
            wire:click="$refresh"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
        >
            Refresh
        </button>
        <button 
            wire:click="toggleEditEnable"
            class="px-4 py-2 text-sm font-medium text-white bg-{{ $isEditingEnabled ? 'red' : 'indigo' }}-600 border border-{{ $isEditingEnabled ? 'red' : 'indigo' }}-600 rounded-md hover:bg-{{ $isEditingEnabled ? 'red' : 'indigo' }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $isEditingEnabled ? 'red' : 'indigo' }}-500 transition-colors duration-200"
        >
            {{ $isEditingEnabled ? 'Disable' : 'Enable' }} Edit
        </button>
    </div>
    
    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($students->count() > 0)
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    Student
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                    Exam Part
                                </th>
                                
                                <!-- Single Subject Header -->
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                    {{ $examClassSubject->subject->name ?? 'N/A' }}<br>
                                    <span class="text-[10px] text-gray-600">{{ $examDetail->examName->name ?? 'N/A' }} - {{ $examDetail->examType->name ?? 'N/A' }}</span>
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $student)
                                @foreach($examParts as $examPart)
                                    <tr class="hover:bg-gray-50">
                                        @if($loop->first)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200 @if($examParts->count() > 1) @else border-b @endif" rowspan="{{ $examParts->count() }}">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-blue-800 font-medium">{{ $student->roll_no ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ $student->studentdb->name ?? 'N/A' }}</div>
                                                        <div class="text-gray-500 text-xs">Roll: {{ $student->roll_no ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ is_object($examPart) ? ($examPart->name ?? 'N/A') : ($examPart['name'] ?? 'N/A') }}
                                        </td>
                                        
                                        <!-- Single Subject Cell -->
                                        @php
                                            $cellKey = $myclassSectionId . '_' . $student->id . '_' . $examClassSubjectId . '_' . (is_object($examPart) ? $examPart->exam_detail_id : $examPart['exam_detail_id']);
                                        @endphp
                                        <td class="px-6 py-4 border border-gray-200 bg-white">
                                            <div class="flex items-center space-x-2">
                                                <input
                                                    type="number"
                                                    wire:model="formData.{{ $cellKey }}.marks"
                                                    class="flex-1 px-2 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 {{ !$isEditingEnabled ? 'bg-gray-100 cursor-not-allowed' : '' }} {{ data_get($formData, "{$cellKey}.is_absent") ? 'bg-gray-100 cursor-not-allowed opacity-50' : '' }}"
                                                    placeholder="Enter marks"
                                                    min="0"
                                                    max="{{ $examClassSubject->full_marks ?? 100 }}"
                                                    {{ !$isEditingEnabled || data_get($formData, "{$cellKey}.is_absent") ? 'disabled' : '' }}
                                                />
                                                <div class="flex items-center">
                                                    <input
                                                        type="checkbox"
                                                        wire:click="clearMarks('{{ $cellKey }}')"
                                                        wire:model="formData.{{ $cellKey }}.is_absent"
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded {{ !$isEditingEnabled ? 'cursor-not-allowed' : '' }}"
                                                        {{ !$isEditingEnabled ? 'disabled' : '' }}
                                                    />
                                                    <span class="ml-1 text-xs text-gray-500">Absent</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button 
                        wire:click="saveAllEntries"
                        class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-emerald-600 rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 {{ !$isEditingEnabled ? 'opacity-50 cursor-not-allowed' : '' }} transition-colors duration-200"
                        {{ !$isEditingEnabled ? 'disabled' : '' }}
                    >
                        Save All Entries
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Students Found</h3>
                <p class="text-gray-500">No students are available for this class and section.</p>
            </div>
        @endif
    </div>
    
    <!-- Footer Info -->
    <div class="mt-6 text-sm text-gray-500">
        Showing exam marks entries for {{ $students->count() ?? 0 }} students in subject: {{ $examClassSubject->subject->name ?? 'N/A' }}
    </div>
</div>