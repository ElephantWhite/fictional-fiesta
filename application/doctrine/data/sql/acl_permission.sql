-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `acl_permissions`
--

CREATE TABLE IF NOT EXISTS `acl_permissions` (
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `permission` varchar(65) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Gegevens worden uitgevoerd voor tabel `acl_permissions`
--

INSERT INTO `acl_permissions` (`role_id`, `resource_id`, `permission`) VALUES
(3, 1, 'allowed'),
(3, 2, 'allowed'),
(1, 1, 'allowed'),
(1, 3, 'allowed'),
(3, 3, 'allowed'),
(1, 2, 'denied'),
(1, 4, 'allowed'),
(3, 4, 'allowed');
