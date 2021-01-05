CREATE TABLE `communityposts_tb` (
  `cpoId` int(11) NOT NULL AUTO_INCREMENT,
  `cpoIdCommunity` int(11) NOT NULL,
  `cpoIdUser` int(11) NOT NULL,
  `cpoDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cpoText` mediumtext NOT NULL,
  PRIMARY KEY (`cpoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
