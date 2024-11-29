<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTU Danao Library System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <style>
        /* Float Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(45deg, #3b82f6, #1e40af);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Blue and Yellow Pattern Backgrounds */
        .blue-yellow-pattern {
            background-image: 
                linear-gradient(45deg, rgba(59, 130, 246, 0.1) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(59, 130, 246, 0.1) 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, rgba(250, 204, 21, 0.1) 75%),
                linear-gradient(-45deg, transparent 75%, rgba(250, 204, 21, 0.1) 75%);
            background-size: 40px 40px;
            background-position: 0 0, 0 20px, 20px -20px, -20px 0px;
        }

        .wave-background {
            background-color: #f0f9ff;
            background-image: 
                linear-gradient(to bottom, rgba(59, 130, 246, 0.1), transparent),
                repeating-linear-gradient(
                    45deg,
                    rgba(250, 204, 21, 0.05) 0,
                    rgba(250, 204, 21, 0.05) 10px,
                    transparent 10px,
                    transparent 20px
                );
        }

        body {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

<!-- Navbar -->
<header class="bg-blue-700 shadow fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo Section with simple hover effect -->
        <div class="flex items-center transform transition-transform duration-300 hover:scale-105 group">
            <img src="{{ asset('images/logo.jpg') }}" alt="Library Logo" class="w-12 h-12 mr-3 rounded-full shadow-lg transition-all duration-300 group-hover:shadow-xl">
            <h1 class="text-2xl font-semibold text-white group-hover:text-yellow-300 transition-colors duration-300">CTU Danao Library</h1>
        </div>

        <!-- Navigation Links -->
        <nav class="hidden md:flex space-x-6">
            <a href="#features" class="text-white hover:text-yellow-300 transition-all duration-300 transform hover:scale-110 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-yellow-300 hover:after:w-full after:transition-all">Features</a>
            <a href="#about-us" class="text-white hover:text-yellow-300 transition-all duration-300 transform hover:scale-110 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-yellow-300 hover:after:w-full after:transition-all">About Us</a>
            <a href="#team" class="text-white hover:text-yellow-300 transition-all duration-300 transform hover:scale-110 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-yellow-300 hover:after:w-full after:transition-all">Team</a>
            <a href="#contact" class="text-white hover:text-yellow-300 transition-all duration-300 transform hover:scale-110 relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-yellow-300 hover:after:w-full after:transition-all">Contact</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button id="menuButton" class="md:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Login Button with enhanced styling -->
        <a href="/login" class="px-6 py-3 bg-yellow-500 text-blue-900 font-bold rounded-lg shadow-md hover:bg-yellow-400 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
            Login
        </a>
    </div>
</header>

<!-- Scroll to Top Button -->
<button id="scrollToTop" class="fixed bottom-8 right-8 bg-blue-700 text-white p-4 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-blue-600 focus:outline-none">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>

<script>
let lastScrollY = window.scrollY;
const navbar = document.getElementById('navbar');
const scrollToTopButton = document.getElementById('scrollToTop');

// Scroll event listener for navbar and scroll-to-top button
window.addEventListener('scroll', () => {
    // Navbar hide/show logic
    const currentScrollY = window.scrollY;
    
    if (currentScrollY > lastScrollY) {
        // Scrolling down - hide navbar
        navbar.style.transform = 'translateY(-100%)';
    } else {
        // Scrolling up - show navbar
        navbar.style.transform = 'translateY(0)';
    }
    lastScrollY = currentScrollY;

    // Scroll-to-top button visibility
    if (currentScrollY > 500) {
        scrollToTopButton.classList.remove('opacity-0', 'invisible');
        scrollToTopButton.classList.add('opacity-100', 'visible');
    } else {
        scrollToTopButton.classList.add('opacity-0', 'invisible');
        scrollToTopButton.classList.remove('opacity-100', 'visible');
    }
});

// Scroll to top functionality
scrollToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>
<script>
    // Initialize AOS (Animate on Scroll)
    AOS.init({
        duration: 800,
        once: true
    });

    // Toggle mobile menu visibility
    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
<!-- Hero Section -->
<section class="relative bg-cover bg-center text-white py-32"
             style="background-image: url('{{ asset('images/bg2.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto relative z-10 text-center">
            <h2 class="text-5xl font-bold mb-6 drop-shadow-lg">Welcome to CTU Danao Library System</h2>
            <p class="text-lg font-light mb-8 max-w-3xl mx-auto drop-shadow-md">
                Empowering knowledge and discovery for the CTU Danao community. Explore resources, services, and spaces designed to enhance learning and innovation.
            </p>
            <div class="flex flex-col md:flex-row justify-center items-center gap-4">
                <a href="#features" class="px-8 py-4 bg-yellow-500 text-white font-medium rounded-lg shadow-lg hover:bg-yellow-400 hover:shadow-xl transition duration-300">
                    Explore Features
                </a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gray-100 text-blue-700 font-medium rounded-lg shadow-lg hover:bg-gray-200 hover:shadow-xl transition duration-300">
                    Become a Member
                </a>
            </div>  
        </div>
    </section>

   <!-- Features Section with Diagonal Pattern and Animations -->
   <section id="features" class="py-16 bg-gradient-to-br from-blue-50 to-blue-100 relative overflow-hidden">
    <div class="absolute inset-0 pattern-diagonal opacity-10"></div>
    <div class="container mx-auto text-center relative z-10">
        <h3 class="text-4xl font-extrabold mb-12 text-blue-800 animate-fade-in">
            Library Services & Support
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Borrow Books -->
            <div onclick="window.location.href='/login'" class="cursor-pointer bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 ease-in-out group">
                <div class="bg-blue-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-3 text-blue-800 group-hover:text-blue-600 transition-colors">Borrow Books</h4>
                <p class="text-gray-600 mb-4">Browse our catalog, select your books, and easily borrow them for study or research.</p>
            </div>

            <!-- Discussion Room Reservation -->
            <div onclick="window.location.href='/login'" class="cursor-pointer bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 ease-in-out group">
                <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h4v4H8V10zM8 14h4v4H8v-4zm4-4h4v4h-4v-4zm4-4h4v4h-4V6z" />
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-3 text-green-800 group-hover:text-green-600 transition-colors">Discussion Room</h4>
                <p class="text-gray-600 mb-4">Reserve rooms for group discussions or quiet study. Book a space with ease.</p>
            </div>

            <!-- PC Room Usage -->
            <div onclick="window.location.href='/login'" class="cursor-pointer bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 ease-in-out group">
                <div class="bg-purple-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-3 text-purple-800 group-hover:text-purple-600 transition-colors">PC Room</h4>
                <p class="text-gray-600 mb-4">Access computers and enjoy free printing services for your academic needs.</p>
            </div>

            <!-- Lost and Found -->
            <div onclick="window.location.href='/login'" class="cursor-pointer bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 ease-in-out group">
                <div class="bg-red-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:rotate-45 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <h4 class="text-xl font-semibold mb-3 text-red-800 group-hover:text-red-600 transition-colors">Lost & Found</h4>
                <p class="text-gray-600 mb-4">Report lost items or help reunite lost belongings with their owners.</p>
            </div>
        </div>
    </div>
</section>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }
        .pattern-diagonal {
            background-image: 
                linear-gradient(45deg, rgba(59, 130, 246, 0.1) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(59, 130, 246, 0.1) 25%, transparent 25%);
            background-size: 40px 40px;
        }
    </style>
