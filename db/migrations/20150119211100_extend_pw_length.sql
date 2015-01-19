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
-- Table structure for table `npl_users`
--

ALTER TABLE `npl_users` CHANGE `password` `password` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
