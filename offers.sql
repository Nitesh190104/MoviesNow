CREATE DATABASE showai;
USE showai;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    points INT DEFAULT 1200,
    tier VARCHAR(20) DEFAULT 'Gold',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Offers table
CREATE TABLE offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    points_required INT NOT NULL,
    valid_until DATE NOT NULL,
    offer_type VARCHAR(20) NOT NULL,
    discount_details TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Redemptions table
CREATE TABLE redemptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    offer_id INT NOT NULL,
    redeemed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (offer_id) REFERENCES offers(id)
);

-- Insert sample user
INSERT INTO users (username, password, email) VALUES 
('john_doe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'john@example.com');

-- Insert sample offers
INSERT INTO offers (title, description, points_required, valid_until, offer_type, discount_details) VALUES
('Flat 15% Cashback', 'On all movie tickets', 500, '2025-06-30', 'BANK OFFER', 'Use code HDFC15 and get 15% cashback up to ₹150'),
('Buy 1 Get 1 Free', 'On weekend shows', 750, '2025-07-15', 'WALLET OFFER', 'Book tickets using Paytm wallet'),
('Flat ₹100 Off', 'On min booking of ₹500', 300, '2025-08-31', 'BANK OFFER', 'When you book using ICICI Bank credit cards');


INSERT INTO offers (title, description, points_required, valid_until, offer_type, discount_details) VALUES
('Free Popcorn Combo', 'With every ticket purchase', 200, '2025-09-30', 'REWARD OFFER', 'Get a free medium popcorn and drink with any ticket purchase'),
('Weekday Special', '20% off on weekday shows', 350, '2025-10-15', 'DISCOUNT OFFER', 'Get 20% off on all weekday movie shows'),
('Family Package', 'Discount for family of 4', 600, '2025-09-15', 'PACKAGE OFFER', 'Special discount when purchasing 4 tickets together'),
('Student Discount', '25% off for students', 250, '2025-12-31', 'STUDENT OFFER', 'Valid student ID required at box office'),
('Early Bird Special', '25% off for early bookings', 150, '2025-10-31', 'EARLY BIRD OFFER', 'Book tickets 2 weeks in advance to avail this offer'),
('3D Movie Discount', 'Flat 20% off on 3D movies', 400, '2025-11-30', '3D MOVIE OFFER', 'Applicable on all 3D movie tickets'),
