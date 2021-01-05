CREATE TABLE `communities_tb` (
  `comId` int(11) NOT NULL AUTO_INCREMENT,
  `comName` varchar(50) NOT NULL,
  `comDescription` varchar(300) DEFAULT NULL,
  `comDateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comStatus` int(11) NOT NULL COMMENT 'comStatus\n1 - Comunidade Ativa\n2 - Comunidade Inativa (ninguém pode entrar e nem postar)',
  `comAcceptance` int(11) NOT NULL COMMENT 'comAcceptance - Tipo de aceitação de membros\n1 - Livre (qualquer um pode entrar)\n2 - Requer aprovação do administrador',
  `comVisibility` int(11) NOT NULL COMMENT 'comVisibility - Visibilidade das postagens\n1 - Aberta para qualquer um ler\n2 - Apenas membros que fazem parte da comunidade',
  `comAdmUser` int(11) NOT NULL,
  PRIMARY KEY (`comId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
