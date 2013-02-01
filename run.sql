CREATE TABLE `starter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

