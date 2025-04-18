<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']); 
$redirect_url = $is_logged_in ? "timing.html" : "login.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HOME PAGE - Show.AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Hide scrollbar for carousel */
    .carousel-track::-webkit-scrollbar { display: none; }
    .carousel-track { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes gradientWave {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    

    .hover-zoom {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-zoom:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    body {
            transition: background-color 0.3s, color 0.3s;
        }
          
  </style>
   <style>
    .slide-up {
      transform: translateY(100%);
      transition: transform 0.3s ease-in-out;
    }
    .slide-in {
      transform: translateY(0%);
    }
  </style>
  <style>
  .glass-card {
    @apply bg-white/10 backdrop-blur-lg border border-white/20 p-4 rounded-xl shadow-md transition-transform transform hover:scale-105;
  }
  .highlight {
            background-color: yellow;
        }
</style>

</head>
<body class=" bg-ghost

 font-sans
   min-h-screen text-black flex flex-col items-center justify-center">
  
  <!-- HEADER SECTION -->
  <header class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-200 shadow-lg rounded-b-xl">

    <div class="container mx-auto px-6 py-3 flex items-center justify-between">
      <!-- Logo Group -->
      <div class="flex items-center space-x-4">
        <img src="img/Movienow.png" alt="Logo" class="w-14 h-14 rounded-full border-2 border-white/20 shadow-xl hover:rotate-12 transition-transform">
        <span class="text-3xl font-extrabold bg-pink-500  bg-clip-text text-transparent">
          MoviesNow
        </span>
      </div>

      <!-- Desktop Nav -->
      <nav class="hidden lg:flex items-center space-x-8">
      <div class="flex items-center justify-center ">
    <div class="relative w-full max-w-lg group">
        <input type="search" placeholder="Search movies, events, or more...",
               class="bg-transparent border border-black/20 px-6 py-3 rounded-full text-black placeholder-black w-80 focus:outline-none focus:ring-2 focus:ring-pink-400 shadow-xl transition duration-300 pr-12"> 
        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-black hover:text-black transition duration-300">
            <i class="fas fa-search text-xl"></i>
        </button>
    </div>
</div>


        
        <div class="flex space-x-6">
        <a href="<?php echo isset($_SESSION['user_id']) ? 'index.php' : 'login.php'; ?>" class="flex items-center text-black hover:text-green-500 group">
    <i class="fas fa-home mr-2 text-pink-500 group-hover:text-green-500"></i>
    Home
</a>

<a href="<?php echo isset($_SESSION['user_id']) ? 'events.html' : 'login.php'; ?>" class="flex items-center text-black hover:text-green-500 group">
    <i class="fas fa-calendar-alt mr-2 text-pink-500 group-hover:text-green-500"></i>
    Events
</a>

          <a href="contact.html" class="flex items-center text-black hover:text-green-500 group">
            <i class="fas fa-phone mr-2 text-pink-500 group-hover:text-green-500"></i>
            Contact
          </a>
          <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'login.php'; ?>" class="flex items-center text-white/90 hover:text-white group px-4 py-2 rounded-lg transition duration-300 bg-gradient-to-r from-indigo-500 to-cyan-400 hover:from-cyan-400 hover:to-indigo-500 shadow-lg">
               <i class="fas fa-layer-group mr-2 text-pink-200 group-hover:text-white"></i>
            Dashboard
           </a>
          <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="px-6 py-2 bg-pink-500 hover:bg-pink-600 rounded-full text-white flex items-center">
              <i class="fas fa-sign-out-alt mr-2"></i>
              Logout
            </a>
          <?php else: ?>
            <div class="flex space-x-4">
              <a href="register.php" class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-cyan-400 hover:from-cyan-500 hover:to-indigo-400 rounded-full text-white flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Signup
              </a>
              <a href="login.php" class="px-6 py-2 border border-white/30 hover:border-white/50 rounded-full text-white bg-gradient-to-r from-indigo-500 to-cyan-400 hover:from-cyan-500 hover:to-indigo-400 flex  items-center">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login
              </a>
             
            </div>
          <?php endif; ?>
        </div>
      </nav>

      <!-- Mobile Menu Trigger -->
      <button class="lg:hidden text-white text-2xl">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <!-- Mobile Menu -->
  <div class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden" id="mobileMenuOverlay">
    <div class="absolute right-0 top-0 h-full w-80 bg-white/5 backdrop-blur-xl p-6 transform transition-all">
      <div class="flex justify-end mb-8">
        <button id="closeMobileMenu" class="text-white text-2xl">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <nav class="space-y-6">
        <a href="#" class="block text-white text-xl py-3 border-b border-white/10">
          <i class="fas fa-home mr-3"></i>
          Home
        </a>
        <a href="#" class="block text-white text-xl py-3 border-b border-white/10">
          <i class="fas fa-calendar-alt mr-3"></i>
          Events
        </a>
        <a href="#" class="block text-white text-xl py-3 border-b border-white/10">
          <i class="fas fa-phone mr-3"></i>
          Contact
        </a>
        <div class="pt-8 space-y-4">
          <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="block w-full text-center py-3 bg-pink-600 hover:bg-pink-700 rounded-lg text-white">
              Logout
            </a>
          <?php else: ?>
            <a href="register.php" class="block w-full text-center py-3 bg-pink-600 hover:bg-pink-700 rounded-lg text-white mb-4">
              Sign Up
            </a>
            <a href="login.php" class="block w-full text-center py-3 border border-white/30 hover:border-white/50 rounded-lg text-white">
              Login
            </a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </div>
  <!-- HEADER SECTION END -->

  <!-- MOBILE MENU (Visible on Mobile Only) -->
  <div id="mobile-menu" class="fixed top-16 left-0 w-full bg-gradient-to-r from-pink-600 via-rose-500 to-red-500 text-white md:hidden hidden z-40">
    <!-- Mobile Search Bar -->
    <div class="px-4 py-2">
      <div class="flex items-center bg-white/20 backdrop-blur-lg rounded-lg px-4 shadow-md">
        <input type="text" placeholder="Search events..." class="px-2 py-2 bg-transparent text-white placeholder-white focus:outline-none w-full" />
        <button class="ml-2 py-2 px-4 text-white font-bold rounded-md hover:bg-red-600 transition">
          🔍
        </button>
      </div>
    </div>
    <!-- Mobile Navigation Links -->
    <nav class="flex flex-col space-y-2 px-4 py-2">
      <a href="#" class="block text-white hover:text-yellow-400 transition">Home</a>
      <a href="#" class="block text-white hover:text-yellow-400 transition">Events</a>
      <a href="#" class="block text-white hover:text-yellow-400 transition">Contact</a>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="block bg-yellow-400 text-black font-semibold text-center px-5 py-2 rounded-lg shadow-md hover:bg-yellow-500 transition">
          Logout
        </a>
      <?php else: ?>
        <a href="register.php" class="block bg-yellow-400 text-black font-semibold text-center px-5 py-2 rounded-lg shadow-md hover:bg-yellow-500 transition">
          Signup
        </a>
        <a href="login.php" class="block bg-yellow-400 text-black font-semibold text-center px-5 py-2 rounded-lg shadow-md hover:bg-yellow-500 transition">
          Login
        </a>
      <?php endif; ?>
    </nav>
  </div>
  <!-- MOBILE MENU END -->

  <!-- MAIN CONTENT (includes HERO & SLIDE sections) -->
  <main class="pt-20">
    


   <!--Hero Section-->
<section class="relative max-w-7xl mx-auto p-4">
  <div class="relative overflow-hidden rounded-lg shadow-lg group cursor-pointer">
    <a href="#">
    <img src="img/trend.png" alt="Image not found" 
     class="w-full h-96 object-cover transition-transform duration-300 group-hover:scale-105 hover:brightness-110 hover:contrast-125 hover:saturate-150 rounded-lg shadow-lg" />

      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-300"></div>
      <div class="absolute bottom-4 left-4 text-white p-2">
        <h1 class="text-xl font-bold group-hover:text-indigo-500 transition-colors duration-300">Trending Now...</h1>
        <h1 class="text-xl opacity-80 group-hover:opacity-100 transition-opacity duration-300">Mufasa </h1>
      </div>
      <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-700  to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book  Now</button>
      </div>
    </a>
  </div>
</section>
  <!-- Latest Movie SECTION -->
  <section class="py-16  text-white">
      <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-4xl font-bold uppercase tracking-widest mb-8 bg-gradient-to-r from-indigo-500 via-pink-600 to-cyan-400 rounded-full h-12">latest movies...</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
          
          
          
       <!-- Event Cards -->

<!-- Event Card 1 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
    <a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/mufasa.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 2 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/moana 2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 3 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/thewildrobot.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 4 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/sanam.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 5 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/pushpa2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 6 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/bb3.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 7 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/kingdom.jpg" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 8 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/workingman.webp" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

          <!-- Event Card 1 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
    <a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/mufasa.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 2 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/moana 2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 3 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/thewildrobot.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 4 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/sanam.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 5 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/pushpa2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 6 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/bb3.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 7 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/kingdom.jpg" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 8 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/workingman.webp" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>  
<!-- Event Card 1 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
    <a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/mufasa.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 2 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/moana 2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 3 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/thewildrobot.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 4 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/sanam.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 5 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/pushpa2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 6 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/bb3.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 7 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/kingdom.jpg" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 8 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/workingman.webp" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>  
      
        
      </div>
    </section>
    <!-- UPCOMING EVENTS SECTION END-->
     <!-- QUOTE SECTION -->
    <section class="py-12 flex justify-center  items-center text-white">
      <div class="max-w-3xl  mx-auto p-8 rounded-xl shadow-xl  bg- border border-gray-200  hover:scale-105 border-white/20 text-center transition transform duration-300">
          <h2 class="text-2xl font-bold tracking-wide italic bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-500 rounded-lg p-2">
              "Your Gateway to <span>Unforgettable Experiences!</span> 🎟✨"
          </h2>
      </div>
    </section>
    <!-- QUOTE SECTION END-->
 
    
   

    

   

    <!-- UPCOMING EVENTS SECTION -->
    <section class="py-16  text-white">
      <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-4xl font-bold uppercase tracking-widest mb-8 bg-gradient-to-r from-indigo-500 via-pink-600 to-cyan-400 rounded-full h-12">Movies and Events...</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
         <!-- Event Card 1 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
    <a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/mufasa.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 2 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/moana 2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 3 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/thewildrobot.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 4 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/sanam.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 5 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/pushpa2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 6 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/bb3.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 7 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/kingdom.jpg" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 8 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/workingman.webp" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>
<!-- Event Card 1 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
    <a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/mufasa.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 2 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/moana 2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 3 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/thewildrobot.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 4 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/sanam.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 5 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/pushpa2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 6 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/bb3.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 7 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/kingdom.jpg" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 8 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/workingman.webp" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>  
<!-- Event Card 1 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
    <a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/mufasa.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 2 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/moana 2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 3 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/thewildrobot.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 4 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/sanam.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 5 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/pushpa2.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 6 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/bb3.png" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 7 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/kingdom.jpg" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>

<!-- Event Card 8 -->
<div class="relative bg-white/10 border border-white/20 rounded-lg shadow-lg hover:scale-110 transition transform duration-300 overflow-hidden group cursor-pointer">
<a href="<?= $redirect_url ?>" class="absolute inset-0 z-10"></a>
    <img src="img/workingman.webp" alt="Image not found" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button class="bg-gradient-to-r from-indigo-500 to-cyan-400 text-black px-4 py-2 rounded-full font-semibold shadow-lg hover:bg-yellow-500 transition-colors duration-300">Book Now</button>
    </div>
</div>  
      </div>
    </section>
    <!-- ONGOING EVENTS SECTION -->

   <!-- COMING SOON SECTION -->
<section class="py-20 text-black">
  <div class="max-w-6xl mx-auto text-center px-6">
    <h2 class="text-5xl font-extrabold uppercase tracking-widest mb-12 bg-gradient-to-br from-cyan-400 to-green-600 backdrop-blur-md py-3 px-6 inline-block rounded-full shadow-lg animate-pulse">
      Coming Soon...
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
      <!-- Card Template -->
      <div class="space-y-6 bg-white/10 border border-white/20 rounded-lg shadow-lg p-6 hover:scale-105 transition transform duration-300">
        <h3 class="text-3xl font-semibold text-yellow-500">🎭 Entertainment Events</h3>
        <div class="space-y-4">
          <div class="glass-card">✔️ Concerts & Music Festivals</div>
          <div class="glass-card">✔️ Stand-up Comedy Shows</div>
          <div class="glass-card">✔️ Theater & Live Performances</div>
          <div class="glass-card">✔️ Movie Premieres & Screenings</div>
        </div>
      </div>

      <div class="space-y-6 bg-white/10 border border-white/20 rounded-lg shadow-lg p-6 hover:scale-105 transition transform duration-300">
        <h3 class="text-3xl font-semibold text-green-500">🏆 Sports Events</h3>
        <div class="space-y-4">
          <div class="glass-card">✔️ Football, Cricket, Basketball Matches</div>
          <div class="glass-card">✔️ Marathons & Fitness Challenges</div>
          <div class="glass-card">✔️ Esports & Gaming Tournaments</div>
          <div class="glass-card">✔️ Wrestling, MMA, and Boxing Fights</div>
        </div>
      </div>

      <div class="space-y-6 bg-white/10 border border-white/20 rounded-lg shadow-lg p-6 hover:scale-105 transition transform duration-300">
        <h3 class="text-3xl font-semibold text-blue-500">🎓 Educational & Career Events</h3>
        <div class="space-y-4">
          <div class="glass-card">✔️ Tech Conferences & Seminars</div>
          <div class="glass-card">✔️ Business & Startup Meetups</div>
          <div class="glass-card">✔️ Coding Hackathons & Workshops</div>
          <div class="glass-card">✔️ College Fests & Competitions</div>
        </div>
      </div>

      <div class="space-y-6 bg-white/10 border border-white/20 rounded-lg shadow-lg p-6 hover:scale-105 transition transform duration-300 ">
        <h3 class="text-3xl font-semibold text-red-500">🌍 Community & Cultural Events</h3>
        <div class="space-y-4">
          <div class="glass-card">✔️ Food & Drink Festivals</div>
          <div class="glass-card">✔️ Cultural & Traditional Celebrations</div>
          <div class="glass-card">✔️ Fashion Shows & Art Exhibitions</div>
          <div class="glass-card">✔️ Charity & Fundraising Events</div>
        </div>
      </div>

      <div class="space-y-6 bg-white/10 border border-white/20 rounded-lg shadow-lg p-6 hover:scale-105 transition transform duration-300">
        <h3 class="text-3xl font-semibold text-purple-500">🏕 Travel & Adventure Events</h3>
        <div class="space-y-4">
          <div class="glass-card">✔️ Trekking & Camping Trips</div>
          <div class="glass-card">✔️ Wildlife Safari & Road Trips</div>
          <div class="glass-card">✔️ Beach & Yacht Parties</div>
          <div class="glass-card">✔️ Adventure Sports (Skydiving, Bungee Jumping)</div>
        </div>
      </div>

      <div class="space-y-6 bg-white/10 border border-white/20 rounded-lg shadow-lg p-6 hover:scale-105 transition transform duration-300">
        <h3 class="text-3xl font-semibold text-orange-500">🔥 Special & Trending Events</h3>
        <div class="space-y-4">
          <div class="glass-card">✔️ New Year & Seasonal Parties</div>
          <div class="glass-card">✔️ Product Launches & Tech Expos</div>
          <div class="glass-card">✔️ Celebrity Meet & Greets</div>
          <div class="glass-card">✔️ Book Signings & Fan Conventions</div>
        </div>
      </div>
    </div>
  </div>
</section>




    <!-- FOOTER SECTION -->
    <footer class="bg-gradient-to-b from-indigo-500 to-cyan-400 text-black py-10">
      <div class="container mx-auto px-6 grid md:grid-cols-3 gap-8 text-center md:text-left">
        <!-- About Section -->
        <div>
          <h3 class="text-xl font-bold text-black">About Us</h3>
          <p class="text-black mt-2 text-sm">
            Show.ai is your go-to platform for booking tickets to the best movies, concerts, and events.
            Experience seamless booking and exclusive deals!
          </p>
        </div>
        <!-- Quick Links -->
        <div>
          <h3 class="text-xl font-bold text-yellow-400">Quick Links</h3>
          <ul class="mt-2 space-y-2">
            <li><a href="#" class="text-black hover:text-yellow-400 transition">Home</a></li>
            <li><a href="#" class="text-black hover:text-yellow-400 transition">Events</a></li>
            <li><a href="contact.html" class="text-black-300 hover:text-yellow-400 transition">Contact</a></li>
            <li><a href="#" class="text-black-300 hover:text-yellow-400 transition">Privacy Policy</a></li>
          </ul>
        </div>
        <!-- Contact Section -->
        <div>
          <h3 class="text-xl font-bold text-yellow-400">Contact Us</h3>
          <p class="text-black mt-2 text-sm">
            📍 Mirzapur, India <br>
            📞 +91 9369572534 <br>
            ✉ ambuj20maurya@gmail.com
          </p>
        </div>
      </div>
      <div class="mt-10 text-center border-t border-gray-700 pt-4">
        <p class="text-sm text-black">&copy; 2025 SHOW.AI. All rights reserved.</p>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="#" class="text-black hover:text-yellow-500 transition">Facebook</a>
          <a href="#" class="text-black hover:text-yellow-500 transition">Twitter</a>
          <a href="#" class="text-black hover:text-yellow-500 transition">Instagram</a>
        </div>
      </div>
    </footer>
    <!--FOOTER SECTION END-->
    <!-- Chatbot section start here-->

    <!-- Chat Toggle Button -->
<button id="chat-toggle" class="fixed bottom-5 right-5 bg-gradient-to-r from-indigo-500  to-cyan-400 hover:from-cyan-400 hover:to-indigo-500  ring-4 ring-white ring-opacity-60   text-black px-4 py-2 rounded-full shadow-lg z-50">
    💬 SHOW.AI
</button>


 <!-- Chatbot Window -->
<div id="chat-container" class="hidden fixed bottom-20 right-5 w-80 h-[500px] bg-white rounded-lg shadow-xl flex flex-col z-40 border border-gray-300">
  
  <!-- Header -->
  <div class="relative bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-400 text-black text-center py-3 rounded-lg font-semibold">
    🤖 Assistant
    <button id="close-chat" class="absolute right-3 top-1 text-black text-xl font-bold hover:text-red-600">&times;</button>
  </div>

  <!-- Messages -->
  <div id="chatbox" class="flex-1 p-3 overflow-y-auto bg-gray-100 space-y-2"></div>

  <!-- Input -->
  <div class="flex items-center border-t border-gray-300 p-2">
    <input type="text" id="user_input" placeholder="Type a message..." class="flex-1 p-2 border border-indigo-300 text-black rounded-md text-sm" />
    <button id="mic_btn" class="ml-2 px-4 py-1 bg-gradient-to-r from-indigo-500 to-pink-500 text-white rounded-lg hover:bg-green-600">
      🎤
    </button>
    <button id="send_btn" class="ml-2 bg-green-600 hover:bg-blue-600 text-black px-3 py-1 rounded-md text-sm">Send</button>
  </div>
</div>

<script>
  // Hide chat when "X" is clicked
  document.getElementById("close-chat").addEventListener("click", function () {
    document.getElementById("chat-container").classList.add("hidden");
  });
</script>

  <!--Chatbot box-->


<script>
// Toggle Chat Visibility
document.getElementById("chat-toggle").addEventListener("click", () => {
  const chatBox = document.getElementById("chat-container");
  chatBox.classList.toggle("hidden");
});

// Send Message
function sendMessage() {
  const input = document.getElementById("user_input");
  const userInput = input.value.trim();
  const chatbox = document.getElementById("chatbox");

  if (!userInput) return;

  // Add user message
  chatbox.innerHTML += `<div class="text-right"><div class="bg-blue-500 text-white px-3 py-2 rounded-lg inline-block">${userInput}</div></div>`;
  input.value = "";

  // Fetch response from Flask
  fetch(`http://localhost:5000/get?msg=${encodeURIComponent(userInput)}`)
    .then(res => res.text())
    .then(data => {
      chatbox.innerHTML += `<div class="text-left"><div class="bg-gray-300 text-black px-3 py-2 rounded-lg inline-block">${data}</div></div>`;
      chatbox.scrollTop = chatbox.scrollHeight;
    });
}

// Events
document.getElementById("send_btn").addEventListener("click", sendMessage);
document.getElementById("user_input").addEventListener("keypress", e => {
  if (e.key === "Enter") sendMessage();
});
</script>
<script>
  const micBtn = document.getElementById('mic_btn');
  const userInput = document.getElementById('user_input');
  const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();

  recognition.continuous = false;
  recognition.lang = 'en-US';
  recognition.interimResults = false;

  micBtn.onclick = () => {
    recognition.start();
  };

  recognition.onresult = (event) => {
    const transcript = event.results[0][0].transcript;
    userInput.value = transcript;
  };

  recognition.onerror = (event) => {
    alert("Voice input failed: " + event.error);
  };
</script>






    <!-- Carousel Script -->
    <script>
  const carousel = document.getElementById("carousel");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");

  let cardWidth = 900 + 16;
  let currentIndex = 0;
  let direction = 1;
  let slideInterval;

  function autoSlide() {
    const totalCards = carousel.querySelectorAll(".card").length;

    if (direction === 1 && currentIndex >= totalCards - 1) {
      direction = -1;
    } else if (direction === -1 && currentIndex <= 0) {
      direction = 1;
    }

    currentIndex += direction;
    carousel.scrollTo({ left: currentIndex * cardWidth, behavior: "smooth" });
  }

  function startAutoSlide() {
    slideInterval = setInterval(autoSlide, 3000);
  }

  function stopAutoSlide() {
    clearInterval(slideInterval);
  }

  nextBtn.addEventListener("click", () => {
    stopAutoSlide();
    if (currentIndex < carousel.querySelectorAll(".card").length - 1) {
      currentIndex++;
      carousel.scrollTo({ left: currentIndex * cardWidth, behavior: "smooth" });
    }
  });

  prevBtn.addEventListener("click", () => {
    stopAutoSlide();
    if (currentIndex > 0) {
      currentIndex--;
      carousel.scrollTo({ left: currentIndex * cardWidth, behavior: "smooth" });
    }
  });

  startAutoSlide();
  carousel.addEventListener("mouseenter", stopAutoSlide);
  carousel.addEventListener("mouseleave", startAutoSlide);
</script>
<script>
    function sendMessage() {
        const userInput = document.getElementById("user_input").value.trim();
        if (!userInput) return;
    
        // Show user message
        const chatbox = document.getElementById("chatbox");
        const userMsgDiv = `<div class="text-right"><div class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg text-sm max-w-[80%]">${userInput}</div></div>`;
        chatbox.innerHTML += userMsgDiv;
        document.getElementById("user_input").value = "";
    
        // Send to Python chatbot API
        fetch(`http://localhost:5000/get?msg=${encodeURIComponent(userInput)}`)
            .then(res => res.text())
            .then(data => {
                const botMsgDiv = `<div class="text-left"><div class="inline-block bg-gray-200 text-gray-900 px-4 py-2 rounded-lg text-sm max-w-[80%]">${data}</div></div>`;
                chatbox.innerHTML += botMsgDiv;
                chatbox.scrollTop = chatbox.scrollHeight;
            });
    }
    
    // Trigger on Enter key
    document.getElementById("user_input").addEventListener("keypress", function (e) {
        if (e.key === "Enter") sendMessage();
    });
    
    // Or use a send button
    document.getElementById("send_btn").addEventListener("click", sendMessage);
   

    </script>

   
    
  
  </body>
</html>
