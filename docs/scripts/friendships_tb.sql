CREATE TABLE `friendships_tb` (
  `friId` int(11) NOT NULL AUTO_INCREMENT,
  `friUserOrigin` int(11) NOT NULL,
  `friUserDestination` int(11) NOT NULL,
  `friDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `friStatus` int(11) NOT NULL DEFAULT '1' COMMENT 'friStatus - Situação da amizade\n1 - Pendente (ao usuário de destino)\n2 - Firmada (pelo usuário de destino)\n3 - Negada (pelo usuário de destino)\n4 - Desfeita (independente de quem)',
  PRIMARY KEY (`friId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
