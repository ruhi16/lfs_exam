<div class="w-full bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex flex-col md:flex-row">
        <!-- Profile Header Section -->
        <div
            class="md:w-1/4 bg-gradient-to-br from-blue-500 to-indigo-600 p-6 flex flex-col items-center justify-center">
            <div class="relative mb-4">
                @if($teacher && $teacher->img_ref)
                    <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md"
                        src="{{ asset('storage/' . $teacher->img_ref) }}" alt="{{ $user->name }}">
                @else
                    <div
                        class="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center border-4 border-white shadow-md">
                        <span class="text-2xl font-bold text-white">
                            {{ substr($user->name, 0, 1) }}
                        </span>
                    </div>
                @endif
                <div class="absolute -bottom-1 -right-1 h-5 w-5 bg-green-400 rounded-full border-2 border-white"></div>
            </div>

            <div class="text-center text-white">
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                @if($role)
                    <span class="inline-block mt-1 px-2 py-1 text-xs font-medium bg-white/20 rounded-full">
                        {{ $role->name }}
                    </span>
                @endif
                <div class="mt-2 flex items-center justify-center text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ $user->email }}</span>
                </div>
                <span class="mt-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                    {{ $user->status == 'active' ? 'bg-green-400/30 text-green-100' : 'bg-red-400/30 text-red-100' }}">
                    <span class="w-2 h-2 rounded-full mr-1 
                        {{ $user->status == 'active' ? 'bg-green-300' : 'bg-red-300' }}"></span>
                    {{ ucfirst($user->status ?? 'Active') }}
                </span>
            </div>
        </div>

        <!-- Teacher Information Section -->
        <div class="md:w-3/4 p-6">
            @if($teacher)
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Professional Details
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium text-gray-900">{{ $teacher->name ?: '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Designation</p>
                            <p class="font-medium text-gray-900">{{ $teacher->desig ?: '-' }}
                                , {{ $teacher->hqual ?: '-' }}
                                , {{ $teacher->train_qual ?: '-' }}
                                , {{ $teacher->extra_qual ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Mobile</p>
                            <p class="font-medium text-gray-900">{{ $teacher->mobno ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">School</p>
                            <p class="font-medium text-gray-900">{{ $teacher->school->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Session</p>
                            <p class="font-medium text-gray-900">{{ $teacher->session->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start sm:col-span-2">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Main Subject</p>
                            <p class="font-medium text-gray-900">
                                {{ $teacher->subject->name ?? ($teacher->main_subject_id ? 'Subject ID: ' . $teacher->main_subject_id : '-') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($teacher->hqual || $teacher->train_qual)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Qualifications</h4>
                        <div class="flex flex-wrap gap-2">
                            @if($teacher->hqual)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $teacher->hqual }}
                                </span>
                            @endif
                            @if($teacher->train_qual)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $teacher->train_qual }}
                                </span>
                            @endif
                            @if($teacher->extra_qual)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $teacher->extra_qual }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.329M12 3c2.755 0 5.255.881 7.08 2.329A7.962 7.962 0 0112 21c-2.755 0-5.255-.881-7.08-2.329A7.962 7.962 0 0112 3z">
                        </path>
                    </svg>
                    <p>No teacher information available</p>
                </div>
            @endif
        </div>
    </div>
</div>