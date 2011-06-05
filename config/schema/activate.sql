
CREATE TABLE IF NOT EXISTS `sitemaps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc` varchar(255) NOT NULL,
  `lastmod` varchar(60) NOT NULL,
  `changefreq` varchar(30) DEFAULT NULL,
  `priority` float(2,2) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;