CREATE TABLE `messages_tb` (
  `mesId` int(11) NOT NULL AUTO_INCREMENT,
  `mesUserOrigin` int(11) NOT NULL,
  `mesUserDestination` int(11) NOT NULL,
  `mesText` mediumtext NOT NULL,
  PRIMARY KEY (`mesId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
