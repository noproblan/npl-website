-- --------------------------------------------------------
-- Use the follwoing command in the shell to generate
-- new migration file names:
--
-- date "+%Y%m%d%H%M%S"
--
-- --------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Dumping data for table `npl_users`
--
-- SALT = banane
-- PW = banane.SALT
--
INSERT INTO `npl_users` (`id`, `username`, `password`, `salt`, `mail`, `active`, `mail_verified`, `register_datetime`, `written_datetime`) VALUES
(1, 'admin', SHA1(CONCAT('banane', SHA1('banane'))), SHA1('banane'), 'admin@noproblan.ch', 1, 1, '2012-01-01 00:00:00', '2012-01-01 00:00:00'),
(2, 'guest', SHA1(CONCAT('banane', SHA1('banane'))), SHA1('banane'), 'noreply@noproblan.ch', 1, 1, '2012-01-01 00:00:00', '2012-01-01 00:00:00');

--
-- Dumping data for table `npl_users_log`
--

--
-- Dumping data for table `npl_userroles`
--

INSERT INTO `npl_userroles` (`id`, `user_id`, `role_id`, `written_datetime`) VALUES
(1, 1, 1, '2012-01-01 00:00:00'),
(2, 2, 2, '2012-01-01 00:00:00');

--
-- Dumping data for table `npl_userroles_log`
--

--
-- Dumping data for table `npl_admin_resources`
--
INSERT INTO `npl_admin_resources` (`id`, `controller_name`, `action_name`, `written_datetime`) VALUES
(1, 'index', 'index', '2012-09-07 22:58:04'),
(2, 'error', '', '2012-07-03 12:49:22'),
(3, 'auth', 'index', '2012-07-03 12:46:47'),
(4, 'auth', 'login', '2012-07-03 12:46:47'),
(5, 'auth', 'logout', '2012-07-03 12:46:57'),
(6, 'user', 'index', '2012-09-07 22:56:18'),
(7, 'rights', 'index', '2012-09-07 22:56:27'),
(8, 'lan', 'index', '2012-09-07 18:30:14'),
(9, 'lan', 'tickets', '2012-09-07 18:30:14'),
(10, 'lan', 'ajaxticket', '2012-09-07 21:56:03'),
(11, 'user', 'new', '2012-09-07 22:56:52'),
(12, 'srs', 'ajaxremove', '2012-09-30 18:24:09'),
(13, 'srs', 'edit', '2013-02-04 21:54:55'),
(14, 'srs', 'ajaxsave', '2013-02-04 21:54:55'),
(15, 'srs', 'index', '2013-02-04 22:12:36'),
(16, 'lan', 'newticket', '2013-04-04 13:02:22');

--
-- Dumping data for table `npl_admin_rights`
--
INSERT INTO `npl_admin_rights` (`id`, `admin_role_id`, `admin_resource_id`, `written_datetime`) VALUES
(2, 2, 2, '2012-09-07 23:24:45'),
(3, 2, 3, '2012-09-07 23:24:51'),
(4, 2, 4, '2012-09-07 23:24:58'),
(6, 3, 8, '2012-09-07 23:30:00'),
(7, 4, 9, '2013-02-04 21:49:20'),
(8, 4, 10, '2013-02-04 21:49:20'),
(14, 3, 1, '2012-09-07 23:41:45'),
(15, 3, 2, '2012-09-07 23:41:45'),
(16, 3, 3, '2012-09-07 23:41:45'),
(17, 3, 4, '2012-09-07 23:41:45'),
(18, 3, 5, '2012-09-07 23:41:45'),
(19, 5, 12, '2013-02-04 21:58:31'),
(20, 5, 13, '2013-02-04 21:58:14'),
(21, 5, 14, '2013-02-04 21:58:14'),
(22, 3, 6, '2013-02-04 22:00:00'),
(23, 3, 11, '2013-02-04 22:00:40'),
(24, 5, 15, '2013-02-04 22:14:49'),
(26, 3, 16, '2013-04-04 13:02:41');

--
-- Dumping data for table `npl_admin_roles`
--
INSERT INTO `npl_admin_roles` (`id`, `name`, `written_datetime`) VALUES
(1, 'Administrator', '2012-09-07 23:28:21'),
(2, 'Guest', '2012-09-07 23:28:13'),
(3, 'Team', '2012-09-07 23:38:50'),
(4, 'Finanzen', '2013-02-04 21:24:17'),
(5, 'Sitzplan', '2013-02-04 21:24:17');

--
-- Dumping data for table `npl_admin_userroles`
--
INSERT INTO `npl_admin_userroles` (`id`, `user_id`, `role_id`, `written_datetime`) VALUES
(1, 1, 1, '2012-09-07 00:00:00'),
(2, 2, 2, '2012-09-07 00:00:00');

--
-- Dumping data for table `npl_gal_albums`
--
INSERT INTO `npl_gal_albums` (`id`, `name`, `folder`, `written_datetime`) VALUES
(10, 'noprobLAN v31.3', 'noprobLAN31_3', '2012-10-16 11:45:23'),
(11, 'noprobLAN v35.6', 'noprobLAN35_6', '2013-04-12 18:00:00'),
(12, 'noprobLAN v39.1', 'noprobLAN39_1', '2013-10-17 23:22:31'),
(13, 'noprobLAN v43.2', 'noprobLAN43_2', '2014-07-13 12:27:09');

--
-- Dumping data for table `npl_gal_albums_log`
--

