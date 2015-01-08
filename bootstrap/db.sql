-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Jan 2015 um 13:19
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `guestbook`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gbentry`
--

DROP TABLE IF EXISTS `gbentry`;
CREATE TABLE IF NOT EXISTS `gbentry` (
  `id_gbentry` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` char(30) NOT NULL,
  `title` char(100) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_gbentry`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `gbentry`
--

INSERT INTO `gbentry` (`id_gbentry`, `author`, `title`, `text`, `date`) VALUES
(1, 'julie', 'asd', 'asdasdasd', '2015-01-07 11:19:03'),
(2, 'dana', 'es funktioniert', 'asdasdasa', '2015-01-07 11:19:16'),
(3, 'asd', 'asd', 'asdasdas', '2015-01-07 12:09:23'),
(4, 'QWERT', 'asdasd', 'asdaasdasd', '2015-01-07 12:11:47'),
(5, 'asdasd', 'asdasda', '??????????????', '2015-01-07 12:27:15'),
(6, 'asdad', 'asdas', 'asdadd', '2015-01-07 13:09:00'),
(7, 'JulieNeuTest', 'jquery tweets', 'adsasddad', '2015-01-07 13:12:06'),
(8, 'asdsada', 'asdad', 'asdasdasd', '2015-01-07 13:16:55');