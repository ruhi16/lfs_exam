<x-app-layout>
    
    <div class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Subadmin Dashboard') }}
    </div>

    @livewire('subadmin-dashboard-container-comp')

    {{-- <livewire:footer-component /> --}}
</x-app-layout>
