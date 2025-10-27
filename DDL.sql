DROP DATABASE IF EXISTS `users`;
CREATE DATABASE `users` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(9) DEFAULT NULL,
  `input_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_unique_email` (`email`),
  UNIQUE KEY `users_unique_phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users (full_name, email, phone, input_date) VALUES
('Ana Pérez', 'ana.perez@example.com', '091234567', '2025-10-20 09:15:30'),
('Carlos Gómez', 'carlos.gomez@example.com', '092345678', '2025-10-20 09:20:10'),
('Lucía Fernández', 'lucia.fernandez@example.com', NULL, '2025-10-20 10:05:45'),
('Marcos López', 'marcos.lopez@example.com', '099876543', '2025-10-21 11:22:50'),
('Sofía Díaz', 'sofia.diaz@example.com', '091112223', '2025-10-21 14:11:00'),
('Javier Morales', 'javier.morales@example.com', NULL, '2025-10-22 08:47:10'),
('Valentina Rodríguez', 'valentina.rodriguez@example.com', '094556677', '2025-10-22 09:33:20'),
('Diego Castro', 'diego.castro@example.com', '090998877', '2025-10-22 13:00:00'),
('Camila Silva', 'camila.silva@example.com', NULL, '2025-10-23 10:42:37'),
('Martín Pereira', 'martin.pereira@example.com', '097654321', '2025-10-23 12:55:00'),
('Paula Ruiz', 'paula.ruiz@example.com', '093221100', '2025-10-24 16:20:10'),
('Federico Torres', 'federico.torres@example.com', NULL, '2025-10-25 09:05:00');