CREATE DATABASE pemesanan;
USE pemesanan;

CREATE TABLE users (
    nama INT VARCHAR(100)
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE buses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_name VARCHAR(50),
    keberangkatan VARCHAR(50),
    tujuan VARCHAR(50),
    price DECIMAL(10, 2),
    available_seats INT
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    bus_id INT,
    tanggal DATE,
    jam TIME,
    kursi INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (bus_id) REFERENCES buses(id)
);
