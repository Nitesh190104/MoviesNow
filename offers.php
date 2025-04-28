<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'showai');

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize user data
$user_id = 1;
$user_points = 2000;
$user_tier = 'Platinum';

// Get user data from database
$user_query = $conn->prepare("SELECT points, tier FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
    $user_points = $user_data['points'];
    $user_tier = $user_data['tier'];
}

// Define tier thresholds
$tiers = [
    'Bronze' => ['min' => 0, 'next' => 'Silver', 'points_needed' => 1000],
    'Silver' => ['min' => 1000, 'next' => 'Gold', 'points_needed' => 2000],
    'Gold' => ['min' => 2000, 'next' => 'Platinum', 'points_needed' => 3500],
    'Platinum' => ['min' => 3500, 'next' => 'Diamond', 'points_needed' => 5000],
    'Diamond' => ['min' => 5000, 'next' => null, 'points_needed' => 0]
];

// Handle point redemption
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['redeem_points'])) {
        $offer_id = $_POST['offer_id'];
        $points_required = $_POST['points_required'];
        
        if ($user_points >= $points_required) {
            $new_points = $user_points - $points_required;
            $update_query = $conn->prepare("UPDATE users SET points = ? WHERE id = ?");
            $update_query->bind_param("ii", $new_points, $user_id);
            $update_query->execute();
            
            $redemption_query = $conn->prepare("INSERT INTO redemptions (user_id, offer_id) VALUES (?, ?)");
            $redemption_query->bind_param("ii", $user_id, $offer_id);
            $redemption_query->execute();
            
            $user_points = $new_points;
            $_SESSION['success'] = "Offer redeemed successfully!";
        } else {
            $_SESSION['error'] = "You don't have enough points for this offer";
        }
        
        header("Location: offers.php");
        exit();
    }
}

// Define all 9 offers with their corresponding images
$offers = [
    [
        'title' => 'Flat 15% Cashback',
        'description' => 'Get 15% cashback on bookings',
        'points_required' => 500,
        'valid_until' => '2025-12-31',
        'offer_type' => 'CASHBACK OFFER',
        'discount_details' => 'Flat 15% cashback on all movie bookings',
        'image' => 'img/Flat15.png'
    ],
    [
        'title' => 'Buy 1 Get 1 Free',
        'description' => 'On all movies',
        'points_required' => 700,
        'valid_until' => '2025-11-30',
        'offer_type' => 'PACKAGE OFFER',
        'discount_details' => 'Buy one ticket and get another free for any movie',
        'image' => 'img/Buy1Get1.png'
    ],
    [
        'title' => 'Flat ₹100 Off',
        'description' => 'On movie tickets',
        'points_required' => 300,
        'valid_until' => '2025-10-31',
        'offer_type' => 'DISCOUNT OFFER',
        'discount_details' => 'Flat ₹100 discount on any movie ticket',
        'image' => 'img/Flat100.png'
    ],
    [
        'title' => 'Premium Movie Package',
        'description' => '2 tickets + large popcorn',
        'points_required' => 800,
        'valid_until' => '2025-12-15',
        'offer_type' => 'PACKAGE OFFER',
        'discount_details' => 'Perfect for date night! Includes 2 tickets and large popcorn',
        'image' => 'img/Popcorn.png'
    ],
    [
        'title' => 'Weekday Special',
        'description' => 'On movie tickets',
        'points_required' => 350,
        'valid_until' => '2025-11-15',
        'offer_type' => 'TIME OFFER',
        'discount_details' => 'Special discounts on weekday movie tickets',
        'image' => 'img/weekday.png'
    ],
    [
        'title' => 'Family Package',
        'description' => '4 tickets + combo meal',
        'points_required' => 1200,
        'valid_until' => '2025-12-25',
        'offer_type' => 'PACKAGE OFFER',
        'discount_details' => 'Perfect family outing! 4 tickets + large combo meal',
        'image' => 'img/FamilyPackage.png'
    ],
    [
        'title' => 'Student Discount',
        'description' => 'Special discount for students',
        'points_required' => 250,
        'valid_until' => '2025-12-31',
        'offer_type' => 'DISCOUNT OFFER',
        'discount_details' => '15% discount for students with valid ID',
        'image' => 'img/studentdiscount.png'
    ],
    [
        'title' => '3D Movie Discount',
        'description' => '20% off on 3D movies',
        'points_required' => 400,
        'valid_until' => '2025-11-30',
        'offer_type' => 'DISCOUNT OFFER',
        'discount_details' => 'Enjoy 20% off on all 3D movie bookings',
        'image' => 'img/3Dmovie.png'
    ],
    [
        'title' => 'Early Bird Special',
        'description' => 'Discount on morning shows',
        'points_required' => 300,
        'valid_until' => '2025-10-15',
        'offer_type' => 'TIME OFFER',
        'discount_details' => 'Get 25% off on shows before 12pm',
        'image' => 'img/EarlyBird.png'
    ]
];

