<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="bg-gray-800 text-white transition-all duration-300 flex-shrink-0 
                  {{ $sidebarOpen ? 'w-64' : 'w-20' }} 
                  flex flex-col">

        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            @if($sidebarOpen)
                <h1 class="text-xl font-bold">SubAdmin Panel</h1>
            @endif
            <button wire:click="toggleSidebar" class="p-2 rounded hover:bg-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="{{ $sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16' }}">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Menu Items -->
        <nav class="flex-1 mt-4 overflow-y-auto">
            @foreach($menuItems as $item)
                <button wire:click="switchComponent('{{ $item['component'] }}')"
                    class="w-full flex items-center px-4 py-3 transition-colors duration-200 
                           {{ $currentComponent === $item['component'] 
                                ? 'bg-gray-700 border-l-4 border-blue-500 text-white' 
                                : 'hover:bg-gray-700' }}">
                    <svg class="w-6 h-6 {{ $sidebarOpen ? 'mr-3' : 'mx-auto' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                    </svg>
                    @if($sidebarOpen)
                        <span class="font-medium">{{ $item['name'] }}</span>
                    @endif
                </button>
            @endforeach
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-700 mt-auto">
            <div class="flex items-center {{ $sidebarOpen ? '' : 'justify-center' }}">
                <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-sm font-semibold">
                    AD
                </div>
                @if($sidebarOpen)
                    <div class="ml-3">
                        <p class="text-sm font-medium">SubAdmin User</p>
                        <p class="text-xs text-gray-400">admin@example.com</p>
                    </div>
                @endif
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Header -->
        <header class="bg-white shadow-sm flex-shrink-0">
            <div class="flex items-center justify-between px-6 py-3">
                <h2 class="text-xl font-semibold text-gray-800">
                    @foreach($menuItems as $item)
                        @if($currentComponent === $item['component'])
                            {{ $item['name'] }}
                        @endif
                    @endforeach
                </h2>

                <button class="p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Scrollable content area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @if($currentComponent === 'dashboard')
                <div class="space-y-6">

                    <!-- First component -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-5 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">DC Profile</h3>
                        </div>
                        <div class="p-5">
                            @livewire('subadmin-dc-profile-comp')
                        </div>
                    </div>

                    <!-- Second component -->
                    @if(auth()->user()->teacher_id)
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-5 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">Marks Entry</h3>
                            </div>
                            <div class="p-5">
                                @livewire('subadmin10-marks-entry-comp', ['teacherId' => auth()->user()->teacher_id])
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-5 rounded">
                            <p class="text-yellow-700">No teacher ID found → Marks entry component not available.</p>
                        </div>
                    @endif

                </div>

            @elseif($currentComponent === 'users')
                <!-- ... -->

            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Component Not Found</h3>
                    <p class="text-gray-500">Selected view: <code class="bg-gray-100 px-2 py-1 rounded">{{ $currentComponent }}</code></p>
                </div>
            @endif
        </main>
    </div>
</div>