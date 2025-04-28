-- Drop and recreate the database
DROP DATABASE IF EXISTS showai;
CREATE DATABASE showai;
USE showai;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    points INT DEFAULT 0,
    tier VARCHAR(20) DEFAULT 'Bronze'
);

-- Create offers table
CREATE TABLE IF NOT EXISTS offers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    points_required INT NOT NULL,
    valid_until DATE NOT NULL,
    offer_type VARCHAR(50) NOT NULL,
    discount_details TEXT
);

-- Create redemptions table
CREATE TABLE IF NOT EXISTS redemptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    offer_id INT NOT NULL,
    redeemed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (offer_id) REFERENCES offers(id)
);

-- Insert a default user
INSERT INTO users (id, points, tier) VALUES (1, 1500, 'Platinum');

-- Insert offers
INSERT INTO offers (title, description, points_required, valid_until, offer_type, discount_details) VALUES
('Flat 15% Cashback', 'Get 15% cashback on bookings', 500, '2025-12-31', 'CASHBACK OFFER', 'Flat 15% cashback on all movie bookings'),
('Buy 1 Get 1 Free', 'On all movies', 700, '2025-11-30', 'PACKAGE OFFER', 'Buy one ticket and get another free for any movie'),
('Flat ₹100 Off', 'On movie tickets', 300, '2025-10-31', 'DISCOUNT OFFER', 'Flat ₹100 discount on any movie ticket'),
('Premium Movie Package', '2 tickets + large popcorn', 800, '2025-12-15', 'PACKAGE OFFER', 'Perfect for date night! Includes 2 tickets and large popcorn'),
('Weekday Special', 'On movie tickets', 350, '2025-11-15', 'TIME OFFER', 'Special discounts on weekday movie tickets'),
('Family Package', '4 tickets + combo meal', 1200, '2025-12-25', 'PACKAGE OFFER', 'Perfect family outing! 4 tickets + large combo meal'),
('Student Discount', 'Special discount for students', 250, '2025-12-31', 'DISCOUNT OFFER', '15% discount for students with valid ID'),
('3D Movie Discount', '20% off on 3D movies', 400, '2025-11-30', 'DISCOUNT OFFER', 'Enjoy 20% off on all 3D movie bookings'),
('Early Bird Special', 'Discount on morning shows', 300, '2025-10-15', 'TIME OFFER', 'Get 25% off on shows before 12pm'); 