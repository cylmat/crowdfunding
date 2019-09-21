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

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) UNIQUE NOT NULL,
  `password` text NOT NULL,
  `civilite` varchar(100),
  `nom` varchar(100),
  `prenom` varchar(100),
  `titre` varchar(100),
  `emploi` varchar(100),
  `ville` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `crowd`.`project` 
ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`fk_id_user`) 
REFERENCES `user`(`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;