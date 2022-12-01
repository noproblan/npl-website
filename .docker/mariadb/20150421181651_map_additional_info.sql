-- --------------------------------------------------------
-- Use the following command in the shell to generate
-- new migration file names:
--
-- date "+%Y%m%d%H%M%S"
--
-- --------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `npl_users`
--

ALTER TABLE `npl`.`npl_srs_maps` ADD `additional_info` TEXT NULL DEFAULT NULL AFTER `width`;
