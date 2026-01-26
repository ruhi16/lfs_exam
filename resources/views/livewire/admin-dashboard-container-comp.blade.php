<div>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside
            class="bg-gray-800 text-white transition-all duration-300 {{ $sidebarOpen ? 'w-64' : 'w-20' }} flex flex-col">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                @if($sidebarOpen)
                    <h1 class="text-xl font-bold">Admin Panel</h1>
                @endif
                <button wire:click="toggleSidebar" class="p-2 rounded hover:bg-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $sidebarOpen ? 'M11 19l-7-7 7-7m8 14l-7-7 7-7' : 'M13 5l7 7-7 7M5 5l7 7-7 7' }}">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Menu Items -->
            <nav class="mt-4 flex-1 overflow-y-auto">
                @foreach($menuItems as $index => $item)
                    <div class="mb-1">
                        <!-- Main Menu Item -->
                        @if(count($item['submenu']) > 0)
                            <!-- Menu with Submenu -->
                            <button wire:click="toggleMenu({{ $index }})" class="w-full flex items-center justify-between px-4 py-3 transition-colors duration-200 hover:bg-gray-700
                                           {{ in_array($index, $expandedMenus) ? 'bg-gray-700' : '' }}">
                                <div class="flex items-center {{ $sidebarOpen ? '' : 'justify-center w-full' }}">
                                    <svg class="w-6 h-6 {{ $sidebarOpen ? 'mr-3' : '' }}" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $item['icon'] }}"></path>
                                    </svg>
                                    @if($sidebarOpen)
                                        <span class="font-medium">{{ $item['name'] }}</span>
                                    @endif
                                </div>
                                @if($sidebarOpen)
                                    <svg class="w-4 h-4 transition-transform duration-200 {{ in_array($index, $expandedMenus) ? 'rotate-180' : '' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                        </path>
                                    </svg>
                                @endif
                            </button>

                            <!-- Submenu Items -->
                            @if($sidebarOpen && in_array($index, $expandedMenus))
                                <div class="bg-gray-900">
                                    @foreach($item['submenu'] as $subitem)
                                        <button wire:click="switchComponent('{{ $subitem['component'] }}')"
                                            class="w-full flex items-center px-4 py-2 pl-14 text-sm transition-colors duration-200 
                                                               {{ $currentComponent === $subitem['component'] ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                                            <span class="mr-2">•</span>
                                            <span>{{ $subitem['name'] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <!-- Menu without Submenu -->
                            <button wire:click="switchComponent('{{ $item['component'] }}')"
                                class="w-full flex items-center px-4 py-3 transition-colors duration-200 
                                           {{ $currentComponent === $item['component'] ? 'bg-gray-700 border-l-4 border-blue-500' : 'hover:bg-gray-700' }}">
                                <svg class="w-6 h-6 {{ $sidebarOpen ? 'mr-3' : 'mx-auto' }}" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $item['icon'] }}"></path>
                                </svg>
                                @if($sidebarOpen)
                                    <span class="font-medium">{{ $item['name'] }}</span>
                                @endif
                            </button>
                        @endif
                    </div>
                @endforeach
            </nav>

            <!-- Sidebar Footer -->
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center {{ $sidebarOpen ? '' : 'justify-center' }}">
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-semibold">AD</span>
                    </div>
                    @if($sidebarOpen)
                        <div class="ml-3 overflow-hidden">
                            <p class="text-sm font-medium truncate">Admin User</p>
                            <p class="text-xs text-gray-400 truncate">admin@example.com</p>
                        </div>
                    @endif
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto flex flex-col">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        @php
                            $pageTitle = 'Dashboard';
                            foreach ($menuItems as $item) {
                                if ($currentComponent === $item['component']) {
                                    $pageTitle = $item['name'];
                                    break;
                                }
                                if (count($item['submenu']) > 0) {
                                    foreach ($item['submenu'] as $subitem) {
                                        if ($currentComponent === $subitem['component']) {
                                            $pageTitle = $item['name'] . ' / ' . $subitem['name'];
                                            break 2;
                                        }
                                    }
                                }
                            }
                            echo $pageTitle;
                        @endphp
                    </h2>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 focus:outline-none relative">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dynamic Content Area -->
            <div class="p-6 flex-1">
                @if($currentComponent === 'dashboard')
                    {{-- @livewire('admin.dashboard-stats') --}}

                {{-- Users Section --}}
                @elseif($currentComponent === 'users.all')
                    @livewire('supadmin-d-c-users-comp')
                



                {{-- Basic Section --}}
                @elseif($currentComponent === 'basic.wall')
                    @livewire('admin-dc-basic-wall-comp')

                    
                @elseif($currentComponent === 'basic.school')
                    @livewire('basic01-school-comp')


                @elseif($currentComponent === 'basic.session')
                    @livewire('basic02-session-comp')



                @elseif($currentComponent === 'basic.class')
                    @livewire('basic03-class-comp')


                @elseif($currentComponent === 'basic.section')
                    @livewire('basic04-section-comp')


                @elseif($currentComponent === 'basic.subject')
                    @livewire('basic06-subject-comp')

                @elseif($currentComponent === 'basic.teacher')
                    @livewire('basic07-teacher-comp')


                @elseif($currentComponent === 'basic.class_section')
                    @livewire('basic10-class-section-comp')

                @elseif($currentComponent === 'basic.class_subject')
                    @livewire('basic11-class-subject-comp')



                
                
                {{-- Exam Details Section --}}
                @elseif($currentComponent === 'exam.detail')
                    @livewire('exam05-exam-detail-comp')

                @elseif($currentComponent === 'exam.fmpm')
                    @livewire('exam06-exam-fmpm-comp')


                @elseif($currentComponent === 'exam.exam_name')
                    @livewire('exam01-exam-name-comp')



                @elseif($currentComponent === 'exam.exam_type')
                    @livewire('exam02-exam-type-comp')


                @elseif($currentComponent === 'exam.exam_part')
                    @livewire('exam03-exam-part-comp')

                
                @elseif($currentComponent === 'exam.exam_mode')
                    @livewire('exam04-exam-mode-comp')





                @elseif($currentComponent === 'marks_entry.wall')
                    @livewire('marks-entry-wall-comp')                


                @elseif($currentComponent === 'marks_entry.anscr_distribution')
                    @livewire('exam07-anscr-distribution-comp')


                @elseif($currentComponent === 'marks_entry.marks_entry')
                    @livewire('exam10-exam-marks-entry-comp')

                @elseif($currentComponent === 'marks_entry.mark_register')
                    @livewire('exam12-exam-mark-register-comp')




                @else
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-2">Component Not Found</h3>
                        <p class="text-gray-600">The requested component "{{ $currentComponent }}" is not available.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <style>
        /* Ensure the component takes full height */
        [wire\:id] {
            height: 100vh;
        }

        /* Custom scrollbar for sidebar */
        aside nav::-webkit-scrollbar {
            width: 6px;
        }

        aside nav::-webkit-scrollbar-track {
            background: #1f2937;
        }

        aside nav::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 3px;
        }

        aside nav::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</div>