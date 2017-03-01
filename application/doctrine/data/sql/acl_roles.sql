-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `acl_roles`
--

CREATE TABLE IF NOT EXISTS `acl_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(65) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `acl_roles`
--

INSERT INTO `acl_roles` (`role_id`, `role_name`) VALUES
(1, 'Guest'),
(2, 'Admin'),
(3, 'Verzuimcoordinator');
