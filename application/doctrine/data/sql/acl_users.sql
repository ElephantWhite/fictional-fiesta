-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `acl_users`
--

CREATE TABLE IF NOT EXISTS `acl_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `username` varchar(65) NOT NULL,
  `password` varchar(160) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `acl_users`
--

INSERT INTO `acl_users` (`uid`, `role_id`, `username`, `password`) VALUES
(1, 3, 'iwan', '01ccce480c60fcdb67b54f4509ffdb56');
