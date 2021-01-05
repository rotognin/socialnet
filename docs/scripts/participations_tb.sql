CREATE TABLE `participations_tb` (
  `parId` int(11) NOT NULL AUTO_INCREMENT,
  `parIdCommunity` int(11) NOT NULL,
  `parIdUser` int(11) NOT NULL,
  `parSituation` int(11) NOT NULL COMMENT 'parSituation - Situação do usuário na comunidade\n1 - Ok - pode postar\n2 - Sob análise do Administrador (não pode postar, mas pode ver)\n3 - Bloqueado (não enxerga nada dentro da comunidade, apenas se ela for aberta ao público) - Não pode reingressar nela',
  `parDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`parId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
