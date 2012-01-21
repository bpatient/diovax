CREATE TABLE IF NOT EXISTS `auth_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_id` int(11) DEFAULT NULL,
  `sessionid` text,
  `bag` text,
  `agent` varchar(254) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `starts` datetime DEFAULT NULL,
  `stops` datetime DEFAULT NULL,
  `location` text,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_auth_log_auth1` (`auth_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=351 ;



drop table `user`;
CREATE TABLE IF NOT EXISTS `diovax`.`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `category` enum('admin','customer','tmp') DEFAULT NULL,
  `banned` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `token` varchar(125) NOT NULL,
  `approved` TINYINT(1)  NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;



-- -----------------------------------------------------
-- Table `diovax`.`auth`
-- -----------------------------------------------------
drop table `diovax`.`auth`;
CREATE TABLE IF NOT EXISTS `diovax`.`auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `service` varchar(45) DEFAULT NULL,
  `key` varchar(45) DEFAULT NULL,
  `value` text,
  `modified` timestamp NULL DEFAULT NULL,
  `active_time` mediumtext,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_auth_user1` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;



