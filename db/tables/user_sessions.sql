#
# TABLE STRUCTURE FOR: user_sessions
#

DROP TABLE IF EXISTS `user_sessions`;

CREATE TABLE `user_sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `session_token` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `session_token` (`session_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_sessions` (`id`, `user_id`, `session_token`, `created`, `updated`) VALUES ('478c2419-95f7-4c54-af5d-b77d80dc13a9', '69d16ada-3aa8-3aa3-de39-9a1d23d04fe7', '439cc75fb31932ea7f1a3ac1d4b6161e961e93dbef9a13b6ed877f9eed82ad29', 1722869493, 1722869493);


