<div class="flex gap-4 p-4 bg-gray-50 min-h-screen">
    {{-- Sidebar Navigation --}}
    <aside class="w-64 shrink-0">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-4 sticky top-4">
            <div class="flex items-center gap-2 mb-4 pb-3 border-b border-blue-500">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <h3 class="text-white font-bold text-lg">Dashboard</h3>
            </div>
            
            <nav class="space-y-1">
                @php
                    $menuItems = [
                        'overview' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Overview', 'color' => 'blue'],
                        'schools' => ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'Schools', 'color' => 'purple'],
                        'sessions' => ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Sessions', 'color' => 'indigo'],
                        'classes' => ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'label' => 'Classes', 'color' => 'green'],
                        'sections' => ['icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 'label' => 'Sections', 'color' => 'teal'],
                        'students' => ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Students', 'color' => 'yellow'],
                        'subjects' => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Subjects', 'color' => 'orange'],
                        'teachers' => ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Teachers', 'color' => 'pink'],
                        'exam_details' => ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'label' => 'Exam Details', 'color' => 'red'],
                    ];
                @endphp
                
                @foreach($menuItems as $key => $item)
                    <button 
                        wire:click="setActive('{{ $key }}')" 
                        class="w-full text-left px-3 py-2.5 rounded-lg transition-all duration-200 flex items-center gap-3 group
                            {{ $active === $key 
                                ? 'bg-white text-blue-700 shadow-md font-medium' 
                                : 'text-blue-100 hover:bg-blue-500/30 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ $active === $key ? 'text-blue-600' : 'text-blue-300 group-hover:text-white' }}" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                        </svg>
                        <span class="text-sm">{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </nav>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1">
        <div class="bg-white rounded-xl shadow-lg p-6">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6 pb-4 border-b">
                <h2 class="text-2xl font-bold text-gray-800 capitalize flex items-center gap-2">
                    <span class="w-2 h-8 bg-gradient-to-b from-blue-500 to-blue-600 rounded-full"></span>
                    {{ str_replace('_',' ', $active) }}
                </h2>
                <div class="text-sm text-gray-500">
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full font-medium">
                        {{ now()->format('M d, Y') }}
                    </span>
                </div>
            </div>

            {{-- Overview Section --}}
            @if($active === 'overview')
                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    @php
                        $colors = [
                            'bg-gradient-to-br from-blue-500 to-blue-600',
                            'bg-gradient-to-br from-purple-500 to-purple-600',
                            'bg-gradient-to-br from-green-500 to-green-600',
                            'bg-gradient-to-br from-orange-500 to-orange-600',
                            'bg-gradient-to-br from-pink-500 to-pink-600',
                            'bg-gradient-to-br from-indigo-500 to-indigo-600',
                            'bg-gradient-to-br from-teal-500 to-teal-600',
                            'bg-gradient-to-br from-red-500 to-red-600',
                        ];
                        $i = 0;
                    @endphp
                    
                    @foreach($stats as $label => $count)
                        <div class="{{ $colors[$i++ % count($colors)] }} rounded-xl p-4 text-white shadow-lg hover:shadow-xl transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-xs font-medium uppercase opacity-90">{{ str_replace('_',' ', $label) }}</div>
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold">{{ number_format($count) }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- Quick Actions: Teacher request and Student self-identification ribbon --}}
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    @unless($isStudent)
                    {{-- Request to be a teacher --}}
                    <div class="bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-9 h-9 bg-green-500 text-white rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5 12.083 12.083 0 015.84 10.578L12 14z"/></svg>
                                </div>
                                <h3 class="font-semibold text-gray-800">Request to be a Teacher</h3>
                            </div>
                        </div>
                        @if($isTeacherRequestActive)
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-gray-700">Your request is active and pending review.</div>
                                <button wire:click="revokeTeachership" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Revoke</button>
                            </div>
                        @else
                            <p class="text-sm text-gray-600 mb-3">Submit a request if you want your account reviewed for teacher access.</p>
                            <button wire:click="requestToBeTeacher" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">Request Teacher Access</button>
                        @endif
                    </div>
                    @endunless

                    {{-- Student ribbonis_Teacher: {{ $isTeacherRequestActive ? 'T' : 'F' }} - is_Student: {{ $isStudent ? 'T' : 'F' }} --}}
                    @if(!$isTeacherRequestActive && !$isStudent)
                    <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-9 h-9 bg-blue-500 text-white rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <h3 class="font-semibold text-gray-800">Identify as a Student</h3>
                            </div>
                        </div>
                        @if($alreadyLinked)
                            <div class="text-sm text-green-700">Your account is already linked to a student record.</div>
                        @else
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Admission Session</label>
                                <select wire:model="sel_session_id" class="w-full border rounded-lg px-2 py-1.5 text-sm">
                                    <option value="">Select Session</option>
                                    @foreach($sessions as $s)
                                        <option value="{{ $s->id }}">{{ $s->name ?? ('Session #'.$s->id) }}</option>
                                    @endforeach
                                </select>
                                @error('sel_session_id') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Class</label>
                                <select wire:model="sel_class_id" class="w-full border rounded-lg px-2 py-1.5 text-sm">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}">{{ $c->name ?? ('Class #'.$c->id) }}</option>
                                    @endforeach
                                </select>
                                @error('sel_class_id') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Section</label>
                                <select wire:model="sel_section_id" class="w-full border rounded-lg px-2 py-1.5 text-sm">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $sc)
                                        <option value="{{ $sc->id }}">{{ $sc->name ?? ('Section #'.$sc->id) }}</option>
                                    @endforeach
                                </select>
                                @error('sel_section_id') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Roll No</label>
                                <input type="number" wire:model.lazy="sel_roll_no" class="w-full border rounded-lg px-2 py-1.5 text-sm" placeholder="e.g. 12" />
                                @error('sel_roll_no') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <button wire:click="findCandidate" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">Find</button>
                        </div>

                        @if($candidate)
                            <div class="mt-3 p-3 border rounded-lg bg-white">
                                <div class="text-xs text-gray-500 mb-2">Candidate preview:</div>
                                <div class="flex items-start gap-3">
                                    <div class="w-16 h-16 rounded overflow-hidden bg-gray-100">
                                        @if(optional($candidate->studentdb)->img_ref_profile)
                                            <img src="{{ asset('storage/' . optional($candidate->studentdb)->img_ref_profile) }}" class="w-full h-full object-cover"/>
                                        @endif
                                    </div>
                                    <div class="text-sm grid grid-cols-2 gap-x-6 gap-y-1 flex-1">
                                        <div class="col-span-2 font-medium">{{ optional($candidate->studentdb)->name ?? 'Unknown' }}</div>
                                        <div><span class="text-gray-500">Father:</span> {{ optional($candidate->studentdb)->fname }}</div>
                                        <div><span class="text-gray-500">Mother:</span> {{ optional($candidate->studentdb)->mname }}</div>
                                        <div class="col-span-2"><span class="text-gray-500">Address:</span> {{ trim(((optional($candidate->studentdb)->vill1).' '.(optional($candidate->studentdb)->post).' '.(optional($candidate->studentdb)->dist).' '.(optional($candidate->studentdb)->state))) }}</div>
                                        <div><span class="text-gray-500">Roll:</span> {{ $candidate->roll_no }}</div>
                                        <div><span class="text-gray-500">Session:</span> {{ $candidate->session_id }}</div>
                                        <div><span class="text-gray-500">Class:</span> {{ $candidate->myclass_id }}</div>
                                        <div><span class="text-gray-500">Section:</span> {{ $candidate->section_id }}</div>
                                    </div>
                                </div>
                            </div>
                            @if($showDobField)
                            <div class="mt-3 grid grid-cols-2 gap-3">
                                <div class="col-span-2">
                                    <label class="block text-xs text-gray-600 mb-1">Date of Birth</label>
                                    <input type="date" wire:model.lazy="dob" class="w-full border rounded-lg px-2 py-1.5 text-sm" />
                                    @error('dob') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-3">
                                <button wire:click="confirmStudent" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">Confirm</button>
                                <span class="text-xs text-gray-500">Enter your date of birth to confirm.</span>
                            </div>
                            @endif
                        @endif
                        @endif
                    </div>
                    @endif
                </div>

                @if($isStudent && $studentdb )
                {{-- Student Profile Dashboard --}}
                <div class="mt-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Student Profile</h3>
                        <button wire:click="revokeStudentship" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Revoke Studentship</button>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="md:col-span-1 bg-gray-50 p-4 rounded-lg border">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 mb-3">
                                @if($studentdb->img_ref_profile)
                                    <img src="{{ asset('storage/' . $studentdb->img_ref_profile) }}" class="w-full h-full object-cover"/>
                                @endif
                            </div>
                            <div class="text-sm space-y-1">
                                <div><span class="font-medium">Name:</span> {{ $studentdb->name }}</div>
                                <div><span class="font-medium">Father:</span> {{ $studentdb->fname }}</div>
                                <div><span class="font-medium">Mother:</span> {{ $studentdb->mname }}</div>
                                <div><span class="font-medium">DOB:</span> {{ $studentdb->dob }}</div>
                                <div><span class="font-medium">Address:</span> {{ trim(($studentdb->vill1.' '.$studentdb->post.' '.$studentdb->dist.' '.$studentdb->state)) }}</div>
                            </div>
                        </div>
                        <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg border">
                            <h4 class="font-semibold mb-2">Present Information</h4>
                            @if($studentcr)
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div><span class="font-medium">Session:</span> {{ $studentcr->session_id }}</div>
                                <div><span class="font-medium">Class:</span> {{ $studentcr->myclass_id }}</div>
                                <div><span class="font-medium">Section:</span> {{ $studentcr->section_id }}</div>
                                <div><span class="font-medium">Roll:</span> {{ $studentcr->roll_no }}</div>
                            </div>
                            @else
                                <div class="text-sm text-gray-500">No current class record found.</div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white border rounded-lg">
                        <div class="px-4 py-2 border-b font-semibold">Exam Details and Marks</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left">Exam</th>
                                        <th class="px-3 py-2 text-left">Subject</th>
                                        <th class="px-3 py-2 text-right">Marks</th>
                                        <th class="px-3 py-2 text-left">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($studentMarks as $m)
                                        <tr class="border-t">
                                            <td class="px-3 py-2">{{ optional($m->examDetail)->id }}</td>
                                            <td class="px-3 py-2">{{ optional($m->examClassSubject)->id }}</td>
                                            <td class="px-3 py-2 text-right">{{ $m->getDisplayMarks() }}</td>
                                            <td class="px-3 py-2">{{ optional($m->grade)->id }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-3 py-2 text-gray-500">No marks available.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white border rounded-lg">
                        <div class="px-4 py-2 border-b font-semibold">Class Overall Results (Totals)</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left">StudentCR</th>
                                        <th class="px-3 py-2 text-right">Total Marks</th>
                                        <th class="px-3 py-2 text-right">Exams</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classOverall as $row)
                                        <tr class="border-t">
                                            <td class="px-3 py-2">{{ $row->studentcr_id }}</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($row->total_marks, 2) }}</td>
                                            <td class="px-3 py-2 text-right">{{ $row->exams_count }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-3 py-2 text-gray-500">No data available.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Recent Items --}}
                <div class="grid md:grid-cols-2 gap-4">
                    @php $recentColors = ['blue', 'purple', 'green', 'orange', 'pink', 'indigo', 'teal', 'red']; $j = 0; @endphp
                    @foreach($recent as $key => $items)
                        @php $color = $recentColors[$j++ % count($recentColors)]; @endphp
                        <div class="bg-gradient-to-br from-{{ $color }}-50 to-white border border-{{ $color }}-100 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 bg-{{ $color }}-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 capitalize">Recent {{ str_replace('_',' ', $key) }}</h3>
                            </div>
                            <div class="space-y-2">
                                @forelse($items as $item)
                                    <div class="flex items-center justify-between p-2 bg-white rounded-lg hover:bg-{{ $color }}-50 transition-colors">
                                        <span class="text-sm font-medium text-{{ $color }}-700">#{{ $item->id }}</span>
                                        <span class="text-sm text-gray-600 truncate ml-2">{{ $item->name ?? ($item->code ?? 'N/A') }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-400 text-sm">No records yet</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            
            {{-- Detail View --}}
            @else
                @php 
                    $items = $recent[$active] ?? collect();
                    $colorMap = [
                        'schools' => 'purple', 'sessions' => 'indigo', 'classes' => 'green',
                        'sections' => 'teal', 'students' => 'yellow', 'subjects' => 'orange',
                        'teachers' => 'pink', 'exam_details' => 'red'
                    ];
                    $color = $colorMap[$active] ?? 'blue';
                @endphp
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($items as $item)
                        <div class="group bg-gradient-to-br from-{{ $color }}-50 to-white border border-{{ $color }}-100 rounded-xl p-4 hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-1 bg-{{ $color }}-500 text-white text-xs font-bold rounded-md">#{{ $item->id }}</span>
                                        <span class="font-semibold text-gray-800 truncate">{{ $item->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="w-8 h-8 bg-{{ $color }}-100 rounded-lg flex items-center justify-center group-hover:bg-{{ $color }}-200 transition-colors">
                                    <svg class="w-4 h-4 text-{{ $color }}-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                @if(isset($item->code))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Code:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->code }}</span>
                                    </div>
                                @endif
                                @if(isset($item->year))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Year:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->year }}</span>
                                    </div>
                                @endif
                                @if(isset($item->myclass_id))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Class:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->myclass_id }}</span>
                                    </div>
                                @endif
                                @if(isset($item->myclass_section_id))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Section:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->myclass_section_id }}</span>
                                    </div>
                                @endif
                                @if(isset($item->studentdb_id))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Student:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->studentdb_id }}</span>
                                    </div>
                                @endif
                                @if(isset($item->subject_type_id))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Type:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->subject_type_id }}</span>
                                    </div>
                                @endif
                                @if(isset($item->exam01_name_id))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Exam:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->exam01_name_id }}</span>
                                    </div>
                                @endif
                                @if(isset($item->exam02_type_id))
                                    <div class="flex items-center gap-1 text-gray-600">
                                        <span class="font-medium">Type:</span>
                                        <span class="text-{{ $color }}-700 font-semibold">{{ $item->exam02_type_id }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-400">
                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-lg font-medium">No records found</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </main>
</div>