</section>
    <!-- About Us Section with Enhanced Animations and Design -->
<section id="about-us" class="py-16 bg-gradient-to-br from-blue-50 to-blue-100 relative overflow-hidden">
    <div class="absolute inset-0 pattern-dots opacity-10"></div>
    <div class="container mx-auto text-center relative z-10">
        <h3 class="text-4xl font-extrabold mb-6 text-blue-800 animate-fade-in">
            Meet Our Team
        </h3>
        <p class="text-lg text-gray-700 mb-12 max-w-4xl mx-auto leading-relaxed animate-slide-in">
            Discover the passionate professionals driving innovation and excellence. Our diverse team is committed to supporting your academic journey with expertise, creativity, and dedication.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8">
            <!-- Team Member 1: Jehan D. Bombio -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:-translate-y-4 hover:shadow-2xl transition-all duration-300 ease-in-out group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                <img src="{{ asset('images/jehan.jpg') }}" alt="Jehan D. Bombio" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-blue-100 transition-transform group-hover:scale-110">
                <h4 class="text-xl font-semibold text-blue-800 mb-2">Jehan D. Bombio</h4>
                <p class="text-blue-600 mb-3 font-medium">Front End Developer</p>
                <p class="text-gray-600 text-sm h-24 overflow-hidden">
                    Creates intuitive user interfaces that bring digital experiences to life.
                </p>
                <div class="mt-4 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="https://facebook.com/jehans115" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                        </svg>
                    </a>
                    <a href="https://facebook.com/jehans115" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700">
                        
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Team Member 2: Rosalio Ligaray Jr. -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:-translate-y-4 hover:shadow-2xl transition-all duration-300 ease-in-out group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-green-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                <img src="{{ asset('images/jun.jpg') }}" alt="Rosalio Ligaray Jr." class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-green-100 transition-transform group-hover:scale-110">
                <h4 class="text-xl font-semibold text-green-800 mb-2">Rosalio Ligaray Jr.</h4>
                <p class="text-green-600 mb-3 font-medium">Back-End Developer</p>
                <p class="text-gray-600 text-sm h-24 overflow-hidden">
                    Architects robust server-side solutions that power complex digital ecosystems.
                </p>
                <div class="mt-4 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="https://facebook.com/junz.ligaray" target="_blank" rel="noopener noreferrer" class="text-green-500 hover:text-green-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                        </svg>
                    </a>
                    <a href="https://facebook.com/junz.ligaray" target="_blank" rel="noopener noreferrer" class="text-green-500 hover:text-green-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Team Member 3: Dan Andrei S. Macasa -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:-translate-y-4 hover:shadow-2xl transition-all duration-300 ease-in-out group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                <img src="{{ asset('images/dan.png') }}" alt="Dan Andrei S. Macasa" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-purple-100 transition-transform group-hover:scale-110">
                <h4 class="text-xl font-semibold text-purple-800 mb-2">Dan Andrei S. Macasa</h4>
                <p class="text-purple-600 mb-3 font-medium">Full Stack Developer</p>
                <p class="text-gray-600 text-sm h-24 overflow-hidden">
                    Masters both front-end and back-end technologies to deliver comprehensive solutions.
                </p>
                <div class="mt-4 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="https://facebook.com/dan.mac15" target="_blank" rel="noopener noreferrer" class="text-purple-500 hover:text-purple-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                        </svg>
                    </a>
                    <a href="https://facebook.com/dan.mac15" target="_blank" rel="noopener noreferrer" class="text-purple-500 hover:text-purple-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Team Member 4: Christian Dave A. Milan -->
