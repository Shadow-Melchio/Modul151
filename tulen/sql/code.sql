-- Datenbank erstellen
CREATE DATABASE IF NOT EXISTS `3d_druck_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `3d_druck_shop`;

-- Tabelle für Benutzer
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabelle für Produkte
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Beispielprodukte einfügen
INSERT INTO `products` (`title`, `description`, `price`) VALUES
('3D-gedruckte Figur', 'Eine coole 3D-Figur aus PLA.', 29.99),
('3D-Druck Ersatzteil', 'Hochwertiges Ersatzteil für deine Geräte.', 15.50);
