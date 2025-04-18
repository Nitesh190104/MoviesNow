<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, email, age, gender, password, above18, agree FROM userr WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $email, $age, $gender, $hashed_password, $above18, $agree);
                $stmt->fetch();
                
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['age'] = $age;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['above18'] = $above18;
                    $_SESSION['agree'] = $agree;

                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
            $stmt->close();
        } else {
            $error = "Database error. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Show.AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn 1s ease-in-out; }
  </style>
</head>

<body class="bg-gradient-to-r from-indigo-500 via-pink-500 to-indigo-500 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md fade-in">
    <h2 class="text-3xl font-bold text-center text-black mb-6">Login Here</h2>
    <?php if (isset($error)) { echo '<p class="text-pink-500 text-center mb-4">'.$error.'</p>'; } ?>
    <form action="login.php" method="POST" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address<span style="color: red;">*</span></label>
        <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-rose-500 focus:border-rose-500" placeholder="you@example.com" />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password<span style="color: red;">*</span></label>
        <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-rose-500 focus:border-rose-500" placeholder="********" />
        <div class="show-password mt-2">
          <input type="checkbox" id="togglePassword" onclick="togglePasswordVisibility()">
          <label for="togglePassword" class="text-gray-700">Show Password</label>
        </div>
      </div>
      <script>
        function togglePasswordVisibility() {
          const passwordInput = document.getElementById("password");
          passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        }
      </script>
      <div>
        <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-400 text-white font-bold py-2 px-4 rounded transition duration-200">Login</button>
      </div>
    </form>
    <p class="mt-4 text-center text-gray-600">
      Forgot your password? <a href="forgot_password.php" class="text-rose-500 hover:underline">Reset Here</a>
    </p>
    <p class="mt-4 text-center text-gray-600">
      Don't have an account? <a href="register.php" class="text-rose-500 hover:underline">Sign Up</a>
    </p>
  </div>
</body>
</html>
