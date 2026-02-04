<x-app-layout>
    <div class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </div>
    
    <div class="p-6">
        
        @livewire('admin-dashboard-container-comp')        
    </div>
</x-app-layout>