/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50552
Source Host           : 192.168.1.102:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2017-04-11 16:58:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for api_users
-- ----------------------------
DROP TABLE IF EXISTS `api_users`;
CREATE TABLE `api_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_uniq` varchar(255) DEFAULT NULL,
  `login_name` varchar(255) DEFAULT NULL,
  `login_pass` varchar(255) DEFAULT NULL,
  `realname` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `head_image` varchar(255) DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `last_login_time` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL,
  `created` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_users
-- ----------------------------
