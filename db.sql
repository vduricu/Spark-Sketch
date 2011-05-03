-- Spark Sketch - V 0.1 - Tristan Tzara Build

-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 27 Apr 2011 la 07:39
-- Versiune server: 5.5.8
-- Versiune PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Baza de date: `sketch`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Salvarea datelor din tabel `draws`
--

INSERT INTO `draws` (`id`, `userid`, `title`, `filename`, `creationdate`, `modificationdate`) VALUES
(1, 2, 'Salut Facebook', '4PmYj0eGahBG', '2011-04-26 16:52:49', '2011-04-26 16:52:49'),
(4, 1, 'admin', 'RQNTmlo9nY7X', '2011-04-26 21:47:52', '2011-04-26 21:47:52'),
(9, 2, 'sada', 'W07288s8V0pz', '2011-04-27 10:30:28', '2011-04-27 10:30:28');

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
  `activated` enum('yes','no') NOT NULL DEFAULT 'no',
  `activation_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Salvarea datelor din tabel `user`
--

INSERT INTO `user` (`id`, `user`, `password`, `rank`, `email`, `firstname`, `lastname`, `creationDate`, `lang`, `quota`, `activated`, `activation_code`) VALUES
(1, 'admin', '3ab32bd3c4eddcce66a8bf6042e65987148017f1', 'admin', 'admin@sparkblog.net', 'Valentin', 'Duricu', '2011-04-25 20:28:37', 'en', -1, 'yes', NULL),
(2, 'usertest', '3ab32bd3c4eddcce66a8bf6042e65987148017f1', 'user', 'test@sparkblog.net', 'Test', 'Utilizator', '2011-04-25 22:19:55', 'en', 100, 'yes', NULL);
