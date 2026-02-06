<div class="px-6 py-6">
    <div class="mb-6">
        <div class="text-2xl font-bold text-gray-900">Exam Settings</div>
        <div class="text-gray-500">Configure exam names, types, parts, and modes with a unified overview</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="text-sm text-gray-500">Exam Names</div>
            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Exam01Name::count() }}</div>
            <div class="mt-2 text-xs text-gray-400">Total configured</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="text-sm text-gray-500">Exam Types</div>
            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Exam02Type::count() }}</div>
            <div class="mt-2 text-xs text-gray-400">Total configured</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="text-sm text-gray-500">Exam Parts</div>
            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Exam03Part::count() }}</div>
            <div class="mt-2 text-xs text-gray-400">Total configured</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="text-sm text-gray-500">Exam Modes</div>
            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Exam04Mode::count() }}</div>
            <div class="mt-2 text-xs text-gray-400">Total configured</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <div class="text-lg font-semibold text-gray-900">Exam Names</div>
                <div class="text-sm text-gray-500">Create and manage named examinations</div>
            </div>
            <div class="p-5">
                @livewire('exam01-exam-name-comp')
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <div class="text-lg font-semibold text-gray-900">Exam Types</div>
                <div class="text-sm text-gray-500">Define summative/formative or other types</div>
            </div>
            <div class="p-5">
                @livewire('exam02-exam-type-comp')
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <div class="text-lg font-semibold text-gray-900">Exam Parts</div>
                <div class="text-sm text-gray-500">Break exams into parts or components</div>
            </div>
            <div class="p-5">
                @livewire('exam03-exam-part-comp')
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <div class="text-lg font-semibold text-gray-900">Exam Modes</div>
                <div class="text-sm text-gray-500">Specify written, oral, practical, etc.</div>
            </div>
            <div class="p-5">
                @livewire('exam04-exam-mode-comp')
            </div>
        </div>
    </div>
</div>
