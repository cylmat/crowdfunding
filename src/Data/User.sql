-- MySql
USE crowd;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,

  `login` varchar(255) UNIQUE NOT NULL,
  `password` text NOT NULL

  `civilite` varchar(100) NULL,
  `nom` varchar(100) NULL,
  `prenom` varchar(100) NULL,

  `titre` varchar(100) NULL,
  `emploi` varchar(100) NULL,

  `ville` varchar(100) NULL,

  `fk_id_login` int(11) NOT NULL,
  
  PRIMARY KEY (`id`),
  KEY `FK_ID_LOGIN` (`fk_id_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;