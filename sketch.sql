-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 16 Mai 2011 la 11:31
-- Versiune server: 5.5.8
-- Versiune PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Baza de date: `sketch`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Salvarea datelor din tabel `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(1, 'default_language', 'en'),
(2, 'timezone', 'Europe/Bucharest'),
(3, 'site_name', 'Spark Sketch');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `draws`
--

CREATE TABLE IF NOT EXISTS `draws` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `creationdate` datetime NOT NULL,
  `modificationdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Salvarea datelor din tabel `draws`
--

INSERT INTO `draws` (`id`, `userid`, `title`, `filename`, `creationdate`, `modificationdate`) VALUES
(21, 2, 'Titei :P', 'pFqCTA4G6DWv', '2011-05-10 08:32:46', '2011-05-10 08:32:46'),
(22, 2, 'Integrala?', 'YpOo11Sda2Ri', '2011-05-10 08:33:53', '2011-05-10 08:33:53'),
(20, 1, 'titei', '6frVelAPbMQs', '2011-05-10 08:31:50', '2011-05-10 08:31:50'),
(19, 1, 'Bine ai venit!', '4UuZCoQ2oF9S', '2011-05-10 08:29:17', '2011-05-10 08:29:17');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `rank` enum('admin','user') NOT NULL DEFAULT 'user',
  `email` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `creationDate` datetime NOT NULL,
  `lang` enum('en','ro') NOT NULL DEFAULT 'en',
  `quota` int(10) NOT NULL DEFAULT '100',
  `sketch_width` int(4) NOT NULL DEFAULT '720',
  `sketch_height` int(4) NOT NULL DEFAULT '580',
  `activated` enum('yes','no') NOT NULL DEFAULT 'no',
  `activation_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Salvarea datelor din tabel `user`
--

INSERT INTO `user` (`id`, `user`, `password`, `rank`, `email`, `firstname`, `lastname`, `creationDate`, `lang`, `quota`, `sketch_width`, `sketch_height`, `activated`, `activation_code`) VALUES
(1, 'admin', '3ab32bd3c4eddcce66a8bf6042e65987148017f1', 'admin', 'admin@duricu.ro', 'Website', 'Administrator', '2011-04-25 20:28:37', 'ro', -1, 720, 580, 'yes', NULL),
(2, 'user', '3ab32bd3c4eddcce66a8bf6042e65987148017f1', 'user', 'user@duricu.ro', 'Test', 'Utilizator', '2011-04-25 22:19:55', 'ro', 100, 720, 580, 'yes', NULL);
