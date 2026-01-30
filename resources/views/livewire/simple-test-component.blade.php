<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Simple Test Component</h2>

    <div class="space-y-4">
        @foreach($simpleData as $key => $data)
            <div class="border rounded p-4" wire:key="subject-{{ $key }}">
                <h3 class="font-medium text-lg">{{ $data['subject'] }}</h3>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700">Marks:</label>
                    <input type="number" wire:model="simpleData.{{ $key }}.marks" wire:key="marks-{{ $key }}"
                        class="mt-1 block w-32 rounded border-gray-300 shadow-sm" min="0" max="100">
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Current marks: {{ $data['marks'] }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 bg-gray-50 p-4 rounded">
        <h3 class="font-medium mb-2">Debug Info:</h3>
        <pre class="text-xs">{{ json_encode($simpleData, JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>