--
-- Dumping data for table `npl_lans`
--
INSERT INTO `npl_lans` (`id`, `name`, `start_datetime`, `end_datetime`, `registration_end_datetime`, `planned_seats`, `written_datetime`) VALUES
(15, 'noprobLAN v50.6', '2099-04-10 18:00:00', '2099-04-12 16:00:00', NULL, 200, '2014-11-08 11:40:39');

--
-- Dumping data for table `npl_lans_log`
--

--
-- Dumping data for table `npl_laninfos`
--
INSERT INTO `npl_laninfos` (`id`, `lan_id`, `name`, `info`, `order`, `written_datetime`) VALUES
(40, 15, 'JUBILÄUM', 'Unsere 15te LAN und wir überschreiten auch gleich noch die 50er-Grenze der Version!', 1, '2014-11-08 11:38:53'),
(41, 15, 'Allgemein', '<ul>\r\n    <li> Beginn: Freitag, 10. April 2015 18:00 Uhr</li>\r\n    <li> Ende: Sonntag, 12. April 2015 16:00 Uhr</li>\r\n    <li> Mindestalter: 16 Jahre\r\n    </li><li> Aus organisatorischen Gründen dürfen an der LAN keine Schüler der Volksschulen teilnehmen!\r\n    </li><li> Die Turnhalle verfügt über genügend kostenlose Parkplätze</li>\r\n</ul>', 2, '2014-11-08 11:38:53'),
(42, 15, 'Preise', '<ul>\r\n    <li>Vorauskasse: 40 CHF</li>\r\n    <li>Abendkasse: 50 CHF</li>\r\n    <li>Gamerinnen: 1/2 Preis*</li>\r\n</ul>\r\n* für Platzreservation muss der volle Preis vorausbezahlt werden. Geld wird an der LAN auf den Badge gutgeschrieben', 3, '2014-11-08 11:38:53'),
(43, 15, 'Infrastruktur für User', '<ul>\r\n    <li> Tische: Banketttische 180cm x 80cm je 2 User\r\n    </li><li> Stühle: schwarze Holzschalenstühle (45-50cm)\r\n    </li><li> Strom: 3 Steckdosen vorverlegt pro Platz (nicht gedacht für Haushaltsgeräte z.B. Kühlschänke, Kaffemaschinen, Staubsauger, etc.)\r\n    </li><li> Netzwerk: 1 RJ45-Kabel vorverlegt pro Platz\r\n    </li><li> Datendurchsatz: Gigabit-Switches (2 Gbit/s Uplink)\r\n    </li><li> Internet: 150 Mbit/s\r\n    </li><li> Clan- & Privat Server: separater Serverraum mit Strom und Netzwerkkabel (1000mbit) eingerichtet.</li>\r\n</ul>', 6, '2014-11-08 11:38:53'),
(44, 15, 'Infos zur Halle', '<ul>\r\n    <li> LAN-Halle: Halle, 200m<sup>2</sup>\r\n    </li><li> Schlafräume: Halle &amp; Geräteraum, 70m<sup>2</sup>\r\n    </li><li> Duschen: vorhanden\r\n    </li>\r\n</ul>', 8, '2014-11-08 11:38:53'),
(45, 15, 'Standort', '<iframe width="425" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/ms?ie=UTF8&amp;msa=0&amp;msid=216891715392143751239.0004cad4b1d188f6d1e61&amp;t=h&amp;ll=47.578527,9.169668&amp;spn=0,0&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps/ms?ie=UTF8&amp;msa=0&amp;msid=216891715392143751239.0004cad4b1d188f6d1e61&amp;t=h&amp;ll=47.578527,9.169668&amp;spn=0,0&amp;source=embed" style="color:#0000FF;text-align:left">noprobLAN</a> auf einer größeren Karte anzeigen</small>\r\n<br /><br />\r\nTurnhalle Neuwies, Berg TG', 7, '2014-11-08 11:38:53'),
(46, 15, 'Catering', 'Wie gewohnt ist unser Catering äusserst deliziös und äusserst günstig!\r\n', 4, '2014-11-08 11:38:53'),
(47, 15, 'Turniere', 'Noch nicht bekannt', 5, '2014-11-08 11:38:53');

--
-- Dumping data for table `npl_laninfos_log`
--

--
-- Dumping data for table `npl_resources`
--

INSERT INTO `npl_resources` (`id`, `controller_name`, `action_name`, `written_datetime`) VALUES
(1, 'error', '', '2012-01-01 00:00:00'),
(2, 'index', 'index', '2012-01-01 00:00:00'),
(3, 'index', 'about', '2012-01-01 00:00:00'),
(4, 'index', 'contact', '2012-01-01 00:00:00'),
(5, 'auth', 'index', '2012-01-01 00:00:00'),
(6, 'auth', 'login', '2012-01-01 00:00:00'),
(7, 'auth', 'logout', '2012-01-01 00:00:00'),
(8, 'user', 'index', '2012-01-01 00:00:00'),
(9, 'user', 'verify', '2012-01-01 00:00:00'),
(10, 'user', 'register', '2012-01-01 00:00:00'),
(11, 'user', 'activate', '2012-01-01 00:00:00'),
(12, 'user', 'forgotpassword', '2012-01-01 00:00:00'),
(13, 'user', 'forgotusername', '2012-01-01 00:00:00'),
(14, 'user', 'resendactivation', '2012-01-01 00:00:00'),
(15, 'user', 'resetpassword', '2012-01-01 00:00:00'),
(16, 'user', 'profile', '2012-01-01 00:00:00'),
(17, 'user', 'changepassword', '2012-01-01 00:00:00'),
(18, 'user', 'changemail', '2012-01-01 00:00:00'),
(19, 'user', 'resendverification', '2012-01-01 00:00:00'),
(20, 'user', 'delete', '2012-01-01 00:00:00'),
(21, 'gallery', 'index', '2012-01-01 00:00:00'),
(22, 'gallery', 'list', '2012-01-01 00:00:00'),
(23, 'gallery', 'album', '2012-01-01 00:00:00'),
(24, 'lan', 'index', '2012-01-01 00:00:00'),
(25, 'lan', 'list', '2012-01-01 00:00:00'),
(26, 'lan', 'info', '2012-01-01 00:00:00'),
(27, 'lan', 'participate', '2012-01-01 00:00:00'),
(28, 'user', 'migrate', '2012-01-01 00:00:00'),
(29, 'user', 'account', '2012-09-08 16:11:10'),
(30, 'ticket', 'changeextras', '2012-09-08 16:11:10'),
(31, 'sponsor', 'index', '2012-09-30 18:24:09'),
(32, 'sponsor', 'list', '2012-09-30 18:24:09'),
(33, 'ticket', 'reserveseat', '2012-09-30 18:24:09'),
(34, 'lan', 'reservation', '2012-09-30 18:24:09');

