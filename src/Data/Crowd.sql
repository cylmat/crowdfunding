-- MySql
CREATE DATABASE `crowd`;
USE crowd;

DROP TABLE IF EXISTS `crowd`.`project`;
CREATE TABLE IF NOT EXISTS `crowd`.`project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `resume` varchar(255),
  `fk_id_user` int(11) NOT NULL,
  `somme` int(11) NOT NULL,
  `max_date` DATE NULL DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_num` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_USER` (`fk_id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `crowd`.`user`;
CREATE TABLE IF NOT EXISTS `crowd`.`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) UNIQUE NOT NULL,
  `password` varchar(200) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` int(10) NOT NULL,
  `ville` varchar(200) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `crowd`.`project` 
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`fk_id_user`) 
REFERENCES `user`(`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;