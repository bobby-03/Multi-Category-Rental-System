-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2026 at 02:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_item`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `user_id` int(30) DEFAULT NULL,
  `customer_name` varchar(200) NOT NULL,
  `date_start` date NOT NULL,
  `days` int(11) DEFAULT 1,
  `total_amount` double DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `item_id`, `user_id`, `customer_name`, `date_start`, `days`, `total_amount`, `status`) VALUES
(20, 15, 5, 'System Admin', '2026-02-22', 1, 1000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category_icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_icon`) VALUES
(4, 'HOUSE', '1771504620_WhatsApp Image 2026-02-19 at 5.47.40 PM (1).jpeg'),
(5, 'Furniture', '1771505340_1.jpg'),
(6, 'TOOL', '1771506840_1.png');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `item_name`, `description`, `price`, `image_path`) VALUES
(1, 1, 'VILLA', '🌿 Luxury 4BHK Villa – Perfect for Stay or Rent\r\n', 90000, '1771321380_villa.jpg'),
(2, 1, 'VILLA', 'vila', 90000, '1771501380_villa.jpg'),
(3, 4, 'VILLA', '• 	Exterior: White walls with red-tiled roofing and large wooden-framed windows.\r\n• 	Balcony: A prominent upper-floor balcony decorated with potted plants and a black wrought-iron railing.\r\n• 	Patio: The ground floor opens to a furnished patio with cushioned seating, a coffee table, lanterns, and plants.\r\n• 	Swimming Pool: A rectangular blue-tiled pool sits beside the patio, with sun loungers and a small table for relaxation.\r\n• 	Surroundings: Lush greenery frames the house, enhancing its serene and inviting atmosphere.', 90000, '1771504740_WhatsApp Image 2026-02-19 at 5.47.40 PM.jpeg'),
(4, 4, 'VILLA', '• 	Exterior: White walls with red-tiled roofing and large wooden-framed windows.\r\n• 	Balcony: A prominent upper-floor balcony decorated with potted plants and a black wrought-iron railing.\r\n• 	Patio: The ground floor opens to a furnished patio with cushioned seating, a coffee table, lanterns, and plants.\r\n• 	Swimming Pool: A rectangular blue-tiled pool sits beside the patio, with sun loungers and a small table for relaxation.\r\n• 	Surroundings: Lush greenery frames the house, enhancing its serene and inviting atmosphere.', 90000, '1771504800_WhatsApp Image 2026-02-19 at 5.47.39 PM.jpeg'),
(5, 4, 'VILLA', '• 	Exterior: White walls with red-tiled roofing and large wooden-framed windows.\r\n• 	Balcony: A prominent upper-floor balcony decorated with potted plants and a black wrought-iron railing.\r\n• 	Patio: The ground floor opens to a furnished patio with cushioned seating, a coffee table, lanterns, and plants.\r\n• 	Swimming Pool: A rectangular blue-tiled pool sits beside the patio, with sun loungers and a small table for relaxation.\r\n• 	Surroundings: Lush greenery frames the house, enhancing its serene and inviting atmosphere.', 90000, '1771504920_WhatsApp Image 2026-02-19 at 5.47.39 PM (3).jpeg'),
(6, 4, 'VILLA', '• 	Exterior: White walls with red-tiled roofing and large wooden-framed windows.\r\n• 	Balcony: A prominent upper-floor balcony decorated with potted plants and a black wrought-iron railing.\r\n• 	Patio: The ground floor opens to a furnished patio with cushioned seating, a coffee table, lanterns, and plants.\r\n• 	Swimming Pool: A rectangular blue-tiled pool sits beside the patio, with sun loungers and a small table for relaxation.\r\n• 	Surroundings: Lush greenery frames the house, enhancing its serene and inviting atmosphere.', 9000, '1771504920_WhatsApp Image 2026-02-19 at 5.47.39 PM (2).jpeg'),
(7, 5, 'Chair', 'Design: Often features a Scandi-style or mid-century modern, minimalist aesthetic, designed with ergonomic back support.\r\nStructure: Commonly constructed from solid wood (like rubberwood or oak), wood veneer, or powder-coated metal frames.\r\nSeat/Backrest: Can be fully solid (wood/plastic) for easy cleaning or feature upholstered, cushioned seats for added comfort.\r\nVersatility: Often lightweight, compact, and sometimes stackable, making them suitable for small spaces and high-traffic, versatile, or commercial use. ', 99, '1771505640_download (4).jpg'),
(8, 5, 'Chair', 'Design: Often features a Scandi-style or mid-century modern, minimalist aesthetic, designed with ergonomic back support.\r\nStructure: Commonly constructed from solid wood (like rubberwood or oak), wood veneer, or powder-coated metal frames.\r\nSeat/Backrest: Can be fully solid (wood/plastic) for easy cleaning or feature upholstered, cushioned seats for added comfort.\r\nVersatility: Often lightweight, compact, and sometimes stackable, making them suitable for small spaces and high-traffic, versatile, or commercial use. ', 90, '1771505700_download (6).jpg'),
(9, 5, 'Chair', 'Design: Often features a Scandi-style or mid-century modern, minimalist aesthetic, designed with ergonomic back support.\r\nStructure: Commonly constructed from solid wood (like rubberwood or oak), wood veneer, or powder-coated metal frames.\r\nSeat/Backrest: Can be fully solid (wood/plastic) for easy cleaning or feature upholstered, cushioned seats for added comfort.\r\nVersatility: Often lightweight, compact, and sometimes stackable, making them suitable for small spaces and high-traffic, versatile, or commercial use. ', 180, '1771505700_download (5).jpg'),
(10, 5, 'Sofa', 'Design: Often features low-profile designs, square arms, or rounded, integrated arms and backs for a cozy look.\r\nMaterials: Frequently upholstered in neutral, breathable, and skin-friendly fabrics like polyester, linen, or corduroy.\r\nStructure: Built on a simple, durable frame (often solid wood or with a metal, sag-resistant foundation).\r\nVersatility: Ideal for apartments, living rooms, or offices, combining comfort with a space-saving,, uncluttered aesthetic', 450, '1771505820_images (1).jpg'),
(11, 5, 'Sofa', 'Design: Often features low-profile designs, square arms, or rounded, integrated arms and backs for a cozy look.\r\nMaterials: Frequently upholstered in neutral, breathable, and skin-friendly fabrics like polyester, linen, or corduroy.\r\nStructure: Built on a simple, durable frame (often solid wood or with a metal, sag-resistant foundation).\r\nVersatility: Ideal for apartments, living rooms, or offices, combining comfort with a space-saving,, uncluttered aesthetic', 540, '1771505820_download (9).jpg'),
(12, 5, 'Bed', 'Design & Materials: Often crafted from solid, oil-rubbed American hardwoods with non-toxic, eco-friendly finishes.\r\nDimensions: Available in standard sizes including Queen and King \r\nStructure: Low-profile platform design with recessed legs to prevent toe stubbing.\r\nFunctionality: Designed for durability and versatility in modern, minimalist, or rustic bedrooms', 900, '1771506060_download (15).jpg'),
(13, 5, 'Bed', 'Design & Materials: Often crafted from solid, oil-rubbed American hardwoods with non-toxic, eco-friendly finishes.\r\nDimensions: Available in standard sizes including Queen and King \r\nStructure: Low-profile platform design with recessed legs to prevent toe stubbing.\r\nFunctionality: Designed for durability and versatility in modern, minimalist, or rustic bedrooms', 103, '1771506120_download (14).jpg'),
(14, 5, 'Table', 'Design & Style: Often feature Mid-Century Modern or Scandinavian aesthetics, characterized by tapered legs, rounded tabletop edges, and uncluttered, clean lines. They focus on functionality and bringing a \"light and airy\" feel to a room.\r\nMaterials: Frequently constructed from durable, natural materials like solid rubberwood, oak, or high-quality MDF with wood veneers.\r\nCommon Shapes: Rectangular (for seating 4-6 people) and Round (ideal for intimate, small-space dining).', 360, '1771506360_download.png'),
(15, 6, 'Pressure Washer', ' A high-pressure water spray tool used to remove mold, grime, dust, mud, and dirt from surfaces such as siding, driveways, decks, and patios.', 1000, '1771506900_download.jpg'),
(16, 6, 'Carpet Cleaner/Extractor', ' A commercial-grade machine that deep cleans rugs and carpets, often more effective than consumer-purchased models.', 100, '1771507020_download (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(5, 'System Admin', 'admin', 'admin123', 1),
(6, 'John Doe', 'user', 'user123', 2),
(7, 'Administrator', 'admin', 'admin123', 1),
(8, 'Administrator', 'admin', 'admin123', 1),
(9, 'Administrator', 'admin', 'admin123', 1),
(10, 'Administrator', 'admin', 'admin123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
