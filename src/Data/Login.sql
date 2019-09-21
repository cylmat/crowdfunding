-- MySql
USE crowd;

DROP TABLE IF EXISTS `crowd`.`login`;
CREATE TABLE IF NOT EXISTS `crowd`.`login` (
  `login` varchar(255) UNIQUE NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;