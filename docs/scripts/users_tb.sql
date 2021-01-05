CREATE TABLE `users_tb` (
  `usuId` int(11) NOT NULL AUTO_INCREMENT,
  `usuName` varchar(45) DEFAULT NULL,
  `usuLogin` varchar(45) DEFAULT NULL,
  `usuPassword` varchar(100) DEFAULT NULL,
  `usuStatus` int(11) DEFAULT '1' COMMENT '1 - Usuário liberado\n2 - Usuário inativo\n3 - Usuário bloqueado',
  `usuDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
