<div class="p-4 sm:p-6 space-y-6 max-w-7xl mx-auto">

    <!-- Header + Back -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Enter Marks</h1>
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-indigo-700 bg-white border border-indigo-200 hover:bg-indigo-50 rounded-lg shadow-sm transition">
            ← Back to Previous
        </a>
    </div>

    <!-- Detail Section – Restored & slightly refined (like your original) -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Exam & Class Details
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-sm">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Exam Name</p>
                    <p class="font-semibold text-gray-900">
                        {{ $distribution->examClassSubject->examDetail->examName->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Class / Section</p>
                    <p class="font-semibold text-gray-900">
                        {{ $distribution->myclassSection->myclass->name ?? 'N/A' }}
                        {{ $distribution->myclassSection->section->name ? ' - ' . $distribution->myclassSection->section->name : '' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Subject</p>
                    <p class="font-semibold text-gray-900">
                        {{ $distribution->examClassSubject->subject->name ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Message -->
    @if(session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Table with Progress -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <!-- Progress Section -->
        @php
            $total = $students->count();
            $entered = 0;
            foreach ($students as $student) {
                $data = $marks[$student->id] ?? [];
                if (($data['is_absent'] ?? false) || (!empty($data['exam_marks']) && $data['exam_marks'] !== null)) {
                    $entered++;
                }
            }
            $progress = $total > 0 ? round(($entered / $total) * 100, 1) : 0;
        @endphp

        <div class="px-6 py-4 bg-gray-50 border-b">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="flex justify-between text-sm text-gray-700 mb-2">
                        <span class="font-medium">Marks Entry Progress</span>
                        <span class="font-bold text-indigo-700">{{ $progress }}%</span>
                    </div>
                    <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 via-indigo-600 to-blue-600 transition-all duration-700 ease-out"
                             style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="mt-1.5 text-xs text-gray-600 flex justify-between">
                        <span>{{ $entered }} / {{ $total }} students marked</span>
                        <span class="{{ $progress == 100 ? 'text-green-700 font-medium' : 'text-amber-700' }}">
                            {{ $total - $entered }} remaining
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Name</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-32">Marks</th>
                        <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-24">Absent</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Remarks</th>
                        <th class="w-12"></th> <!-- status icon -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($students as $student)
                        @php
                            $row = $marks[$student->id] ?? [];
                            $absent = $row['is_absent'] ?? false;
                            $hasMark = !empty($row['exam_marks']) && $row['exam_marks'] !== null;
                            $complete = $absent || $hasMark;
                        @endphp

                        <tr class="{{ $absent ? 'bg-red-50/40' : '' }} {{ $complete ? 'bg-green-50/30' : '' }} hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $student->studentdb->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-gray-500 mt-1">ID: {{ $student->id }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <input type="number" step="0.01" min="0"
                                    wire:model.live.debounce.500ms="marks.{{ $student->id }}.exam_marks"
                                    class="block w-full rounded-lg border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:opacity-70"
                                    {{ $absent ? 'disabled' : '' }}>
                                @error("marks.{$student->id}.exam_marks")
                                    <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </td>
                            <td class="px-5 py-4 text-center">
                                <input type="checkbox"
                                    wire:model.live="marks.{{ $student->id }}.is_absent"
                                    class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            <td class="px-5 py-4">
                                <input type="text"
                                    wire:model.live.debounce.500ms="marks.{{ $student->id }}.remarks"
                                    class="block w-full rounded-lg border-gray-300 sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </td>
                            <td class="px-3 py-4 text-center">
                                @if($complete)
                                    <div class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-700" title="Completed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-3 h-3 rounded-full bg-amber-400 mx-auto" title="Pending"></div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500 italic">
                                No students available for this class/section.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-6 py-5 bg-gray-50 border-t flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="text-sm text-gray-700 order-2 sm:order-1">
                <span class="font-medium">{{ $students->count() }} students</span>
                <span class="mx-2">•</span>
                <span class="text-indigo-700 font-medium">{{ $progress }}% complete</span>
            </div>

            <button wire:click="save"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-60 transition-all order-1 sm:order-2">
                <svg wire:loading.remove class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                <span wire:loading.remove>Save Marks</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </div>

</div>