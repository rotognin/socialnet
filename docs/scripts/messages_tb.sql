CREATE TABLE `messages_tb` (
  `mesId` int NOT NULL AUTO_INCREMENT,
  `mesUserOrigin` int NOT NULL,
  `mesUserDestination` int NOT NULL,
  `mesText` mediumtext NOT NULL,
  `mesDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mesStatus` int NOT NULL COMMENT 'Situação da mensagem:\n1 - Não lida (aparece na tela principal do usuário)\n2 - Lida (só aparece quando listar todas)\n3 - Excluída (fica em banco, podendo ser recuperada pelo administrador da rede)',
  PRIMARY KEY (`mesId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
