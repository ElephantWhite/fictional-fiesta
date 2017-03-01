-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `acl_resources`
--

CREATE TABLE IF NOT EXISTS `acl_resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(65) NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `acl_resources`
--

INSERT INTO `acl_resources` (`resource_id`, `resource_name`) VALUES
(1, 'auth'),
(2, 'home'),
(3, 'index'),
(4, 'error');