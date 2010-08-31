-- ----------------------------
-- Table structure for `account_extend`
-- ----------------------------
DROP TABLE IF EXISTS `account_extend`;
CREATE TABLE `account_extend` (
  `account_id` int(10) unsigned NOT NULL,
  `account_level` smallint(3) NOT NULL DEFAULT '1',
  `theme` smallint(3) NOT NULL DEFAULT '0',
  `last_visit` int(25) DEFAULT NULL,
  `registration_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `activation_code` bigint(255) DEFAULT NULL,
  `secret_q1` text,
  `secret_a1` text,
  `secret_q2` text,
  `secret_a2` text,
  `hide_email` smallint(3) NOT NULL DEFAULT '0',
  `web_points` int(3) NOT NULL DEFAULT '0',
  `points_earned` smallint(5) NOT NULL DEFAULT '0',
  `points_spent` smallint(5) NOT NULL DEFAULT '0',
  `total_donations` varchar(5) NOT NULL DEFAULT '0.00',
  `total_votes` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account_extend
-- ----------------------------

-- ----------------------------
-- Table structure for `account_groups`
-- ----------------------------
DROP TABLE IF EXISTS `account_groups`;
CREATE TABLE `account_groups` (
  `account_level` smallint(2) NOT NULL DEFAULT '1',
  `title` text,
  PRIMARY KEY (`account_level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account_groups
-- ----------------------------
INSERT INTO `account_groups` VALUES ('1', 'Guest');
INSERT INTO `account_groups` VALUES ('2', 'Member');
INSERT INTO `account_groups` VALUES ('3', 'Admin');
INSERT INTO `account_groups` VALUES ('4', 'Super Admin');
INSERT INTO `account_groups` VALUES ('5', 'Banned');

-- ----------------------------
-- Table structure for `account_keys`
-- ----------------------------
DROP TABLE IF EXISTS `account_keys`;
CREATE TABLE `account_keys` (
  `id` int(11) unsigned NOT NULL,
  `key` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `assign_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of account_keys
-- ----------------------------

-- ----------------------------
-- Table structure for `keyscms_version`
-- ----------------------------
DROP TABLE IF EXISTS `keyscms_version`;
CREATE TABLE `keyscms_version` (
  `dbver` varchar(20) NOT NULL DEFAULT '',
  `dbdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dbver`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of keyscms_version
-- ----------------------------
INSERT INTO `keyscms_version` VALUES ('1.0', '0');

-- ----------------------------
-- Table structure for `online`
-- ----------------------------
DROP TABLE IF EXISTS `online`;
CREATE TABLE `online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(200) NOT NULL DEFAULT 'Guest',
  `user_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `logged` int(10) NOT NULL DEFAULT '0',
  `currenturl` varchar(255) NOT NULL DEFAULT './',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of online
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_items`
-- ----------------------------
DROP TABLE IF EXISTS `shop_items`;
CREATE TABLE `shop_items` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `item_number` varchar(255) NOT NULL DEFAULT '0',
  `itemset` int(10) NOT NULL DEFAULT '0',
  `gold` int(25) NOT NULL DEFAULT '0',
  `quanity` int(25) NOT NULL DEFAULT '1',
  `desc` varchar(255) DEFAULT NULL,
  `wp_cost` varchar(5) NOT NULL DEFAULT '0',
  `donation_cost` varchar(5) NOT NULL DEFAULT '0.00',
  `realms` int(100) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shop_items
-- ----------------------------

-- ----------------------------
-- Table structure for `site_news`
-- ----------------------------
DROP TABLE IF EXISTS `site_news`;
CREATE TABLE `site_news` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `title` text,
  `message` longtext,
  `posted_by` text,
  `post_time` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of site_news
-- ----------------------------

-- ----------------------------
-- Table structure for `site_regkeys`
-- ----------------------------
DROP TABLE IF EXISTS `site_regkeys`;
CREATE TABLE `site_regkeys` (
  `id` smallint(9) NOT NULL DEFAULT '0',
  `key` int(255) DEFAULT '0',
  `used` smallint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of site_regkeys
-- ----------------------------

ALTER TABLE `realmlist` 
ADD `dbinfo` VARCHAR( 355 ) NOT NULL default 'username;password;3306;127.0.0.1;DBWorld;DBCharacter' COMMENT 'Database info to THIS row',
ADD `ra_info` varchar(255) NOT NULL DEFAULT 'type;port;username;password' COMMENT 'type being 0 for Telnet, 1 for SOAP'
ADD `site_enabled` smallint(1) DEFAULT '0';