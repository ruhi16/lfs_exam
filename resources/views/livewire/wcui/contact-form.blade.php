{{-- 4. Contact Form View --}}
{{-- resources/views/livewire/contact-form.blade.php --}}
<div class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Get In Touch</h2>
                <p class="text-xl text-gray-600">
                    Ready to give your child the best start? Contact us today to schedule a visit or learn more about our programs.
                </p>
            </div>

            @if($success)
            <div class="bg-green-100 border-l-4 border-green-500 p-6 rounded-lg mb-8">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">Thank You!</h3>
                        <p class="text-green-700">Your message has been sent successfully. We'll get back to you within 24 hours.</p>
                    </div>
                </div>
                <button wire:click="resetForm" class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                    Send Another Message
                </button>
            </div>
            @endif

            @if($showForm)
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form wire:submit.prevent="submit" class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Parent/Guardian Name *</label>
                        <input wire:model="name" type="text" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email Address *</label>
                        <input wire:model="email" type="email" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                        <input wire:model="phone" type="tel" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Child's Age *</label>
                        <select wire:model="child_age" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Age</option>
                            <option value="1.5-2.5">1.5 - 2.5 Years</option>
                            <option value="2.5-3.5">2.5 - 3.5 Years</option>
                            <option value="3.5-4.5">3.5 - 4.5 Years</option>
                            <option value="4.5-5.5">4.5 - 5.5 Years</option>
                        </select>
                        @error('child_age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Interested Program *</label>
                        <select wire:model="program" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Program</option>
                            <option value="playgroup">Playgroup</option>
                            <option value="nursery">Nursery</option>
                            <option value="lkg">LKG</option>
                            <option value="ukg">UKG</option>
                        </select>
                        @error('program') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">Message *</label>
                        <textarea wire:model="message" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Tell us about your child and any specific questions you have..."></textarea>
                        @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 text-center">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-semibold transition-colors duration-300">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>