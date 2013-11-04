CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `cover_image_1` varchar(500) DEFAULT NULL,
  `cover_image_2` varchar(500) DEFAULT NULL,
  `cover_image_3` varchar(500) DEFAULT NULL,
  `pubdate` date NOT NULL,
  `gallery` bit(1) NOT NULL,
  `state` int(11) NOT NULL COMMENT '0:draft, 1:online, 2:trashed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `articles_tags`
--

CREATE TABLE IF NOT EXISTS `articles_tags` (
  `articleID` int(11) NOT NULL,
  `tagID` int(11) NOT NULL,
  KEY `articleID` (`articleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `optionName` varchar(100) NOT NULL,
  `optionValue` varchar(2000) NOT NULL,
  PRIMARY KEY (`optionName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='siteoptions';

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` varchar(256) NOT NULL,
  `tagslug` varchar(256) NOT NULL,
  `inmenu` tinyint(1) NOT NULL,
  `menuorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `sidebarorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `articles_tags`
--
ALTER TABLE `articles_tags`
  ADD CONSTRAINT `articles_tags_ibfk_1` FOREIGN KEY (`articleID`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