<div class="bg-white rounded-xl shadow-lg p-6 transform hover:-translate-y-4 hover:shadow-2xl transition-all duration-300 ease-in-out group relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
    <img src="{{ asset('images/tatan.jpg') }}" alt="Christian Dave A. Milan" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-orange-100 transition-transform group-hover:scale-110">
    <h4 class="text-xl font-semibold text-orange-800 mb-2">Christian Dave A. Milan</h4>
    <p class="text-orange-600 mb-3 font-medium">Project Manager/Full Stack Developer</p>
    <p class="text-gray-600 text-sm h-24 overflow-hidden">
        A strategic leader who coordinates project execution and delivers comprehensive technological solutions.
    </p>
    <div class="mt-4 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
    <a href="https://facebook.com/ChristiandaveMilan" target="_blank" rel="noopener noreferrer" class="text-orange-500 hover:text-orange-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
            </svg>
        </a>
        <a href="https://facebook.com/ChristiandaveMilan" target="_blank" rel="noopener noreferrer" class="text-orange-500 hover:text-orange-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
        </a>
    </div>
</div>

<!-- Team Member 5: Lorenze Supapo -->
<div class="bg-white rounded-xl shadow-lg p-6 transform hover:-translate-y-4 hover:shadow-2xl transition-all duration-300 ease-in-out group relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
    <img src="{{ asset('images/papo.jpg') }}" alt="Lorenze Supapo" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-teal-100 transition-transform group-hover:scale-110">
    <h4 class="text-xl font-semibold text-teal-800 mb-2">Lorenze Supapo</h4>
    <p class="text-teal-600 mb-3 font-medium">Documentation Specialist</p>
    <p class="text-gray-600 text-sm h-24 overflow-hidden">
        Ensures precise documentation, manages records, and maintains the integrity of critical information systems.
    </p>
    <div class="mt-4 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
    <a href="https://facebook.com/reapersupapo" target="_blank" rel="noopener noreferrer" class="text-teal-500 hover:text-teal-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
            </svg>
        </a>
        <a href="https://facebook.com/reapersupapo" target="_blank" rel="noopener noreferrer" class="text-teal-500 hover:text-teal-700">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
        </a>
    </div>
