
--
-- Struttura della tabella `adv_comments`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;