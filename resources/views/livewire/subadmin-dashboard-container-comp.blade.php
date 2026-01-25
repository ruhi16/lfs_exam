<div>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white transition-all duration-300 {{ $sidebarOpen ? 'w-64' : 'w-20' }}">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                @if($sidebarOpen)
                    <h1 class="text-xl font-bold">SubAdmin Panel</h1>
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
            <nav class="mt-4">
                @foreach($menuItems as $item)
                    <button wire:click="switchComponent('{{ $item['component'] }}')"
                        class="w-full flex items-center px-4 py-3 transition-colors duration-200 
                               {{ $currentComponent === $item['component'] ? 'bg-gray-700 border-l-4 border-blue-500' : 'hover:bg-gray-700' }}">
                        <svg class="w-6 h-6 {{ $sidebarOpen ? 'mr-3' : 'mx-auto' }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}">
                            </path>
                        </svg>
                        @if($sidebarOpen)
                            <span class="font-medium">{{ $item['name'] }}</span>
                        @endif
                    </button>
                @endforeach
            </nav>

            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
                <div class="flex items-center {{ $sidebarOpen ? '' : 'justify-center' }}">
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">
                        <span class="text-sm font-semibold">AD</span>
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

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        @foreach($menuItems as $item)
                            @if($currentComponent === $item['component'])
                                {{ $item['name'] }}
                            @endif
                        @endforeach
                    </h2>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dynamic Content Area -->
            <div class="p-6">
                @if($currentComponent === 'dashboard')
                    {{-- @livewire('admin.dashboard-stats') --}}
                    @livewire('subadmin-dc-profile-comp')
                @elseif($currentComponent === 'users')
                    {{-- @livewire('admin.users-list') --}}
                @elseif($currentComponent === 'products')
                    {{-- @livewire('admin.products-list') --}}
                @elseif($currentComponent === 'orders')
                    {{-- @livewire('admin.orders-list') --}}
                @elseif($currentComponent === 'settings')
                    {{-- @livewire('admin.settings-panel') --}}
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
    </style>
</div>