--
-- Dumping data for table `npl_resources_log`
--


--
-- Dumping data for table `npl_roles`
--

INSERT INTO `npl_roles` (`id`, `name`, `written_datetime`) VALUES
(1, 'Administrator', '2012-01-01 00:00:00'),
(2, 'Guest', '2012-01-01 00:00:00'),
(3, 'User', '2012-01-01 00:00:00'),
(4, 'Team', '2012-09-25 00:00:00');

--
-- Dumping data for table `npl_roles_log`
--


--
-- Dumping data for table `npl_rights`
--

INSERT INTO `npl_rights` (`id`, `role_id`, `resource_id`, `written_datetime`) VALUES
(1, 2, 2, '2012-01-01 00:00:00'),
(2, 2, 3, '2012-01-01 00:00:00'),
(3, 2, 4, '2012-01-01 00:00:00'),
(4, 3, 2, '2012-01-01 00:00:00'),
(5, 3, 3, '2012-01-01 00:00:00'),
(6, 3, 4, '2012-01-01 00:00:00'),
(7, 2, 5, '2012-01-01 00:00:00'),
(8, 2, 6, '2012-01-01 00:00:00'),
(9, 3, 5, '2012-01-01 00:00:00'),
(10, 3, 7, '2012-01-01 00:00:00'),
(11, 2, 8, '2012-01-01 00:00:00'),
(12, 2, 9, '2012-01-01 00:00:00'),
(13, 2, 10, '2012-01-01 00:00:00'),
(14, 2, 11, '2012-01-01 00:00:00'),
(15, 2, 12, '2012-01-01 00:00:00'),
(16, 2, 13, '2012-01-01 00:00:00'),
(17, 2, 14, '2012-01-01 00:00:00'),
(18, 2, 15, '2012-01-01 00:00:00'),
(19, 3, 8, '2012-01-01 00:00:00'),
(20, 3, 9, '2012-01-01 00:00:00'),
(21, 3, 16, '2012-08-15 17:33:34'),
(22, 3, 17, '2012-08-15 17:33:35'),
(23, 3, 18, '2012-08-15 17:33:35'),
(24, 3, 19, '2012-01-01 00:00:00'),
(25, 3, 20, '2012-01-01 00:00:00'),
(26, 2, 21, '2012-01-01 00:00:00'),
(27, 2, 22, '2012-01-01 00:00:00'),
(29, 2, 23, '2012-01-01 00:00:00'),
(30, 3, 21, '2012-01-01 00:00:00'),
(31, 3, 22, '2012-01-01 00:00:00'),
(32, 3, 23, '2012-01-01 00:00:00'),
(33, 2, 24, '2012-01-01 00:00:00'),
(34, 2, 25, '2012-01-01 00:00:00'),
(35, 2, 26, '2012-01-01 00:00:00'),
(37, 3, 24, '2012-01-01 00:00:00'),
(38, 3, 25, '2012-01-01 00:00:00'),
(39, 3, 26, '2012-01-01 00:00:00'),
(40, 3, 27, '2012-01-01 00:00:00'),
(41, 2, 28, '2012-01-01 00:00:00'),
(42, 3, 29, '2012-09-08 16:11:10'),
(43, 2, 16, '2012-09-08 16:11:10'),
(44, 3, 6, '2012-09-08 16:11:10'),
(45, 3, 30, '2012-09-08 16:11:10'),
(46, 2, 31, '2012-09-30 18:24:09'),
(47, 2, 32, '2012-09-30 18:24:09'),
(48, 3, 31, '2012-09-30 18:24:09'),
(49, 3, 32, '2012-09-30 18:24:09'),
(50, 4, 2, '2012-09-25 00:00:00'),
(51, 4, 3, '2012-09-25 00:00:00'),
(52, 4, 4, '2012-09-25 00:00:00'),
(53, 4, 5, '2012-09-25 00:00:00'),
(54, 4, 6, '2012-09-25 00:00:00'),
(55, 4, 7, '2012-09-25 00:00:00'),
(56, 4, 8, '2012-09-25 00:00:00'),
(57, 4, 9, '2012-09-25 00:00:00'),
(58, 4, 16, '2012-09-25 00:00:00'),
(59, 4, 17, '2012-09-25 00:00:00'),
(60, 4, 18, '2012-09-25 00:00:00'),
(61, 4, 19, '2012-09-25 00:00:00'),
(62, 4, 20, '2012-09-25 00:00:00'),
(63, 4, 21, '2012-09-25 00:00:00'),
(64, 4, 22, '2012-09-25 00:00:00'),
(65, 4, 23, '2012-09-25 00:00:00'),
(66, 4, 24, '2012-09-25 00:00:00'),
(67, 4, 25, '2012-09-25 00:00:00'),
(68, 4, 26, '2012-09-25 00:00:00'),
(69, 4, 27, '2012-09-25 00:00:00'),
(70, 4, 29, '2012-09-25 00:00:00'),
(71, 4, 30, '2012-09-25 00:00:00'),
(72, 4, 31, '2012-09-25 00:00:00'),
(73, 4, 32, '2012-09-25 00:00:00'),
(81, 3, 33, '2012-09-30 18:24:09'),
(82, 3, 34, '2012-09-30 18:24:09');

