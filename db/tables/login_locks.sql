#
# TABLE STRUCTURE FOR: login_locks
#

DROP TABLE IF EXISTS `login_locks`;

CREATE TABLE `login_locks` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `lock_expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

