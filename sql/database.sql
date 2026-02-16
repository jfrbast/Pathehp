CREATE DATABASE IF NOT EXISTS cinema_reservation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cinema_reservation;

-- Utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    remember_token VARCHAR(255) NULL,
    remember_token_expires_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Films
CREATE TABLE IF NOT EXISTS films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    duration INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Séances
CREATE TABLE IF NOT EXISTS seances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    seats_total INT NOT NULL,
    CONSTRAINT fk_seances_film FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE CASCADE
);

-- Réservations
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    seance_id INT NOT NULL,
    seats INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_res_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_res_seance FOREIGN KEY (seance_id) REFERENCES seances(id) ON DELETE CASCADE
);

