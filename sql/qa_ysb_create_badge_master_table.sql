CREATE TABLE IF NOT EXISTS `^ysb_badge_master` (
  `badgeid` int(10) unsigned UNIQUE NOT NULL,
  `name` varchar(255) NOT NULL,
  `event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;