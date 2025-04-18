<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure session variables exist before accessing them
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Not Provided';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
  .animate-fade-in {
    animation: fadeIn 0.8s ease-in-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

   
    
    <title>Dashboard</title>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <!-- ✅ Improved Professional Header -->
    <header class="w-full bg-white shadow-md px-6 py-4 flex items-center justify-between">
        <div class="text-3xl font-extrabold bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-400 bg-clip-text text-transparent tracking-wide">MoviesNow</div>
        
        <nav class="hidden md:flex gap-8">
            <a href="index.php" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Home</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">About</a>
            <a href="#" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Services</a>
            <a href="contact.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Contact</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Events</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Gallery</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Resources</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">News</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Blog</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Careers</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Community</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">Feedback</a>
            <a href="About.html" class="text-gray-700 hover:text-blue-500 transition-all duration-300 font-medium">FAQ</a>
           
        </nav>

        <!-- Logout Button -->
        <a href="logout.php" class="px-5 py-2 bg-pink-600 hover:bg-red-700 text-white rounded-lg flex items-center shadow-lg transition-all font-semibold">
            <i class="fas fa-sign-out-alt mr-2"></i>
            Logout
        </a>
    </header>

    <div class="mt-3"></div>

    <section class="flex flex-col items-center text-center py-16 bg-gradient-to-br from-indigo-500   to-cyan-400 text-white shadow-lg">
        <h1 class="text-3xl font-extrabold">Dashboard</h1>
        <p class="mt-2 text-lg">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
        
    
        <div class="relative mt-4">
            <img id="profileImage" src="img/ambuj5.png" alt="User Avatar" class="w-32 h-32 rounded-full border-4 border-white shadow-lg cursor-pointer">
            <input type="file" id="fileInput" class="hidden" accept="image/*">
        </div>

    
        <div class="mt-4 text-lg">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p class="mt-2"><strong>Email:</strong> <span contenteditable="true" id="email"><?php echo htmlspecialchars($email); ?></span></p>
        </div><br><br>
        <a href="offers.php" target="_blank"
   class="bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-xl text-center text-lg font-semibold shadow-md block w-64 mx-auto mb-3">
  Loyalty Program
  

</a>
    </section>
    <div class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-lg border-2 border-green-500 animate-fade-in">
  <h2 class="text-2xl font-bold text-green-600 text-center mb-6">🎫 Your Ticket is Confirmed</h2>

  <p class="text-gray-800 mb-2"><strong>Movie Name:</strong> MUFASA THE LION KING</p>
  <p class="text-gray-800 mb-2"><strong>Show Time:</strong> 09:30 AM</p>
  <p class="text-gray-800 mb-2"><strong>Ticket Price:</strong> ₹289</p>
  <p class="text-gray-800 mb-2"><strong>Email:</strong> Abhishek123@</p>
  <p class="text-gray-800 mb-4"><strong>Phone:</strong> 8979897900</p>

  <img class="mx-auto   rounded-lg mb-4" 
       src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=MUFASA123456" 
       alt="QR Code" width="180" height="180" />

  <p class="text-center text-sm text-gray-600">Show this QR code at the cinema entrance</p>
</div>

    
    

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dashboardButton = document.getElementById("dashboardToggle");
            const body = document.body;

            // Apply saved theme
            if (localStorage.getItem("theme") === "dark") {
                body.classList.add("dark");
            }

            // Toggle mode
            dashboardButton.addEventListener("click", function () {
                body.classList.toggle("dark");

                // Save mode globally
                if (body.classList.contains("dark")) {
                    localStorage.setItem("theme", "dark");
                } else {
                    localStorage.setItem("theme", "light");
                }
            });
        });
        document.getElementById("profileImage").addEventListener("click", function() {
            document.getElementById("fileInput").click();
        });
        
        document.getElementById("fileInput").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("profileImage").src = e.target.result;
                    document.getElementById("deleteImage").classList.remove("opacity-0");
                };
                reader.readAsDataURL(file);
            }
        });
        
        document.getElementById("deleteImage").addEventListener("click", function() {
            document.getElementById("profileImage").src = "img/default.png";
            this.classList.add("opacity-0");
        });
    </script>
</body>
</html>
