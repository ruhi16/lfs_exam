<div class="h-screen min-w-full mx-auto gap-2">
    @section('header')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Home: ' . __(auth()->user()->name . ': ' . __(auth()->user()->teacher->name)) }}
        </h2> 
    @endsection
    
    <h1>Change Password Component</h1>

   

<div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    
    
    
    {{-- <svg class="w-7 h-7 text-gray-500 dark:text-gray-400 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M18 5h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C8.4.842 6.949 0 5.5 0A3.5 3.5 0 0 0 2 3.5c.003.52.123 1.033.351 1.5H2a2 2 0 0 0-2 2v3a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V7a2 2 0 0 0-2-2ZM8.058 5H5.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM11 13H9v7h2v-7Zm-4 0H2v5a2 2 0 0 0 2 2h3v-7Zm6 0v7h3a2 2 0 0 0 2-2v-5h-5Z"/>
    </svg>
    <a href="#">
        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Need a help in Claim?</h5>
    </a>
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
    <a href="#" class="inline-flex font-medium items-center text-blue-600 hover:underline">
        See our guideline
        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
        </svg>
    </a> --}}
</div>


  {{-- Modal for Class-Section: Teacher Selection --}}
  <div class=" {{ $showModal ? '' : 'hidden' }}">
    <div wire:ignore.self class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto" id="modal"
        aria-labelledby="modal-title" aria-modal="true" role="dialog" aria-hidden="true">
        <div class="relative w-full max-w-2xl max-h-full px-4 py-6 bg-white rounded-lg shadow-lg">
            <div class="flex flex-row justify-between items-center mb-4">
                <h3 class="text-lg font-bold">
                    For Class Section Teacher Selection
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" wire:click="closeModal">
                    <svg width="25" height="25" viewbox="0 0 40 40">
                        <path d="M 10,10 L 30,30 M 30,10 L 10,30" stroke="black" stroke-width="4" />
                    </svg>
                </button>
            </div>
            <div>
                <form class="max-w-sm mx-auto" wire:submit.prevent="saveChanges">
                    <div class="grid grid-cols-4 gap-6">
                        <div class="col-span-2 mb-6">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email"
                                {{-- value="{{ $myclassSections->where('id', $myclassSection_id)->first()->myclass->name ?? 'NA' }}" --}}
                                {{-- wire:model="selectedClass" --}}
                                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        

                        </div>
                        <div class="col-span-2 mb-6">

                        </div>
                    </div>
                </form>
            </div>







   
                   
        </div>
    </div>
</div>




</div>