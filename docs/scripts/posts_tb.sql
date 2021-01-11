CREATE TABLE `posts_tb` (
  `posId` int(11) NOT NULL AUTO_INCREMENT,
  `posUser` int(11) NOT NULL,
  `posVisibility` int(11) NOT NULL COMMENT 'posVisibility - Visibilidade da postagem\n1 - Pública (todos podem ver)\n2 - Amigos\n3 - Particular (ninguém pode ver)',
  `posText` mediumtext NOT NULL,
  `posDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`posId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
