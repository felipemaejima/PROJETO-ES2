#
# TABLE STRUCTURE FOR: functions
#

DROP TABLE IF EXISTS `functions`;

CREATE TABLE `functions` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `isinactive` varchar(1) NOT NULL DEFAULT 'T',
  `confirmed` varchar(1) NOT NULL DEFAULT 'F',
  `ip` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('02e9ad16-4e03-fa26-d01a-4cad5176e794', 'agreements', 'Agreements', 'F', 'T', '127.0.0.1', 'Chrome 127.0.0.0', NULL, 'Windows 10', 1723470543, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('06b4f3cc-153b-98aa-014b-dadb70082a8f', 'licensecontrol', 'Licensecontrol', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('22e0b2e7-87d4-4d21-0039-dce3a713bd4c', 'relationships', 'Relationships', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('3fc39101-3571-00da-f98c-d60d6312684e', 'salesorders', 'Salesorders', 'F', 'T', '127.0.0.1', 'Firefox 126.0', NULL, 'Windows 10', 1715790716, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('496c9b50-6eef-3e5b-8f68-dc1878d31598', 'separations', 'Separations', 'F', 'T', '127.0.0.1', 'Firefox 126.0', NULL, 'Windows 10', 1717523503, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('4d38b83d-9a59-cabf-320c-2109b76994e0', 'documents', 'Documents', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('4eba3983-b275-67aa-dc29-a0f45839e03f', 'returnreceipts', 'Returnreceipts', 'F', 'T', '127.0.0.1', 'Chrome 127.0.0.0', NULL, 'Windows 10', 1727110881, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('52966554-5cef-514e-5084-16547a86bc6b', 'employees', 'Employees', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('5671d67b-a0a2-ed67-0b58-989f491e6cbf', 'returnauthorizations', 'Returnauthorizations', 'F', 'T', '127.0.0.1', 'Chrome 127.0.0.0', NULL, 'Windows 10', 1726860590, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('58d7f043-a58b-68da-d6e1-a011f2c677e5', 'roles', 'Roles', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('5930a980-6f45-09cf-4434-98d45a5e611a', 'items', 'Items', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1710335371, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('648500b9-8e08-2794-243b-37ffb4090ed8', 'Payments', 'Payments', 'F', 'T', '127.0.0.1', 'Chrome 128.0.0.0', '', 'Windows 10', 1726243615, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('650f6c9f-db91-e820-fe55-d0d7dfb1a037', 'estimates', 'Estimates', 'F', 'T', '127.0.0.1', 'Chrome 124.0.0.0', '', 'Windows 10', 1713963950, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('6875b398-2cf0-aab7-1b60-87f67a22ba64', 'suppliers', 'Suppliers', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1710180909, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('6a936116-93a6-d6a4-8bb5-f26f4d81cef3', 'Installments', 'Installments', 'F', 'T', '127.0.0.1', 'Chrome 128.0.0.0', '', 'Windows 10', 1726243615, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('6e9846f1-f96b-75cf-abcc-c6856c073b8c', 'addresses', 'Addresses', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('7f58a537-65e6-f8bd-df87-d314d620920d', 'receipts', 'Receipts', 'F', 'T', '127.0.0.1', 'Chrome 123.0.0.0', '', 'Windows 10', 1712866142, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('86bef170-6a28-bfd0-e316-d9547ff00b4e', 'purchaserequests', 'Purchaserequests', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1721658867, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('8c5fc224-3041-ad5b-af27-32ec4d242215', 'cfops', 'Cfops', 'F', 'T', '127.0.0.1', 'Chrome 123.0.0.0', NULL, 'Windows 10', 1712866142, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('973c141a-1fb1-9f97-486c-f0315cd77ca6', 'accounts', 'Accounts', 'F', 'T', '127.0.0.1', 'Chrome 125.0.0.0', NULL, 'Windows 10', 1717610797, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('a152dad5-8f04-7ef5-ef4d-083838dd55ee', 'services', 'Services', 'F', 'T', '127.0.0.1', 'Chrome 125.0.0.0', NULL, 'Windows 10', 1720893842, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('a1e5fedc-8417-1f60-a64f-84a1fd597741', 'inventory', 'Inventory', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1711139346, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('a35ff78d-229e-9f4d-d86e-78703b070f08', 'subsidiaries', 'Subsidiaries', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('a3ee0bca-cc0c-4bf6-6a67-7390d492f1ce', 'carriers', 'Carriers', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1710180919, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('b3459ffd-9526-91ad-0062-8fb26a56706a', 'ncms', 'Ncms', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('b533d24e-7df1-98f3-7f34-76a640b8add5', 'creditmemos', 'Creditmemos', 'F', 'T', '127.0.0.1', 'Chrome 127.0.0.0', NULL, 'Windows 10', 1727265161, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('bdbd5ddc-970a-7b84-499b-4c5e0b605d5d', 'expenses', 'Expenses', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('d45c03fc-b147-8d6a-1b2c-5a8cb9bd4561', 'onus', 'Onus', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1710441258, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('d6e6c393-6202-4f74-69fe-f2357a91bd9a', 'invoices', 'Invoices', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', '', 'Windows 10', 1722357919, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('e4f71c25-a4e3-8e04-a16e-c318bf0c6a63', 'customers', 'Customers', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1709146903, NULL);
INSERT INTO `functions` (`id`, `name`, `title`, `isinactive`, `confirmed`, `ip`, `agent`, `referer`, `platform`, `created`, `updated`) VALUES ('e55459c2-b592-7e34-d5aa-29a62ceb7aed', 'purchaseorders', 'Purchaseorders', 'F', 'T', '127.0.0.1', 'Chrome 122.0.0.0', NULL, 'Windows 10', 1711459630, NULL);


