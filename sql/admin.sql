/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : psy_test

 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 04/15/2016 14:41:19 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `amid` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'admin username',
  `password` varchar(72) CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'admin password',
  PRIMARY KEY (`amid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `admin`
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES ('1', 'admin', '1234');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
