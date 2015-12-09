-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 06 lug, 2011 at 11:08 PM
-- Versione MySQL: 5.1.36
-- Versione PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pierotof_sito2`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `lessons_archive`
--

CREATE TABLE IF NOT EXISTS `lessons_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `max_partecipants` int(11) NOT NULL DEFAULT '0',
  `registrations_count` int(11) NOT NULL DEFAULT '0',
  `recording_available` tinyint(1) NOT NULL DEFAULT '0',
  `recording_in_download` tinyint(1) NOT NULL DEFAULT '0',
  `needs_recording_processing` tinyint(1) NOT NULL DEFAULT '0',
  `ended` tinyint(1) NOT NULL DEFAULT '0',
  `webhuddle_id` int(11) DEFAULT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `cancellation_reason` text,
  `allow_seating` tinyint(1) NOT NULL DEFAULT '0',
  `first_teacher_notification_sent` tinyint(1) NOT NULL DEFAULT '0',
  `second_teacher_notification_sent` tinyint(1) NOT NULL DEFAULT '0',
  `first_students_notification_sent` tinyint(1) NOT NULL DEFAULT '0',
  `second_students_notification_sent` tinyint(1) NOT NULL DEFAULT '0',
  `hidden_from_listings` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`subcategory_id`,`user_id`,`start_date`),
  KEY `subcategory_id` (`subcategory_id`),
  KEY `start_date` (`start_date`),
  KEY `webhuddle_id` (`webhuddle_id`),
  KEY `needs_recording_processing` (`needs_recording_processing`),
  KEY `ended` (`ended`),
  KEY `cancelled` (`cancelled`),
  KEY `hidden_from_listings` (`hidden_from_listings`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `lessons_categories`
--

CREATE TABLE IF NOT EXISTS `lessons_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `lessons_registrations`
--

CREATE TABLE IF NOT EXISTS `lessons_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `registration_time` int(11) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `lessons_subcategories`
--

CREATE TABLE IF NOT EXISTS `lessons_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `descr` text,
  `lesson_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
