{{-- 5. Testimonials View --}}
{{-- resources/views/livewire/testimonials.blade.php --}}
<div class="py-20 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">What Parents Say</h2>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Hear from our wonderful parent community about their experience with Little Stars
            </p>
        </div>

        <div class="max-w-4xl mx-auto relative">
            @foreach($testimonials as $index => $testimonial)
            <div class="{{ $currentTestimonial === $index ? 'block' : 'hidden' }}">
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 md:p-12 text-center">
                    <div class="flex justify-center mb-6">
                        @for($i = 0; $i < $testimonial['rating']; $i++)
                        <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        @endfor
                    </div>
                    
                    <blockquote class="text-xl md:text-2xl font-light leading-relaxed mb-8 italic">
                        "{{ $testimonial['text'] }}"
                    </blockquote>
                    
                    <div class="border-t border-white/20 pt-6">
                        <div class="font-semibold text-lg">{{ $testimonial['name'] }}</div>
                        <div class="text-blue-200">Parent of {{ $testimonial['child'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Navigation Arrows --}}
            <button wire:click="prevTestimonial" 
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-12 bg-white/20 hover:bg-white/30 rounded-full p-3 transition-all duration-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
            
            <button wire:click="nextTestimonial" 
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-12 bg-white/20 hover:bg-white/30 rounded-full p-3 transition-all duration-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>

            {{-- Dots Indicator --}}
            <div class="flex justify-center space-x-3 mt-8">
                @foreach($testimonials as $index => $testimonial)
                <button wire:click="currentTestimonial = {{ $index }}" 
                        class="w-3 h-3 rounded-full transition-all duration-300 {{ $currentTestimonial === $index ? 'bg-white' : 'bg-white/40 hover:bg-white/60' }}">
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>