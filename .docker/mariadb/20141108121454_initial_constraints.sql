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
-- Constraints for dumped tables
--

--
-- Constraints for table `npl_laninfos`
--
ALTER TABLE `npl`.`npl_laninfos`
  ADD CONSTRAINT `npl_laninfos_ibfk_1` FOREIGN KEY (`lan_id`) REFERENCES `npl_lans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `npl_srs_desks`
--
ALTER TABLE `npl`.`npl_srs_desks`
  ADD CONSTRAINT `npl_srs_desks_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `npl_srs_maps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `npl_srs_maps`
--
ALTER TABLE `npl`.`npl_srs_maps`
  ADD CONSTRAINT `npl_srs_maps_ibfk_1` FOREIGN KEY (`lan_id`) REFERENCES `npl_lans` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `npl_srs_seats`
--
ALTER TABLE `npl`.`npl_srs_seats`
  ADD CONSTRAINT `npl_srs_seats_ibfk_1` FOREIGN KEY (`desk_id`) REFERENCES `npl_srs_desks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `npl_srs_tickets`
--
ALTER TABLE `npl`.`npl_srs_tickets`
  ADD CONSTRAINT `npl_srs_tickets_ibfk_10` FOREIGN KEY (`lan_id`) REFERENCES `npl_lans` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `npl_srs_tickets_ibfk_11` FOREIGN KEY (`seat_id`) REFERENCES `npl_srs_seats` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `npl_srs_tickets_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `npl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `npl_userroles`
--
ALTER TABLE `npl`.`npl_userroles`
  ADD CONSTRAINT `npl_userroles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `npl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
