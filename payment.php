<?php
require('vendor/autoload.php'); // Composer autoloader

use Razorpay\Api\Api;

// Razorpay API credentials
$api_key = 'rzp_test_Oo31Muy4R7xzyI';
$api_secret = 'Gu7lz8SB25XQXlofAkrzKtVs';

$api = new Api($api_key, $api_secret);

// Get seats and total amount from URL query parameters
$seats = isset($_GET['seats']) ? $_GET['seats'] : 'Not specified';
$totalAmount = isset($_GET['total']) ? (int) $_GET['total'] : 100; // Default ₹1.00

// Create Razorpay Order
$orderData = [
    'receipt' => 'receipt_' . uniqid(),
    'amount' => $totalAmount, // in paise
    'currency' => 'INR',
    'payment_capture' => 1
];

$order = $api->order->create($orderData);
$order_id = $order['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pay with UPI - Razorpay</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<div class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-xl border border-gray-200 mt-10">
  <h2 class="text-2xl font-semibold text-green-600 text-center mb-4">
    Pay ₹<?php echo $totalAmount / 100; ?> using UPI
  </h2>

  <p class="text-gray-700 text-center mb-6">
    <strong>Booked Seats:</strong> <?php echo htmlspecialchars($seats); ?>
  </p>

  <div class="flex justify-center">
    <button id="rzp-button" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
      Pay Now
    </button>
  </div>
</div>


    <script>
    var options = {
        "key": "<?php echo $api_key; ?>",
        "amount": "<?php echo $totalAmount; ?>", // Amount in paise
        "currency": "INR",
        "name": "Ambuj's Store",
        "description": "Seat Booking Payment for seats: <?php echo $seats; ?>",
        "order_id": "<?php echo $order_id; ?>",
        "handler": function (response){
            alert("✅ Payment Successful!\nPayment ID: " + response.razorpay_payment_id);
            // Optional: Redirect or send payment ID to server for verification
        },
        "prefill": {
            "name": "Ambuj Kumar",
            "email": "ambuj@example.com",
            "contact": "9999999999"
        },
        "theme": {
            "color": "#3399cc"
        },
        "method": {
            "upi": true,
            "card": false,
            "netbanking": false,
            "wallet": false
        }
    };

    var rzp = new Razorpay(options);
    document.getElementById('rzp-button').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
    </script>
</body>
</html>
