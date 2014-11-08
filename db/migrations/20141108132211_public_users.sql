-- --------------------------------------------------------
-- Use the follwoing command in the shell to generate
-- new migration file names:
--
-- date "+%Y%m%d%H%M%S"
--
-- --------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Structure for view `npl_view_users`
--
DROP TABLE IF EXISTS `npl_view_users`;

CREATE VIEW `npl_view_users` AS select `npl_users`.`id` AS `id`,`npl_users`.`username` AS `username` from `npl_users`;
