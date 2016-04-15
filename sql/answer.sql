/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : psy_test

 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 04/15/2016 14:41:50 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `answer`
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `aid` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `finish_test` bit(1) NOT NULL DEFAULT b'0',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'name of user',
  `occupation` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gender` char(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'gender of user',
  `birthday` datetime NOT NULL COMMENT 'birthday of user',
  `education` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'education',
  `bloodType` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'blood type',
  `marriage` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'marriage info',
  `test_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `qid` int(255) unsigned NOT NULL COMMENT 'last submitted answer belongs to which question (for session recovery)',
  `answer_json` mediumtext CHARACTER SET ascii COMMENT 'answer json',
  `start_time` varchar(128) DEFAULT NULL COMMENT 'the time when user starts to take the test',
  `finish_time` varchar(128) DEFAULT NULL COMMENT 'the time when user submit all answers and finish test',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
