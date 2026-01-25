@if($subject && $subject->subject) {{-- Add null check --}}
<tr class="hover:bg-gray-50">
    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
        {{ $subject->subject->name }}
    </td>

    @foreach($examDetails as $examDetail)
    @php
    $key = $examDetail->id . '_' . $subject->subject_id;
    $isSelected = $this->isSubjectSelected($examDetail->id, $subject->subject_id);
    $isEnabled = $this->isSubjectTypeEnabledForExam($examDetail);
    $savedData = $this->getSavedDataForKey($key);
    @endphp
    <td class="border border-gray-300 px-2 py-2 text-center 
                   {{ !$isEnabled ? 'bg-gray-100' : '' }} 
                   {{ $isFinalized ? 'bg-gray-50' : '' }}">
        @if($isEnabled)
        <div class="space-y-2">
            {{-- Checkbox --}}
            @if(!$isFinalized)
            <div>
                <input type="checkbox" wire:click="toggleSubject({{ $examDetail->id }}, {{ $subject->subject_id }})" {{
                    $isSelected ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            </div>
            @else
            <div>
                <input type="checkbox" {{ $isSelected ? 'checked' : '' }} disabled
                    class="h-4 w-4 text-gray-400 border-gray-300 rounded cursor-not-allowed">
            </div>
            @endif

            {{-- Marks Input Component --}}
            @if($isSelected)
            @livewire('exam-setting.marks-input', [
            'examDetailId' => $examDetail->id,
            'subjectId' => $subject->subject_id,
            'classId' => $classId,
            'isEnabled' => true,
            'isFinalized' => $isFinalized,
            'savedData' => $savedData
            ], key($key))
            @endif
        </div>
        @else
        <div class="text-xs text-gray-400 py-2">
            <span class="inline-block px-2 py-1 bg-gray-200 rounded text-gray-600">Not Available</span>
        </div>
        @endif
    </td>
    @endforeach
</tr>
@endif