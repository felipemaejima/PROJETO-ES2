#
# TABLE STRUCTURE FOR: lost_password
#

DROP TABLE IF EXISTS `lost_password`;

CREATE TABLE `lost_password` (
  `id` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL DEFAULT '',
  `hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `used` tinyint(1) DEFAULT '0',
  `ip` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `lost_password` (`id`, `id_user`, `hash`, `email`, `used`, `ip`, `platform`, `agent`, `referer`, `created`, `updated`, `resolution`) VALUES ('26154d18-80c0-c3e9-9c07-b48bb37d34e3', '783bbe7a-b05b-733b-b2db-b0a4eba7cac1', '3c50ba129a4c9db62d3cd3fbf3a3eab7', 'trinitynascimento@gmail.com', 0, '127.0.0.1', 'Windows 10', 'Chrome 126.0.0.0', 'http://127.0.0.1/erp.app/login', 1721916388, NULL, NULL);
INSERT INTO `lost_password` (`id`, `id_user`, `hash`, `email`, `used`, `ip`, `platform`, `agent`, `referer`, `created`, `updated`, `resolution`) VALUES ('b5512f6c-963a-8ef6-15e6-6ee5665e15d0', '783bbe7a-b05b-733b-b2db-b0a4eba7cac1', '5f00a1bf961ae2213a0668d5436de1fa', 'trinitynascimento@gmail.com', 0, '127.0.0.1', 'Windows 10', 'Chrome 126.0.0.0', 'http://127.0.0.1/erp.app/login', 1721916116, NULL, NULL);
INSERT INTO `lost_password` (`id`, `id_user`, `hash`, `email`, `used`, `ip`, `platform`, `agent`, `referer`, `created`, `updated`, `resolution`) VALUES ('c3511cb2-f32e-1ad2-df18-20f2038fb741', '783bbe7a-b05b-733b-b2db-b0a4eba7cac1', '3a8945ba7870348c5db09a4478087b74', 'trinitynascimento@gmail.com', 0, '127.0.0.1', 'Windows 10', 'Chrome 126.0.0.0', 'http://127.0.0.1/erp.app/login', 1721917281, NULL, NULL);


