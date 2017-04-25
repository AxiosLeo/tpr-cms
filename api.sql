/*
Navicat MySQL Data Transfer

Source Server         : localvm
Source Server Version : 50552
Source Host           : 192.168.1.102:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2017-04-25 16:46:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for api_admin
-- ----------------------------
DROP TABLE IF EXISTS `api_admin`;
CREATE TABLE `api_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security_id` varchar(40) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login_ip` varchar(30) DEFAULT NULL,
  `last_login_time` varchar(15) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_admin
-- ----------------------------
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '0', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', '192.168.1.59', '1493109922', 'e2c35eeeb2ff8fcc89345be94a046860');

-- ----------------------------
-- Table structure for api_app
-- ----------------------------
DROP TABLE IF EXISTS `api_app`;
CREATE TABLE `api_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(100) DEFAULT NULL,
  `platform` varchar(60) DEFAULT NULL,
  `base_version` varchar(60) DEFAULT NULL,
  `last_version` varchar(30) DEFAULT NULL,
  `last_version_time` varchar(20) DEFAULT NULL,
  `app_id` varchar(60) DEFAULT NULL,
  `app_secret` varchar(60) DEFAULT NULL,
  `app_status` tinyint(4) NOT NULL,
  `remark` text,
  `created_at` varchar(30) NOT NULL,
  `update_at` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_app
-- ----------------------------

-- ----------------------------
-- Table structure for api_app_setting
-- ----------------------------
DROP TABLE IF EXISTS `api_app_setting`;
CREATE TABLE `api_app_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` varchar(15) DEFAULT NULL,
  `update_at` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_app_setting
-- ----------------------------

-- ----------------------------
-- Table structure for api_app_version
-- ----------------------------
DROP TABLE IF EXISTS `api_app_version`;
CREATE TABLE `api_app_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) DEFAULT NULL,
  `app_version` varchar(255) DEFAULT NULL,
  `app_key` varchar(255) DEFAULT NULL,
  `version_type` varchar(20) DEFAULT NULL,
  `update_type` tinyint(4) NOT NULL,
  `publish_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_app_version
-- ----------------------------

-- ----------------------------
-- Table structure for api_menu
-- ----------------------------
DROP TABLE IF EXISTS `api_menu`;
CREATE TABLE `api_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_symbol` varchar(60) DEFAULT NULL,
  `icon` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `func` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_menu
-- ----------------------------

-- ----------------------------
-- Table structure for api_role
-- ----------------------------
DROP TABLE IF EXISTS `api_role`;
CREATE TABLE `api_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_role
-- ----------------------------

-- ----------------------------
-- Table structure for api_role_node
-- ----------------------------
DROP TABLE IF EXISTS `api_role_node`;
CREATE TABLE `api_role_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_role_node
-- ----------------------------

-- ----------------------------
-- Table structure for api_test
-- ----------------------------
DROP TABLE IF EXISTS `api_test`;
CREATE TABLE `api_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` varchar(25) DEFAULT NULL,
  `test` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of api_test
-- ----------------------------
INSERT INTO `api_test` VALUES ('57', '2017-03-31 11:15:39', null);
INSERT INTO `api_test` VALUES ('58', '2017-03-31 11:15:44', null);
INSERT INTO `api_test` VALUES ('59', '2017-03-31 11:15:44', null);
INSERT INTO `api_test` VALUES ('60', '2017-03-31 11:15:49', null);
INSERT INTO `api_test` VALUES ('61', '2017-03-31 11:15:54', null);
INSERT INTO `api_test` VALUES ('62', '2017-03-31 11:15:54', null);
INSERT INTO `api_test` VALUES ('64', '2017-03-31 11:53:01', null);
INSERT INTO `api_test` VALUES ('65', '2017-03-31 11:53:06', null);
INSERT INTO `api_test` VALUES ('66', '2017-03-31 11:53:16', null);
INSERT INTO `api_test` VALUES ('67', '2017-03-31 11:53:21', null);
INSERT INTO `api_test` VALUES ('68', '2017-03-31 11:53:26', null);
INSERT INTO `api_test` VALUES ('69', '2017-03-31 11:53:31', null);
INSERT INTO `api_test` VALUES ('70', '2017-03-31 11:53:36', null);
INSERT INTO `api_test` VALUES ('71', '2017-03-31 11:53:41', null);
INSERT INTO `api_test` VALUES ('72', '2017-03-31 11:53:51', null);
INSERT INTO `api_test` VALUES ('73', '2017-03-31 11:53:56', null);
INSERT INTO `api_test` VALUES ('74', '2017-03-31 11:54:01', null);
INSERT INTO `api_test` VALUES ('75', '2017-03-31 11:54:06', null);
INSERT INTO `api_test` VALUES ('76', '2017-03-31 11:54:11', null);
INSERT INTO `api_test` VALUES ('77', '2017-03-31 11:54:16', null);
INSERT INTO `api_test` VALUES ('78', '2017-03-31 11:54:26', null);
INSERT INTO `api_test` VALUES ('79', '2017-03-31 11:54:31', null);
INSERT INTO `api_test` VALUES ('80', '2017-03-31 11:54:36', null);
INSERT INTO `api_test` VALUES ('81', '2017-03-31 11:54:41', null);
INSERT INTO `api_test` VALUES ('82', '2017-03-31 11:54:46', null);
INSERT INTO `api_test` VALUES ('83', '2017-03-31 11:54:51', null);
INSERT INTO `api_test` VALUES ('84', '2017-03-31 11:55:01', null);
INSERT INTO `api_test` VALUES ('85', '2017-03-31 11:55:06', null);
INSERT INTO `api_test` VALUES ('86', '2017-03-31 11:55:11', null);
INSERT INTO `api_test` VALUES ('87', '2017-03-31 11:55:16', null);
INSERT INTO `api_test` VALUES ('88', '2017-03-31 11:55:21', null);
INSERT INTO `api_test` VALUES ('89', '2017-03-31 11:55:26', null);
INSERT INTO `api_test` VALUES ('90', '2017-03-31 11:55:36', null);
INSERT INTO `api_test` VALUES ('91', '2017-03-31 11:55:41', null);
INSERT INTO `api_test` VALUES ('92', '2017-03-31 11:55:46', null);
INSERT INTO `api_test` VALUES ('93', '2017-03-31 11:55:51', null);
INSERT INTO `api_test` VALUES ('94', '2017-03-31 11:55:56', null);
INSERT INTO `api_test` VALUES ('95', '2017-03-31 11:56:01', null);
INSERT INTO `api_test` VALUES ('96', '2017-03-31 11:56:11', null);
INSERT INTO `api_test` VALUES ('97', '2017-03-31 11:56:16', null);

-- ----------------------------
-- Table structure for api_users
-- ----------------------------
DROP TABLE IF EXISTS `api_users`;
CREATE TABLE `api_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_uniq` varchar(255) DEFAULT NULL,
  `login_name` varchar(255) DEFAULT NULL,
  `login_pass` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `last_login_time` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `update_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_users
-- ----------------------------
