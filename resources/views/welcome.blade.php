{{-- Main Welcome Page Layout --}}
{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Flowers Nursery School - Where Learning Begins with Love</title>
    <meta name="description" content="Premier English medium nursery school providing quality early childhood education in a safe, nurturing environment. Enroll your child today!">
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Custom CSS for animations --}}
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out;
        }
        
        .scroll-smooth {
            scroll-behavior: smooth;
        }
        
        /* Custom gradient backgrounds */
        .bg-gradient-rainbow {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            background-size: 300% 300%;
            animation: gradient-shift 8s ease infinite;
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
    
    {{-- Livewire Styles --}}
    @livewireStyles
</head>
<body class="font-sans antialiased scroll-smooth">
    
    {{-- Navigation Header --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-lg transition-all duration-300">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">⭐</span>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 text-lg">Little Flowers</div>
                        <div class="text-xs text-gray-600 -mt-1">Nursery School</div>
                    </div>
                </div>
                
                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center space-x-8 ">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">About</a>
                    <a href="#programs" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Programs</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Reviews</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Contact</a>

                    {{-- <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full font-semibold transition-colors">
                        Enroll Now
                    </button> --}}
                    @if (Route::has('login'))
                        {{-- <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block"> --}}
                            @auth
                            {{-- <a wire:navigate href="{{ url('/test-dashboard') }}"
                                class="text-sm text-gray-700 dark:text-gray-500 underline">Test Dashboard</a> --}}
                                
                                <a wire:navigate href="{{ url('/dashboard') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard: {{ auth()->user()->id }}</a>
                            @else
                                <a wire:navigate href="{{ route('login') }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full font-semibold transition-colors">Log in</a>

                                @if (Route::has('register'))
                                    <a wire:navigate href="{{ route('login') }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full font-semibold transition-colors">Register</a>
                                @endif
                            @endauth
                        {{-- </div> --}}
                    @endif

                </div>
                
                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        {{-- Hero Section --}}
        <section id="home">
            @livewire('wcui.hero-section')
        </section>

        {{-- About Section --}}
        <section id="about">
            @livewire('wcui.about-section')
        </section>

        {{-- Programs Section --}}
        <section id="programs">
            @livewire('wcui.programs')
        </section>

        {{-- Testimonials Section --}}
        <section id="testimonials">
            @livewire('wcui.testimonials')
        </section>

        {{-- School Info Section --}}
        <section id="info">
            @livewire('wcui.school-info')
        </section>

        {{-- Contact Section --}}
        <section id="contact">
            @livewire('wcui.contact-form')
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                {{-- School Info --}}
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-lg">⭐</span>
                        </div>
                        <div>
                            <div class="font-bold text-white text-lg">Little Flowers</div>
                            <div class="text-sm text-gray-400 -mt-1">Nursery School</div>
                        </div>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Providing quality English medium education in a nurturing environment where every child can shine bright.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#programs" class="text-gray-400 hover:text-white transition-colors">Programs</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Admissions</a></li>
                    </ul>
                </div>

                {{-- Programs --}}
                <div>
                    <h3 class="font-bold text-lg mb-4">Our Programs</h3>
                    <ul class="space-y-2">
                        <li><span class="text-gray-400">Playgroup (1.5-2.5 years)</span></li>
                        <li><span class="text-gray-400">Nursery (2.5-3.5 years)</span></li>
                        <li><span class="text-gray-400">LKG (3.5-4.5 years)</span></li>
                        <li><span class="text-gray-400">UKG (4.5-5.5 years)</span></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h3 class="font-bold text-lg mb-4">Contact Info</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-400 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 text-sm">123 Education Street, City Center</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <span class="text-gray-400 text-sm">+1 234 567 8900</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <span class="text-gray-400 text-sm">info@littlestarsnursery.com</span>
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-800 hover:bg-blue-900 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 hover:bg-pink-700 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.402.271-.402.271-.402-.271-.925-1.199-.925-1.199-.402-.271-.925-1.199-.925-1.199-.402-.271-.925-1.199-.925-1.199-.402-.271-.925-1.199-.925-1.199-.402-.271-.925-1.199-.925-1.199-.402-.271-.925-1.199-.925-1.199-.402-.271-.925-1.199-.925-1.199-.271-.402-.271-.925-1.199-.925-1.199-.271-.402-.271-.925-1.199-.925-1.199-.271-.402-.271-.925-1.199-.925-1.199-.271-.402-.271-.925-1.199-.925z"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

            {{-- Copyright --}}
            <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                <p class="text-gray-400">
                    © {{ date('Y') }} Little Flowers Nursery School. All rights reserved. 
                    <span class="mx-2">|</span>
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <span class="mx-2">|</span>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </p>
            </div>

        </div>
    </footer>

    {{-- Floating WhatsApp Button --}}
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/1234567890" target="_blank" 
           class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.568-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
        </a>
    </div>

    {{-- Scroll to Top Button --}}
    <div class="fixed bottom-6 left-6 z-50">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-75 hover:opacity-100">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    {{-- Livewire Scripts --}}
    @livewireScripts
    
    {{-- Custom JavaScript --}}
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 100) {
                navbar.classList.add('bg-white');
                navbar.classList.remove('bg-white/95');
            } else {
                navbar.classList.remove('bg-white');
                navbar.classList.add('bg-white/95');
            }
        });

        // Auto-advance hero slider
        document.addEventListener('livewire:load', function () {
            setInterval(function() {
                Livewire.emit('nextSlide');
            }, 8000); // Change slide every 8 seconds
        });
    </script>
</body>
</html>