-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: mysqlmaster.uni-paderborn.de
-- Erstellungszeit: 13. Juni 2013 um 00:11
-- Server Version: 5.1.66
-- PHP-Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `winfo1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_accessories`
--

CREATE TABLE IF NOT EXISTS `paver_accessories` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat` int(10) unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `attr1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `station` int(10) unsigned DEFAULT NULL,
  `booking` int(10) unsigned DEFAULT NULL,
  `bike` int(10) unsigned DEFAULT NULL,
  `avail` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator` int(10) unsigned NOT NULL,
  `del` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=122 ;

--
-- Daten für Tabelle `paver_accessories`
--

INSERT INTO `paver_accessories` (`ID`, `cat`, `title`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `station`, `booking`, `bike`, `avail`, `created`, `creator`, `del`) VALUES
(71, 31, 'Smart E-Bike Akku', '-', 'Smart E-Bike', NULL, NULL, NULL, 1, NULL, 1, 1, '2013-05-17 13:05:17', 21, 0),
(61, 31, 'Grace MX Akku', '-', 'Grace MX', NULL, NULL, NULL, 2, NULL, 2, 1, '2013-05-17 13:04:58', 21, 0),
(51, 31, 'KTM e-Style Akku', '-', 'KTM e-Style', NULL, NULL, NULL, 1, NULL, 3, 1, '2013-05-17 13:04:24', 21, 0),
(41, 11, 'BionX Bordcomputer', 'Smart E-Bike', NULL, NULL, NULL, NULL, 1, NULL, 1, 1, '2013-05-17 11:24:41', 21, 0),
(31, 1, 'ABUS Bordo', 'Faltschloss', 'Rot', NULL, NULL, NULL, 2, NULL, NULL, 1, '2013-05-17 11:06:52', 21, 0),
(21, 1, 'ABUS Bordo', 'Faltschloss', 'Weiß', NULL, NULL, NULL, 1, NULL, NULL, 1, '2013-05-17 11:06:39', 21, 0),
(11, 1, 'ABUS Bordo', 'Faltschloss', 'Schwarz', NULL, NULL, NULL, 1, NULL, NULL, 1, '2013-05-17 08:04:15', 21, 0),
(81, 21, 'Akku Schlüssel', 'Smart E-Bike Akku', NULL, NULL, NULL, NULL, 1, NULL, 1, 1, '2013-05-17 13:06:31', 21, 0),
(91, 21, 'Akku Schlüssel', 'Grace MX', NULL, NULL, NULL, NULL, 2, NULL, 2, 1, '2013-05-17 13:07:43', 21, 0),
(101, 21, 'Akku Schlüssel', 'KTM e-Style', NULL, NULL, NULL, NULL, 1, NULL, 3, 1, '2013-05-17 13:09:16', 21, 0),
(111, 41, 'Smart E-Bike Ladegerät', '1kg', NULL, NULL, NULL, NULL, 1, NULL, 1, 1, '2013-05-17 16:18:52', 21, 0),
(121, 41, 'Grace MX Ladegerät', '1,5kg', NULL, NULL, NULL, NULL, 1, NULL, 2, 1, '2013-05-17 16:20:26', 21, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_agbs`
--

CREATE TABLE IF NOT EXISTS `paver_agbs` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `paver_agbs`
--

