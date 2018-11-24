-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Nov 20, 2018 alle 16:20
-- Versione del server: 10.2.19-MariaDB
-- Versione PHP: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fruttitaliacom_alejandro`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `kinds`
--

-- CREATE TABLE `kinds` (
--   `entity` blob NOT NULL,
--   `code` varchar(40) NOT NULL,
--   `name` varchar(255) NOT NULL,
--   `value` text DEFAULT NULL,
--   `descriptions` text DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 
-- --
-- -- Dump dei dati per la tabella `kinds`
-- --

INSERT INTO `kinds` (`entity`, `code`, `name`, `value`, `descriptions`) VALUES
(0x5461786573, '4', 'IVA 4%', '4', NULL),
(0x436f6e7461637473, 'ADRPR', 'Indirizzo Privato', NULL, NULL),
(0x436f6d70616e696573, 'CUST', 'customers', NULL, NULL),
(0x41747472696275746573, 'CUST_CREDIT', 'Limit credit', '{\"code_filter\":\"\", \"default\":\"10000\"}', 'Establecer el limite de crédito en los clientes.\r\nEstablish the credit limit in the clients.\r\nStabilire il limite di fido nei clienti.'),
(0x446f63756d656e7473, 'DDT', 'Documento di trasporto', NULL, NULL),
(0x41747472696275746573, 'DEF_A', 'Default A', '1', NULL),
(0x446f63756d656e7473, 'DFD', 'Documento Fattura Differita', NULL, NULL),
(0x436f6e7461637473, 'e-mail', 'e-mail', NULL, NULL),
(0x50726f6475637473, 'FAB', 'Prodotto confezionato', NULL, NULL),
(0x4f7264657273, 'IN', 'Ordine in entrata', NULL, NULL),
(0x5461786573, 'IVA10', 'iva 10%', '10', NULL),
(0x5461786573, 'IVA3', 'iva 3%', '3', NULL),
(0x436f6d70616e696573, 'MC', 'MultiCompany', NULL, NULL),
(0x4f7264657273, 'OUT', 'Ordine in uscita', NULL, NULL),
(0x50686f6e6573, 'Pho', 'telephone', NULL, NULL),
(0x41747472696275746573, 'PROD_Brand', 'Brand', NULL, NULL),
(0x41747472696275746573, 'PROD_Pallet', 'Pallet', NULL, NULL),
(0x436f6d70616e696573, 'PROV', 'Provider', NULL, NULL),
(0x436f6d70616e696573, 'SHIP', 'Shippers', NULL, NULL),
(0x436f6d70616e696573, 'SUP', 'Suppliers', NULL, NULL),
(0x416464726573736573, 'VMCT GEMG', 'Address comerciale', NULL, NULL);

--
-- Indici per le tabelle scaricate
--

-- --
-- -- Indici per le tabelle `kinds`
-- --
-- ALTER TABLE `kinds`
--   ADD PRIMARY KEY (`code`);
-- COMMIT;
-- 
-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
