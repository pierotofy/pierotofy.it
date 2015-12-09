-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2012 at 10:52 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pierotof_sito2`
--

-- --------------------------------------------------------

--
-- Table structure for table `adv_chapters`
--

CREATE TABLE IF NOT EXISTS `adv_chapters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `chapter` int(11) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `context` longtext NOT NULL,
  `validated` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=851 ;

-- --------------------------------------------------------

--
-- Table structure for table `adv_chapters1`
--

CREATE TABLE IF NOT EXISTS `adv_chapters1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `chapter` int(11) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `context` longtext NOT NULL,
  `validated` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=459 ;

-- --------------------------------------------------------

--
-- Table structure for table `adv_comments`
--

CREATE TABLE IF NOT EXISTS `adv_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `page_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_posted` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `reply_to` int(11) NOT NULL DEFAULT '0',
  `indentation` smallint(6) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `flagged` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`page_id`,`user_id`,`reply_to`,`ordering`),
  KEY `flagged` (`flagged`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2902 ;

-- --------------------------------------------------------

--
-- Table structure for table `adv_guides`
--

CREATE TABLE IF NOT EXISTS `adv_guides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `descr` text NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_bans`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_bans` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_invitations`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_invitations` (
  `userID` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_messages`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_online`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_online` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `algorithm`
--

CREATE TABLE IF NOT EXISTS `algorithm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL DEFAULT '0',
  `module_name` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `program_id_referer` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `context` mediumblob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `program_id_referer` (`program_id_referer`),
  KEY `module_name` (`module_name`),
  KEY `owner` (`owner`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4686 ;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer_code` text,
  `answer_comment` text,
  `email_notify` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `approval_tutorials_votes`
--

CREATE TABLE IF NOT EXISTS `approval_tutorials_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tutorial_id` int(11) DEFAULT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=637 ;

--
-- Dumping data for table `approval_tutorials_votes`
--

INSERT INTO `approval_tutorials_votes` (`id`, `user_id`, `tutorial_id`, `vote`) VALUES
(635, 8, 1219, 0),
(636, 8, 1220, 0);

-- --------------------------------------------------------

--
-- Table structure for table `approval_votes`
--

CREATE TABLE IF NOT EXISTS `approval_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11964 ;

--
-- Dumping data for table `approval_votes`
--

INSERT INTO `approval_votes` (`id`, `user_id`, `program_id`, `vote`) VALUES
(11955, 8, 18995, 0),
(11956, 8, 18996, 0),
(11957, 8, 18997, 0),
(11958, 8, 18998, 0),
(11959, 8, 18999, 0),
(11960, 8, 19000, 0),
(11961, 8, 19001, 0),
(11962, 8, 19002, 0),
(11963, 8, 19003, 0);

-- --------------------------------------------------------

--
-- Table structure for table `aptchat`
--

CREATE TABLE IF NOT EXISTS `aptchat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(60) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37538 ;

-- --------------------------------------------------------

--
-- Table structure for table `badge_activity_count`
--

CREATE TABLE IF NOT EXISTS `badge_activity_count` (
  `user_id` int(11) NOT NULL,
  `programs` int(11) NOT NULL DEFAULT '0',
  `tutorials` int(11) NOT NULL DEFAULT '0',
  `news` int(11) NOT NULL DEFAULT '0',
  `forum_posts` int(11) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bad_queries`
--

CREATE TABLE IF NOT EXISTS `bad_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `page` varchar(255) NOT NULL,
  `stacktrace` text NOT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bestbanner`
--

CREATE TABLE IF NOT EXISTS `bestbanner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preference` varchar(255) NOT NULL DEFAULT '',
  `voter_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `image` blob,
  `size` int(11) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(255) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=361 ;

-- --------------------------------------------------------

--
-- Table structure for table `burningtools`
--

CREATE TABLE IF NOT EXISTS `burningtools` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `refer` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `filename` varchar(128) NOT NULL DEFAULT '',
  `size` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `cache_blocks`
--

CREATE TABLE IF NOT EXISTS `cache_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` blob NOT NULL,
  `block_id` varchar(40) NOT NULL,
  `expiration` int(11) NOT NULL DEFAULT '0',
  `dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cache_pages`
--

CREATE TABLE IF NOT EXISTS `cache_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` blob NOT NULL,
  `group_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `page_num` int(11) NOT NULL DEFAULT '0',
  `expiration` int(11) NOT NULL DEFAULT '0',
  `dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`page_id`),
  KEY `page_page` (`page_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mail` varchar(64) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `date` varchar(19) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=606 ;

-- --------------------------------------------------------

--
-- Table structure for table `compilers`
--

CREATE TABLE IF NOT EXISTS `compilers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `descrizione` text NOT NULL,
  `filename` varchar(128) NOT NULL DEFAULT '',
  `size` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `copypastebin`
--

CREATE TABLE IF NOT EXISTS `copypastebin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` longtext NOT NULL,
  `language` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cid` varchar(100) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE IF NOT EXISTS `counter` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `browser` varchar(255) NOT NULL DEFAULT '',
  `referer` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `counter_old`
--

CREATE TABLE IF NOT EXISTS `counter_old` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `os_browser` varchar(255) DEFAULT NULL,
  `heures` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=244 ;

-- --------------------------------------------------------

--
-- Table structure for table `daily_ip_accesses`
--

CREATE TABLE IF NOT EXISTS `daily_ip_accesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `downloads_count`
--

CREATE TABLE IF NOT EXISTS `downloads_count` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(128) NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `program_name` (`program_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4431 ;

-- --------------------------------------------------------

--
-- Table structure for table `external_urls`
--

CREATE TABLE IF NOT EXISTS `external_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18606 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_arguments`
--

CREATE TABLE IF NOT EXISTS `forum_arguments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `root` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `moderators` varchar(255) DEFAULT NULL,
  `private` int(1) unsigned NOT NULL DEFAULT '0',
  `priority` int(11) DEFAULT NULL,
  `developers_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=670 ;

--
-- Dumping data for table `forum_arguments`
--

INSERT INTO `forum_arguments` (`id`, `root`, `title`, `subject`, `moderators`, `private`, `priority`, `developers_only`) VALUES
(668, 'Programming', 'C++', 'Discussioni sul linguaggio C++', 'Piero Tofy', 0, 1, 0),
(669, 'Programming', 'Java', 'Discussioni sul linguaggio Java', 'Piero Tofy', 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_arguments_old`
--

CREATE TABLE IF NOT EXISTS `forum_arguments_old` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `root` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `moderators` varchar(255) DEFAULT NULL,
  `private` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=542 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_comments`
--

CREATE TABLE IF NOT EXISTS `forum_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2619 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_notifications`
--

CREATE TABLE IF NOT EXISTS `forum_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notify_tm` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `page_num` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`user_id`,`notify_tm`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_notifications_add_list`
--

CREATE TABLE IF NOT EXISTS `forum_notifications_add_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_notifications_skip_list`
--

CREATE TABLE IF NOT EXISTS `forum_notifications_skip_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_poll`
--

CREATE TABLE IF NOT EXISTS `forum_poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9733 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(9) NOT NULL DEFAULT '0',
  `argument` int(9) NOT NULL DEFAULT '0',
  `subject` varchar(255) DEFAULT NULL,
  `message` longtext,
  `type` int(1) NOT NULL DEFAULT '0',
  `root_topic` varchar(255) DEFAULT NULL,
  `post_date` int(9) DEFAULT '0',
  `edit_date` int(9) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `locked` int(1) DEFAULT NULL,
  `show_as` int(1) NOT NULL DEFAULT '0',
  `last_post_date` int(9) NOT NULL DEFAULT '0',
  `edit_by` int(9) NOT NULL DEFAULT '0',
  `notifies_list` text,
  `attachment_filename` varchar(255) DEFAULT NULL,
  `attachment_data` longblob,
  `attachment_size` int(11) DEFAULT NULL,
  `attachment_type` varchar(255) DEFAULT NULL,
  `poll` varchar(1200) DEFAULT NULL,
  `show_poll_in_menu` tinyint(4) DEFAULT '0',
  `question` tinyint(1) DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `best` tinyint(1) NOT NULL DEFAULT '0',
  `replies` int(11) DEFAULT NULL,
  `has_comments` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `argument` (`argument`),
  KEY `user_id` (`user_id`),
  KEY `root_topic` (`root_topic`),
  KEY `type` (`type`),
  KEY `show_poll_in_menu` (`show_poll_in_menu`),
  FULLTEXT KEY `subject` (`subject`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1030426 ;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`id`, `user_id`, `argument`, `subject`, `message`, `type`, `root_topic`, `post_date`, `edit_date`, `ip`, `locked`, `show_as`, `last_post_date`, `edit_by`, `notifies_list`, `attachment_filename`, `attachment_data`, `attachment_size`, `attachment_type`, `poll`, `show_poll_in_menu`, `question`, `score`, `best`, `replies`, `has_comments`) VALUES
(1030417, 8, 668, 'Primo post', 'Prova :D', 0, '', 1314719896, NULL, '192.168.1.107', 0, 0, 1344466092, 0, NULL, '', '', 0, '', '', 0, 0, 0, 0, 1, 0),
(1030418, 8, 669, 'Domanda', 'Test', 0, '', 1314719951, NULL, '192.168.1.107', 0, 0, 1314719951, 0, NULL, '', '', 0, '', '', 0, 1, 0, 0, 0, 0),
(1030425, 8, 668, '', 'Test', 1, '1030417', 1344466092, NULL, '192.168.56.1', 0, 0, 0, 0, NULL, '', '', 0, '', NULL, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_reports`
--

CREATE TABLE IF NOT EXISTS `forum_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=578 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_scores`
--

CREATE TABLE IF NOT EXISTS `forum_scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `voted_post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `voted_post_id` (`voted_post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4005 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `banner_url` varchar(255) NOT NULL DEFAULT '',
  `approved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `approved` (`approved`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `protocol` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

--
-- Table structure for table `images_upload`
--

CREATE TABLE IF NOT EXISTS `images_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `data` longblob,
  `size` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `join_requests`
--

CREATE TABLE IF NOT EXISTS `join_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `born_date` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `date` varchar(50) NOT NULL DEFAULT '',
  `motivation` text,
  `program_name` varchar(255) NOT NULL DEFAULT '',
  `program_data` longblob NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '',
  `passport` varchar(255) NOT NULL DEFAULT '',
  `agreed` tinyint(4) NOT NULL DEFAULT '0',
  `refused_because` text,
  `handled_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `handled_by` (`handled_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1203 ;

-- --------------------------------------------------------

--
-- Table structure for table `jokes`
--

CREATE TABLE IF NOT EXISTS `jokes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_archive`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_categories`
--

CREATE TABLE IF NOT EXISTS `lessons_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_registrations`
--

CREATE TABLE IF NOT EXISTS `lessons_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `registration_time` int(11) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_subcategories`
--

CREATE TABLE IF NOT EXISTS `lessons_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `descr` text,
  `lesson_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `library_books`
--

CREATE TABLE IF NOT EXISTS `library_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL DEFAULT '',
  `author` varchar(100) NOT NULL DEFAULT '',
  `pags` int(11) NOT NULL DEFAULT '0',
  `year` int(11) NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `available` tinyint(1) DEFAULT '1',
  `original_owner` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `library_feedbacks`
--

CREATE TABLE IF NOT EXISTS `library_feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` int(11) NOT NULL DEFAULT '0',
  `sender_id` int(11) NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `operation_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `library_operations`
--

CREATE TABLE IF NOT EXISTS `library_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `book_wanted` int(11) NOT NULL DEFAULT '0',
  `book_exchanged` int(11) DEFAULT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `agreed` int(11) NOT NULL DEFAULT '0',
  `closed` int(11) NOT NULL DEFAULT '0',
  `price_offert` varchar(100) DEFAULT NULL,
  `starter_id` int(11) NOT NULL DEFAULT '0',
  `receiver_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137344 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `ip`, `timestamp`, `user_id`, `text`) VALUES
(137308, '127.0.0.1', 1314637472, 8, ' (8) effettua il login'),
(137309, '127.0.0.1', 1314637476, 8, ' (8) effettua il login'),
(137310, '127.0.0.1', 1314637588, 8, 'pierotofy (8) effettua il login'),
(137311, '127.0.0.1', 1314637631, 8, 'pierotofy (8) effettua il login'),
(137312, '127.0.0.1', 1314638029, 8, 'pierotofy (8) effettua il login'),
(137313, '127.0.0.1', 1314638173, 8, 'pierotofy (8) effettua il login'),
(137314, '192.168.1.107', 1314638196, 8, 'pierotofy (8) effettua il login'),
(137315, '192.168.1.107', 1314638299, 8, 'pierotofy (8) effettua il login'),
(137316, '127.0.0.1', 1314717888, 8, 'pierotofy (8) effettua il login'),
(137317, '127.0.0.1', 1314718181, 8, 'pierotofy (8) effettua il login'),
(137318, '127.0.0.1', 1314718283, 8, 'pierotofy (8) effettua il login'),
(137319, '192.168.1.107', 1314718724, 8, 'pierotofy (8) effettua il login'),
(137320, '192.168.56.1', 1344435998, 8, 'pierotofy (8) effettua il login'),
(137321, '192.168.56.1', 1344436002, 8, 'pierotofy (8) effettua il login'),
(137322, '192.168.56.1', 1344436011, 8, 'pierotofy (8) effettua il login'),
(137323, '192.168.56.1', 1344436086, 8, 'pierotofy (8) effettua il login'),
(137324, '192.168.56.1', 1344439751, 8, 'Caricato programma test - CPP in attesa di essere valutato'),
(137325, '192.168.56.1', 1344440021, 8, 'Caricato programma test - CPP in attesa di essere valutato'),
(137326, '192.168.56.1', 1344440064, 8, 'Caricato programma test2 - CPP in attesa di essere valutato'),
(137327, '192.168.56.1', 1344440277, 8, 'Caricato programma test2 - CPP in attesa di essere valutato'),
(137328, '192.168.56.1', 1344440402, 8, 'Caricato programma test2 - CPP in attesa di essere valutato'),
(137329, '192.168.56.1', 1344440436, 8, 'Caricato programma test3 - CPP in attesa di essere valutato'),
(137330, '192.168.56.1', 1344440455, 8, 'Cancellato programma CPP - Piero_Tofys_desktop.zip'),
(137331, '192.168.56.1', 1344440460, 8, 'Cancellato programma CPP - Piero_Tofys_desktop.zip'),
(137332, '192.168.56.1', 1344441013, 8, 'Caricato programma test3 - CPP in attesa di essere valutato'),
(137333, '192.168.56.1', 1344441087, 8, 'Caricato articolo  in Esempi'),
(137334, '192.168.56.1', 1344441121, 8, 'Cancellato articolo  - '),
(137335, '192.168.56.1', 1344442744, 8, 'Cancellato Topic (1030419)'),
(137336, '192.168.56.1', 1344442819, 8, 'Cancellato Post (1030421)'),
(137337, '192.168.56.1', 1344442956, 8, 'Cancellato Post (1030424)'),
(137338, '192.168.56.1', 1344442962, 8, 'Cancellato Post (1030423)'),
(137339, '192.168.56.1', 1344442967, 8, 'Cancellato Post (1030422)'),
(137340, '192.168.56.1', 1344442972, 8, 'Cancellato Topic (1030420)'),
(137341, '192.168.56.1', 1344465042, 8, 'Caricato programma test - CPP in attesa di essere valutato'),
(137342, '192.168.56.1', 1344465064, 8, 'Caricato programma test2 - CPP in attesa di essere valutato'),
(137343, '192.168.56.1', 1344465103, 8, 'Caricato articolo  in Esempi');

-- --------------------------------------------------------

--
-- Table structure for table `medals`
--

CREATE TABLE IF NOT EXISTS `medals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) DEFAULT NULL,
  `description` longtext,
  `age` varchar(10) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `born_date` int(11) DEFAULT NULL,
  `last_login` varchar(30) DEFAULT NULL,
  `is_founder` char(1) DEFAULT NULL,
  `interests` varchar(255) DEFAULT NULL,
  `employ` varchar(255) DEFAULT NULL,
  `icq` varchar(255) DEFAULT NULL,
  `msn` varchar(255) DEFAULT NULL,
  `aim` varchar(255) DEFAULT NULL,
  `yahoo` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `medals` varchar(255) DEFAULT NULL,
  `review_message_shown` tinyint(1) DEFAULT '0',
  `library_disclaimer_shown` tinyint(4) DEFAULT '0',
  `personal_info` text,
  `real_name` varchar(255) DEFAULT NULL,
  `real_surname` varchar(255) DEFAULT NULL,
  `working_exp` text,
  `reunion_pass` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `email_activated` int(11) DEFAULT '0',
  `webhost_activated` tinyint(4) DEFAULT '0',
  `webhost_pass` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=545 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `nickname`, `description`, `age`, `location`, `mail`, `image`, `born_date`, `last_login`, `is_founder`, `interests`, `employ`, `icq`, `msn`, `aim`, `yahoo`, `web`, `medals`, `review_message_shown`, `library_disclaimer_shown`, `personal_info`, `real_name`, `real_surname`, `working_exp`, `reunion_pass`, `skype`, `email_activated`, `webhost_activated`, `webhost_pass`, `twitter`) VALUES
(544, 'Piero Tofy', 'Programmatore', NULL, 'Trieste', 'admin@pierotofy.it', '', 607928400, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 'Piero', 'Toffanin', NULL, NULL, NULL, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_tm` int(11) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `from_id` (`from_id`),
  KEY `to_id` (`to_id`),
  KEY `viewed` (`viewed`),
  KEY `deleted` (`deleted`),
  KEY `multiple` (`multiple`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messenger`
--

CREATE TABLE IF NOT EXISTS `messenger` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `msgfrom_id` varchar(255) DEFAULT NULL,
  `msgto_id` varchar(255) DEFAULT NULL,
  `message` longtext,
  `date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `msgfrom_id` (`msgfrom_id`),
  KEY `msgto_id` (`msgto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19445 ;

-- --------------------------------------------------------

--
-- Table structure for table `midi`
--

CREATE TABLE IF NOT EXISTS `midi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `artist` varchar(255) DEFAULT NULL,
  `song` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18883 ;

-- --------------------------------------------------------

--
-- Table structure for table `most_visited`
--

CREATE TABLE IF NOT EXISTS `most_visited` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `small_text` text NOT NULL,
  `full_text` longtext NOT NULL,
  `data` bigint(20) NOT NULL DEFAULT '0',
  `read_count` int(11) NOT NULL DEFAULT '0',
  `member_id` int(11) NOT NULL DEFAULT '0',
  `refer` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5948 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `small_text`, `full_text`, `data`, `read_count`, `member_id`, `refer`) VALUES
(5942, 'Test', 'Testo breve, Testo breve, Testo breve, Testo breve, Testo breve, Testo breve, Testo breve, Testo breve', '<p>Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news, Testo news, testo news</p>', 1314718333, 4, 0, 'http://www.pierotofy.it'),
(5946, 'test3', 'test3432432test3432432test3432432test3432432test3432432test3432432vv', '<p>Testo completo della newstest3432432test3432432test3432432test3432432</p>', 1344465076, 0, 544, ''),
(5947, 'test3', 'dasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdas', '<p>Testo completo della newsdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdas</p>', 1344465088, 0, 544, '');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6066 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_queue`
--

CREATE TABLE IF NOT EXISTS `newsletter_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `body` text NOT NULL,
  `type` int(11) NOT NULL,
  `headers` text NOT NULL,
  `resume_from` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `news_comments`
--

CREATE TABLE IF NOT EXISTS `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9661270 ;

--
-- Dumping data for table `online`
--

INSERT INTO `online` (`id`, `ip`, `timestamp`, `user_id`) VALUES
(9661269, '127.0.0.1', 1344466170, 0),
(9661261, '192.168.56.1', 1344466047, 8);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(255) DEFAULT NULL,
  `partner_url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `top` tinyint(1) DEFAULT '0',
  `position` int(11) DEFAULT '99',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vote_id` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2805 ;

-- --------------------------------------------------------

--
-- Table structure for table `poll_questions`
--

CREATE TABLE IF NOT EXISTS `poll_questions` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `program_name` varchar(255) DEFAULT NULL,
  `description` longtext,
  `programmer` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `categoria` varchar(64) NOT NULL DEFAULT '',
  `pro_votes` int(11) DEFAULT '0',
  `cons_votes` int(11) DEFAULT '0',
  `approved` int(11) DEFAULT '0',
  `screenshot_filename` varchar(255) DEFAULT NULL,
  `rates_score` float DEFAULT '0',
  `rates_count` int(11) DEFAULT '0',
  `comments` int(11) DEFAULT '0',
  `website` varchar(255) DEFAULT NULL,
  `long_description` text,
  `support_windows` tinyint(1) DEFAULT '1',
  `support_linux` tinyint(1) DEFAULT '0',
  `support_mac` tinyint(1) DEFAULT '0',
  `support_bsd` tinyint(1) DEFAULT '0',
  `timestamp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `approved` (`approved`),
  KEY `programmer` (`programmer`),
  KEY `screenshot_filename` (`screenshot_filename`),
  KEY `program_name` (`program_name`),
  KEY `type` (`type`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19004 ;

-- --------------------------------------------------------

--
-- Table structure for table `programs_categories`
--

CREATE TABLE IF NOT EXISTS `programs_categories` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `descr` varchar(64) NOT NULL DEFAULT '',
  `descr_long` varchar(255) DEFAULT NULL,
  `congiunzione` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `programs_categories`
--

INSERT INTO `programs_categories` (`id`, `descr`, `descr_long`, `congiunzione`) VALUES
(19, 'Esempi', 'Esempi', 'in');

-- --------------------------------------------------------

--
-- Table structure for table `programs_comments`
--

CREATE TABLE IF NOT EXISTS `programs_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `admins` text NOT NULL,
  `developers` text NOT NULL,
  `recruitment` varchar(128) NOT NULL DEFAULT '',
  `os` varchar(128) NOT NULL DEFAULT '',
  `license` varchar(128) NOT NULL DEFAULT '',
  `programming_languages` varchar(128) NOT NULL DEFAULT '',
  `creation_date` varchar(128) NOT NULL DEFAULT '',
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `releases_count` int(11) NOT NULL DEFAULT '0',
  `svn_requested` int(11) DEFAULT '0',
  `svn_repname` varchar(255) DEFAULT NULL,
  `svn_pass` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `svn_requested` (`svn_requested`),
  KEY `name` (`name`),
  KEY `programming_languages` (`programming_languages`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=581 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_bugs`
--

CREATE TABLE IF NOT EXISTS `projects_bugs` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `submitted_by` varchar(128) NOT NULL DEFAULT '',
  `fixed` int(1) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '0',
  `project_id` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `fixed` (`fixed`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_files`
--

CREATE TABLE IF NOT EXISTS `projects_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `size` bigint(20) NOT NULL DEFAULT '0',
  `version` varchar(20) NOT NULL DEFAULT '',
  `release_date` varchar(128) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '',
  `release_require` text NOT NULL,
  `owner` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1700 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_todo`
--

CREATE TABLE IF NOT EXISTS `projects_todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(128) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '0',
  `sender` varchar(10) NOT NULL DEFAULT '',
  `assigned_to` varchar(10) NOT NULL DEFAULT '',
  `date` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=605 ;

-- --------------------------------------------------------

--
-- Table structure for table `query_stats`
--

CREATE TABLE IF NOT EXISTS `query_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=536710 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE IF NOT EXISTS `quiz_attempts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `mail` varchar(128) NOT NULL DEFAULT '',
  `language` varchar(128) NOT NULL DEFAULT '',
  `rank` int(2) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `browser` varchar(128) NOT NULL DEFAULT '',
  `hour` varchar(5) NOT NULL DEFAULT '',
  `day` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer1` text NOT NULL,
  `answer2` text NOT NULL,
  `answer3` text NOT NULL,
  `answer4` text NOT NULL,
  `lang` varchar(128) NOT NULL DEFAULT '',
  `rank` int(2) NOT NULL DEFAULT '0',
  `true` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `question` (`question`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Table structure for table `referendum`
--

CREATE TABLE IF NOT EXISTS `referendum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preference` varchar(255) NOT NULL DEFAULT '',
  `voter_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `descr` varchar(255) NOT NULL DEFAULT '',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `context` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews_cats`
--

CREATE TABLE IF NOT EXISTS `reviews_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `descr` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `search_queries`
--

CREATE TABLE IF NOT EXISTS `search_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `query` (`query`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19349 ;

-- --------------------------------------------------------

--
-- Table structure for table `stallman_editions`
--

CREATE TABLE IF NOT EXISTS `stallman_editions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` int(11) NOT NULL DEFAULT '0',
  `end_date` int(11) NOT NULL DEFAULT '0',
  `subtitle` varchar(255) NOT NULL DEFAULT '',
  `winner_id` int(11) NOT NULL DEFAULT '0',
  `manual_title` text NOT NULL,
  `work_url` varchar(255) NOT NULL DEFAULT '',
  `judges` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `stallman_partecipants`
--

CREATE TABLE IF NOT EXISTS `stallman_partecipants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edition_id` int(11) NOT NULL DEFAULT '0',
  `member_id` int(11) NOT NULL DEFAULT '0',
  `subscription_date` int(11) NOT NULL DEFAULT '0',
  `work_url` varchar(255) NOT NULL DEFAULT '',
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE IF NOT EXISTS `tutorials` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `dir_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext,
  `members_name` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `cache` longtext,
  `timestamp` int(11) DEFAULT '0',
  `old_text_format` tinyint(1) NOT NULL DEFAULT '0',
  `pro_votes` int(11) NOT NULL DEFAULT '0',
  `cons_votes` int(11) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `body` longtext,
  PRIMARY KEY (`id`),
  KEY `approved` (`approved`),
  KEY `dir_id` (`dir_id`),
  KEY `type` (`type`),
  KEY `members_name` (`members_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1221 ;

-- --------------------------------------------------------

--
-- Table structure for table `tutorials_categories`
--

CREATE TABLE IF NOT EXISTS `tutorials_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dir_id` (`dir_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tutorials_categories`
--

INSERT INTO `tutorials_categories` (`id`, `dir_id`, `name`) VALUES
(1, 1, 'Esempi');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials_comments`
--

CREATE TABLE IF NOT EXISTS `tutorials_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tutorial_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `program_id` (`tutorial_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usenet_groups`
--

CREATE TABLE IF NOT EXISTS `usenet_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

-- --------------------------------------------------------

--
-- Table structure for table `usenet_posts`
--

CREATE TABLE IF NOT EXISTS `usenet_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `messageid` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `post_date` int(11) NOT NULL DEFAULT '0',
  `post_from` varchar(255) NOT NULL DEFAULT '',
  `post_references` varchar(1200) DEFAULT NULL,
  `replyto` varchar(255) DEFAULT NULL,
  `contenttype` varchar(255) DEFAULT NULL,
  `contenttransfenc` varchar(255) DEFAULT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `subject` (`subject`),
  KEY `messageid` (`messageid`),
  KEY `post_references` (`post_references`(1000)),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86275 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `os_browser` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `verified` int(11) DEFAULT NULL,
  `md5` varchar(255) DEFAULT NULL,
  `previous_login_timestamp` int(11) DEFAULT '0',
  `last_login_timestamp` int(11) DEFAULT '0',
  `signature` varchar(255) DEFAULT NULL,
  `last_login_ip` varchar(16) DEFAULT NULL,
  `biometric_hash` varchar(255) DEFAULT NULL,
  `disable_biometric` varchar(255) NOT NULL DEFAULT '',
  `wiki_enabled` tinyint(1) DEFAULT '1',
  `avatar` varchar(255) DEFAULT NULL,
  `banned` int(11) DEFAULT NULL,
  `banned_reason` text,
  `newsletter` tinyint(1) NOT NULL,
  `forum_votes_pro` int(11) NOT NULL DEFAULT '0',
  `forum_votes_cons` int(11) NOT NULL DEFAULT '0',
  `forum_post_count` int(11) NOT NULL DEFAULT '0',
  `requirepwdreset` tinyint(1) NOT NULL DEFAULT '0',
  `developerpermission` int(11) NOT NULL DEFAULT '0',
  `webhuddle_script_ids` text,
  `member_id` int(11) NOT NULL DEFAULT '0',
  `is_teacher` tinyint(1) NOT NULL DEFAULT '0',
  `webhuddle_password` varchar(255) DEFAULT NULL,
  `forum_badges_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `md5` (`md5`),
  KEY `user` (`user`),
  KEY `mail` (`mail`),
  KEY `member_id` (`member_id`),
  KEY `is_teacher` (`is_teacher`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17009 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `user`, `pass`, `mail`, `ip`, `os_browser`, `date`, `description`, `permission`, `verified`, `md5`, `previous_login_timestamp`, `last_login_timestamp`, `signature`, `last_login_ip`, `biometric_hash`, `disable_biometric`, `wiki_enabled`, `avatar`, `banned`, `banned_reason`, `newsletter`, `forum_votes_pro`, `forum_votes_cons`, `forum_post_count`, `requirepwdreset`, `developerpermission`, `webhuddle_script_ids`, `member_id`, `is_teacher`, `webhuddle_password`, `forum_badges_count`) VALUES
(8, NULL, 'pierotofy', '', 'admin@pierotofy.it', NULL, NULL, '04/12/2003 15:12', '<font class=small color=yellow>Admin</font>', 0, 1, '2e0f9a29bed76d2e7c635eacb307e4d7', 1344436011, 1344436086, '[left]\r\nFai quello che ti piace, e fallo bene.\r\n\r\n[b]TheKaneB[/b]: [i]sta chat sta diventando un ritrovo di pazzi esaltati e scimmie ubriache %-)[/i]', '192.168.56.1', '', '', 0, 'pierotofy_1283542569.png', NULL, NULL, 1, 12, 2, 4098, 0, 2, NULL, 544, 0, NULL, 2),
(17008, NULL, 'utente', '', 'pierotofy@libero.it', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8', '04/09/2010 23:56', 'Normal User', 9, 1, 'a0cdd710cf4e43b2230da91aeb3bc12b', 1283644689, 1286656992, NULL, '127.0.0.1', NULL, '', 1, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, 0, 0, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_badges`
--

CREATE TABLE IF NOT EXISTS `user_badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `badge_id` int(11) NOT NULL DEFAULT '0',
  `earned_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`badge_id`,`earned_on`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `wall_followers`
--

CREATE TABLE IF NOT EXISTS `wall_followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `following_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`following_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wall_posts`
--

CREATE TABLE IF NOT EXISTS `wall_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `trusted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`timestamp`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `wall_posts`
--

INSERT INTO `wall_posts` (`id`, `user_id`, `author_id`, `body`, `timestamp`, `type`, `trusted`) VALUES
(1, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/-/''></a> nella sezione <a href=''/pages/sorgenti///''></a> / <a href=''/pages/sorgenti//''></a>', 1344439776, 2, 1),
(2, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/18996-test/''>test</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344440031, 2, 1),
(3, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/18997-test2/''>test2</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344440072, 2, 1),
(4, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/18998-test2/''>test2</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344440281, 2, 1),
(5, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/18999-test2/''>test2</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344440409, 2, 1),
(6, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/19000-test3/''>test3</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344440440, 2, 1),
(7, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/19001-test3/''>test3</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344441018, 2, 1),
(8, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha scritto un nuovo articolo <a href=''/pages/guide_tutorials/Esempi/Test/''>Test</a> nella sezione <a href=''/pages/guide_tutorials/Esempi/''>Esempi</a>', 1344441092, 3, 1),
(9, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/19002-test/''>test</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344465114, 2, 1),
(10, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha caricato un nuovo programma <a href=''/pages/sorgenti/dettagli/19003-test2/''>test2</a> nella sezione <a href=''/pages/sorgenti/CPlusPlus/Esempi/''>Esempi</a> / <a href=''/pages/sorgenti/CPlusPlus/''>C++</a>', 1344465118, 2, 1),
(11, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha scritto un nuovo articolo <a href=''/pages/guide_tutorials/Esempi/test/''>test</a> nella sezione <a href=''/pages/guide_tutorials/Esempi/''>Esempi</a>', 1344465121, 3, 1),
(12, 8, 0, '<b><a href=''/pages/members/profile.php?uid=8''>pierotofy</a></b> ha guadagnato un''onorificenza per essere il maggior contributore di programmi del mese', 1344465819, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wiki`
--

CREATE TABLE IF NOT EXISTS `wiki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` int(11) DEFAULT NULL,
  `term` varchar(255) NOT NULL DEFAULT '',
  `text` text,
  `source` varchar(255) DEFAULT NULL,
  `feedback_pos` int(11) DEFAULT '0',
  `feedback_neg` int(11) DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `member_nick` varchar(255) DEFAULT NULL,
  `abbr_for` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3029 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
