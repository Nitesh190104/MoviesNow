<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $above18 = isset($_POST['above18']) ? 1 : 0;
    $agree = isset($_POST['agree']) ? 1 : 0;

    if (empty($username) || empty($email) || empty($password) || empty($age) || empty($gender)) {
        $error = "Please fill in all required fields.";
    } elseif ($password != $confirm_password) {
        $error = "Passwords do not match.";
    } elseif ($age < 18) {
        $error = "You must be 18 or older to register.";
    } elseif (!$above18 || !$agree) {
        $error = "You must confirm you are above 18 and accept the Terms and Conditions.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM userr WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO userr (username, email, password, age, gender, above18, agree) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssissi", $username, $email, $hashed_password, $age, $gender, $above18, $agree);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up - Ticket-Lelo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-pink-500 to-indigo-500 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
    <h2 class="text-3xl font-bold mb-6 text-center text-black">Sign Up</h2>
    <?php if(isset($error)) { echo '<p class="text-red-500 text-center mb-4">'.$error.'</p>'; } ?>
    <form action="register.php" method="POST" id="registerForm" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full p-2 border rounded-md" />
      <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded-md" />
      <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded-md" />
      <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full p-2 border rounded-md" />
      <input type="number" name="age" id="age" placeholder="Enter your age" required min="0" class="w-full p-2 border rounded-md" />
      <select name="gender" required class="w-full p-2 border rounded-md">
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
      <label class="flex items-center">
        <input type="checkbox" id="above18" name="above18" class="mr-2">
        I am above 18
      </label>
      <label class="flex items-center">
        <input type="checkbox" id="agree" name="agree" class="mr-2">
        I agree to the <a href="terms.php" class="text-blue-500 underline ml-2"> Terms and Conditions</a>
      </label>
      <button type="submit" id="registerBtn" disabled class="w-full bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-400 cursor-not-allowed text-white font-bold py-2 px-4 rounded">Register</button>
    </form>
    <p class="mt-4 text-center text-gray-600">
      Already have an account? 
      <a href="login.php" class="text-rose-500 hover:underline">Login here</a>
    </p>
  </div>

  <script>
    document.querySelectorAll('#above18, #agree').forEach(el => {
      el.addEventListener('change', function() {
        var registerBtn = document.getElementById('registerBtn');
        if (document.getElementById('above18').checked && document.getElementById('agree').checked) {
          registerBtn.disabled = false;
          registerBtn.classList.remove("cursor-not-allowed");
        } else {
          registerBtn.disabled = true;
          registerBtn.classList.add("cursor-not-allowed");
        }
      });
    });
  </script>
</body>
</html>

<?php
$conn->close();
?>
