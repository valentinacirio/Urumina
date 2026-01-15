-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 03, 2026 alle 09:01
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urumina`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `nome_prodotto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`nome_prodotto`) VALUES
('Urumina Glow Prism Powder'),
('Urumina Pure Glow Mist Blue'),
('Urumina Pure Glow Mist Lilac'),
('Urumina Pure Glow UV Milk Levender'),
('Urumina Pure Glow UV Milk Yellow');

-- --------------------------------------------------------

--
-- Struttura della tabella `recensioni`
--

CREATE TABLE `recensioni` (
  `id` int(100) NOT NULL,
  `prodotto_recensito` varchar(100) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `testo` varchar(200) NOT NULL,
  `email_utente` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `recensioni`
--

INSERT INTO `recensioni` (`id`, `prodotto_recensito`, `titolo`, `testo`, `email_utente`) VALUES
(21, 'Urumina Glow Prism Powder', 'Ottima cipria', 'La ricomprerò sicuramente:)', 'q@gmail.com'),
(23, 'Urumina Pure Glow UV Milk Yellow', 'Fantastica!', 'La miglior crema che abbia mai provato!!', 'anna@gmail.com'),
(24, 'Urumina Glow Prism Powder', 'Comoda', 'Questa cipria fa proprio al caso mio, è ben compatta quindi la posso tenere in borsetta :)', 'anna@gmail.com'),
(26, 'Urumina Pure Glow Mist Lilac', 'Buona ', 'Buon prodotto', 'anna@gmail.com'),
(49, 'Urumina Pure Glow Mist Lilac', 'Cipria meravigliosa', 'Funziona bene', 'a@gmail.com'),
(51, 'Urumina Pure Glow Mist Lilac', 'ottimo', 'fa un ottimo lavoro', 'a@gmail.com'),
(53, 'Urumina Glow Prism Powder', 'a', 'qk', 'a@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`username`, `password`, `email`) VALUES
('a', '$2y$10$t5sCBYCNZO0MaW.SDslAp.wMP2ZONa8rZcgcquoja0SjZ9jLGVba2', 'a@gmail.com'),
('anna', '$2y$10$.DM81uDwEpgLqiCUIXFLD.M0Y7xFhhK1qg74LbNunj42F7.4WhHQW', 'anna@gmail.com'),
('q', '$2y$10$O2SfzrFsYp5G4v4Dx51pCOrkomx3TTUdqk9BaE6xmfY9fFjCWld4y', 'q@gmail.com'),
('w', '$2y$10$udbI436y1947BlKkAFGqNOdesTGw2BL9unU1jfpYWmlSSjQoJbAYa', 'w@gmail.com');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`nome_prodotto`);

--
-- Indici per le tabelle `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotto_recensito` (`prodotto_recensito`),
  ADD KEY `email_utente` (`email_utente`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `recensioni_ibfk_1` FOREIGN KEY (`prodotto_recensito`) REFERENCES `prodotti` (`nome_prodotto`),
  ADD CONSTRAINT `recensioni_ibfk_2` FOREIGN KEY (`email_utente`) REFERENCES `utenti` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
