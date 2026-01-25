<div>
    <style>
        .submenu-container {
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .submenu-container.closed {
            max-height: 0;
            opacity: 0;
        }

        .submenu-container.open {
            max-height: 1000px;
            opacity: 1;
        }
    </style>

    <div class="flex h-[calc(100vh_-_72px)] bg-gray-100 overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L3 7v11a1 1 0 001 1h3v-6a1 1 0 011-1h4a1 1 0 011 1v6h3a1 1 0 001-1V7l-7-5z" />
                    </svg>
                    <span class="text-xl font-semibold">AdminPanel</span>
                </div>
            </div>
            <!-- Left Side Navigation Bar -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                @foreach ($menuItems as $key => $item)
                    <div>
                        {{-- {{ $key }}-{{ isset($item['subitems']) ? 'yes' : 'no' }} --}}
                        @if (isset($item['subitems']))
                            <!-- Menu item with submenu -->
                            <button wire:click="toggleSubmenu('{{ $key }}')"
                                class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-colors menu-item-hover
                                                                                                                                                                                                                                                                                                                                                {{ in_array($key, $openSubmenus) ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:text-blue-600' }}">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $item['icon'] }}" />
                                    </svg>
                                    {{ $item['label'] }}
                                </div>
                                <svg class="w-4 h-4 transition-transform {{ in_array($key, $openSubmenus) ? 'rotate-180' : '' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Submenu -->
                            <div class="submenu-container {{ in_array($key, $openSubmenus) ? 'open' : 'closed' }}">
                                <div class="ml-6 mt-2 space-y-1">
                                    @foreach ($item['subitems'] as $subKey => $subItem)
                                        <button wire:click="setActiveMenu('{{ $key }}', '{{ $subKey }}')"
                                            class="w-full flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                                                                                                                                                                                                                                                                                                                                                                                                                    {{ $activeMenu === $subKey ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $subItem['icon'] }}" />
                                            </svg>
                                            {{ $subItem['label'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Single menu item -->
                            <button wire:click="setActiveMenu('{{ $key }}')"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors menu-item-hover
                                                                                                                                                                                                                                                                                                                                                {{ $activeMenu === $key ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['label'] }}
                            </button>
                        @endif
                    </div>
                @endforeach
            </nav>

            <!-- User Profile -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">JD</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Little Flower School</p>
                        <p class="text-xs text-gray-500 truncate">admin@example.com</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 capitalize">
                            {{ str_replace('-', ' ', $activeMenu) }}
                            <small class="text-xs text-gray-400">({{ $activeMenu }})</small>
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            @php
                                $description = '';
                                foreach ($menuItems as $menu) {
                                    if (isset($menu['subitems'])) {
                                        foreach ($menu['subitems'] as $subKey => $subItem) {
                                            if ($subKey === $activeMenu) {
                                                $description = $subItem['description'];
                                                break;
                                            }
                                        }
                                    } elseif ($menu['label'] === $activeMenu) {
                                        $description = $menu['description'];
                                        break;
                                    }
                                }
                                echo $description;
                            @endphp
                            {{-- {{ $description }} --}}
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM12 8v8m-6-4h12" />
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>

                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-8xl mx-auto">
                    <!-- Dashboard -->
                    @if($activeMenu === 'dashboard')
                        @livewire('dashboard-comp')
                    @endif

                    <!-- Student Database -->
                    @if($activeMenu === 'student-database')
                        @livewire('student-db-component')
                    @endif

                    <!-- Sessions -->
                    @if($activeMenu === 'sessions')
                        @livewire('session-comp')
                    @endif

                    <!-- Schools -->
                    @if($activeMenu === 'schools')
                        @livewire('school-comp')
                    @endif

                    <!-- Teachers -->
                    @if($activeMenu === 'teachers')
                        @livewire('teacher-comp')
                    @endif

                    <!-- Classes -->
                    @if($activeMenu === 'classes')
                        @livewire('myclass-comp')
                    @endif

                    <!-- Sections -->
                    @if($activeMenu === 'sections')
                        @livewire('section-comp')
                    @endif

                    <!-- Class Sections -->
                    @if($activeMenu === 'class-sections')
                        @livewire('myclass-section-comp')
                    @endif

                    <!-- My Class (Legacy) -->
                    @if($activeMenu === 'MyClass')
                        @livewire('myclass-comp')
                    @endif

                    <!-- Subject Types -->
                    @if($activeMenu === 'subject-types')
                        @livewire('subject-type-comp')
                    @endif

                    <!-- Subjects -->
                    @if($activeMenu === 'subjects')
                        @livewire('subject-comp')
                    @endif

                    <!-- Subject Teacher -->
                    @if($activeMenu === 'subject-teachers')
                        @livewire('subject-teacher-comp')
                    @endif

                    <!-- Class Subjects -->
                    @if($activeMenu === 'myclass-subjects')
                        @livewire('myclass-subject-comp')
                    @endif

                    <!-- Exam Settings -->
                    @if($activeMenu === 'exam-settings')
                        @livewire('exam-settings')
                    @endif

                    <!-- Exam Settings View -->
                    {{-- @if($activeMenu === 'exam-settings-view')
                        @livewire('exam-settings-view')
                    @endif --}}

                    <!-- Exam Settings FMPM -->
                    {{-- @if($activeMenu === 'exam-settings-fmpm')
                        @livewire('exam-settings-fmpm-comp')
                    @endif --}}

                     <!-- Exam Settings FMPM -->
                    @if($activeMenu === 'exam-settings-fmpm2')
                        @livewire('exam-setting-with-fmpm')
                    @endif

                    <!-- Exam Names -->
                    @if($activeMenu === 'exam-names')
                        @livewire('exam-name-comp')
                    @endif

                    <!-- Exam Types -->
                    @if($activeMenu === 'exam-types')
                        @livewire('exam-type-comp')
                    @endif

                    <!-- Exam Parts -->
                    @if($activeMenu === 'exam-parts')
                        @livewire('exam-part-comp')
                    @endif

                    <!-- Exam Modes -->
                    @if($activeMenu === 'exam-modes')
                        @livewire('exam-mode-comp')
                    @endif

                    <!-- Exam Cinfiguration -->
                    {{-- @if($activeMenu === 'exam-config')
                        @livewire('exam-config-comp')
                    @endif --}}

                    <!-- Student Class Records -->
                    @if($activeMenu === 'student-cr')
                        @livewire('student-cr-comp')
                    @endif

                    <!-- Answer Script Distribution -->
                    {{-- @if($activeMenu === 'answer-script-distribution')
                        @livewire('answer-script-distribution-comp')
                    @endif --}}

                    <!-- Answer Script Distribution -->
                    @if($activeMenu === 'answer-script-distribution2')
                        @livewire('answer-script-distribution-comp2')
                    @endif

                    <!-- Marks Entry -->
                    @if($activeMenu === 'class-section-tasks')
                        @livewire('class-section-tasks-comp')
                    @endif
                    
                    <!-- Marks Entry -->
                    @if($activeMenu === 'marks-entry')
                        @livewire('marks-entry-comp')
                    @endif

                    <!-- Marks Entry -->
                    @if($activeMenu === 'teacher-entry')
                        @livewire('teacher-marks-entry-comp')
                    @endif

                    <!-- System Logs -->
                    @if($activeMenu === 'logs-viewer')
                        @livewire('logs-viewer-comp')
                    @endif

                    <!-- Class Exam Subjects -->
                    @if($activeMenu === 'class-exam-subject')
                        @livewire('class-exam-subject-comp')
                    @endif

                    <!-- Mark Register -->
                    @if($activeMenu === 'mark-register')
                        @livewire('mark-register-comp')
                    @endif

                    <!-- User Role Components -->
                    @if($activeMenu === 'user-roles')
                        @livewire('user-role-comp')
                    @endif

                    <!-- Analytics -->
                    @if($activeMenu === 'analytics')
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics</h3>
                                <p class="text-gray-500 mb-6">View application analytics and reports.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Default/Other Pages -->
                    @if(!in_array($activeMenu, ['dashboard', 'schools', 'classes', 'sections', 'class-sections', 'subject-types', 'subjects', 'MyClass', 'myclass-subjects', 'student-database', 'sessions', 'teachers', 'subject-teachers', 'exam-settings', 'exam-settings-view', 'exam-settings-fmpm', 'exam-names', 'exam-types', 'exam-parts', 'exam-modes', 'student-cr', 'answer-script-distribution', 'marks-entry', 'logs-viewer', 'class-exam-subject', 'mark-register', 'user-roles', 'analytics', 'exam-config', 'exam-settings-fmpm2', 'class-section-tasks']))
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 capitalize">
                                    {{ str_replace('-', ' ', $activeMenu) }} Page
                                </h3>
                                <p class="text-gray-500 mb-6">
                                    This is the '{{ str_replace('-', ' ', $activeMenu) }}' section. Content for this page
                                    would
                                    be implemented here.
                                </p>
                                <button
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Get Started
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>

    </div>

</div>