-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-01-2019 a las 18:54:47
-- Versión del servidor: 10.2.19-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pdms2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kinds`
--

CREATE TABLE IF NOT EXISTS `kinds` (
  `entity` blob NOT NULL,
  `code` varchar(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `descriptions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `kinds`
--

INSERT IGNORE INTO `kinds` (`entity`, `code`, `name`, `value`, `descriptions`) VALUES
(0x5461786573, '4', 'IVA 4%', '4', NULL),
(0x436f6d70616e696573, 'BANK', 'Bank', NULL, 'define el tipo como banco al tipo de compañia\r\nSet as bank the kinds company'),
(0x7364692d436f6469636544657374696e61746172696f, 'CD_ALE', 'Codice destinatario ALE', NULL, NULL),
(0x50686f6e6573, 'CELL_P', 'Cellphone Personal', NULL, NULL),
(0x50686f6e6573, 'CELL_W', 'Cellphone Work', NULL, NULL),
(0x436173684e6f7465, 'CN_IN', 'Input cash note', NULL, NULL),
(0x436173684e6f7465, 'CN_OUT', 'Output Cash Note', NULL, NULL),
(0x456e74697479, 'code', 'name', NULL, NULL),
(0x41747472696275746573, 'CodiceDestinatario', 'Codice Destinatario', '{\"code_filter\":\"MC\", \"default\":\"\"}', 'codice dell\'ufficio dell’amministrazione dello stato destinatario della fattura, definito dall\'amministrazione di appartenenza come riportato nella rubrica “Indice PA”.'),
(0x41747472696275746573, 'COMMISION', 'Commision Rate', '{\"code_filter\":\"MC\", \"default\":\"10\"}', 'Fixed Field only can be changed by admin.\r\nCommision rate for multi companies'),
(0x436f6e74616374732c20436f6d70616e696573, 'CUST', 'Customers', NULL, NULL),
(0x41747472696275746573, 'CUST_CREDIT', 'Limit credit', '{\"code_filter\":\"CUST\", \"default\":\"10000\"}', 'Establecer el limite de crédito en los clientes.\r\nEstablish the credit limit in the clients.\r\nStabilire il limite di fido nei clienti.'),
(0x41747472696275746573, 'CUST_PAYMENT', 'Tipo di pagamento', '{\"code_filter\":\"CUST\", \"default\":\"30\"}', 'Establece la cantidad de día que tiene como límite para realizar el pago\r\nSet the amount of day you have as limit to make the payment\r\nImposta l\'importo del giorno che hai come limite per effettuare il pagamento'),
(0x446f63756d656e7473, 'DDT', 'Documento di trasporto', NULL, NULL),
(0x41747472696275746573, 'DEF_A', 'Default A', '1', NULL),
(0x446f63756d656e7473, 'DFD', 'Documento Fattura Differita', NULL, NULL),
(0x50726f6475637473, 'FAB', 'Prodotto confezionato', NULL, NULL),
(0x446f63756d656e7473, 'FTIM', 'Fattura inmediata', NULL, NULL),
(0x4164647265737365732c2050686f6e65732c204d61696c73, 'HOME', 'Home', NULL, NULL),
(0x4f7264657273, 'IN', 'Ordine in entrata', NULL, NULL),
(0x5461786573, 'IVA10', 'iva 10%', '10', NULL),
(0x5461786573, 'IVA3', 'iva 3%', '3', NULL),
(0x436f6d70616e696573, 'MC', 'MultiCompany', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP01', 'contanti', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP02', 'assegno', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP03', 'assegno circolare', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP04', 'contanti presso Tesoreria', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP05', 'bonifico', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP06', 'vaglia cambiario', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP07', 'bollettino bancario', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP08', 'carta di pagamento', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP09', 'RID', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP10', 'RID utenze', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP11', 'RID veloce', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP12', 'RIBA', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP13', 'MAV', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP14', 'quietanza erario', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP15', 'giroconto su conti di contabilità speciale', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP16', 'domiciliazione bancaria', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP17', 'domiciliazione postale', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP18', 'bollettino di c/c postale', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP19', 'SEPA Direct Debit', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP20', 'SEPA Direct Debit CORE', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP21', 'SEPA Direct Debit B2B', NULL, NULL),
(0x7364692d4d6f64616c697461506167616d656e746f, 'MP22', 'Trattenuta su somme già riscosse', NULL, NULL),
(0x7364692d4e6174757261, 'N1', 'escluse ex art. 15', NULL, NULL),
(0x7364692d4e6174757261, 'N2', 'non soggette', NULL, NULL),
(0x7364692d4e6174757261, 'N3', 'non imponibili', NULL, NULL),
(0x7364692d4e6174757261, 'N4', 'esenti', NULL, NULL),
(0x7364692d4e6174757261, 'N5', 'regime del margine / IVA non esposta in fattura', NULL, NULL),
(0x7364692d4e6174757261, 'N6', 'inversione contabile (per le operazioni in reverse charge ovvero nei casi di autofatturazione per acquisti extra UE di servizi ovvero per importazioni di beni nei soli casi previsti)', NULL, NULL),
(0x7364692d4e6174757261, 'N7', 'IVA assolta in altro stato UE (vendite a distanza ex art. 40 c. 3 e 4 e art. 41 c. 1 lett. b,  DL 331/93; prestazione di servizi di telecomunicazioni, tele-radiodiffusione ed elettronici ex art. 7-sexies lett. f, g, art. 74-sexies DPR 633/72)', NULL, NULL),
(0x4f7264657273, 'OUT', 'Ordine in uscita', NULL, NULL),
(0x436f6e7461637473, 'PARTNER', 'Partner', NULL, NULL),
(0x41747472696275746573, 'PROD_Brand', 'Brand', NULL, NULL),
(0x41747472696275746573, 'PROD_Pallet', 'Pallet', NULL, NULL),
(0x436f6e74616374732c20436f6d70616e696573, 'PROV', 'Provider', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF01', 'Ordinario', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF02', 'Contribuenti minimi (art.1, c.96-117, L. 244/07) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF04', 'Agricoltura e attività connesse e pesca (artt.34 e 34-bis, DPR 633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF05', 'Vendita sali e tabacchi (art.74, c.1, DPR. 633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF06', 'Commercio fiammiferi (art.74, c.1, DPR  633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF07', 'Editoria (art.74, c.1, DPR  633/72)', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF08', 'Gestione servizi telefonia pubblica (art.74, c.1, DPR 633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF09', 'Rivendita documenti di trasporto pubblico e di sosta (art.74, c.1, DPR  633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF10', 'Intrattenimenti, giochi e altre attività di cui alla tariffa allegata al DPR 640/72 (art.74, c.6, DPR 633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF11', 'Agenzie viaggi e turismo (art.74-ter, DPR 633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF12', 'Agriturismo (art.5, c.2, L. 413/91) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF13', 'Vendite a domicilio (art.25-bis, c.6, DPR  600/73) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF14', 'Rivendita beni usati, oggetti d’arte, d’antiquariato o da collezione (art.36, DL 41/95) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF15', 'Agenzie di vendite all’asta di oggetti d’arte, antiquariato o da collezione (art.40-bis, DL 41/95) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF16', 'IVA per cassa P.A. (art.6, c.5, DPR 633/72) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF17', 'IVA per cassa (art. 32-bis, DL 83/2012) ', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF18', 'Altro', NULL, NULL),
(0x7364692d526567696d6546697363616c65, 'RF19', 'Regime forfettario (art.1, c.54-89, L. 190/2014)', NULL, NULL),
(0x436f6d70616e696573, 'SHIP', 'Shippers', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC01', 'Cassa nazionale previdenza e assistenza avvocati e procuratori legali ', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC02', 'Cassa previdenza dottori commercialisti', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC03', 'Cassa previdenza e assistenza geometri', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC04', 'Cassa nazionale previdenza e assistenza ingegneri e architetti liberi professionisti', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC05', 'Cassa nazionale del notariato', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC06', 'Cassa nazionale previdenza e assistenza ragionieri e periti commerciali', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC07', 'Ente nazionale assistenza agenti e rappresentanti di commercio (ENASARCO)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC08', 'Ente nazionale previdenza e assistenza consulenti del lavoro (ENPACL)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC09', 'Ente nazionale previdenza e assistenza medici (ENPAM)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC10', 'Ente nazionale previdenza e assistenza farmacisti (ENPAF)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC11', 'Ente nazionale previdenza e assistenza veterinari (ENPAV)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC12', 'Ente nazionale previdenza e assistenza impiegati dell\'agricoltura (ENPAIA)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC13', 'Fondo previdenza impiegati imprese di spedizione e agenzie marittime', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC14', 'Istituto nazionale previdenza giornalisti italiani (INPGI)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC15', 'Opera nazionale assistenza orfani sanitari italiani (ONAOSI)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC16', 'Cassa autonoma assistenza integrativa giornalisti italiani (CASAGIT)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC17', 'Ente previdenza periti industriali e periti industriali laureati (EPPI)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC18', 'Ente previdenza e assistenza pluricategoriale (EPAP)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC19', 'Ente nazionale previdenza e assistenza biologi (ENPAB)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC20', 'Ente nazionale previdenza e assistenza professione infermieristica (ENPAPI)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC21', 'Ente nazionale previdenza e assistenza psicologi (ENPAP)', NULL, NULL),
(0x7364692d5469706f4361737361, 'TC22', 'INPS', NULL, NULL),
(0x446f63756d656e7473, 'TD01', 'fattura', NULL, NULL),
(0x446f63756d656e7473, 'TD02', 'acconto/anticipo su fattura', NULL, NULL),
(0x446f63756d656e7473, 'TD03', 'acconto/anticipo su parcella', NULL, NULL),
(0x446f63756d656e7473, 'TD04', 'nota di credito', NULL, NULL),
(0x446f63756d656e7473, 'TD05', 'nota di debito', NULL, NULL),
(0x446f63756d656e7473, 'TD06', 'parcella', NULL, NULL),
(0x4164647265737365732c2050686f6e65732c204d61696c73, 'WORK', 'Work', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `kinds`
--
ALTER TABLE `kinds`
  DROP PRIMARY KEY;
ALTER TABLE `kinds`
  ADD PRIMARY KEY (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
