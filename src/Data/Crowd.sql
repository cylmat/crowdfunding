-- MySql
CREATE DATABASE IF NOT EXISTS `crowd`;
USE crowd;

DROP TABLE IF EXISTS `crowd`.`3wa_user`;
CREATE TABLE IF NOT EXISTS `crowd`.`3wa_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) UNIQUE NOT NULL,
  `password` varchar(200) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` int(10) NOT NULL,
  `ville` varchar(200) NULL DEFAULT '',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `crowd`.`3wa_project`;
CREATE TABLE IF NOT EXISTS `crowd`.`3wa_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `resume` varchar(255) NOT NULL DEFAULT '',
  `fk_id_user` int(11) NOT NULL,
  `somme_necessaire` int(11) NOT NULL,
  `date_fin` DATE NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_num` int(2) NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_ID_USER` (`fk_id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `crowd`.`3wa_project` 
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`fk_id_user`) 
REFERENCES `3wa_user`(`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;




DROP TABLE IF EXISTS `crowd`.`3wa_stat`;
CREATE TABLE IF NOT EXISTS `crowd`.`3wa_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_project` int(11) NOT NULL,
  `date_don` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `montant` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_PROJECT` (`fk_id_project`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `crowd`.`3wa_stat` 
  ADD CONSTRAINT `fk_id_project` FOREIGN KEY (`fk_id_project`) 
REFERENCES `3wa_project`(`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT;


-- first value
-- necessaire pour récupérer le nom des colonnes
INSERT INTO `3wa_user` (`id`, `login`, `password`, `nom`, `prenom`, `email`, `telephone`, `ville`, `is_admin`, `date_creation`) VALUES (NULL, '', '', '', '', '', '0', '', '0', CURRENT_TIMESTAMP);
INSERT INTO `3wa_project` (`id`, `titre`, `description`, `resume`, `fk_id_user`, `somme_necessaire`, `date_fin`, `image_url`, `category_num`, `date_creation`, `actif`) VALUES (NULL, '', '', '', '1', '0', '2009-01-01', '', '1', CURRENT_TIMESTAMP, 0);
INSERT INTO `3wa_stat` (`id`, `fk_id_project`, `date_don`, `montant`) VALUES (NULL, '1', CURRENT_TIMESTAMP, '0');