INSERT INTO `paver_agbs` (`ID`, `text`) VALUES
(1, '<h1>Erste Test AGB</h1>\r\n<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>\r\n<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>\r\n<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>\r\n<p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_bikes`
--

CREATE TABLE IF NOT EXISTS `paver_bikes` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('smart','grace','ktm') CHARACTER SET latin1 NOT NULL,
  `station` int(10) unsigned DEFAULT NULL,
  `battery` float NOT NULL,
  `status` smallint(6) NOT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `booking` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `paver_bikes`
--

INSERT INTO `paver_bikes` (`ID`, `type`, `station`, `battery`, `status`, `user`, `booking`) VALUES
(1, 'smart', 1, 119, 4, NULL, NULL),
(2, 'grace', 1, 0, 5, NULL, NULL),
(3, 'ktm', 1, 0, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_booked_accessories`
--

CREATE TABLE IF NOT EXISTS `paver_booked_accessories` (
  `booking` int(10) unsigned NOT NULL,
  `accessory` int(10) unsigned NOT NULL,
  `broke` tinyint(1) NOT NULL,
  UNIQUE KEY `booking` (`booking`,`accessory`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `paver_booked_accessories`
--

INSERT INTO `paver_booked_accessories` (`booking`, `accessory`, `broke`) VALUES
(11, 31, 0),
(21, 41, 0),
(21, 71, 0),
(31, 51, 0),
(41, 31, 0),
(41, 91, 0),
(41, 61, 0),
(51, 41, 0),
(51, 71, 0),
(61, 11, 0),
(61, 101, 0),
(61, 51, 0),
(71, 41, 0),
(71, 81, 0),
(71, 71, 0),
(71, 111, 0),
(81, 121, 0),
(91, 101, 0),
(91, 51, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_bookings`
--

CREATE TABLE IF NOT EXISTS `paver_bookings` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `bike` int(10) unsigned NOT NULL,
  `startTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endTime` timestamp NULL DEFAULT NULL,
  `startStation` int(10) unsigned NOT NULL,
  `endStation` int(10) unsigned DEFAULT NULL,
  `reservation` int(10) unsigned DEFAULT NULL,
  `forcedtocancel` int(11) DEFAULT NULL,
  `sService` int(10) unsigned DEFAULT NULL,
  `eService` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=92 ;

--
-- Daten für Tabelle `paver_bookings`
--

INSERT INTO `paver_bookings` (`ID`, `user`, `bike`, `startTime`, `endTime`, `startStation`, `endStation`, `reservation`, `forcedtocancel`, `sService`, `eService`) VALUES
(1, 51, 2, '2013-05-16 18:05:53', '2013-05-17 09:33:32', 1, 1, 1, NULL, 1, 1),
(11, 41, 2, '2013-05-17 12:11:29', '2013-05-17 12:25:54', 1, 1, 11, NULL, 21, 21),
(21, 41, 1, '2013-05-17 13:14:29', '2013-05-17 13:18:26', 1, 1, 21, NULL, 21, 21),
(31, 41, 3, '2013-05-17 15:02:32', '2013-05-17 15:49:55', 1, 1, 51, NULL, 21, 21),
(41, 41, 2, '2013-05-17 16:08:16', '2013-05-17 16:22:33', 1, 2, 61, NULL, 21, 21),
(51, 41, 1, '2013-05-23 15:40:09', '2013-05-23 15:52:14', 1, 1, 81, NULL, 21, 21),
(61, 31, 3, '2013-05-28 14:00:58', '2013-05-28 17:01:22', 1, 1, 91, NULL, 121, 1),
(71, 41, 1, '2013-06-04 09:34:11', '2013-06-04 09:34:59', 1, 1, 101, NULL, 21, 21),
(81, 151, 2, '2013-06-05 12:46:41', '2013-06-05 14:41:58', 1, 1, 111, NULL, 101, 101),
(91, 161, 3, '2013-06-05 12:46:56', '2013-06-05 14:42:08', 1, 1, 121, NULL, 101, 101);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_cal_closed`
--

CREATE TABLE IF NOT EXISTS `paver_cal_closed` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `station` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `paver_cal_closed`
--

INSERT INTO `paver_cal_closed` (`ID`, `start`, `end`, `title`, `station`) VALUES
(1, '2013-06-06 14:00:00', '2013-06-07 00:00:00', 'ASTA Sommerfestival', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_cal_open`
--

CREATE TABLE IF NOT EXISTS `paver_cal_open` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `stime` time NOT NULL,
  `etime` time NOT NULL,
  `date` date NOT NULL,
  `enddate` date DEFAULT NULL,
  `period` enum('days','weeks','months','years') COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `station` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=112 ;

--
-- Daten für Tabelle `paver_cal_open`
--

INSERT INTO `paver_cal_open` (`ID`, `stime`, `etime`, `date`, `enddate`, `period`, `duration`, `station`) VALUES
(1, '18:00:00', '18:15:00', '2013-05-16', NULL, NULL, NULL, 1),
(11, '08:45:00', '18:00:00', '2013-05-17', NULL, NULL, NULL, 1),
(21, '09:00:00', '12:00:00', '2013-05-14', '2013-06-09', 'weeks', 1, 1),
(31, '09:00:00', '11:00:00', '2013-05-15', '2013-06-09', 'weeks', 1, 1),
(41, '09:00:00', '11:00:00', '2013-05-16', '2013-06-09', 'weeks', 1, 1),
(51, '09:00:00', '11:00:00', '2013-05-17', '2013-06-09', 'weeks', 1, 1),
(61, '14:00:00', '17:00:00', '2013-05-13', '2013-06-09', 'weeks', 1, 1),
(71, '14:00:00', '17:00:00', '2013-05-14', '2013-06-09', 'weeks', 1, 1),
(81, '14:00:00', '17:00:00', '2013-05-15', '2013-06-09', 'weeks', 1, 1),
(91, '14:00:00', '17:00:00', '2013-05-16', '2013-06-09', 'weeks', 1, 1),
(101, '12:00:00', '18:00:00', '2013-05-17', NULL, NULL, NULL, 2),
(111, '12:30:00', '13:59:00', '2013-06-05', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_cat_accessories`
--

CREATE TABLE IF NOT EXISTS `paver_cat_accessories` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `limit` smallint(6) NOT NULL,
  `attr1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attr5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Daten für Tabelle `paver_cat_accessories`
--

INSERT INTO `paver_cat_accessories` (`ID`, `title`, `limit`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`) VALUES
(1, 'Schlösser', 1, 'Art', 'Farbe', NULL, NULL, NULL),
(11, 'Bordcomputer', 1, 'Pedelectyp', NULL, NULL, NULL, NULL),
(21, 'Schlüssel', 1, 'für', NULL, NULL, NULL, NULL),
(31, 'Akku', 1, 'Model', 'Pedelec', NULL, NULL, NULL),
(41, 'Ladegerät', 1, 'Gewicht', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_messages`
--

CREATE TABLE IF NOT EXISTS `paver_messages` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `result` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=522 ;

--
-- Daten für Tabelle `paver_messages`
--

INSERT INTO `paver_messages` (`ID`, `user`, `title`, `text`, `result`, `timestamp`) VALUES
(1, 51, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #1</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">16.05.2013 18:05</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-16 18:04:47'),
(11, 51, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #1</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">16.05.2013 18:05</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-16 18:04:48'),
(21, 51, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #1</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">16.05.2013 18:05</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-16 18:04:54'),
(31, 51, 'Erinnerung an Rückgabe', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Rückgabe\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #1</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">16.05.2013 18:05</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 08:55:01'),
(41, 81, 'Ihr Mitarbeiterkonto wurde erfolgreich erstellt', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhr Mitarbeiter Konto wurde erfolgreich erstellt!  Bitte ändern Sie ihr Passwort umgehend!\r\n<br/><br/>\r\nIhr Passwort lautet: 261729\r\n</body></html>', 1, '2013-05-17 11:33:56'),
(51, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #11</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 12:09</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 12:24</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 12:09:57'),
(61, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #11</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 12:09</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 12:24</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 12:09:58'),
(71, 41, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #11</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 12:09</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 12:24</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 12:09:59'),
(81, 41, 'Erinnerung an Rückgabe', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Rückgabe\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #11</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 12:09</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 12:24</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 12:19:00'),
(91, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #21</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 13:13</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 13:28</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 13:13:27'),
(101, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #21</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 13:13</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 13:28</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 13:13:27'),
(111, 41, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #21</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 13:13</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 13:28</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 13:13:35'),
(121, 61, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #31</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>21.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 13:34:05'),
(131, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #41</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 14:12</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 14:42</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 14:12:54'),
(141, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #41</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 14:12</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 14:42</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 14:12:54'),
(151, 41, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #41</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 14:12</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 14:42</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 14:13:00'),
(161, 41, 'Sie sind ihre Buchung nicht angetreten', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nSie sind ihre Buchung nicht angetreten!\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #41</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 14:12</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 14:42</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 14:27:00'),
(171, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #51</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 15:01</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 18:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 15:01:44'),
(181, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #51</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 15:01</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 18:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 15:01:45'),
(191, 41, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #51</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 15:01</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 18:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 15:01:46'),
(201, 61, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #31</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>21.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 15:30:01'),
(211, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #61</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 16:04</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 16:44</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 16:04:29'),
(221, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #61</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 16:04</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 16:44</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 16:04:29'),
(231, 41, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #61</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 16:04</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>17.05.2013 16:44</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 16:04:32'),
(241, 91, 'Ihr Konto wurde eröffnet', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Ihr Konto konnte erfolgreich erstellt werden. Bitte ändern sie umgehend ihr Passwort.<br/><br/>\r\nPasswort: 339031</body></html>', 1, '2013-05-17 16:15:34'),
(251, 61, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #31</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>21.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 16:55:00'),
(261, 61, 'Sie sind ihre Buchung nicht angetreten', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nSie sind ihre Buchung nicht angetreten!\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #31</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">17.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>21.05.2013 09:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-17 17:15:00'),
(271, 101, 'Ihr Mitarbeiterkonto wurde erfolgreich erstellt', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhr Mitarbeiter Konto wurde erfolgreich erstellt!  Bitte ändern Sie ihr Passwort umgehend!\r\n<br/><br/>\r\nIhr Passwort lautet: 208479\r\n</body></html>', 1, '2013-05-23 13:34:30'),
(281, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #71</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">23.05.2013 15:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>23.05.2013 16:05</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-23 15:36:04'),
(291, 41, 'Anfrage konnte nicht bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nLeider konnte ihre Anfrage nicht bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #71</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">23.05.2013 15:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>23.05.2013 16:05</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-23 15:36:04'),
(301, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #81</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">23.05.2013 15:38</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>23.05.2013 16:08</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-23 15:38:18'),
(311, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #81</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">23.05.2013 15:38</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>23.05.2013 16:08</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-23 15:38:18'),
(321, 41, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #81</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">23.05.2013 15:38</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>23.05.2013 16:08</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-23 15:38:20'),
(331, 111, 'Ihr Konto wurde eröffnet', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Ihr Konto konnte erfolgreich erstellt werden. Bitte ändern sie umgehend ihr Passwort.<br/><br/>\r\nPasswort: 135002</body></html>', 1, '2013-05-28 13:11:46'),
(341, 31, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #91</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">28.05.2013 14:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>28.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-28 13:16:24'),
(351, 31, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #91</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">28.05.2013 14:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>28.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-28 13:17:02'),
(361, 121, 'Ihr Mitarbeiterkonto wurde erfolgreich erstellt', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhr Mitarbeiter Konto wurde erfolgreich erstellt!  Bitte ändern Sie ihr Passwort umgehend!\r\n<br/><br/>\r\nIhr Passwort lautet: 623333\r\n</body></html>', 1, '2013-05-28 13:20:32'),
(371, 31, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #91</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">28.05.2013 14:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>28.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-28 13:55:01'),
(381, 31, 'Erinnerung an Rückgabe', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Rückgabe\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #91</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">28.05.2013 14:00</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>28.05.2013 17:00</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-05-28 16:55:00'),
(401, 141, 'Ihr Mitarbeiterkonto wurde erfolgreich erstellt', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhr Mitarbeiter Konto wurde erfolgreich erstellt!  Bitte ändern Sie ihr Passwort umgehend!\r\n<br/><br/>\r\nIhr Passwort lautet: 878639\r\n</body></html>', 1, '2013-05-28 17:14:12'),
(411, 41, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #101</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">04.06.2013 09:34</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>04.06.2013 09:50</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-04 09:34:01'),
(421, 41, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #101</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">04.06.2013 09:34</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>04.06.2013 09:50</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-04 09:34:01'),
(431, 151, 'Ihr Konto wurde eröffnet', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Ihr Konto konnte erfolgreich erstellt werden. Bitte ändern sie umgehend ihr Passwort.<br/><br/>\r\nPasswort: 630510</body></html>', 1, '2013-06-05 12:02:41'),
(441, 151, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #111</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 12:12:31'),
(451, 151, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #111</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 12:12:31'),
(461, 161, 'Ihr Konto wurde eröffnet', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Ihr Konto konnte erfolgreich erstellt werden. Bitte ändern sie umgehend ihr Passwort.<br/><br/>\r\nPasswort: 254251</body></html>', 1, '2013-06-05 12:15:40'),
(471, 161, 'Ihre Anfrage wurde erfolgreich gespeichert', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #121</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 12:19:57'),
(481, 161, 'Anfrage kann bedient werden', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;"><h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #121</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 12:19:57'),
(491, 151, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #111</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 12:30:00'),
(501, 161, 'Erinnerung an Ihre Buchung!', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #121</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 12:30:00'),
(511, 151, 'Erinnerung an Rückgabe', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Rückgabe\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #111</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 13:50:00');
INSERT INTO `paver_messages` (`ID`, `user`, `title`, `text`, `result`, `timestamp`) VALUES
(521, 161, 'Erinnerung an Rückgabe', '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PaVeR</title></head><body style="font-family: ''Verdana''; font-size: 14px;">Erinnerung an Rückgabe\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id="book">\r\n<tr><th colspan="2">Buchung/Anfrage #121</th></tr>\r\n<tr><td  style="font-weight: bold; width: 140px;">Startzeit:</td></td><td style="width: 227px;">05.06.2013 12:35</td></tr>\r\n<tr><td style="font-weight: bold;">Endzeit:</td><td>05.06.2013 13:55</td></tr>\r\n<tr><td style="font-weight: bold;">Start Station:</td><td>Universität</td></tr>\r\n<tr><td style="font-weight: bold; ">End Station:</td><td>Universität</td></tr>\r\n</table>\r\n</body></html>', 1, '2013-06-05 13:50:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_preferences`
--

CREATE TABLE IF NOT EXISTS `paver_preferences` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `group` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `varchar_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_value` text COLLATE utf8_unicode_ci,
  `int_value` int(11) DEFAULT NULL,
  `bool_value` tinyint(1) DEFAULT NULL,
  `datetime_value` datetime DEFAULT NULL,
  `time_value` time DEFAULT NULL,
  `type` enum('varchar','text','int','bool','datetime','time') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=92 ;

--
-- Daten für Tabelle `paver_preferences`
--

INSERT INTO `paver_preferences` (`ID`, `key`, `group`, `label`, `desc`, `varchar_value`, `text_value`, `int_value`, `bool_value`, `datetime_value`, `time_value`, `type`) VALUES
(1, 'pageTitle', 1, 'Seiten Titel', NULL, 'PaVeR', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(2, 'startAccept', 1, 'Buchungen Annehmen', 'Wieviel min vor der Startzeit sollen Buchungen zugesagt werden.', NULL, NULL, 90, NULL, NULL, NULL, 'int'),
(3, 'startCancel', 1, 'Buchungen absagen', 'Wieviele min vor der Startzeit sollen Buchungen abgesagt werden', NULL, NULL, 60, NULL, NULL, NULL, 'int'),
(4, 'unattended', 1, 'Nicht angetreten', 'Die Buchung wird nach ablauf dieser Minuten als nicht angetreten deklariert.', NULL, NULL, 15, NULL, NULL, NULL, 'int'),
(5, 'mTitlePrefered', 2, 'Titel wenn zurückgestuft', NULL, 'Buchung zurückgestuft', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(6, 'mTxtPrefered', 2, 'Text wenn zurückgestuft', NULL, NULL, '<h1>PaVeR</h1>\r\nLeider müssen wir Ihnen mitteilen, dass durch einen Störfall ihre Buchung nicht mehr bedient werden kann.\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(7, 'mTitleQueued', 2, 'Titel wenn zugesagt', NULL, 'Anfrage kann bedient werden', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(8, 'mTxtQueued', 2, 'Text wenn zugesagt', NULL, NULL, '<h1>PaVeR</h1>\r\nIhre Anfrage kann bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(9, 'mTitleFailed', 2, 'Titel wenn nicht bedient werden konnte', NULL, 'Anfrage konnte nicht bedient werden', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(10, 'mTxtFailed', 2, 'Text wenn nicht bedient werden konnte', NULL, NULL, '<h1>PaVeR</h1>\r\nLeider konnte ihre Anfrage nicht bedient werden.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(11, 'mTitleCanceled', 2, 'Titel Stornierung', NULL, 'Die Buchung wurde storniert', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(12, 'mTxtCanceled', 2, 'Text Stornierung', NULL, NULL, '<h1>PaVeR</h1>\r\nIhre Buchung wurde stroniert.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(35, 'mailFrom', 1, 'E-Mail Sender', 'Wie lautet die E-Mail adresse von dem Versender?\r\n\r\nBsp. \r\n"PaVeR System <paver@mail.upb.de>"', 'PaVeR System <PaVeR@wiwi.uni-paderborn.de>', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(20, 'prefereqbooks', 1, 'Schnelle Buchungen bevorzugen', 'Sollen schnelle Buchungen bevorzugt werden im Belegungsplan?', NULL, NULL, NULL, 1, NULL, NULL, 'bool'),
(21, 'mTitlersave', 2, 'Titel Anfrage wurde gespeichert', NULL, 'Ihre Anfrage wurde erfolgreich gespeichert', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(22, 'mTxtrsave', 2, 'Text Anfrage wurde gespeichert', NULL, NULL, '<h1>PaVeR</h1>\r\nIhre Buchung wurde erfolgreich gespeichert. Hier nochmal eine Zusammenfassung. <br/><br/>\r\n\r\nWenn die Anfrage zugesagt wird erhalten Sie eine weitere Bestätigungsemail.\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(23, 'exceptionStartTime', 4, 'Fehler Startzeit in Vergangenheit', NULL, NULL, 'Startzeit liegt in der Vergangenheit!', NULL, NULL, NULL, NULL, 'text'),
(24, 'exceptionEndTime', 4, 'Endzeit vor der Startzeit', NULL, NULL, 'Die Endzeit liegt vor der Startzeit!', NULL, NULL, NULL, NULL, 'text'),
(25, 'exlentoshort', 4, 'Länge der Entleihe zu kurz', NULL, NULL, 'Länge der Entleihe zu kurz, mind. 15min', NULL, NULL, NULL, NULL, 'text'),
(26, 'maxlen', 1, 'Maximale Dauer einer Entleihe', 'In Minuten (z.B. 5760 entspricht 4 Tagen)', NULL, NULL, 5760, NULL, NULL, NULL, 'int'),
(27, 'minlen', 1, 'Minimale Dauer einer Entleihe', 'In Minuten', NULL, NULL, 15, NULL, NULL, NULL, 'int'),
(28, 'exlenmax', 4, 'Maximale Entleihe', NULL, NULL, 'Die maximale Dauer einer Entleihe wurde überschritten!', NULL, NULL, NULL, NULL, 'text'),
(29, 'exstclosed', 4, 'Startstation kein service', NULL, NULL, 'Zum Startzeitpunkt ist die Startstation nicht besetzt', NULL, NULL, NULL, NULL, 'text'),
(30, 'exetclosed', 4, 'Enstation kein Service', NULL, NULL, 'Zum Endzeitpunkt ist die Endstation nicht besetzt', NULL, NULL, NULL, NULL, 'text'),
(31, 'mTitleunattended', 2, 'Titel nicht angetreten', NULL, 'Sie sind ihre Buchung nicht angetreten', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(32, 'mTxtunattended', 2, 'Text nicht angetreten', NULL, NULL, '<h1>PaVeR</h1>\r\nSie sind ihre Buchung nicht angetreten!\r\n\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(33, 'exintersection', 4, 'Überschneidung', NULL, NULL, 'Es gab eine Überschneidung mit einer älteren Buchung von Ihnen!\r\n\r\nEs sind keine parallelen Entleihen möglich.', NULL, NULL, NULL, NULL, 'text'),
(34, 'maxlenactive', 1, 'Entleihe einschränken (Maximal)', NULL, NULL, NULL, NULL, 0, NULL, NULL, 'bool'),
(36, 'mTiWcreated', 2, 'Titel Mitarbeiter erstellt', NULL, 'Ihr Mitarbeiterkonto wurde erfolgreich erstellt', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(37, 'mTxWcreated', 2, 'Text Mitarbeiter erstellt', NULL, NULL, '<h1>PaVeR</h1>\r\nIhr Mitarbeiter Konto wurde erfolgreich erstellt!  Bitte ändern Sie ihr Passwort umgehend!\r\n<br/><br/>\r\nIhr Passwort lautet: %s\r\n', NULL, NULL, NULL, NULL, 'text'),
(38, 'mTiPwReset', 2, 'Titel Passwort Zurückgesetzt', NULL, 'Ihr Passwort wurde zurückgesetzt', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(39, 'mTxPwReset', 2, 'Text Passwort wurde zurückgesetzt', NULL, NULL, '<h1>PaVeR</h1>\r\nIhr Passwort wurde zurückgesetzt. Bitte ändern Sie ihr neues Passwort bei nächster Gelegenheit!\r\n<br/><br/>\r\nIhr neues Passwort lautet: %s', NULL, NULL, NULL, NULL, 'text'),
(40, 'qbooksdiff', 1, 'Schnelle Buchungen', 'Bis welche Zeit in Minuten ist eine Buchung eine schnelle Buchung? (Standard: 30min)', NULL, NULL, 30, NULL, NULL, NULL, 'int'),
(41, 'maxprebooktimebool', 1, 'Maximale Vorbuchzeit aktivieren?', 'Eine Anzahl von Tagen die Maximal vorgeplant werden darf. Soll diese Grenze aktiviert sein?', NULL, NULL, NULL, 0, NULL, NULL, 'bool'),
(42, 'maxprebooktime', 1, 'Maximale Vorbuchzeit', 'Eine Anzahl von Tagen die Maximal vorgeplant werden darf. ', NULL, NULL, 14, NULL, NULL, NULL, 'int'),
(43, 'exmaxprebooktime', 4, 'Maximale Vorbuchungszeit', 'Warnung wenn die maximale Vorbuchungszeit überschritten wurde', NULL, 'Sie haben die maximale Vorbuchungszeit von 14 Tagen überschritten!', NULL, NULL, NULL, NULL, 'text'),
(44, 'mTiCcreated', 2, 'Kunde erstellt Titel', NULL, 'Ihr Konto wurde eröffnet', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(45, 'mTxCcreated', 2, 'Kunde erstellt Text', NULL, NULL, 'Ihr Konto konnte erfolgreich erstellt werden. Bitte ändern sie umgehend ihr Passwort.<br/><br/>\r\nPasswort: %s', NULL, NULL, NULL, NULL, 'text'),
(46, 'startreminder', 1, 'Erinnerungen an Entleihe', 'Wie viele Minuten vor Entleihe soll der Kunde erinnert werden per E-Mail?', NULL, NULL, NULL, NULL, NULL, '00:05:00', 'time'),
(47, 'mTiSRem', 2, 'Titel Erinnerung an Entleihe', NULL, 'Erinnerung an Ihre Buchung!', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(48, 'mTxSRem', 2, 'Text Erinnerung an Entleihe', NULL, NULL, 'Erinnerung an Ihre Buchung!\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(49, 'mTiERem', 2, 'Text Erinnerung an Rückgabe', NULL, 'Erinnerung an Rückgabe', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(50, 'mTxERem', 2, 'Text Erinnerung an Rückgabe', NULL, NULL, 'Erinnerung an Rückgabe\r\n<br/><br/>\r\n<style>\r\n#book { border-collapse: collapse;  }\r\n#book td {\r\n	border-bottom: #aaa 1px solid;\r\n	padding: 4px;\r\n}\r\n#book th {\r\n	border-bottom: #000 2px solid;\r\n	padding: 4px;\r\n}\r\n#book tr:last-child td {\r\n	border-bottom: 0px;\r\n}\r\n</style>\r\n<table id=\\"book\\">\r\n<tr><th colspan=\\"2\\">Buchung/Anfrage #%s</th></tr>\r\n<tr><td  style=\\"font-weight: bold; width: 140px;\\">Startzeit:</td></td><td style=\\"width: 227px;\\">%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Endzeit:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold;\\">Start Station:</td><td>%s</td></tr>\r\n<tr><td style=\\"font-weight: bold; \\">End Station:</td><td>%s</td></tr>\r\n</table>\r\n', NULL, NULL, NULL, NULL, 'text'),
(51, 'endreminder', 1, 'Erinnerungen an Rückgabe', 'Wieviele Minuten vorher soll an die Rückgabe erinnert werden?', NULL, NULL, NULL, NULL, NULL, '00:05:00', 'time'),
(61, 'dbLock', -1, '', NULL, 'null', NULL, NULL, NULL, NULL, NULL, 'varchar'),
(71, 'lastCron', -1, '', NULL, NULL, NULL, NULL, NULL, NULL, '00:11:00', 'time'),
(81, 'exnotfoundcust', 4, 'Kunde konnte nicht gefunden werden', NULL, NULL, 'Es konnte kein Kunde gefunden werden!', NULL, NULL, NULL, NULL, 'text'),
(91, 'agb', 1, 'Aktuelle AGB', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_reminder`
--

CREATE TABLE IF NOT EXISTS `paver_reminder` (
  `reservation` int(10) unsigned NOT NULL,
  `status` enum('start','end') COLLATE utf8_unicode_ci NOT NULL,
  `send` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `reservation` (`reservation`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `paver_reminder`
--

INSERT INTO `paver_reminder` (`reservation`, `status`, `send`) VALUES
(1, 'start', '2013-05-16 18:04:54'),
(1, 'end', '2013-05-17 08:55:01'),
(11, 'start', '2013-05-17 12:09:59'),
(11, 'end', '2013-05-17 12:19:00'),
(21, 'start', '2013-05-17 13:13:35'),
(41, 'start', '2013-05-17 14:13:00'),
(51, 'start', '2013-05-17 15:01:46'),
(61, 'start', '2013-05-17 16:04:32'),
(31, 'start', '2013-05-17 16:55:00'),
(81, 'start', '2013-05-23 15:38:20'),
(91, 'start', '2013-05-28 13:55:01'),
(91, 'end', '2013-05-28 16:55:00'),
(111, 'start', '2013-06-05 12:30:00'),
(121, 'start', '2013-06-05 12:30:00'),
(111, 'end', '2013-06-05 13:50:00'),
(121, 'end', '2013-06-05 13:50:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_reports`
--

CREATE TABLE IF NOT EXISTS `paver_reports` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bike` int(10) unsigned DEFAULT NULL,
  `battery` float DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `subject` enum('login','logout','crash','changed','start','end','report','canceled') COLLATE utf8_unicode_ci NOT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `service` int(10) unsigned DEFAULT NULL,
  `reservation` int(10) unsigned DEFAULT NULL,
  `booking` int(10) unsigned DEFAULT NULL,
  `station` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=752 ;

--
-- Daten für Tabelle `paver_reports`
--

INSERT INTO `paver_reports` (`ID`, `timestamp`, `bike`, `battery`, `status`, `comment`, `subject`, `user`, `service`, `reservation`, `booking`, `station`) VALUES
(1, '2013-05-16 18:00:29', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(11, '2013-05-16 18:02:11', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(21, '2013-05-16 18:05:28', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(31, '2013-05-16 18:05:53', 2, 100, 5, NULL, 'start', 51, 1, NULL, 1, NULL),
(41, '2013-05-17 09:33:13', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(51, '2013-05-17 09:33:32', 2, 20, 5, '', 'end', 51, 1, NULL, 1, NULL),
(61, '2013-05-17 11:15:46', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(71, '2013-05-17 11:26:20', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(81, '2013-05-17 11:26:56', 2, 100, 5, NULL, 'changed', NULL, 21, NULL, NULL, NULL),
(91, '2013-05-17 11:27:01', 3, 100, 5, NULL, 'changed', NULL, 21, NULL, NULL, NULL),
(101, '2013-05-17 11:34:21', NULL, NULL, NULL, NULL, 'login', NULL, 81, NULL, NULL, 2),
(111, '2013-05-17 12:10:49', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(121, '2013-05-17 12:11:29', 2, 100, 5, NULL, 'start', 41, 21, NULL, 11, NULL),
(131, '2013-05-17 12:25:54', 2, 90, 5, '', 'end', 41, 21, NULL, 11, NULL),
(141, '2013-05-17 12:48:03', NULL, NULL, NULL, NULL, 'logout', NULL, 21, NULL, NULL, 1),
(151, '2013-05-17 12:48:07', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 2),
(161, '2013-05-17 13:12:30', NULL, NULL, NULL, NULL, 'logout', NULL, 21, NULL, NULL, 2),
(171, '2013-05-17 13:12:31', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(181, '2013-05-17 13:13:47', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(191, '2013-05-17 13:14:29', 1, 100, 5, NULL, 'start', 41, 21, NULL, 21, NULL),
(201, '2013-05-17 13:18:26', 1, 96, 5, '', 'end', 41, 21, NULL, 21, NULL),
(211, '2013-05-17 13:34:20', NULL, NULL, NULL, NULL, 'login', NULL, 11, NULL, NULL, 1),
(221, '2013-05-17 13:34:36', 2, 90, 3, NULL, 'changed', NULL, 11, NULL, NULL, NULL),
(231, '2013-05-17 13:34:40', 3, 100, 4, NULL, 'changed', NULL, 11, NULL, NULL, NULL),
(241, '2013-05-17 14:30:31', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(251, '2013-05-17 15:02:05', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(261, '2013-05-17 15:02:32', 3, 100, 4, NULL, 'start', 41, 21, NULL, 31, NULL),
(271, '2013-05-17 15:12:38', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(281, '2013-05-17 15:49:55', 3, 70, 5, '', 'end', 41, 21, NULL, 31, NULL),
(291, '2013-05-17 16:05:59', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(301, '2013-05-17 16:08:16', 2, 90, 3, NULL, 'start', 41, 21, NULL, 41, NULL),
(311, '2013-05-17 16:14:07', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(321, '2013-05-17 16:22:05', NULL, NULL, NULL, NULL, 'logout', NULL, 21, NULL, NULL, 1),
(331, '2013-05-17 16:22:10', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 2),
(341, '2013-05-17 16:22:33', 2, 50, 5, '', 'end', 41, 21, NULL, 41, NULL),
(351, '2013-05-18 00:35:22', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(361, '2013-05-18 00:35:30', NULL, NULL, NULL, NULL, 'logout', NULL, 21, NULL, NULL, 1),
(371, '2013-05-18 00:35:33', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 2),
(381, '2013-05-18 00:37:08', NULL, NULL, NULL, NULL, 'logout', NULL, 21, NULL, NULL, 2),
(391, '2013-05-18 23:38:59', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(401, '2013-05-21 11:49:39', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(411, '2013-05-21 17:32:31', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(421, '2013-05-21 19:19:42', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(431, '2013-05-23 13:36:56', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(441, '2013-05-23 13:39:25', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(451, '2013-05-23 13:39:30', NULL, NULL, NULL, NULL, 'logout', NULL, 21, NULL, NULL, 1),
(461, '2013-05-23 15:36:15', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(471, '2013-05-23 15:38:34', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(481, '2013-05-23 15:40:09', 1, 96, 5, NULL, 'start', 41, 21, NULL, 51, NULL),
(491, '2013-05-23 15:52:14', 1, 119, 4, '', 'end', 41, 21, NULL, 51, NULL),
(501, '2013-05-27 18:09:23', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(511, '2013-05-28 10:05:24', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(521, '2013-05-28 13:14:12', NULL, NULL, NULL, NULL, 'login', NULL, 11, NULL, NULL, 1),
(531, '2013-05-28 13:22:12', NULL, NULL, NULL, NULL, 'login', NULL, 121, NULL, NULL, 1),
(541, '2013-05-28 14:00:58', 3, 70, 5, NULL, 'start', 31, 121, NULL, 61, NULL),
(551, '2013-05-28 14:12:13', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(561, '2013-05-28 16:01:23', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(571, '2013-05-28 17:00:55', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(581, '2013-05-28 17:01:22', 3, 5, 5, '', 'end', 31, 1, NULL, 61, NULL),
(591, '2013-05-29 13:04:57', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(601, '2013-06-04 09:33:35', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(611, '2013-06-04 09:34:11', 1, 119, 4, NULL, 'start', 41, 21, NULL, 71, NULL),
(621, '2013-06-04 09:34:59', 1, 119, 4, 'Test Adhoc Entleihe', 'end', 41, 21, NULL, 71, NULL),
(631, '2013-06-04 09:40:12', NULL, NULL, NULL, NULL, 'login', NULL, 1, NULL, NULL, 1),
(641, '2013-06-05 11:18:22', NULL, NULL, NULL, NULL, 'login', NULL, 101, NULL, NULL, 1),
(651, '2013-06-05 12:08:22', NULL, NULL, NULL, NULL, 'login', NULL, 101, NULL, NULL, 1),
(661, '2013-06-05 12:14:30', NULL, NULL, NULL, NULL, 'login', NULL, 101, NULL, NULL, 1),
(671, '2013-06-05 12:20:23', NULL, NULL, NULL, NULL, 'login', NULL, 101, NULL, NULL, 1),
(681, '2013-06-05 12:46:41', 2, 50, 5, NULL, 'start', 151, 101, NULL, 81, NULL),
(691, '2013-06-05 12:46:56', 3, 5, 5, NULL, 'start', 161, 101, NULL, 91, NULL),
(701, '2013-06-05 14:41:45', NULL, NULL, NULL, NULL, 'login', NULL, 101, NULL, NULL, 1),
(711, '2013-06-05 14:41:58', 2, 0, 5, '', 'end', 151, 101, NULL, 81, NULL),
(721, '2013-06-05 14:42:08', 3, 0, 5, '', 'end', 161, 101, NULL, 91, NULL),
(731, '2013-06-05 18:57:33', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(741, '2013-06-06 11:58:26', NULL, NULL, NULL, NULL, 'login', NULL, 21, NULL, NULL, 1),
(751, '2013-06-06 15:47:58', NULL, NULL, NULL, NULL, 'login', NULL, 101, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_reservations`
--

CREATE TABLE IF NOT EXISTS `paver_reservations` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `booking` int(10) unsigned DEFAULT NULL,
  `startstation` int(10) unsigned NOT NULL,
  `endstation` int(10) unsigned NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('crash','forcedtocancel','unattended','progress','queued','succeeded','canceled','pending','failed','prefered') COLLATE utf8_unicode_ci NOT NULL,
  `canceled` timestamp NULL DEFAULT NULL,
  `forcedtocancel` int(11) DEFAULT NULL,
  `creator` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=122 ;

--
-- Daten für Tabelle `paver_reservations`
--

INSERT INTO `paver_reservations` (`ID`, `user`, `booking`, `startstation`, `endstation`, `startTime`, `endTime`, `created`, `status`, `canceled`, `forcedtocancel`, `creator`) VALUES
(1, 51, 1, 1, 1, '2013-05-16 18:05:00', '2013-05-17 09:00:00', '2013-05-16 18:04:47', 'succeeded', NULL, NULL, 51),
(11, 41, 11, 1, 1, '2013-05-17 12:09:00', '2013-05-17 12:24:00', '2013-05-17 12:09:57', 'succeeded', NULL, NULL, 41),
(21, 41, 21, 1, 1, '2013-05-17 13:13:00', '2013-05-17 13:28:00', '2013-05-17 13:13:27', 'succeeded', NULL, NULL, 41),
(31, 61, NULL, 1, 1, '2013-05-17 17:00:00', '2013-05-21 09:00:00', '2013-05-17 13:34:05', 'unattended', NULL, NULL, 61),
(41, 41, NULL, 1, 1, '2013-05-17 14:12:00', '2013-05-17 14:42:00', '2013-05-17 14:12:54', 'unattended', NULL, NULL, 41),
(51, 41, 31, 1, 1, '2013-05-17 15:01:00', '2013-05-17 18:00:00', '2013-05-17 15:01:44', 'succeeded', NULL, NULL, 41),
(61, 41, 41, 1, 1, '2013-05-17 16:04:00', '2013-05-17 16:44:00', '2013-05-17 16:04:29', 'succeeded', NULL, NULL, 41),
(91, 31, 61, 1, 1, '2013-05-28 14:00:00', '2013-05-28 17:00:00', '2013-05-28 13:16:24', 'succeeded', NULL, NULL, 31),
(81, 41, 51, 1, 1, '2013-05-23 15:38:00', '2013-05-23 16:08:00', '2013-05-23 15:38:18', 'succeeded', NULL, NULL, 41),
(101, 41, 71, 1, 1, '2013-06-04 09:34:00', '2013-06-04 09:50:00', '2013-06-04 09:34:00', 'succeeded', NULL, NULL, 21),
(111, 151, 81, 1, 1, '2013-06-05 12:35:00', '2013-06-05 13:55:00', '2013-06-05 12:12:31', 'succeeded', NULL, NULL, 151),
(121, 161, 91, 1, 1, '2013-06-05 12:35:00', '2013-06-05 13:55:00', '2013-06-05 12:19:57', 'succeeded', NULL, NULL, 161);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_rights`
--

CREATE TABLE IF NOT EXISTS `paver_rights` (
  `position` int(11) NOT NULL,
  `label` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `paver_rights`
--

INSERT INTO `paver_rights` (`position`, `label`, `desc`, `key`) VALUES
(0, 'Mitarbeiter', 'Mitarbeiter anlegen, bearbeiten, sperren.', 'worker'),
(1, 'Kunden', 'Kunden anlegen, bearbeiten, sperren.', 'customers'),
(2, 'Stationen', 'Kann an Stationen denen er zugeordnet ist Pedelecs entleihen, zurücknehmen und Status bearbeiten', 'moderate'),
(3, 'Öffnungszeiten', 'Öffnungszeiten bearbeiten', 'calendar'),
(4, 'Allgemeine Einstellungen', 'Einstellungen zu Zeiträumen und das Verleihsystem im Allgemeinen', 'prefAllg'),
(5, 'E-Mail Texte', 'Die Texte der E-Mails bearbeiten.', 'prefMail'),
(6, 'Texte der Warnungen/Meldungen', 'Die Meldungen bzw. Warnungen die ausgegeben werden wenn eine Anfrage', 'prefExc'),
(7, 'Anfragen- und Buchungsverlauf', 'Benutzer kann sich den Anfragen und Buchungsverlauf anschauen.', 'overview'),
(8, 'Pedelecs', 'Zugriff auf die Verwaltung der Pedelecs des Systems.', 'pedelecs'),
(9, 'Zubehör', 'Stammdaten Zubehör verwalten', 'accessories'),
(10, 'Adhoc Entleihe Vollmacht', 'Volle Berechtigung bei adhoc Entleihen. \r\nMuss bei Angabe der Endzeit nicht die Öffnungszeit beachten etc.', 'adhoc');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_stations`
--

CREATE TABLE IF NOT EXISTS `paver_stations` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET latin1 NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `power` tinyint(1) NOT NULL,
  `slots` mediumint(9) NOT NULL,
  `pass` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `paver_stations`
--

INSERT INTO `paver_stations` (`ID`, `title`, `longitude`, `latitude`, `power`, `slots`, `pass`) VALUES
(1, 'Universität', 8.77155, 51.7081, 1, 20, 'da26305744816945c8c101b2c484c9baf1b4e635005ee44494594ce0b71cc1143fa2a1b83df4e4dcd166f352ea0ca57e402df5ba5c7a212bac7c7d426893ab1b'),
(2, 'HNI', 8.73568, 51.7314, 0, 20, 'da26305744816945c8c101b2c484c9baf1b4e635005ee44494594ce0b71cc1143fa2a1b83df4e4dcd166f352ea0ca57e402df5ba5c7a212bac7c7d426893ab1b');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_station_rights`
--

CREATE TABLE IF NOT EXISTS `paver_station_rights` (
  `user` int(11) NOT NULL,
  `station` int(11) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  UNIQUE KEY `user` (`user`,`station`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `paver_station_rights`
--

INSERT INTO `paver_station_rights` (`user`, `station`, `start`, `end`) VALUES
(21, 1, NULL, NULL),
(21, 2, NULL, NULL),
(11, 1, NULL, NULL),
(11, 2, NULL, NULL),
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(81, 2, NULL, NULL),
(101, 1, NULL, NULL),
(121, 1, NULL, NULL),
(121, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_users`
--

CREATE TABLE IF NOT EXISTS `paver_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `booking` int(10) unsigned DEFAULT NULL,
  `bike` int(10) unsigned DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `worker` tinyint(1) NOT NULL,
  `matrikel` int(11) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `zip` int(11) NOT NULL,
  `street` varchar(250) NOT NULL,
  `home` varchar(100) NOT NULL,
  `birth` date NOT NULL,
  `major` varchar(100) NOT NULL,
  `rights` int(10) unsigned NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `creator` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

--
-- Daten für Tabelle `paver_users`
--

INSERT INTO `paver_users` (`ID`, `name`, `surname`, `password`, `booking`, `bike`, `email`, `worker`, `matrikel`, `phone`, `zip`, `street`, `home`, `birth`, `major`, `rights`, `start`, `end`, `creator`, `created`) VALUES
(1, 'Dennis', 'H', '', NULL, NULL, 'yxccvb@wiwi.upb.de', 1, 0, '01600000000', 0, '', '', '0000-00-00', '', 4290772992, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(11, 'André', 'W', '', NULL, NULL, 'wca@upb.de', 1, 0, '01749009004', 0, '', '', '0000-00-00', '', 4290772992, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(21, 'Test', 'Benutzer', 'da26305744816945c8c101b2c484c9baf1b4e635005ee44494594ce0b71cc1143fa2a1b83df4e4dcd166f352ea0ca57e402df5ba5c7a212bac7c7d426893ab1b', NULL, NULL, 'test@mail.upb.de', 1, 123123, '00000', 0, '', '', '0000-00-00', '', 4290772992, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(31, 'Ivo', 'S', '', NULL, NULL, 'asdfdg@wiwi.upb.de', 0, 123123, '0', 0, '', '', '0000-00-00', '', 0, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(41, 'Johannes', 'K', '', NULL, NULL, 'sdfghj@mail.uni-paderborn.de', 0, 123123, '000000000', 0, '', '', '0000-00-00', '', 0, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(51, 'Dennis', 'H', '', NULL, NULL, 'sdfghj@me.com', 0, 123123, '0', 0, '', '', '0000-00-00', '', 0, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(61, 'André', 'W', '', NULL, NULL, 'fghjkl@me.com', 0, 123123, '0', 0, '', '', '0000-00-00', '', 0, '2013-01-01 00:00:00', '2013-11-01 00:00:00', 21, '2013-05-16 15:13:14'),
(71, 'Uwe', 'K', '', NULL, NULL, 'eqwzrt@wiwi.upb.de', 0, 123123, '0', 0, '', '', '0000-00-00', '', 0, '2013-01-01 00:00:00', '2013-10-01 00:00:00', 21, '2013-05-16 15:13:14'),
(101, 'Sebastian', 'K', '', NULL, NULL, 'jklyxc@asd.net', 1, 0, '', 0, '', '', '0000-00-00', '', 2143289344, '2013-05-23 13:33:00', '2013-10-10 13:33:00', 21, '2013-05-23 13:34:30'),
(111, 'Christopher', 'A', '', NULL, NULL, 'qwertz@mail.upb.de', 0, 123123, '', 0, '', '', '2013-05-28', '', 0, '2013-05-28 13:11:00', '2013-09-30 13:11:00', 11, '2013-05-28 13:11:46'),
(121, 'Ivo', 'S', '', NULL, NULL, 'wertzu@gmx.de', 1, 0, '', 0, '', '', '0000-00-00', '', 4290772992, '2013-05-28 13:20:00', '2013-09-30 13:20:00', 11, '2013-05-28 13:20:31'),
(151, 'Klatte', 'S', '', NULL, NULL, 'rtzuio@mail.uni-paderborn.de', 0, 123123, '', 0, '', '', '', '', 0, '2013-06-05 12:01:00', '2013-06-30 12:01:00', 101, '2013-06-05 12:02:41'),
(161, 'Stroop', 'S', '', NULL, NULL, 'ertzui@mail.uni-paderborn.de', 0, 123123, '', 123, 'lala', 'Herford', '2013-06-05', 'Wirtschaftswissenschaften', 0, '2013-06-05 12:14:00', '2013-06-30 12:14:00', 101, '2013-06-05 12:15:40');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paver_validcustomer`
--

CREATE TABLE IF NOT EXISTS `paver_validcustomer` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agb` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `sign` text NOT NULL,
  `userid` text NOT NULL,
  `worker` int(10) unsigned DEFAULT NULL,
  `validated` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `paver_validcustomer`
--

