<div class="p-6 bg-white border-b border-gray-200">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Subject-MyClass Matrix</h2>
        <div class="flex items-center">
            <span class="mr-3 text-sm font-medium text-gray-900">{{ $isEditMode ? 'Edit Mode ON' : 'Edit Mode OFF' }}</span>
            <label for="toggle-edit" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle-edit" class="sr-only peer" wire:click="toggleEditMode" {{ $isEditMode ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border-r">
                        Subject (Type)
                    </th>
                    @foreach($myclasses as $myclass)
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l">
                            {{ $myclass->name }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($subjects as $subject)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r">
                            {{ $subject->name }}
                            <span class="text-xs text-gray-500 block">
                                {{ $subject->subjectType ? $subject->subjectType->name : 'No Type' }}
                            </span>
                        </td>
                        @foreach($myclasses as $myclass)
                            @php
                                $isChecked = isset($matrix[$subject->id][$myclass->id]);
                            @endphp
                            <td class="px-6 py-4 whitespace-nowrap text-center border-l">
                                <input type="checkbox" 
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed h-5 w-5"
                                    {{ $isChecked ? 'checked' : '' }}
                                    {{ $isEditMode ? '' : 'disabled' }}
                                    wire:click="updateMapping({{ $subject->id }}, {{ $myclass->id }}, $event.target.checked)"
                                >
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
