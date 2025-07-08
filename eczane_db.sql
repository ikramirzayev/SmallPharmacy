-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 May 2025, 15:42:04
-- Sunucu sürümü: 8.0.42
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `eczane_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `ad` varchar(100) DEFAULT NULL,
  `kullanici_adi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`id`, `ad`, `kullanici_adi`) VALUES
(1, 'ikram', 'admin');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilac`
--

CREATE TABLE `ilac` (
  `ilac_id` int NOT NULL,
  `ilac_adi` varchar(100) DEFAULT NULL,
  `firma` varchar(100) DEFAULT NULL,
  `fiyat` decimal(10,2) DEFAULT NULL,
  `stok` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `ilac`
--

INSERT INTO `ilac` (`ilac_id`, `ilac_adi`, `firma`, `fiyat`, `stok`) VALUES
(1, 'Parol', 'Abdi ?brahim', 25.00, 130),
(2, 'Aferin', 'Nobel', 20.00, 90),
(3, 'Nurafen', 'Reckitt Benckiser', 30.50, 126);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri`
--

CREATE TABLE `musteri` (
  `musteri_id` int NOT NULL,
  `ad` varchar(100) DEFAULT NULL,
  `soyad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `musteri`
--

INSERT INTO `musteri` (`musteri_id`, `ad`, `soyad`) VALUES
(1, 'ikram', 'irzayev'),
(2, 'zeynep sevval', 'yildiz'),
(3, 'ahmet', 'yilmaz'),
(4, 'Novruz', 'Irzayev'),
(7, 'Ali', 'Kara'),
(8, 'zehra', 'kınık'),
(9, 'zeliha', 'kıyak');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `satin_alma`
--

CREATE TABLE `satin_alma` (
  `satinal_id` int NOT NULL,
  `musteri_id` int DEFAULT NULL,
  `ilac_id` int DEFAULT NULL,
  `miktar` int DEFAULT NULL,
  `tarih` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `satin_alma`
--

INSERT INTO `satin_alma` (`satinal_id`, `musteri_id`, `ilac_id`, `miktar`, `tarih`) VALUES
(1, NULL, 1, 2, '2025-05-16'),
(2, NULL, 1, 5, '2025-05-16'),
(3, NULL, 2, 10, '2025-05-16'),
(4, 3, 1, 1, '2025-05-16'),
(5, 1, 1, 2, '2025-05-16'),
(6, 4, 1, 4, '2025-05-21'),
(8, 7, 1, 15, '2025-05-21'),
(9, 8, 3, 12, '2025-05-21'),
(10, 9, 1, 1, '2025-05-21');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ilac`
--
ALTER TABLE `ilac`
  ADD PRIMARY KEY (`ilac_id`);

--
-- Tablo için indeksler `musteri`
--
ALTER TABLE `musteri`
  ADD PRIMARY KEY (`musteri_id`);

--
-- Tablo için indeksler `satin_alma`
--
ALTER TABLE `satin_alma`
  ADD PRIMARY KEY (`satinal_id`),
  ADD KEY `musteri_id` (`musteri_id`),
  ADD KEY `ilac_id` (`ilac_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `ilac`
--
ALTER TABLE `ilac`
  MODIFY `ilac_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `musteri`
--
ALTER TABLE `musteri`
  MODIFY `musteri_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `satin_alma`
--
ALTER TABLE `satin_alma`
  MODIFY `satinal_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `satin_alma`
--
ALTER TABLE `satin_alma`
  ADD CONSTRAINT `satin_alma_ibfk_1` FOREIGN KEY (`musteri_id`) REFERENCES `musteri` (`musteri_id`),
  ADD CONSTRAINT `satin_alma_ibfk_2` FOREIGN KEY (`ilac_id`) REFERENCES `ilac` (`ilac_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
