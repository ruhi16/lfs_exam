{{-- 2. About Section View --}}
{{-- resources/views/livewire/about-section.blade.php --}}
<div class="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Why Choose Little Flowers?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We provide a nurturing environment where children develop confidence, curiosity, and a love for learning 
                through our carefully crafted English medium curriculum.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($features as $feature)
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300 text-center">
                <div class="text-5xl mb-4">{{ $feature['icon'] }}</div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-16 bg-white rounded-2xl shadow-xl p-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">Our Mission</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        At Little Flowers Nursery, we believe that every child is unique and deserves individual attention 
                        to reach their full potential. Our experienced teachers create a warm, supportive environment 
                        where children feel safe to explore, learn, and grow.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Through our English medium curriculum, we prepare children for their academic journey while 
                        fostering creativity, critical thinking, and strong moral values that will serve them throughout life.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-6 text-center">
                    <div class="bg-blue-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-blue-600">13+</div>
                        <div class="text-gray-600">Years of Excellence</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-green-600">200+</div>
                        <div class="text-gray-600">Happy Students</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-yellow-600">15</div>
                        <div class="text-gray-600">Qualified Teachers</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-purple-600">100%</div>
                        <div class="text-gray-600">Parent Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>