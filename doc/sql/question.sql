/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : psy_test

 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 04/15/2016 14:42:10 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `question`
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `qid` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(128) NOT NULL,
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `option_1` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NULL' COMMENT 'answer1',
  `option_2` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NULL' COMMENT 'answer2',
  `option_3` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NULL' COMMENT 'answer3',
  `option_4` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NULL' COMMENT 'answer4',
  `option_5` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NULL' COMMENT 'answer5',
  PRIMARY KEY (`qid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