</div>
    
</section>

    <!-- Modified Team Section -->
    <section id="team" class="py-20 bg-gradient-to-br from-blue-50 to-blue-100">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-32 h-32 bg-yellow-300 rounded-full opacity-10 transform -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-blue-300 rounded-full opacity-10 transform translate-x-20 translate-y-20"></div>
    </div>
    
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-blue-800 mb-4 relative inline-block">
                Meet Our Library Staff
                <div class="absolute bottom-0 left-0 w-full h-1 bg-yellow-400 transform -skew-x-12"></div>
            </h2>
            <p class="text-blue-600 text-lg max-w-2xl mx-auto">Dedicated professionals committed to serving our academic community</p>
        </div>

        <!-- Team Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Team Member Cards -->
            <div class="group">
                <div class="relative overflow-hidden bg-white rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <img src="{{ asset('images/librarian.jpg') }}" alt="Sarah Jean N. Jamero" class="w-full h-64 object-cover object-center">
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-bold text-blue-800 group-hover:text-yellow-400 transition-colors duration-300">Sarah Jean N. Jamero</h3>
                        <p class="text-blue-600 font-medium mb-4">Head Librarian</p>
                        <div class="h-0 group-hover:h-20 overflow-hidden transition-all duration-300">
                            <p class="text-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Leading our library services with expertise and dedication to academic excellence.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repeat for other team members with different images and details -->
            <div class="group">
                <div class="relative overflow-hidden bg-white rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="bg-blue-50 h-64 flex items-center justify-center">
                        <img src="https://via.placeholder.com/150" alt="Assistant Librarian" class="w-32 h-32 rounded-full object-cover border-4 border-yellow-400">
                    </div>
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-bold text-blue-800 group-hover:text-yellow-400 transition-colors duration-300">Assistant Librarian</h3>
                        <p class="text-blue-600 font-medium mb-4">Library Operations</p>
                        <div class="h-0 group-hover:h-20 overflow-hidden transition-all duration-300">
                            <p class="text-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Supporting daily library operations and ensuring smooth service delivery.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group">
                <div class="relative overflow-hidden bg-white rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <img src="{{ asset('images/alvin.jpg') }}" alt="Alvin Kris Hermosilla" class="w-full h-50 object-cover object-center">
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-bold text-blue-800 group-hover:text-yellow-400 transition-colors duration-300">Alvin Kris Hermosilla</h3>
                        <p class="text-blue-600 font-medium mb-4">Digital Resources Manager</p>
                        <div class="h-0 group-hover:h-20 overflow-hidden transition-all duration-300">
                            <p class="text-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Managing our digital resources and technological infrastructure.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group">
                <div class="relative overflow-hidden bg-white rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="bg-blue-50 h-64 flex items-center justify-center">
                        <img src="https://via.placeholder.com/150" alt="Maria Clara Santos" class="w-32 h-32 rounded-full object-cover border-4 border-yellow-400">
                    </div>
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-bold text-blue-800 group-hover:text-yellow-400 transition-colors duration-300">Maria Clara Santos</h3>
                        <p class="text-blue-600 font-medium mb-4">Cataloging Specialist</p>
                        <div class="h-0 group-hover:h-20 overflow-hidden transition-all duration-300">
                            <p class="text-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Organizing and maintaining our extensive collection catalog.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group">
                <div class="relative overflow-hidden bg-white rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="bg-blue-50 h-64 flex items-center justify-center">
                        <img src="https://via.placeholder.com/150" alt="John Michael Cruz" class="w-32 h-32 rounded-full object-cover border-4 border-yellow-400">
                    </div>
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-bold text-blue-800 group-hover:text-yellow-400 transition-colors duration-300">John Michael Cruz</h3>
                        <p class="text-blue-600 font-medium mb-4">Systems Librarian</p>
                        <div class="h-0 group-hover:h-20 overflow-hidden transition-all duration-300">
                            <p class="text-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">Maintaining and improving our library systems and databases.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</section>
