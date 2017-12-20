CREATE TABLE IF NOT EXISTS `^ysb_badges` (
  `badgeid` int(20) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `show_flag` smallint unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
