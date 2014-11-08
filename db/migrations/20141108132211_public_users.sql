--
-- Structure for view `npl_view_users`
--
DROP TABLE IF EXISTS `npl_view_users`;

CREATE VIEW `npl_view_users` AS select `npl_users`.`id` AS `id`,`npl_users`.`username` AS `username` from `npl_users`;
