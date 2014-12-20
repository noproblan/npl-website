-- --------------------------------------------------------
-- Use the follwoing command in the shell to generate
-- new migration file names:
--
-- date "+%Y%m%d%H%M%S"
--
-- --------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Table structure for table `npl_admin_resources`
--

CREATE TABLE IF NOT EXISTS `npl_admin_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(20) NOT NULL,
  `action_name` varchar(20) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller_action` (`controller_name`,`action_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_admin_rights`
--

CREATE TABLE IF NOT EXISTS `npl_admin_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_role_id` int(11) NOT NULL,
  `admin_resource_id` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_resource` (`admin_role_id`,`admin_resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_admin_roles`
--

CREATE TABLE IF NOT EXISTS `npl_admin_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_admin_userroles`
--

CREATE TABLE IF NOT EXISTS `npl_admin_userroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_role` (`user_id`,`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_errors`
--

CREATE TABLE IF NOT EXISTS `npl_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority_name` text NOT NULL,
  `priority` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_ip` text NOT NULL,
  `user_name` text NOT NULL,
  `url` text NOT NULL,
  `params` text NOT NULL,
  `file` text NOT NULL,
  `line` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_gal_albums`
--

CREATE TABLE IF NOT EXISTS `npl_gal_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `folder` (`folder`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_gal_albums_log`
--

CREATE TABLE IF NOT EXISTS `npl_gal_albums_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `name` (`name`,`written_datetime`),
  UNIQUE KEY `folder` (`folder`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_laninfos`
--

CREATE TABLE IF NOT EXISTS `npl_laninfos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `info` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_lan_id` (`name`,`lan_id`),
  KEY `lan_id` (`lan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_laninfos_log`
--

CREATE TABLE IF NOT EXISTS `npl_laninfos_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `info` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `name_lan_id` (`name`,`lan_id`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_lans`
--

CREATE TABLE IF NOT EXISTS `npl_lans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `start_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registration_end_datetime` timestamp NULL DEFAULT NULL,
  `planned_seats` int(11) NOT NULL DEFAULT '0',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_lans_log`
--

CREATE TABLE IF NOT EXISTS `npl_lans_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `start_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `name` (`name`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_oldusers`
--

CREATE TABLE IF NOT EXISTS `npl_oldusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `register_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_resources`
--

CREATE TABLE IF NOT EXISTS `npl_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(20) NOT NULL,
  `action_name` varchar(20) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller_action` (`controller_name`,`action_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_resources_log`
--

CREATE TABLE IF NOT EXISTS `npl_resources_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(20) NOT NULL,
  `action_name` varchar(20) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `controller_action` (`controller_name`,`action_name`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_rights`
--

CREATE TABLE IF NOT EXISTS `npl_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_resource` (`role_id`,`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_rights_log`
--

CREATE TABLE IF NOT EXISTS `npl_rights_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `role_resource` (`role_id`,`resource_id`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_roles`
--

CREATE TABLE IF NOT EXISTS `npl_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_roles_log`
--

CREATE TABLE IF NOT EXISTS `npl_roles_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `rolename` (`name`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_sponsors`
--

CREATE TABLE IF NOT EXISTS `npl_sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `picture_name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_sponsors_log`
--

CREATE TABLE IF NOT EXISTS `npl_sponsors_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `picture_name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `name` (`name`,`written_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_desks`
--

CREATE TABLE IF NOT EXISTS `npl_srs_desks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL,
  `desk_type_id` int(11) NOT NULL,
  `position_x` int(6) NOT NULL,
  `position_y` int(6) NOT NULL,
  `rotation` int(3) NOT NULL DEFAULT '0',
  `height` int(6) NOT NULL DEFAULT '80',
  `width` int(6) NOT NULL DEFAULT '180',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `map_id` (`map_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_desks_log`
--

CREATE TABLE IF NOT EXISTS `npl_srs_desks_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL,
  `desk_type_id` int(11) NOT NULL,
  `position_x` int(6) NOT NULL,
  `position_y` int(6) NOT NULL,
  `rotation` int(3) NOT NULL DEFAULT '0',
  `height` int(6) NOT NULL DEFAULT '80',
  `width` int(6) NOT NULL DEFAULT '180',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_desktypes`
--

CREATE TABLE IF NOT EXISTS `npl_srs_desktypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `color` varchar(6) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_desktypes_log`
--

CREATE TABLE IF NOT EXISTS `npl_srs_desktypes_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `color` varchar(6) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_maps`
--

CREATE TABLE IF NOT EXISTS `npl_srs_maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(6) NOT NULL DEFAULT '000000',
  `height` int(6) NOT NULL,
  `width` int(6) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lan_id` (`lan_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_maps_log`
--

CREATE TABLE IF NOT EXISTS `npl_srs_maps_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(6) NOT NULL DEFAULT '000000',
  `height` int(6) NOT NULL,
  `width` int(6) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `lan_id` (`lan_id`,`name`,`written_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_seatpositions`
--

CREATE TABLE IF NOT EXISTS `npl_srs_seatpositions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_seatpositions_log`
--

CREATE TABLE IF NOT EXISTS `npl_srs_seatpositions_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_seats`
--

CREATE TABLE IF NOT EXISTS `npl_srs_seats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desk_id` int(11) NOT NULL,
  `seat_position_id` int(11) NOT NULL,
  `name` varchar(3) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_desk_id` (`name`,`desk_id`),
  KEY `desk_id` (`desk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_seats_log`
--

CREATE TABLE IF NOT EXISTS `npl_srs_seats_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desk_id` int(11) NOT NULL,
  `seat_position_id` int(11) NOT NULL,
  `name` varchar(3) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `name_desk_id` (`id`,`desk_id`,`written_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_tickets`
--

CREATE TABLE IF NOT EXISTS `npl_srs_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `extras` set('breakfast','dinner','cable') NOT NULL DEFAULT 'breakfast,dinner',
  `status` enum('prepaid','paid','notpaid') NOT NULL DEFAULT 'notpaid',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lan_id` (`lan_id`,`seat_id`),
  KEY `user_id` (`user_id`),
  KEY `seat_id` (`seat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_srs_tickets_log`
--

CREATE TABLE IF NOT EXISTS `npl_srs_tickets_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_userroles`
--

CREATE TABLE IF NOT EXISTS `npl_userroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_role` (`user_id`,`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_userroles_log`
--

CREATE TABLE IF NOT EXISTS `npl_userroles_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `user_role` (`user_id`,`role_id`,`written_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_users`
--

CREATE TABLE IF NOT EXISTS `npl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `mail_verified` tinyint(1) NOT NULL,
  `register_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npl_users_log`
--

CREATE TABLE IF NOT EXISTS `npl_users_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `mail_verified` tinyint(1) NOT NULL,
  `register_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `written_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`written_datetime`),
  UNIQUE KEY `username` (`username`,`written_datetime`),
  UNIQUE KEY `mail` (`mail`,`written_datetime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `npl_view_users`
--
CREATE TABLE IF NOT EXISTS `npl_view_users` (
`id` int(11)
,`username` varchar(20)
);
-- --------------------------------------------------------
