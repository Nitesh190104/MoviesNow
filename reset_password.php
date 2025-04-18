<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_otp'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = trim($_POST['otp']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($entered_otp != $_SESSION['reset_otp']) {
        $message = "Invalid OTP. Please try again.";
    } elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $email = $_SESSION['reset_email'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE userr SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            unset($_SESSION['reset_email'], $_SESSION['reset_otp']);
            header("Location: login.php?reset=success");
            exit();
        } else {
            $message = "Error updating password. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password - Show.AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-500 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-black mb-6">Reset Your Password</h2>

    <?php if (!empty($message)) : ?>
      <p class="text-pink-600 text-center mb-4"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4">
      <div>
        <label for="otp" class="block text-sm font-medium text-gray-700">Enter OTP<span class="text-red-500">*</span></label>
        <input type="text" name="otp" id="otp" required class="mt-1 block w-full px-4 py-2 border rounded-md" placeholder="6-digit OTP" />
      </div>

      <div>
        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password<span class="text-red-500">*</span></label>
        <input type="password" name="new_password" id="new_password" required class="mt-1 block w-full px-4 py-2 border rounded-md" placeholder="********" />
      </div>

      <div>
        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password<span class="text-red-500">*</span></label>
        <input type="password" name="confirm_password" id="confirm_password" required class="mt-1 block w-full px-4 py-2 border rounded-md" placeholder="********" />
      </div>

      <div>
        <button type="submit" class="w-full bg-gradient-to-r from-pink-500 via-indigo-500 to-cyan-400 text-white font-bold py-2 px-4 rounded transition duration-200">Reset Password</button>
      </div>
    </form>
    <p class="mt-4 text-center text-gray-600">
    🧠💡 Brain just clicked? 
        <a href="login.php" class="text-rose-500 font-medium hover:underline">Log in now</a>
    </p>
  </div>
</body>
</html>
