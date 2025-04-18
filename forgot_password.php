<?php
session_start();
require 'connection.php';

// Use your working mailer path and import
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files (use the working one from your setup)
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Check if email exists in `userr` table
    $stmt = $conn->prepare("SELECT id FROM userr WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp'] = $otp;

        $mail = new PHPMailer(true);

        try {
            // SMTP settings (based on your working setup)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ambuj20maurya@gmail.com';   // your email
            $mail->Password   = 'fzgo fcxh uhcw lidj';        // your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Mail content
            $mail->setFrom('ambuj20maurya@gmail.com', 'Show.AI');
            $mail->addAddress($email);  // to the entered email

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body    = "<p>Your OTP is: <strong>$otp</strong></p>";
            $mail->AltBody = "Your OTP is: $otp";

            $mail->send();
            header("Location: reset_password.php");
            exit();
        } catch (Exception $e) {
            $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "No account found with that email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - Show.AI</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-pink-500 via-indigo-500 to-blue-500 flex items-center justify-center min-h-screen">
  <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center text-black">Forgot Password</h2>

    <?php if (!empty($message)) : ?>
      <p class="text-center text-pink-600 mb-4"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Enter your registered email<span class="text-red-500">*</span></label>
        <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-rose-500 focus:border-rose-500" placeholder="you@example.com" />
      </div>
      <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 via-pink-500 to-cyan-400 text-white font-bold py-2 px-4 rounded transition duration-200">Send OTP</button>
    </form>
    <p class="mt-4 text-center text-gray-600">
    🧠💡 Brain just clicked? 
        <a href="login.php" class="text-rose-500 font-medium hover:underline">Log in now</a>
    </p>

  </div>
</body>
</html>
