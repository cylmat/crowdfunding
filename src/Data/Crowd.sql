-- MySql
USE crowd;

DROP TABLE IF EXISTS `crowd`.`project`;
CREATE TABLE IF NOT EXISTS `crowd`.`project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fk_id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_USER` (`fk_id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `crowd`.`user`;
CREATE TABLE IF NOT EXISTS `crowd`.`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) UNIQUE NOT NULL,
  `password` varchar(200) NOT NULL,
  `nom` varchar(100),
  `prenom` varchar(100),
  `email` varchar(100),
  `telephone` int(10),
  `ville` varchar(200),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `crowd`.`project` 
ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`fk_id_user`) 
REFERENCES `user`(`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;