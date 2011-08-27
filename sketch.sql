-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 27 Aug 2011 la 10:29
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
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Salvarea datelor din tabel `config`
--

INSERT INTO `config` (`name`, `value`) VALUES
('plugins', 'a:1:{i:0;s:7:"akismet";}'),
('timezone', 'Europe/Bucharest'),
('title', 'Spark Sketch'),
('path', ''),
('default_height', '580'),
('default_width', '850'),
('description', 'Platforma online de desenare.'),
('keywords', 'sketch, spark, drawing pad, sketch pad'),
('registration', 'opened'),
('demo_save', 'approved');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `discuss`
--

CREATE TABLE IF NOT EXISTS `discuss` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `drawid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `data` datetime NOT NULL,
  `text` text NOT NULL,
  `like` int(10) unsigned DEFAULT NULL,
  `dislike` int(10) unsigned DEFAULT NULL,
  `status` enum('approved','waiting','spam','deleted') NOT NULL DEFAULT 'approved',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Salvarea datelor din tabel `discuss`
--

INSERT INTO `discuss` (`id`, `drawid`, `userid`, `data`, `text`, `like`, `dislike`, `status`) VALUES
(30, 39, 1, '2011-08-04 12:54:49', 'akismet', NULL, NULL, 'approved');

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
  `status` enum('approved','waiting','reported','deleted') NOT NULL DEFAULT 'approved',
  `type` enum('normal','extended') NOT NULL DEFAULT 'normal',
  `width` int(4) unsigned NOT NULL DEFAULT '850',
  `height` int(4) unsigned NOT NULL DEFAULT '580',
  `bkgcolor` varchar(10) NOT NULL DEFAULT 'none',
  `reportedby` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL,
  `reportdata` datetime NOT NULL,
  `moderated` enum('yes','no') NOT NULL DEFAULT 'no',
  `moderatedby` int(10) unsigned DEFAULT NULL,
  `ip` varchar(255) NOT NULL DEFAULT 'registered',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Salvarea datelor din tabel `draws`
--

INSERT INTO `draws` (`id`, `userid`, `title`, `filename`, `creationdate`, `modificationdate`, `status`, `type`, `width`, `height`, `bkgcolor`, `reportedby`, `reason`, `reportdata`, `moderated`, `moderatedby`, `ip`) VALUES
(2, 2, 'Xz', 'sGHyFPC14uoe', '2011-07-02 15:26:57', '2011-07-09 10:29:02', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(10, 1, 'Lol', 'oRQTDStBsZXL', '2011-07-09 14:55:54', '2011-07-09 14:55:54', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(24, 1, '2', '7XusgNN2JDSn', '2011-07-24 13:24:16', '2011-07-24 13:24:16', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(22, 1, 'ub', 'jlDKj71dSYf8', '2011-07-17 12:55:39', '2011-07-17 12:55:39', 'approved', 'normal', 850, 580, 'none', 1, 'asgs', '2011-07-17 17:12:20', 'yes', 1, 'registered'),
(31, 0, 'w', 'tb3FAiOzudfW', '2011-07-24 20:59:24', '2011-07-24 20:59:24', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, '127.0.0.1'),
(25, 1, 'wf', '24oq8ejgoMTh', '2011-07-24 13:25:07', '2011-07-24 13:25:07', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(26, 1, '33', 'WRKsGiQTkjU1', '2011-07-24 13:30:52', '2011-07-24 13:32:14', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(27, 1, '363', 'UUNDxNNdJNFg', '2011-07-24 13:32:26', '2011-07-24 13:32:26', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(28, 1, 'sad', 'K1RpSDAIWxTy', '2011-07-24 18:53:03', '2011-07-24 18:53:03', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(32, 1, 'rosu', 'WrQG3dRLEFsD', '2011-07-24 21:04:43', '2011-07-24 21:04:43', 'approved', 'extended', 850, 580, '#ff0000', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(30, 1, 'sda', 'LZ3jBFuEgyS8', '2011-07-24 20:57:34', '2011-07-24 20:57:34', 'approved', 'extended', 850, 580, 'axis', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(37, 1, 'asdasda', 'OuKVIbYWX1Ue', '2011-07-24 21:21:48', '2011-07-24 21:21:48', 'approved', 'extended', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(38, 1, 'sarpeX', 'E0oLokM3fMTY', '2011-07-24 21:22:09', '2011-07-26 11:02:27', 'approved', 'extended', 850, 580, '#ff0000', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(39, 1, 'line', 'lERyKFTEn1jP', '2011-07-24 21:22:22', '2011-07-26 11:51:35', 'approved', 'extended', 850, 580, 'axis', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(40, 1, 'sa', 'WkAQM65X7zoY', '2011-07-26 10:23:44', '2011-07-26 10:55:34', 'approved', 'extended', 850, 580, '#ffffff', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(41, 1, 'Meh', 'vYOURhOimRym', '2011-07-26 10:58:33', '2011-07-26 11:02:14', 'approved', 'extended', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered'),
(44, 1, 'sdas', 'QjQZ6P3da7CO', '2011-08-26 23:12:15', '2011-08-26 23:12:15', 'approved', 'normal', 850, 580, 'none', 0, '', '0000-00-00 00:00:00', 'no', NULL, 'registered');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` enum('en','ro') NOT NULL DEFAULT 'ro',
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `faq`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `rank` enum('admin','moderator','user') NOT NULL DEFAULT 'user',
  `email` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `creationDate` datetime NOT NULL,
  `lang` enum('en','ro') NOT NULL DEFAULT 'en',
  `activated` enum('yes','no') NOT NULL DEFAULT 'no',
  `activation_code` varchar(255) DEFAULT NULL,
  `invitedby` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`,`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Salvarea datelor din tabel `user`
--

INSERT INTO `user` (`id`, `user`, `password`, `rank`, `email`, `firstname`, `lastname`, `creationDate`, `lang`, `activated`, `activation_code`, `invitedby`) VALUES
(0, 'demouser', 'demouser', 'user', 'demouser@duricu.ro', 'Demo', 'User', '2011-07-09 17:37:47', 'en', 'no', NULL, NULL),
(1, 'usertest', '9df2a4e79678f8bd6cbb06cf7218b727a67b62f0', 'admin', 'admin@sketch.ro', 'Test', 'Utilizator', '2011-04-25 22:19:55', 'en', 'yes', NULL, NULL);
