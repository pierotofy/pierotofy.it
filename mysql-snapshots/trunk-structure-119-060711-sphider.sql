-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 06 lug, 2011 at 11:05 PM
-- Versione MySQL: 5.1.36
-- Versione PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sphider`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` text,
  `parent_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) NOT NULL,
  PRIMARY KEY (`keyword_id`),
  UNIQUE KEY `kw` (`keyword`),
  KEY `keyword` (`keyword`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3823 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `fulltxt` mediumtext,
  `indexdate` date DEFAULT NULL,
  `size` float DEFAULT NULL,
  `md5sum` varchar(32) DEFAULT NULL,
  `visible` int(11) DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  KEY `url` (`url`),
  KEY `md5key` (`md5sum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword0`
--

CREATE TABLE IF NOT EXISTS `link_keyword0` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword1`
--

CREATE TABLE IF NOT EXISTS `link_keyword1` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword2`
--

CREATE TABLE IF NOT EXISTS `link_keyword2` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword3`
--

CREATE TABLE IF NOT EXISTS `link_keyword3` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword4`
--

CREATE TABLE IF NOT EXISTS `link_keyword4` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword5`
--

CREATE TABLE IF NOT EXISTS `link_keyword5` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword6`
--

CREATE TABLE IF NOT EXISTS `link_keyword6` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword7`
--

CREATE TABLE IF NOT EXISTS `link_keyword7` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword8`
--

CREATE TABLE IF NOT EXISTS `link_keyword8` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyword9`
--

CREATE TABLE IF NOT EXISTS `link_keyword9` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyworda`
--

CREATE TABLE IF NOT EXISTS `link_keyworda` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keywordb`
--

CREATE TABLE IF NOT EXISTS `link_keywordb` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keywordc`
--

CREATE TABLE IF NOT EXISTS `link_keywordc` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keywordd`
--

CREATE TABLE IF NOT EXISTS `link_keywordd` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keyworde`
--

CREATE TABLE IF NOT EXISTS `link_keyworde` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link_keywordf`
--

CREATE TABLE IF NOT EXISTS `link_keywordf` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `pending`
--

CREATE TABLE IF NOT EXISTS `pending` (
  `site_id` int(11) DEFAULT NULL,
  `temp_id` varchar(32) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `query_log`
--

CREATE TABLE IF NOT EXISTS `query_log` (
  `query` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `elapsed` float DEFAULT NULL,
  `results` int(11) DEFAULT NULL,
  KEY `query_key` (`query`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `short_desc` text,
  `indexdate` date DEFAULT NULL,
  `spider_depth` int(11) DEFAULT '2',
  `required` text,
  `disallowed` text,
  `can_leave_domain` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `site_category`
--

CREATE TABLE IF NOT EXISTS `site_category` (
  `site_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `link` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `id` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
