
--
-- 表的结构 `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) default NULL,
  `allday` tinyint(1) NOT NULL default '0',
  `color` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;