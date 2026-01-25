{{-- 6. School Info View --}}
{{-- resources/views/livewire/school-info.blade.php --}}
<div class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Visit Our School</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Come see our beautiful facilities and meet our dedicated team. We'd love to show you around!
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            {{-- Contact Information --}}
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-4 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <div class="font-semibold text-gray-800">Address</div>
                                <div class="text-gray-600">{{ $schoolData['address'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <div>
                                <div class="font-semibold text-gray-800">Phone</div>
                                <div class="text-gray-600">{{ $schoolData['phone'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <div>
                                <div class="font-semibold text-gray-800">Email</div>
                                <div class="text-gray-600">{{ $schoolData['email'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- School Hours --}}
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">School Hours</h3>
                    <div class="space-y-3">
                        @foreach($schoolData['timings'] as $day => $time)
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">{{ $day }}</span>
                            <span class="text-gray-600">{{ $time }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Facilities --}}
            <div>
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Facilities</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($schoolData['facilities'] as $facility)
                        <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm text-gray-700">{{ $facility }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="mt-8 grid grid-cols-2 gap-6">
                    <div class="bg-yellow-50 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $schoolData['students'] }}</div>
                        <div class="text-gray-600">Happy Students</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $schoolData['teachers'] }}</div>
                        <div class="text-gray-600">Qualified Teachers</div>
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="mt-8 text-center">
                    <button class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        Schedule a Visit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>