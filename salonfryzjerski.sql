-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Gru 2022, 13:38
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `salonfryzjerski`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rejestracja`
--

CREATE TABLE `rejestracja` (
  `id` int(2) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `haslo` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `rejestracja`
--

INSERT INTO `rejestracja` (`id`, `nazwa`, `haslo`, `email`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com'),
(4, 'kacper', 'de2dd81dd97213fcd7863f74809ea448', 'kacper123@gmail.com'),
(5, 'sobol', '2644536c5888ceae91faaad0a0c90b37', 'sobol123@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyty`
--

CREATE TABLE `wizyty` (
  `id` int(11) NOT NULL,
  `godzina` varchar(5) COLLATE utf8mb4_polish_ci NOT NULL,
  `nazwa` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `usluga` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `termin` varchar(10) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `rejestracja`
--
ALTER TABLE `rejestracja`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `rejestracja`
--
ALTER TABLE `rejestracja`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