--
-- Dumping data for table `npl_rights_log`
--


--
-- Dumping data for table `npl_sponsors`
--

INSERT INTO `npl_sponsors` (`id`, `name`, `picture_name`, `link`, `written_datetime`) VALUES
(1, 'Brack', 'brack.jpg', '//www.brack.ch', '2012-09-30 18:53:15'),
(3, 'Raiffeisen', 'raiffeisen.jpg', '//www.raiffeisen.ch', '2012-09-30 18:54:04'),
(4, 'Bolliger', 'bolliger.jpg', '//www.bollimetzg.ch', '2012-10-08 22:59:15');

--
-- Dumping data for table `npl_sponsors_log`
--


--
-- Dumping data for table `npl_srs_desktypes`
--

INSERT INTO `npl_srs_desktypes` (`id`, `name`, `color`, `written_datetime`) VALUES
(1, 'PC', '00FF00', '2012-01-01 00:00:00');

--
-- Dumping data for table `npl_srs_desktypes_log`
--

--
-- Dumping data for table `npl_srs_maps`
--

INSERT INTO `npl_srs_maps` (`id`, `lan_id`, `name`, `color`, `height`, `width`, `written_datetime`) VALUES
(6, 15, 'Halle npL v50.6', '3F3F3F', 600, 940, '2014-06-01 14:45:27');

--
-- Dumping data for table `npl_srs_maps_log`
--

--
-- Dumping data for table `npl_srs_seatpositions`
--

INSERT INTO `npl_srs_seatpositions` (`id`, `name`, `position_x`, `position_y`, `written_datetime`) VALUES
(1, 'Links', 2, 29, '2012-01-01 00:00:00'),
(2, 'Rechts', 2, 119, '2012-01-01 00:00:00');

--
-- Dumping data for table `npl_srs_seatpositions_log`
--


--
-- Dumping data for table `npl_srs_desks`
--

