-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 06, 2023 la 07:08 PM
-- Versiune server: 10.4.28-MariaDB
-- Versiune PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `romanianshack`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `cart`
--

CREATE TABLE `cart` (
  `ID` int(11) NOT NULL,
  `IDuser` int(11) NOT NULL,
  `IDproduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `cart`
--

INSERT INTO `cart` (`ID`, `IDuser`, `IDproduct`) VALUES
(55, 0, 44);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `imagelocation` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `products`
--

INSERT INTO `products` (`ID`, `type`, `name`, `imagelocation`, `price`) VALUES
(1, 'telefon', 'SAMSUNG Galaxy A04s', 'database\\a04.jpg', 600),
(2, 'telefon', 'SAMSUNG Galaxy A54', 'database\\a54.jpg', 1800),
(3, 'telefon', 'SAMSUNG Galaxy A34', 'database\\a34.jpg', 1400),
(4, 'telefon', 'SAMSUNG Galaxy A14', 'database\\a14.jpg', 850),
(5, 'telefon', 'SAMSUNG Galaxy S23 Ultra 5G', 'database\\s23ultra.jpg', 5750),
(6, 'telefon', 'SAMSUNG Galaxy A13', 'database\\a13.jpg', 700),
(7, 'telefon', 'SAMSUNG Galaxy S22 5G', 'database\\s22.jpg', 2900),
(8, 'telefon', 'SAMSUNG Galaxy S23 5G', 'database\\s23.jpg', 4000),
(9, 'telefon', 'SAMSUNG Galaxy Zflip4 5G', 'database\\zflip4.jpg', 3900),
(10, 'telefon', 'SAMSUNG Galaxy Zfold4 5G', 'database\\zfold4.jpg', 6700),
(11, 'telefon', 'XIAOMI 12X 5G', 'database\\12x.jpg', 2600),
(12, 'telefon', 'XIAOMI Redmi Note 11 Pro+ 5G', 'database\\note11pro.jpg', 1600),
(13, 'telefon', 'XIAOMI 12 Pro 5G', 'database\\12pro.jpg', 3600),
(14, 'telefon', 'XIAOMI 11 Lite 5G NE', 'database\\11lite.jpg', 1800),
(15, 'telefon', 'XIAOMI Redmi Note11S', 'database\\note11s.jpg', 1000),
(16, 'telefon', 'XIAOMI Redmi 10', 'database\\10.jpg', 700),
(17, 'telefon', 'XIAOMI Redmi 9T', 'database\\9t.jpg', 780),
(18, 'telefon', 'Xiaomi Redmi 9A', 'database\\9a.jpg', 379),
(19, 'telefon', 'Xiaomi Redmi 9C', 'database\\9c.jpg', 400),
(20, 'telefon', 'iPhone 14 5G', 'database\\i145g.jpg', 4200),
(21, 'telefon', 'iPhone 14 Pro', 'database\\i14pro.jpg', 5600),
(22, 'telefon', 'iPhone 13 5g', 'database\\i135g.jpg', 4000),
(23, 'telefon', 'iPhone 11', 'database\\i11.jpg', 2400),
(24, 'telefon', 'iPhone 12 5G', 'database\\i125g.jpg', 3500),
(25, 'telefon', 'iPhone SE 5g', 'database\\ise.jpg', 2100),
(26, 'tableta', 'Lenovo P11 Plus', 'database\\p11.jpg', 1500),
(27, 'tableta', 'Samsung Galaxy Tab A7', 'database\\a7.jpg', 800),
(28, 'tableta', 'Samsung Galaxy Tab A8', 'database\\a8.jpg', 900),
(29, 'tableta', 'Lenovo Tab M10', 'database\\m10.jpg', 700),
(30, 'tableta', 'iPad 9', 'database\\ipad9.jpg', 200),
(31, 'tableta', 'Lenovo Tab M7', 'database\\m7.jpg', 440),
(32, 'tableta', 'Lenovo Yoga Tab 11', 'database\\yogatab11.jpg', 1500),
(33, 'tableta', 'Lenovo Tab M9', 'database\\m9.jpg', 700),
(34, 'tableta', 'Huawei MatePad SE', 'database\\matepadse.jpg', 1000),
(35, 'tableta', 'Nokia T21', 'database\\t21.jpg', 1000),
(36, 'tableta', 'iPad10', 'database\\ipad10.jpg', 2800),
(37, 'tableta', 'Huawei MatePad Paper 10', 'database\\paper10.jpg', 1900),
(38, 'tableta', 'iPad Pro', 'database\\ipadpro.jpg', 5000),
(39, 'tableta', 'iPad Air5', 'database\\ipad5.jpg', 3600),
(40, 'tableta', 'Samsung Galaxy Tab S8 Ultra', 'database\\tabs8.jpg', 5400),
(41, 'laptop', 'Asus ROG Strix G17', 'database\\g17.jpg', 5000),
(42, 'laptop', 'Lenovo IdeaPad Gaming 3 15ACH6', 'database\\15ACH6.jpg', 3200),
(43, 'laptop', 'Lenovo IdeaPad Gaming 3 15IAH7', 'database\\15IAH7.jpg', 4000),
(44, 'laptop', 'ASUS TUF F15', 'database\\f15.jpg', 3300),
(45, 'laptop', 'ASUS TUF A15', 'database\\a15.jpg', 6400),
(46, 'laptop', 'ACER Aspire 7', 'database\\aspire7.jpg', 3700),
(47, 'laptop', 'ACER ROG STRIX G16', 'database\\g16.jpg', 9000),
(48, 'laptop', 'Lenovo Legion 5', 'database\\legion.jpg', 5200),
(49, 'laptop', 'Acer Nitro 5', 'database\\nitro5.jpg', 3800),
(50, 'laptop', 'Macbook Air 13', 'database\\mbair13.jpg', 4800),
(51, 'laptop', 'Macbook Pro 14', 'database/mbpro14.jpg', 13200),
(52, 'laptop', 'Macbook Pro 13', 'database/mbpro13.jpg', 7200);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`ID`, `firstname`, `lastname`, `email`, `adress`, `phonenumber`, `pass`) VALUES
(1, 'Radu', 'Togoe', 'radutogoe@gmail.com', 'C17', '0753590800', '1234'),
(2, 'Radu', 'Togoe', 'togoeradu@gmail.com', 'C17', '1234567890', '1234');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `cart`
--
ALTER TABLE `cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pentru tabele `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
