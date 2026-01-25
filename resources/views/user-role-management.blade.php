@extends('layouts.app')

@section('title', 'User Role Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow">
        @livewire('user-role-comp')
    </div>
</div>
@endsection

@section('scripts')
@livewireScripts
<script>
    // Additional JavaScript for enhanced functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add any custom JavaScript here
        console.log('User Role Management loaded');
    });
</script>
@endsection