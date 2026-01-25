<div>
    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto">
            <button wire:click="switchTab('school')"
                class="{{ $activeTab === 'school' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Schools
            </button>
            <button wire:click="switchTab('session')"
                class="{{ $activeTab === 'session' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Sessions
            </button>
            <button wire:click="switchTab('class')"
                class="{{ $activeTab === 'class' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Classes
            </button>
            <button wire:click="switchTab('section')"
                class="{{ $activeTab === 'section' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Sections
            </button>
            <button wire:click="switchTab('subject')"
                class="{{ $activeTab === 'subject' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Subjects
            </button>
            <button wire:click="switchTab('room')"
                class="{{ $activeTab === 'room' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Rooms
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="mt-6">
        @if($activeTab === 'school')
            @livewire('basic01-school-comp')
        @elseif($activeTab === 'session')
            @livewire('basic02-session-comp')
        @elseif($activeTab === 'class')
            @livewire('basic03-class-comp')
        @elseif($activeTab === 'section')
            @livewire('basic04-section-comp')
        @elseif($activeTab === 'subject')
            @livewire('basic06-subject-comp')
        @elseif($activeTab === 'room')
            @livewire('basic05-room-comp')
        @endif
    </div>
</div>