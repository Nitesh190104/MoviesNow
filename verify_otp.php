<?php
session_start();

$message = "";

// Check session variables
if (!isset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['otp_generated_at'])) {
    header("Location: forgot_password.php");
    exit();
}

$otp_expiry_minutes = 10;
$current_time = time();
$otp_created_time = $_SESSION['otp_generated_at'];

if ($current_time - $otp_created_time > ($otp_expiry_minutes * 60)) {
    $message = "OTP has expired. Please request a new one.";
    session_unset();
    session_destroy();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = isset($_POST['otp']) ? trim($_POST['otp']) : '';
    $_SESSION['otp_attempts'] = isset($_SESSION['otp_attempts']) ? $_SESSION['otp_attempts'] : 0;
    $_SESSION['otp_attempts']++;
    

    if ($_SESSION['otp_attempts'] > 3) {
        $message = "Too many failed attempts. Please try again later.";
        session_unset();
        session_destroy();
    } elseif ($entered_otp === $_SESSION['reset_otp']) {
        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify OTP - Show.AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-500 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-black mb-6">Verify OTP</h2>

    <?php if (!empty($message)): ?>
      <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (!isset($_SESSION['otp_verified']) && empty($message) || str_contains($message, 'Invalid')): ?>
      <form method="POST" action="" class="space-y-4">
        <div>
          <label for="otp" class="block text-sm font-medium text-gray-700">Enter OTP</label>
          <input type="text" name="otp" id="otp" required maxlength="6" class="mt-1 block w-full px-4 py-2 border rounded-md" placeholder="6-digit OTP" />
        </div>
        <div>
          <button type="submit" class="w-full bg-gradient-to-r from-pink-500 via-indigo-500 to-cyan-400 text-white font-bold py-2 px-4 rounded transition duration-200">Verify OTP</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
