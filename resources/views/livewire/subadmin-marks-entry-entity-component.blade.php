<div>

    {{-- <x-app-layout> --}}
        {{-- <x-slot:header> --}}
            @section('header')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ 'Marks Entry: ' . __(auth()->user()->name . ': ' . __(auth()->user()->teacher->name)) }}
            </h2>
            {{-- <h2>Admin Marks Entry Entity Component</h2> --}}
            @endsection
            {{-- </x-slot> --}}

            {{-- <livewire:users-profile-detais-component> --}}

                <div class="min-w-full mx-auto bg-green-300 text-center text-4xl font-bold my-4">
                    Marks Entry Entity for Teachers (Sub-Admin)
                    <span class="text-red-500">Class: {{ $myclassSection->myclass->name }}</span> &
                    <span class="text-red-500">Section: {{ $myclassSection->section->name }}</span>

                </div>

                @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
                @endif



                <table class="min-w-auto mx-auto my-6 border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py2 font-bold">Class/Sec</th>
                            <td class="border border-gray-300 px-4 py2">{{ $myclassSection->myclass->name}}/{{
                                $myclassSection->section->name}}</td>
                            <th class="border border-gray-300 px-4 py2"></th>
                            <th class="border border-gray-300 px-4 py2 font-bold">Subject</th>
                            <td class="border border-gray-300 px-4 py2">{{ $myclassSubject->subject->name}}</td>
                            <th class="border border-gray-300 px-4 py2"></th>
                            <th class="border border-gray-300 px-4 py2 font-bold">Pass Marks</th>
                            <td class="border border-gray-300 px-4 py2">{{ $examdetail->pass_mark ?? 'X' }}</td>
                            <th class="border border-gray-300 px-4 py2"></th>
                            <th class="border border-gray-300 px-4 py2 font-bold">Full Mark</th>
                            <td class="border border-gray-300 px-4 py2">{{ $examdetail->full_mark ?? 'X' }}</td>

                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-4 py2 font-bold">Exam</th>
                            <td class="border border-gray-300 px-4 py2">{{ $examdetail->exam->name ?? 'X'}}</td>
                            <th class="border border-gray-300 px-4 py2"></th>
                            <th class="border border-gray-300 px-4 py2 font-bold">Exam Type</th>
                            <td class="border border-gray-300 px-4 py2">{{ $examdetail->examtype->name ?? 'X'}}</td>
                            <th class="border border-gray-300 px-4 py2"></th>
                            <th class="border border-gray-300 px-4 py2 font-bold">Exam Mode</th>
                            <td class="border border-gray-300 px-4 py2">{{ $examdetail->exammode->name ?? 'X'}}</td>
                            <th class="border border-gray-300 px-4 py2"></th>
                            <th class="border border-gray-300 px-4 py2 font-bold">Teacher</th>
                            <td class="border border-gray-300 px-4 py2">
                                <span class="text-red-500 font-extrabold"> {{
                                    $ansscriptdistribution->first()->teacher->name ?? 'NA' }}</span>
                            </td>


                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                {{-- <div
                    class="min-w-auto mx-auto my-6 border-collapse border border-gray-300 font-bold text-center text-2xl">
                    Marks: {{ json_encode($marks) }}: {{ json_encode($cbmarks) }}
                    value=>{{$v}} key=>{{$k}}
                </div> --}}

                <table class="min-w-auto mx-auto my-6 border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Sl</th>
                            <th class="border border-gray-300 px-4 py-2">Student Id</th>
                            <th class="border border-gray-300 px-4 py-2">Name</th>
                            <th class="border border-gray-300 px-4 py-2">Roll</th>
                            <th class="border border-gray-300 px-4 py-2">Marks</th>
                            <th class="border border-gray-300 px-4 py-2">Marks</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($studentcrs as $studentcr)
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}/{{$studentcr->id  ?? 'X'}}</th>
                            <th class="border border-gray-300 px-4 py-2">{{ $studentcr->studentdb->studentid  ?? 'X'}}</th>
                            <th class="border border-gray-300 px-4 py-2">{{ $studentcr->studentdb->name  ?? 'X'}}</th>
                            <th class="border border-gray-300 px-4 py-2">{{ $studentcr->roll_no  ?? 'X'}}</th>
                            <th class="border border-gray-300 px-4 py-2">
                                {{-- {{ $studentcr->id }}-{{ $marksentry->where('studentcr_id', $studentcr->id)->first() }} --}}
                                {{-- {{ 
                                    ($marksentry->where('studentcr_id', $studentcr->id)->first()->marks ?? false)
                                    ? ($marksentry->where('studentcr_id', $studentcr->id)->first()->marks >= 0 ? 
                                    $marksentry->where('studentcr_id', $studentcr->id)->first()->marks : 'AB') : '--' 
                                }} --}}
                                {{ 
                                    ($marksentry->where('studentcr_id', $studentcr->id)->first()->marks ?? false)
                                    ? ($marksentry->where('studentcr_id', $studentcr->id)->first()->marks < 0 
                                        ? 'AB' : $marksentry->where('studentcr_id', $studentcr->id)->first()->marks) 
                                    : ($marksentry->where('studentcr_id', $studentcr->id)->first() == Null ? '--' : 0) 
                                }}
                            </th>
                            <th class="border border-gray-300 px-4 py-2">
                                {{-- <input type="number" min="0" max="500" value="{{ $studentcr->id}}"
                                    class="border border-gray-300 px-4 py-2 w-32 rounded-md" {{--wire:rules="max:400"
                                    wire:model.debounce.250ms="marks.{{ $studentcr->id }}"
                                    oninput="if (this.value < 0 || this.value > {{$examdetail->full_mark}}) this.value = '';" />
                                --}}

                                @if($ansscriptdistribution->first() && $ansscriptdistribution->first()->finalize_dt ==
                                null)
                                    <div class="relative">
                                        <input type="number"
                                            placeholder="{{ isset($cbmarks[$studentcr->id]) && $cbmarks[$studentcr->id] ? 'AB' : 'Number' }}"
                                            {{--
                                            value="{{ isset($cbmarks[$studentcr->id]) && $cbmarks[$studentcr->id] ? $cbmarks[$studentcr->id] : '' }}"
                                            --}} 
                                            min="0" max="{{ $examdetail->full_mark }}"
                                            class="pl-10 pr-4 w-48 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            {{ 
                                                isset($cbmarks[$studentcr->id]) && $cbmarks[$studentcr->id] ? 'disabled' : ''
                                            }}
                                            wire:model.debounce.250ms="marks.{{ $studentcr->id }}"
                                            oninput="if (this.value < 0 || this.value> {{$examdetail->full_mark}}) this.value =
                                                '';"
                                            />
                                            <input type="checkbox" wire:model="cbmarks.{{ $studentcr->id }}"
                                                class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500" />
                                    </div>
                                @else
                                <h2 class="text-purple-500 text-sm">Assign Invegilator</h2>
                                @endif
                            </th>
                        </tr>
                        @endforeach
                        <tr>
                            <th class="border border-gray-300 px-4 py-2"></th>
                            <th class="border border-gray-300 px-4 py-2"></th>
                            <th class="border border-gray-300 px-4 py-2"></th>
                            <th class="border border-gray-300 px-4 py-2"></th>
                            <th class="border border-gray-300 px-4 py-2"></th>
                            <th class="border border-gray-300 px-4 py-2">
                                @if( $ansscriptdistribution->first() )
                                <button wire:click="finalize"
                                    class="bg-rose-500 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded ">
                                    Finalize
                                </button>
                                @else
                                Not Allowed
                                @endif
                            </th>
                        </tr>

                    </tbody>
                </table>