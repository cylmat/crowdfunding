-- MySql
USE crowd;

CREATE TABLE IF NOT EXISTS `crowd`.`project` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fk_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_project`),
  KEY `FK_ID_USER` (`fk_id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `crowd`.`project` 
ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`fk_id_user`) 
REFERENCES `user`(`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;