INSERT INTO `npl_srs_desks` (`id`, `map_id`, `desk_type_id`, `position_x`, `position_y`, `rotation`, `height`, `width`, `active`, `written_datetime`) VALUES
(250, 6, 1, 140, 30, 45, 80, 180, 1, '2014-06-01 14:55:19'),
(251, 6, 1, 270, 160, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(252, 6, 1, 450, 160, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(253, 6, 1, 630, 160, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(254, 6, 1, 810, 330, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(255, 6, 1, 630, 330, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(256, 6, 1, 450, 330, 135, 80, 180, 1, '2014-06-01 14:55:19'),
(257, 6, 1, 320, 460, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(258, 6, 1, 150, 640, 270, 80, 180, 1, '2014-06-01 14:55:19'),
(259, 6, 1, 150, 460, 270, 80, 180, 1, '2014-06-01 14:55:19'),
(260, 6, 1, 150, 280, 225, 80, 180, 1, '2014-06-01 14:55:19'),
(261, 6, 1, 80, 1380, -45, 80, 180, 1, '2014-06-01 14:55:19'),
(262, 6, 1, 270, 1230, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(263, 6, 1, 450, 1230, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(264, 6, 1, 630, 1230, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(265, 6, 1, 810, 1220, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(266, 6, 1, 630, 1220, -180, 80, 180, 1, '2014-06-01 14:55:19'),
(267, 6, 1, 390, 1190, -135, 80, 180, 1, '2014-06-01 14:55:19'),
(268, 6, 1, 240, 1000, 270, 80, 180, 1, '2014-06-01 14:55:19'),
(269, 6, 1, 230, 820, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(270, 6, 1, 230, 1000, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(271, 6, 1, 200, 1240, 135, 80, 180, 1, '2014-06-01 14:55:19'),
(272, 6, 1, 2000, 1260, 45, 80, 180, 1, '2014-06-01 14:55:19'),
(273, 6, 1, 1760, 1230, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(274, 6, 1, 1580, 1230, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(275, 6, 1, 1400, 1230, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(276, 6, 1, 1580, 1220, -180, 80, 180, 1, '2014-06-01 14:55:19'),
(277, 6, 1, 1760, 1220, -180, 80, 180, 1, '2014-06-01 14:55:19'),
(278, 6, 1, 1950, 1070, 135, 80, 180, 1, '2014-06-01 14:55:19'),
(279, 6, 1, 1970, 830, -270, 80, 180, 1, '2014-06-01 14:55:19'),
(280, 6, 1, 1980, 1010, -90, 80, 180, 1, '2014-06-01 14:55:19'),
(281, 6, 1, 1980, 1190, -90, 80, 180, 1, '2014-06-01 14:55:19'),
(282, 6, 1, 2130, 1380, -135, 80, 180, 1, '2014-06-01 14:55:19'),
(283, 6, 1, 2130, 90, 135, 80, 180, 1, '2014-06-01 14:55:19'),
(284, 6, 1, 1940, 240, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(285, 6, 1, 1760, 240, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(286, 6, 1, 1580, 240, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(287, 6, 1, 1400, 250, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(288, 6, 1, 1580, 250, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(289, 6, 1, 1820, 270, 45, 80, 180, 1, '2014-06-01 14:55:19'),
(290, 6, 1, 1980, 470, 270, 80, 180, 1, '2014-06-01 14:55:19'),
(291, 6, 1, 2000, 230, -45, 80, 180, 1, '2014-06-01 14:55:19'),
(292, 6, 1, 1020, 250, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(293, 6, 1, 1000, 490, 135, 80, 180, 1, '2014-06-01 14:55:19'),
(294, 6, 1, 810, 640, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(295, 6, 1, 630, 640, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(296, 6, 1, 530, 640, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(297, 6, 1, 530, 740, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(298, 6, 1, 710, 740, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(299, 6, 1, 950, 760, 45, 80, 180, 1, '2014-06-01 14:55:19'),
(300, 6, 1, 1100, 950, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(301, 6, 1, 1100, 1130, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(302, 6, 1, 1270, 250, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(303, 6, 1, 1270, 430, 45, 80, 180, 1, '2014-06-01 14:55:19'),
(304, 6, 1, 1400, 560, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(305, 6, 1, 1580, 560, 0, 80, 180, 1, '2014-06-01 14:55:19'),
(306, 6, 1, 1760, 640, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(307, 6, 1, 1680, 820, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(308, 6, 1, 1500, 820, 180, 80, 180, 1, '2014-06-01 14:55:19'),
(309, 6, 1, 1320, 820, 135, 80, 180, 1, '2014-06-01 14:55:19'),
(310, 6, 1, 1190, 950, 90, 80, 180, 1, '2014-06-01 14:55:19'),
(311, 6, 1, 1190, 1130, 90, 80, 180, 1, '2014-06-01 14:55:19');

--
-- Dumping data for table `npl_srs_desks_log`
--


--
-- Dumping data for table `npl_srs_seats`
--

INSERT INTO `npl_srs_seats` (`id`, `desk_id`, `seat_position_id`, `name`, `active`, `written_datetime`) VALUES
(1362, 250, 1, 'A1', 1, '2014-06-01 15:00:29'),
(1363, 250, 2, 'A2', 1, '2014-06-01 15:00:29'),
(1364, 251, 1, 'A3', 1, '2014-06-01 15:00:29'),
(1365, 251, 2, 'A4', 1, '2014-06-01 15:00:29'),
(1366, 252, 1, 'A5', 1, '2014-06-01 15:00:29'),
(1367, 252, 2, 'A6', 1, '2014-06-01 15:00:29'),
(1368, 253, 1, 'A7', 1, '2014-06-01 15:00:29'),
(1369, 253, 2, 'A8', 1, '2014-06-01 15:00:29'),
(1370, 254, 1, 'A9', 1, '2014-06-01 15:00:29'),
(1371, 254, 2, 'A10', 1, '2014-06-01 15:00:29'),
(1372, 255, 1, 'A11', 1, '2014-06-01 15:00:29'),
(1373, 255, 2, 'A12', 1, '2014-06-01 15:00:29'),
(1374, 256, 1, 'A13', 1, '2014-06-01 15:00:29'),
(1375, 256, 2, 'A14', 1, '2014-06-01 15:00:29'),
(1376, 257, 1, 'A15', 1, '2014-06-01 15:00:29'),
(1377, 257, 2, 'A16', 1, '2014-06-01 15:00:29'),
(1378, 258, 1, 'A17', 1, '2014-06-01 15:00:29'),
(1379, 258, 2, 'A18', 1, '2014-06-01 15:00:29'),
(1380, 259, 1, 'A19', 1, '2014-06-01 15:00:29'),
(1381, 259, 2, 'A20', 1, '2014-06-01 15:00:29'),
(1382, 260, 1, 'A21', 0, '2014-06-01 15:00:29'),
(1383, 260, 2, 'A22', 0, '2014-06-01 15:00:29'),
(1384, 261, 1, 'B1', 1, '2014-06-01 15:00:29'),
(1385, 261, 2, 'B2', 1, '2014-06-01 15:00:29'),
(1386, 262, 1, 'B3', 1, '2014-06-01 15:00:29'),
(1387, 262, 2, 'B4', 1, '2014-06-01 15:00:29'),
(1388, 263, 1, 'B5', 1, '2014-06-01 15:00:29'),
(1389, 263, 2, 'B6', 1, '2014-06-01 15:00:29'),
(1390, 264, 1, 'B7', 1, '2014-06-01 15:00:29'),
(1391, 264, 2, 'B8', 1, '2014-06-01 15:00:29'),
(1392, 265, 1, 'B9', 1, '2014-06-01 15:00:29'),
(1393, 265, 2, 'B10', 1, '2014-06-01 15:00:29'),
(1394, 266, 1, 'B11', 1, '2014-06-01 15:00:29'),
(1395, 266, 2, 'B12', 1, '2014-06-01 15:00:29'),
(1396, 267, 1, 'B13', 1, '2014-06-01 15:00:29'),
(1397, 267, 2, 'B14', 1, '2014-06-01 15:00:29'),
(1398, 268, 1, 'B15', 1, '2014-06-01 15:00:29'),
(1399, 268, 2, 'B16', 1, '2014-06-01 15:00:29'),
(1400, 269, 1, 'B17', 1, '2014-06-01 15:00:29'),
(1401, 269, 2, 'B18', 1, '2014-06-01 15:00:29'),
(1402, 270, 1, 'B19', 1, '2014-06-01 15:00:29'),
(1403, 270, 2, 'B20', 1, '2014-06-01 15:00:29'),
(1404, 271, 1, 'B21', 1, '2014-06-01 15:00:29'),
(1405, 271, 2, 'B22', 1, '2014-06-01 15:00:29'),
(1406, 272, 2, 'C1', 1, '2014-06-01 15:00:29'),
(1407, 272, 1, 'C2', 1, '2014-06-01 15:00:29'),
(1408, 273, 2, 'C3', 1, '2014-06-01 15:00:29'),
(1409, 273, 1, 'C4', 1, '2014-06-01 15:00:29'),
(1410, 274, 2, 'C5', 1, '2014-06-01 15:00:29'),
(1411, 274, 1, 'C6', 1, '2014-06-01 15:00:29'),
(1412, 275, 2, 'C7', 1, '2014-06-01 15:00:29'),
(1413, 275, 1, 'C8', 1, '2014-06-01 15:00:29'),
(1414, 276, 2, 'C9', 1, '2014-06-01 15:00:29'),
(1415, 276, 1, 'C10', 1, '2014-06-01 15:00:29'),
(1416, 277, 2, 'C11', 1, '2014-06-01 15:00:29'),
(1417, 277, 1, 'C12', 1, '2014-06-01 15:00:29'),
(1418, 278, 2, 'C13', 1, '2014-06-01 15:00:29'),
(1419, 278, 1, 'C14', 1, '2014-06-01 15:00:29'),
(1420, 279, 2, 'C15', 1, '2014-06-01 15:00:29'),
(1421, 279, 1, 'C16', 1, '2014-06-01 15:00:29'),
(1422, 280, 2, 'C17', 1, '2014-06-01 15:00:29'),
(1423, 280, 1, 'C18', 1, '2014-06-01 15:00:29'),
(1424, 281, 2, 'C19', 1, '2014-06-01 15:00:29'),
(1425, 281, 1, 'C20', 1, '2014-06-01 15:00:29'),
(1426, 282, 2, 'C21', 1, '2014-06-01 15:00:29'),
(1427, 282, 1, 'C22', 1, '2014-06-01 15:00:29'),
(1428, 283, 1, 'D1', 1, '2014-06-01 15:00:29'),
(1429, 283, 2, 'D2', 1, '2014-06-01 15:00:29'),
(1430, 284, 1, 'D3', 1, '2014-06-01 15:00:29'),
(1431, 284, 2, 'D4', 1, '2014-06-01 15:00:29'),
(1432, 285, 1, 'D5', 1, '2014-06-01 15:00:29'),
(1433, 285, 2, 'D6', 1, '2014-06-01 15:00:29'),
(1434, 286, 1, 'D7', 1, '2014-06-01 15:00:29'),
(1435, 286, 2, 'D8', 1, '2014-06-01 15:00:29'),
(1436, 287, 1, 'D9', 1, '2014-06-01 15:00:29'),
(1437, 287, 2, 'D10', 1, '2014-06-01 15:00:29'),
(1438, 288, 1, 'D11', 1, '2014-06-01 15:00:29'),
(1439, 288, 2, 'D12', 1, '2014-06-01 15:00:29'),
(1440, 289, 1, 'D13', 1, '2014-06-01 15:00:29'),
(1441, 289, 2, 'D14', 1, '2014-06-01 15:00:29'),
(1442, 290, 1, 'D15', 1, '2014-06-01 15:00:29'),
(1443, 290, 2, 'D16', 1, '2014-06-01 15:00:29'),
(1444, 291, 1, 'D17', 0, '2014-06-01 15:00:29'),
(1445, 291, 2, 'D18', 0, '2014-06-01 15:00:29'),
(1446, 292, 1, 'E1', 1, '2014-06-01 15:00:29'),
(1447, 292, 2, 'E2', 1, '2014-06-01 15:00:29'),
(1448, 293, 1, 'E3', 1, '2014-06-01 15:00:29'),
(1449, 293, 2, 'E4', 1, '2014-06-01 15:00:29'),
(1450, 294, 1, 'E5', 1, '2014-06-01 15:00:29'),
(1451, 294, 2, 'E6', 1, '2014-06-01 15:00:29'),
(1452, 295, 1, 'E7', 1, '2014-06-01 15:00:29'),
(1453, 295, 2, 'E8', 1, '2014-06-01 15:00:29'),
(1454, 297, 1, 'E11', 1, '2014-06-01 15:00:29'),
(1455, 297, 2, 'E12', 1, '2014-06-01 15:00:29'),
(1456, 298, 1, 'E13', 1, '2014-06-01 15:00:29'),
(1457, 298, 2, 'E14', 1, '2014-06-01 15:00:29'),
(1458, 299, 1, 'E15', 1, '2014-06-01 15:00:29'),
(1459, 299, 2, 'E16', 1, '2014-06-01 15:00:29'),
(1460, 300, 1, 'E17', 1, '2014-06-01 15:00:29'),
(1461, 300, 2, 'E18', 1, '2014-06-01 15:00:29'),
(1462, 301, 1, 'E19', 1, '2014-06-01 15:00:29'),
(1463, 301, 2, 'E20', 1, '2014-06-01 15:00:29'),
(1464, 302, 1, 'F1', 1, '2014-06-01 15:00:29'),
(1465, 302, 2, 'F2', 1, '2014-06-01 15:00:29'),
(1466, 303, 1, 'F3', 1, '2014-06-01 15:00:29'),
(1467, 303, 2, 'F4', 1, '2014-06-01 15:00:29'),
(1468, 304, 1, 'F5', 1, '2014-06-01 15:00:29'),
(1469, 304, 2, 'F6', 1, '2014-06-01 15:00:29'),
(1470, 305, 1, 'F7', 1, '2014-06-01 15:00:29'),
(1471, 305, 2, 'F8', 1, '2014-06-01 15:00:29'),
(1472, 307, 1, 'F11', 1, '2014-06-01 15:00:29'),
(1473, 307, 2, 'F12', 1, '2014-06-01 15:00:29'),
(1474, 308, 1, 'F13', 1, '2014-06-01 15:00:29'),
(1475, 308, 2, 'F14', 1, '2014-06-01 15:00:29'),
(1476, 309, 1, 'F15', 1, '2014-06-01 15:00:29'),
(1477, 309, 2, 'F16', 1, '2014-06-01 15:00:29'),
(1478, 310, 1, 'F17', 1, '2014-06-01 15:00:29'),
(1479, 310, 2, 'F18', 1, '2014-06-01 15:00:29'),
(1480, 311, 1, 'F19', 1, '2014-06-01 15:00:29'),
(1481, 311, 2, 'F20', 1, '2014-06-01 15:00:29');

--
-- Dumping data for table `npl_srs_seats_log`
--

--
-- Dumping data for table `npl_srs_tickets`
--

--
-- Dumping data for table `npl_srs_tickets_log`
--

--
-- Dumping data for table `npl_news`
--
INSERT INTO `npl_news` (`id`, `author_id`, `title`, `description`, `written_datetime`)
VALUES
	(1,3,'21.12.2012','<strong>Apocalypse hat verschlafen</strong><br/>\n	Nun, das mit dem Weltuntergang scheint wohl schief gegangen zu sein...<br />\n	Umso mehr freuen wir uns euch die nächsten noprobLANs anzukünden!<br />\n	<br />\n	<strong>noprobLAN v35.6</strong> 5. - 7.April 2013<br />\n	<strong>noprobLAN v39.1</strong> 11. - 13. Oktober 2013','2014-11-08 13:56:08'),
	(2,3,'noprobLAN participate @ GameThat','<strong>We will be there</strong><br/>\n	Mitte Februar findet in Flawil die GameThat	statt.<br />\n	Wir haben uns mit dem OK-Mitglied ill.oOminated unterhalten und haben uns\n	bereit erklärt, der GameThat unser Material zur Verfügung zu stellen.<br />\n	Im Gegenzug werden OK-Mitglieder der noprobLAN an der GameThat anwesend sein.<br />\n	Wir hoffen bekannte Gesichter zu sehen, Herausforderungen zu meistern und \n	freuen uns auf die GameThat!','2014-11-08 13:56:37'),
	(3,3,'The number eleven','<strong>Incoming noprobLAN v35.6</strong><br/>\n	In etwa zwei Monaten ist es soweit, die noprobLAN v35.6 wird ihre Tore öffnen.<br />\n	<br />\n	Wir hoffen wie immer auf ein gemütliches Beisammensein!<br /><br />\n	<a class=\"button\" href=\"<?= $this->baseUrl(\'lan/info/lanid/11\') ?>\">Zur LAN</a>','2014-11-08 13:57:06'),
	(4,3,'Wir sind fast voll...','<strong>Wer zuerst kommt, mahlt zuerst</strong><br/>\n	Unsere Plätze sind begrenzt.<br />\n	Wir haben leider nicht die Möglichkeit mehr als 120 Leute unterzubringen.\n	<br /><br />\n	So wie es jetzt aussieht bekommen nur diejenigen einen Sitzplatz, die vorausbezahlt haben.<br />\n	Darum bitten wir Dich so schnell wie möglich einzuzahlen!<br />\n	<br />\n	<b style=\"color: darkred;\">...er Vorfreude</b><br />\n	<br />\n	Das npL-Team','2014-11-08 13:57:33'),
	(5,3,'Heisser Sommer, gemütlicher Herbst','<strong>Sitzplatz, Vorauszahlung, Platzknappheit.</strong><br/>\n	Wie es aussieht haben wir wiederum mehr Anmeldungen als Plätze!<br />\n	In diesem Falle gilt: Die ersten 120, die vorauszahlen, erhalten die Plätze.<br />\n	Du bist noch garnicht angemeldet?<br />\n	Dann pack die Gelegenheit am Schopf, melde dich an und zahle direkt voraus.<br />\n	Die Chancen sind jetzt noch da einen der Sitzplätze zu ergattern!\n	<br /><br />\n	<strong>Abkühlung, Ferien, Gemeinsamkeit.</strong><br />\n	Ein heisser Sommer haben wir diese Tage.<br />\n	Aber keine Bange, auf diesen heissen Sommer folgt ein gemütlicher Event ;)<br />\n	Einige von euch verbrachten die Sommerferien im Ausland,<br />\n	andere gönnten sich einen Sprung ins kühle Nass.<br />\n	Wir sind in den Vorbereitungen für die nächste noprobLAN diesen Oktober.<br />\n	Oh, natürlich gönnen auch wir uns Abkühlung ;) 	\n	<br /><br />\n	Das npL-Team','2014-11-08 13:57:59'),
	(6,3,'Fully loaded','<strong>Wir sind ausverkauft!</strong><br />\n	Sitzplätze gibt es nur noch auf dem Schwarzmarkt oder durch Bestechung des Teams ;-)<br />\n	<br />\n	Nie hätten wir gedacht, dass wir so überrannt werden.<br />\n	Wir freuen uns wahnsinnig auf die LAN\n	und die gemütliche Stimmung mit euch allen.<br />\n	Gleichzeitig ist es natürlich schade, dass nicht alle kommen können.<br />\n	Bei einem solchen Ansturm müssen wir für die Zukunft natürlich weiterdenken.<br />\n	Wie das sein wird, wissen wir noch nicht.<br />\n	<br />\n	Auf jeden Fall möchten wir euch allen herzlichst danken.<br />\n	Wir haben klein angefangen und nur mit euch konnten wir wachsen.<br />\n	Nur mit euch ist die noprobLAN die gemütlichste LAN-Party der Schweiz!<br />\n	<br />\n	Das npL-Team','2014-11-08 13:58:30'),
	(7,3,'noprobLAN v39.1 has ended','<strong>Ein Dankeschön aus der Küche</strong><br />\n        Am letzten Sonntag schlossen sich die Türen der noprobLAN ein weiteres Mal.<br />\n        Wir dürfen gemeinsam auf ein gemütliches und gelungenes Wochenende zurückschauen.<br />\n        Dies verdanken wir vor allem den Gamerinnen und Gamern aus dem In- und Ausland, welche zur guten Atmosphäre beigetragen haben.<br />\n        Ein grosses Dankeschön an alle, die da waren. Ohne euch ist die noprobLAN keine noprobLAN!<br />\n        <br />\n        Wir freuen uns schon jetzt darauf die Türen am 30.05.2014 ab 12:00 Uhr (!) wieder für euch zu öffnen.<br />\n        Und ich für meinen Teil freue mich bereits wieder euch einen kulinarischen Leckerbissen aufzutischen.<br />\n        <br />\n        Es grüsst AdP, der Küchenchef, und der Rest eures npL-Teams','2014-11-08 13:58:55'),
	(8,3,'Frohe Festtage','Es ist wieder soweit und ein weiteres Jahr geht dem Ende zu.<br />\n        Uns bleibt nur noch euch und euren Familien ein schönes Weihnachtsfest und einen guten Rutsch ins neue Jahr zu wünschen.<br />\n        Wir freuen uns euch auch im Jahr 2014 wieder die gemütlichste LAN-Party zu bieten und hoffen auf eine rege Teilnahme.<br />\n        <br />\n        Das npL-Team','2014-11-08 13:59:15'),
	(9,3,'Noch drei Monate...','...und dann ist es wieder soweit. Die nächste noprobLAN schaltet ihre Ports frei und öffnet euch den Weg ins Netwerk.<br />\n        Bereits sind über die Hälfte der Plätze belegt.<br />\n        Also melde dich noch heute an und vergiss die Vorauszahlung nicht, um dir Deinen Platz zu sichern.<br />\n        <br />\n        Wir freuen uns schon jetzt, euch wieder in der MZH Berg zu begrüssen.','2014-11-08 13:59:42'),
	(10,3,'npL v43.2 AUSVERKAUFT','Zwei Monate vor der LAN sind wir bereits komplett ausverkauft!<br />\n        <br />\n        <strong>ABER</strong> für alle, die nicht vorausbezahlt haben gibt es noch eine Chance!<br />\n        Ein paar wenige weitere Plätze können wir zusätzlich einrichten und Du hast die Chance einen dieser Plätze zu ergattern.<br />\n        Interessiert? Dann schick uns ein originelles Mail warum ausgerechnet Du einen dieser Plätze haben sollst bis am 05.04.2014 um 23:59 Uhr an\n        special@npl.ch und mit etwas Glück kannst Du doch noch an die LAN kommen.<br />\n        Ihr seid eine kleine Gruppe? Dann schreibt ein Mail für die Gruppe! Bitte gebt dann auch die Anzahl Leute an.<br />\n        Also ran an die Tastatur!<br />\n        <br />\n        Das npL-Team','2014-11-08 14:00:04'),
	(11,3,'noprobLAN v43.2 ping is to high!','<strong>Es dankt das NOC allen Netzwerk-Betatestern ;)</strong><br />\n        <br />\n        Die noprobLAN v43.2 ist vorbei. Das npL-Team befindet sich im Sommerschlaf (träumt von den Bildern in der Gallerie) und bereitet\n        sich geistig auf die nächste LAN am 10.10.2014 vor.<br />\n        <br />\n        Es grüsst das NOC und das ganze npL-Team','2014-11-08 14:00:25'),
	(12,3,'Fast ausverkauft!','Schon sehr bald öffnen wir die Türen für die noprobLAN v47.1.\n        Willst auch Du kommen, hast Du dir Deinen Platz aber noch nicht gesichert?\n        Dann nichts wie ran an deinen PC und sichere dir noch heute einen der letzten freien Plätze.<br />\n        <br />\n        Wir freuen uns euch schon bald begrüssen zu dürfen.<br />\n        Das NPL-Team','2014-11-08 14:00:45'),
	(13,3,'Erste wichtige Infos zur npL > 50','<p>Wir möchten euch über ein paar wenige aber wichtige Dinge informieren zur nächsten noprobLAN:<br /><ul><li>Der Sitzplan ist derzeit noch nicht aufgeschaltet, da wir noch daran arbeiten. Dementsprechend kann noch nicht reserviert werden.</li><li>Wir stellen dieses Mal keine der Turnhallen-Matten zur Verfügung. Bis anhin boten wir diese als Zusatz an, dies ist uns nicht länger möglich. Bitte bringt entsprechend eine eigene Matte oder Feldbett oder "Gumpischloss" oder was auch immer mit! (Im Falle das jemand ernsthaft ein "Gumpischloss" mitnehmen sollte wären wir sicherlich froh das zu wissen!)</li></ul>Weitere Updates (und vorallem gute Neuigkeiten wie der Sitzplan, geplante Turniere, etc) folgen demnächst!<br><br>Das NPL-Team</p>','2014-11-08 14:00:45');
