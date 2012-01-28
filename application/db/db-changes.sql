-- phpMyAdmin SQL Dump
-- version 3.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2012 at 01:43 AM
-- Server version: 5.1.38
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `diovax`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(125) DEFAULT NULL,
  `line_one` varchar(45) DEFAULT NULL,
  `line_two` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `prs` varchar(45) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `owner`, `line_one`, `line_two`, `city`, `country`, `prs`, `latitude`, `longitude`) VALUES
(5, '9fb4c351e9d97b8c46c97497b7793b04', '5360 av. Walkley', '110', 'montreal', 'Canada', 'QC', 0.000000, 0.000000);

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `user_id`, `service`, `key`, `value`, `modified`, `active_time`, `active`) VALUES
(1, 1, 'system', 'password', '8a4630c5e7d23fd8fd96a683b26f9b2c', '2012-01-22 20:01:12', '0', 1),
(2, 2, 'system', 'password', 'c6b2a02423a6ac3bba08816ce64e4390', '2012-01-22 20:03:52', '0', 1),
(3, 3, 'system', 'password', '5f5219c46007056734a44201c11b53d5', '2012-01-27 22:32:35', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_log`
--

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

--
-- Dumping data for table `auth_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE IF NOT EXISTS `expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `amount` float(10,2) DEFAULT NULL,
  `doneby` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`id`,`property_id`),
  KEY `fk_spending_property` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `expense`
--


-- --------------------------------------------------------

--
-- Table structure for table `landlord`
--

CREATE TABLE IF NOT EXISTS `landlord` (
  `users_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  PRIMARY KEY (`users_id`,`property_id`),
  KEY `fk_users_has_property_property1` (`property_id`),
  KEY `fk_users_has_property_users1` (`users_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `landlord`
--


-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE IF NOT EXISTS `lease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `start` datetime DEFAULT NULL,
  `ends` datetime DEFAULT NULL,
  `started` tinyint(1) DEFAULT NULL,
  `owner` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`id`,`property_id`),
  KEY `fk_lease_property1` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lease`
--


-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `description` text,
  `url` text,
  `owner` varchar(125) DEFAULT NULL,
  `displayed` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `media`
--


-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE IF NOT EXISTS `property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitcode` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `title` varchar(254) DEFAULT NULL,
  `url` varchar(254) DEFAULT NULL,
  `token` varchar(125) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `leased` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `unitcode`, `name`, `title`, `url`, `token`, `description`, `created`, `modified`, `approved`, `leased`) VALUES
(12, '12423432', 'Pascal Maniraho', 'Title of the house one', 'pascal-maniraho-e6bffa76bd75e6a7e9e7d490e2e44212', 'e6bffa76bd75e6a7e9e7d490e2e44212', 'this is the description.', '2012-01-28 01:22:55', '2012-01-28 01:22:55', 1, 1),
(13, '12423432', 'Pascal Maniraho', 'Title of the house one', 'pascal-maniraho-cfd3a70f569e6e07eae1aecf98e852d0', 'cfd3a70f569e6e07eae1aecf98e852d0', 'this is the description.', '2012-01-28 01:23:34', '2012-01-28 01:23:34', 1, 1),
(14, '12423432', 'Pascal Maniraho', 'Title of the house one', 'pascal-maniraho-9fb4c351e9d97b8c46c97497b7793b04', '9fb4c351e9d97b8c46c97497b7793b04', 'this is the description.', '2012-01-28 01:24:14', '2012-01-28 01:24:14', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
  `approved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `birthday`, `category`, `banned`, `active`, `modified`, `created`, `token`, `approved`) VALUES
(1, 'Pascal Maniraho', 'murindwaz@yahoo.fr', NULL, 'admin', NULL, 1, NULL, NULL, '38629d815335e882cdb04177348ed5dc', NULL),
(2, 'PASCAL MANIRAHO', 'murindwaz@hotmail.com', NULL, 'admin', NULL, 1, NULL, NULL, '60e1d8ef7407ef47172476dcb860ee80', NULL),
(3, 'Pascal Maniraho', 'murindwaz@gmail.com', NULL, 'admin', NULL, 1, NULL, NULL, 'b90797f259a4be0c96bcc2e4fbe7f3d3', NULL);