<!-- Contact Section -->
<section id="contact" class="py-16 bg-blue-800">
    <div class="container mx-auto px-6">
        <h3 class="text-4xl font-bold mb-10 text-center text-white">Contact Us</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            
            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition duration-300">
                <h4 class="text-2xl font-semibold mb-6 text-blue-700">Send us a message</h4>
                <form class="space-y-6">
                    <div class="relative group">
                        <label class="block text-gray-700 font-medium mb-2">Name</label>
                        <input type="text" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                    </div>
                    <div class="relative group">
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                    </div>
                    <div class="relative group">
                        <label class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea rows="4" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"></textarea>
                    </div>
                    <button class="w-full py-3 bg-blue-700 text-white rounded-lg hover:bg-blue-600 transform hover:scale-105 transition duration-300">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
<div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition duration-300">
    <h4 class="text-2xl font-semibold mb-6 text-blue-700">Library Information</h4>
    <div class="space-y-6">
        <div class="flex items-start space-x-4">
            <div class="h-12 w-12 bg-blue-500 text-white flex items-center justify-center rounded-full shadow-md transform hover:scale-110 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h5 class="font-semibold text-black">Address</h5>
                <p class="text-black-200">CTU Danao Campus, Sabang, Danao City, Cebu</p>
            </div>
        </div>
        <div class="flex items-start space-x-4">
            <div class="h-12 w-12 bg-blue-500 text-white flex items-center justify-center rounded-full shadow-md transform hover:scale-110 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h5 class="font-semibold text-black">Email</h5>
                <p class="text-black-200">library@ctu.edu.ph</p>
            </div>
        </div>
        <div class="flex items-start space-x-4">
            <div class="h-12 w-12 bg-blue-500 text-white flex items-center justify-center rounded-full shadow-md transform hover:scale-110 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h5 class="font-semibold text-black">Library Hours</h5>
                <p class="text-black-200">Monday - Friday: 8:00 AM - 5:00 PM</p>
                <p class="text-black-200">Saturday: 8:00 AM - 12:00 PM</p>
            </div>
        </div>
        <!-- New Facebook Section -->
        <div class="flex items-start space-x-4">
            <div class="h-12 w-12 bg-blue-500 text-white flex items-center justify-center rounded-full shadow-md transform hover:scale-110 transition duration-300">
                <!-- Facebook Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 3h-13A1.5 1.5 0 004 4.5v15A1.5 1.5 0 005.5 21h13A1.5 1.5 0 0020 19.5v-15A1.5 1.5 0 0018.5 3zM18 7h-2V6c0-.553.447-1 1-1h1V3h-2c-1.104 0-2 .896-2 2v1h-2v2h2v7h2V9h2l1-2h-3V6c0-.553.447-1 1-1h2v-2h-2z" />
                </svg>
            </div>
            <div>
                <h5 class="font-semibold text-black">Follow us on Facebook</h5>
                <p class="text-black-200"><a href="https://www.facebook.com/yourlibrary" class="text-blue-500 hover:underline" target="_blank">facebook.com/yourlibrary</a></p>
            </div>
        </div>
    </div>
</div>

</section>



    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 CTU Danao Library System. All rights reserved.</p>
            <p class="mt-4">
                <a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a> |
                <a href="#" class="text-gray-400 hover:text-white">Terms of Service</a>
            </p>
        </div>
    </footer>

</body>
</html>
</body>
</html>