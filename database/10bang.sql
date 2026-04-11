CREATE DATABASE IF NOT EXISTS gym_pro_management;
USE gym_pro_management;

-- 1. USERS: Quản lý tài khoản và phân quyền
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('member', 'trainer', 'staff', 'admin') DEFAULT 'member',
    avatar_url VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. TRAINER_PROFILES: Thông tin chuyên sâu của HLV
CREATE TABLE trainer_profiles (
    user_id INT PRIMARY KEY,
    specialization VARCHAR(100) NOT NULL,
    experience_years INT DEFAULT 0,
    bio TEXT,
    rating_avg DECIMAL(3,2) DEFAULT 0.00, -- Điểm đánh giá TB (tự động cập nhật)
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 3. MEMBERSHIPS: Định nghĩa các gói tập
CREATE TABLE memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('gym', 'yoga', 'zumba', 'all') DEFAULT 'gym',
    duration_days INT NOT NULL, 
    price DECIMAL(12,2) NOT NULL,
    has_pt TINYINT(1) DEFAULT 0,
    pt_sessions INT DEFAULT 0, -- Số buổi PT tặng kèm khi mua gói
    is_active TINYINT(1) DEFAULT 1
);

-- 4. SUBSCRIPTIONS: Quản lý việc sở hữu gói tập của hội viên
CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    membership_id INT NOT NULL,
    trainer_id INT NULL COMMENT 'PT hướng dẫn chính nếu có',
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    pt_sessions_left INT DEFAULT 0, -- [Suy luận] Cột cực quan trọng để trừ dần khi khách tập PT
    status ENUM('active', 'expired', 'pending_payment', 'cancelled') DEFAULT 'pending_payment',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (membership_id) REFERENCES memberships(id),
    FOREIGN KEY (trainer_id) REFERENCES users(id)
);

-- 5. PAYMENTS: Chi tiết giao dịch tiền tệ
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subscription_id INT NOT NULL,
    invoice_code VARCHAR(50) UNIQUE NOT NULL, -- Mã hóa đơn (VD: GYM-2024-001)
    amount DECIMAL(12,2) NOT NULL,
    method ENUM('cash', 'transfer', 'vnpay', 'momo') DEFAULT 'cash',
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    processed_by INT NULL COMMENT 'Nhân viên thu tiền',
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(id) ON DELETE CASCADE,
    FOREIGN KEY (processed_by) REFERENCES users(id)
);

-- 6. SCHEDULES: Lịch dạy và ca tập
CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    trainer_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    capacity INT DEFAULT 20,
    current_enrolled INT DEFAULT 0, -- [Chưa xác minh] Dùng để check full chỗ nhanh
    class_type ENUM('group', 'pt_1on1') DEFAULT 'group',
    FOREIGN KEY (trainer_id) REFERENCES users(id)
);

-- 7. BOOKINGS: Đăng ký tham gia ca tập
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subscription_id INT NOT NULL, -- Phải có gói còn hạn mới được đặt lịch
    schedule_id INT NOT NULL,
    booking_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('booked', 'attended', 'cancelled') DEFAULT 'booked',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(id),
    FOREIGN KEY (schedule_id) REFERENCES schedules(id) ON DELETE CASCADE
);

-- 8. ATTENDANCE: Nhật ký ra vào (Phục vụ QR động)
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    checkin_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    notes VARCHAR(255) NULL, -- Ghi chú (VD: Quên mang thẻ, khách vãng lai)
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 9. REVIEWS: Phản hồi từ khách hàng
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    trainer_id INT NOT NULL,
    booking_id INT NULL UNIQUE COMMENT 'Đảm bảo tập xong mới được review',
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES users(id),
    FOREIGN KEY (trainer_id) REFERENCES users(id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- 10. NEWS: Nội dung website và thông báo
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL, -- Đường dẫn thân thiện cho Web (VD: thong-bao-nghi-le)
    summary TEXT,
    content LONGTEXT NOT NULL,
    thumbnail_url VARCHAR(255),
    category ENUM('promotion', 'event', 'guide') DEFAULT 'guide',
    is_published TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);