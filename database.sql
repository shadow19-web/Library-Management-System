-- Database: libro_tech_db
-- Applied Normalization: 1NF, 2NF, 3NF
-- Updated: 2026-05-17 (Synced with Website Code)

CREATE DATABASE IF NOT EXISTS libro_tech_db;
USE libro_tech_db;

-- 1. Categories Table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Authors Table
CREATE TABLE authors (
    author_id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(255) NOT NULL UNIQUE,
    biography TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Users Table (Normalized with proper column lengths for encryption)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(255),
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    civil_status ENUM('Single', 'Married', 'Divorced', 'Widowed') NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Librarian', 'Student', 'Admin') NOT NULL,
    approval_status ENUM('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
    last_notif_view TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3.1 OTP Table
CREATE TABLE IF NOT EXISTS otp (
    otp_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    otp_expiration DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. Books Table (Synced with Librarian Dashboard requirements)
CREATE TABLE books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    isbn VARCHAR(50) NOT NULL UNIQUE,
    category VARCHAR(100),
    category_id INT,
    year_published INT,
    quantity INT DEFAULT 0,
    available_copies INT DEFAULT 0,
    status ENUM('Available', 'Out of Stock', 'Discontinued', 'Borrowed', 'Not Available') DEFAULT 'Available',
    book_image VARCHAR(255),
    description TEXT,
    added_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL,
    FOREIGN KEY (added_by) REFERENCES users(user_id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 5. Book_Authors Junction Table
CREATE TABLE book_authors (
    book_id INT,
    author_id INT,
    PRIMARY KEY (book_id, author_id),
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES authors(author_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Borrowings Table (Consolidated name used in website code)
CREATE TABLE borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT DEFAULT 1,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE DEFAULT NULL,
    status ENUM('pending', 'approved', 'borrowed', 'returned', 'overdue', 'rejected', 'Borrowed', 'Returned', 'Overdue') DEFAULT 'pending',
    fine_amount DECIMAL(10, 2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7. Notifications Table
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 8. System Settings Table
CREATE TABLE IF NOT EXISTS system_settings (
    setting_id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Initial Seed Data
INSERT INTO system_settings (setting_key, setting_value) VALUES 
('library_name', 'LibroTech'),
('max_borrow_days', '7'),
('fine_per_day', '5.00'),
('contact_email', 'support@librotech.com');

-- Sample Admin Account (Password: admin123)
-- Note: In real setup, passwords should be properly hashed using password_hash()
INSERT INTO users (first_name, last_name, email, phone_number, gender, civil_status, username, password, role, approval_status) 
VALUES ('System', 'Admin', 'admin@librotech.com', '09123456789', 'Male', 'Single', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Approved');

-- Sample Categories
INSERT INTO categories (category_name) VALUES ('Programming'), ('Cybersecurity'), ('Romance'), ('History');
