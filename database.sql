CREATE DATABASE IF NOT EXISTS madrasa_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE madrasa_management;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS fees, attendance, students, teachers, classes, users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE classes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE teachers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(30),
    subject VARCHAR(100) NOT NULL,
    class_id INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (name), FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);
CREATE TABLE students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    father_name VARCHAR(100) NOT NULL,
    phone VARCHAR(30),
    address TEXT,
    class_id INT UNSIGNED NULL,
    admission_date DATE NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (name), INDEX (phone), FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);
CREATE TABLE attendance (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    attendance_date DATE NOT NULL,
    status ENUM('Present','Absent','Leave') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_student_date (student_id, attendance_date),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
CREATE TABLE fees (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    fee_month CHAR(7) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    paid_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    due_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    status ENUM('Paid','Partial','Due') NOT NULL DEFAULT 'Due',
    payment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (fee_month), FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

INSERT INTO users (name, username, password) VALUES ('Administrator', 'admin', '$2y$10$r7h6Y939J6qZZtj2p.4MrufXNIpwJN37lnEoS51RiKw3MQ2bKCSAm');
INSERT INTO classes (class_name, description) VALUES
('Noorani', 'Foundational Quran reading'), ('Nazera', 'Quran recitation'), ('Hifz', 'Quran memorization'), ('Kitab', 'Islamic studies');
INSERT INTO teachers (name, phone, subject, class_id) VALUES
('Abdul Karim', '01700000001', 'Quran', 1), ('Musa Ahmed', '01700000002', 'Tajweed', 2), ('Yusuf Ali', '01700000003', 'Hifz', 3), ('Hamza Rahman', '01700000004', 'Fiqh', 4);
INSERT INTO students (student_id, name, father_name, phone, address, class_id, admission_date, status) VALUES
('STD-001','Abdullah Hasan','Mahmud Hasan','01800000001','Dhaka',1,'2025-01-10','Active'),
('STD-002','Rahim Uddin','Karim Uddin','01800000002','Dhaka',2,'2025-01-12','Active'),
('STD-003','Hasan Ali','Salim Ali','01800000003','Narayanganj',3,'2025-02-02','Active'),
('STD-004','Omar Faruk','Jamal Faruk','01800000004','Gazipur',4,'2025-02-05','Active'),
('STD-005','Ibrahim Khan','Rashid Khan','01800000005','Dhaka',1,'2025-02-08','Inactive');
INSERT INTO attendance (student_id, attendance_date, status) VALUES
(1,CURDATE(),'Present'),(2,CURDATE(),'Present'),(3,CURDATE(),'Absent'),(4,CURDATE(),'Leave');
INSERT INTO fees (student_id, fee_month, amount, paid_amount, due_amount, status, payment_date) VALUES
(1,DATE_FORMAT(CURDATE(),'%Y-%m'),1000,1000,0,'Paid',CURDATE()),
(2,DATE_FORMAT(CURDATE(),'%Y-%m'),1000,500,500,'Partial',CURDATE()),
(3,DATE_FORMAT(CURDATE(),'%Y-%m'),1000,0,1000,'Due',CURDATE());
