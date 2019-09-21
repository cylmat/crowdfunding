-- MySql
USE crowd;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,

  `login` varchar(100),
  `password` TEXT,

  `civilite` varchar(100),
  `nom` varchar(100),
  `prenom` varchar(100),

  `titre` varchar(100),
  `emploi` varchar(100),

  `ville` varchar(100),

  `fk_id_login` int(11) NOT NULL,
  
  PRIMARY KEY (`id`),
  KEY `FK_ID_LOGIN` (`fk_id_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;