CREATE TABLE `compostresponses_tb` (
  `cprId` int(11) NOT NULL AUTO_INCREMENT,
  `cprIdCpo` int(11) NOT NULL,
  `cprIdUser` int(11) NOT NULL,
  `cprDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cprText` mediumtext NOT NULL,
  PRIMARY KEY (`cprId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
