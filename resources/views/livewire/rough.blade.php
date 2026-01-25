{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(auth()->user()->name.' Dashboard') }}
        </h2>
    </x-slot>



    Hello Subject
    
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in! as {{ auth()->user()->name }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout> --}}








{{-- <div class="flex">
        <div class="bg-red-400 h-screen p-5 pt-8 {{ $sbOpen ? 'w-72' : 'w-20'}} relative">SideBar
            
            <svg class="h-8 w-8 text-red-500 bg-white rounded-full absolute -right-3 top-9 
                border-2 border-purple-600 cursor-pointer"  
                id="btn"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            
        </div>
        <div class="p-7">Home Page {{ $sbOpen }}</div>
    </div> --}}



    {{-- <script type="text/javascript">

        // let btn = document.getElementById("btn")
        // btn.addEventListener("click", toggleRental)


        // function toggleRental(){
        //     console.log("hello")
        //     // alert('Hello')
        // }


    $(document).ready(function(e)  {
        console.log('Hello JQery')
        $('#btn').on('click', function(e) {
            // var val = $("#thisr").attr('value');
            console.log('He is from btn click in jq: '+ {{$sbOpen}} +', '+ Math.random());
            {{ $sbOpen = 0 }}

        });
    });
    
    
    //   $(document).ready(function(){
    //     // alert('hh');
    //     toggleRental = function(){
    //         alert('Hello')
    //         console.log('Hello');
    //     }
    //   }
    </script> --}}