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
-- Table structure for table `npl_news`
--

ALTER TABLE  `npl_srs_seats` DROP INDEX `name_desk_id`;
ALTER TABLE  `npl_srs_seats` ADD UNIQUE INDEX `name_desk_id` (`name`,`desk_id`,`seat_position_id`);