// Insert offers into database if they don't exist
foreach ($offers as $key => $offer) {
    $check_query = $conn->prepare("SELECT id FROM offers WHERE title = ?");
    $check_query->bind_param("s", $offer['title']);
    $check_query->execute();
    $check_result = $check_query->get_result();
    
    if ($check_result->num_rows == 0) {
        $insert_query = $conn->prepare("INSERT INTO offers (title, description, points_required, valid_until, offer_type, discount_details) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_query->bind_param("ssisss", 
            $offer['title'],
            $offer['description'],
            $offer['points_required'],
            $offer['valid_until'],
            $offer['offer_type'],
            $offer['discount_details']
        );
        $insert_query->execute();
        $offers[$key]['id'] = $conn->insert_id;
    } else {
        $row = $check_result->fetch_assoc();
        $offers[$key]['id'] = $row['id'];
    }
}

// Calculate tier progress
$current_tier = $tiers[$user_tier];
$next_tier = $current_tier['next'];
$points_needed = $next_tier ? ($current_tier['points_needed'] - $user_points) : 0;
$progress_percentage = $next_tier ? min(100, (($user_points - $current_tier['min']) / ($current_tier['points_needed'] - $current_tier['min'])) * 100) : 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show.AI - Offers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .offer-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #9333ea;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .offer-card {
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e9d5ff;
        }
        .offer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(147, 51, 234, 0.1);
        }
        .tab-button {
            transition: all 0.3s ease;
        }
        .tab-button.active {
            background-color: #9333ea;
            color: white;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }
        .popup-content {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            z-index: 1001;
            animation: slideIn 0.5s, fadeOut 0.5s 2.5s;
        }
        .alert-success {
            background-color: #10b981;
        }
        .alert-error {
            background-color: #ef4444;
        }
        @keyframes slideIn {
            from { right: -100px; opacity: 0; }
            to { right: 20px; opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .progress-bar {
            height: 10px;
            border-radius: 5px;
            background-color: #e9d5ff;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, #9333ea, #a855f7);
            transition: width 0.5s ease;
        }
        .offer-image-container {
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3e8ff;
            overflow: hidden;
            position: relative;
        }
        .offer-image {
            max-height: 100%;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Display alerts -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <div class="text-2xl font-bold text-primary-600">MovieNow</div>
                <nav class="hidden md:flex space-x-7 ml-10">
                    <a href="index.php" class="bg-primary-600 text-white px-4 py-1 rounded-full text-sm font-medium hover:bg-primary-700">Movies</a>
                    <a href="events.html" class="bg-primary-600 text-white px-4 py-1 rounded-full text-sm font-medium hover:bg-primary-700">Events</a>
                </nav>
            </div>
            <div class="flex items-center space-x-4">
                <a href="index.php" class="bg-primary-600 text-white px-4 py-1 rounded-full text-sm font-medium hover:bg-primary-700">Home</a>
            </div>
        </div>
    </header>

    <!-- Loyalty Points Banner -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-400 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-2">MovieNow Rewards</h2>
            <div class="flex justify-center items-center space-x-8 mb-4">
                <div>
                    <p class="text-sm">Your Points</p>
                    <p class="text-3xl font-bold"><span id="user-points"><?= $user_points ?></span></p>
                </div>
                <div>
                    <p class="text-sm">Your Tier</p>
                    <p class="text-3xl font-bold"><span id="user-tier"><?= $user_tier ?></span></p>
                </div>
            </div>
            <button onclick="showTierPopup()" class="bg-white text-primary-600 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition">
                Redeem Points
            </button>
        </div>
    </div>

    <!-- Offers Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex overflow-x-auto space-x-4 pb-2">
            <button class="tab-button active px-4 py-2 rounded-full whitespace-nowrap bg-primary-600 text-white">All Offers</button>
        </div>
        
        <!-- Offers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <?php foreach ($offers as $offer): ?>
                <div class="offer-card bg-white shadow-md">
                    <div class="relative">
                        <div class="offer-image-container">
                            <img src="<?= $offer['image'] ?>" alt="<?= $offer['title'] ?>" class="offer-image">
                        </div>
                        <div class="offer-tag"><?= $offer['offer_type'] ?></div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg"><?= $offer['title'] ?></h3>
                                <p class="text-sm text-gray-600"><?= $offer['description'] ?></p>
                            </div>
                        </div>
                        <p class="text-sm mb-4 text-gray-700"><?= $offer['discount_details'] ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">Valid till <?= date('d M Y', strtotime($offer['valid_until'])) ?></span>
                            <button onclick="showRedeemPopup(<?= $offer['points_required'] ?>, '<?= $offer['title'] ?>', <?= $offer['id'] ?? 0 ?>)" 
                                class="bg-primary-600 text-white px-4 py-1 rounded text-sm font-medium hover:bg-primary-700 transition">
                                Redeem
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Redeem Popup -->
    <div id="redeemPopup" class="popup-overlay">
        <div class="popup-content">
            <form method="POST" action="offers.php">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold" id="popupOfferTitle">Offer Title</h3>
                    <button type="button" onclick="closeRedeemPopup()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Your Points:</span>
                        <span class="font-bold" id="popupUserPoints"><?= $user_points ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Points Required:</span>
                        <span class="font-bold" id="popupPointsRequired">500</span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-2 flex justify-between">
                        <span class="text-gray-600">Points After Redemption:</span>
                        <span class="font-bold" id="popupPointsAfter"><?= $user_points - 500 ?></span>
                    </div>
                    
                    <input type="hidden" name="offer_id" id="popupOfferId">
                    <input type="hidden" name="points_required" id="popupPointsRequiredInput">
                    <input type="hidden" name="redeem_points" value="1">
                    
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-primary-600 text-white py-2 rounded font-medium hover:bg-primary-700 transition">
                            Confirm Redemption
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tier Progress Popup -->
    <div id="tierPopup" class="popup-overlay">
        <div class="popup-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Your Tier Progress</h3>
                <button type="button" onclick="closeTierPopup()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary-600 mb-1"><?= $user_tier ?></div>
                    <div class="text-sm text-gray-600">Current Tier</div>
                </div>
                
                <?php if ($next_tier): ?>
                    <div class="text-center">
                        <div class="text-lg font-bold mb-1"><?= $points_needed ?> points to <?= $next_tier ?></div>
                        <div class="text-sm text-gray-600">Next Tier: <?= $next_tier ?></div>
                    </div>
                    
                    <div class="pt-2">
                        <div class="flex justify-between text-sm mb-1">
                            <span><?= $current_tier['min'] ?> pts</span>
                            <span><?= $current_tier['points_needed'] ?> pts</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= $progress_percentage ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="text-center text-sm text-gray-600 mt-2">
                        You have <?= $user_points ?> points (<?= round($progress_percentage) ?>% to next tier)
                    </div>
                <?php else: ?>
                    <div class="text-center text-lg font-bold text-primary-600">
                        You've reached the highest tier!
                    </div>
                <?php endif; ?>
                
                <div class="pt-4">
                    <button onclick="closeTierPopup()" class="w-full bg-primary-600 text-white py-2 rounded font-medium hover:bg-primary-700 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Setup tab buttons
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    // Filter offers based on tab (simplified demo)
                    const offerType = tab.textContent.trim().toUpperCase().replace(' OFFERS', '');
                    document.querySelectorAll('.offer-card').forEach(card => {
                        if (offerType === 'ALL' || card.querySelector('.offer-tag').textContent.includes(offerType)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
            
            // Auto-hide alerts after animation
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 3000);
        });
        
        // Show redeem popup
        function showRedeemPopup(pointsRequired, offerTitle, offerId) {
            const currentUserPoints = <?= $user_points ?>;
            
            // Update popup content
            document.getElementById('popupOfferTitle').textContent = offerTitle;
            document.getElementById('popupUserPoints').textContent = currentUserPoints;
            document.getElementById('popupPointsRequired').textContent = pointsRequired;
            document.getElementById('popupPointsAfter').textContent = currentUserPoints - pointsRequired;
            document.getElementById('popupOfferId').value = offerId;
            document.getElementById('popupPointsRequiredInput').value = pointsRequired;
            
            // Show popup
            document.getElementById('redeemPopup').style.display = 'flex';
        }
        
        // Close redeem popup
        function closeRedeemPopup() {
            document.getElementById('redeemPopup').style.display = 'none';
        }
        
        // Show tier popup
        function showTierPopup() {
            document.getElementById('tierPopup').style.display = 'flex';
        }
        
        // Close tier popup
        function closeTierPopup() {
            document.getElementById('tierPopup').style.display = 'none';
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>