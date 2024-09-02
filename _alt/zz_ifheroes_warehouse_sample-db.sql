-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Aug 2024 um 21:56
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ifheroes_warehouse`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `player_warehouse`
--

CREATE TABLE `player_warehouse` (
  `player_uuid` varchar(120) NOT NULL,
  `player_name` varchar(16) NOT NULL,
  `player_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `player_warehouse`
--

INSERT INTO `player_warehouse` (`player_uuid`, `player_name`, `player_data`) VALUES
('504bf585-2d78-4ef7-864f-71eb47ccef4e', 'I_Dev', '{\n    \"basicData\": {\n        \"uuid\": \"504bf585-2d78-4ef7-864f-71eb47ccef4e\",\n        \"name\": \"I_Dev\"\n    },\n    \"advancedData\": {\n        \"language\": \"EN\"\n    },\n    \"pluginData\": {\n        \"values\": {\n            \"elicitation\": {\n                \"effects\": [\n                    \"fire\",\n                    \"stoned\",\n                    \"healthregen\"\n                ],\n                \"points\": 1\n            }\n        }\n    }\n}');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `player_warehouse`
--
ALTER TABLE `player_warehouse`
  ADD PRIMARY KEY (`player_uuid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
