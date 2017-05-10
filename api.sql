/*
Navicat MySQL Data Transfer

Source Server         : myrds
Source Server Version : 50634
Source Host           : rds8h6rsn4414tu0cnrao.mysql.rds.aliyuncs.com:3306
Source Database       : tpr

Target Server Type    : MYSQL
Target Server Version : 50634
File Encoding         : 65001

Date: 2017-05-09 19:21:19
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
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '1', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', '39.188.118.167', '1494328647', '9e081b9bccc0985f41c98c33f6fcc7d4');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_app
-- ----------------------------
INSERT INTO `api_app` VALUES ('1', '应用A一版', 'ios-ipad', '1', '1.0.1.170427_release', '1493299036', 'cd150df4407c4e0acd61c96a5d39734e', 'bc59c46dc97c14b93ca702f7b89cec37', '1', '', '1493299025', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_app_version
-- ----------------------------
INSERT INTO `api_app_version` VALUES ('1', 'cd150df4407c4e0acd61c96a5d39734e', '1.0.1.170427_release', '3baaed341d3b28453a80541522dfc396', 'release', '0', '2017-04-27 21:17:15');

-- ----------------------------
-- Table structure for api_menu
-- ----------------------------
DROP TABLE IF EXISTS `api_menu`;
CREATE TABLE `api_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_symbol` varchar(60) DEFAULT NULL,
  `menu_fast` tinyint(1) NOT NULL,
  `icon` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `func` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_menu
-- ----------------------------
INSERT INTO `api_menu` VALUES ('1', 'system', '0', 'icon-cog', '系统管理', '0', 'admin', null, '', '0', '0');
INSERT INTO `api_menu` VALUES ('2', 'application', '0', 'icon-apple', '应用管理', '0', 'admin', null, '', '1', '0');
INSERT INTO `api_menu` VALUES ('3', 'api', '0', 'icon-cogs', '接口管理', '0', 'admin', 'api', 'index', '2', '0');
INSERT INTO `api_menu` VALUES ('4', null, '0', null, '系统用户', '1', 'admin', 'admin', 'index', '2', '0');
INSERT INTO `api_menu` VALUES ('5', null, '0', null, '角色列表', '1', 'admin', 'role', 'index', '1', '0');
INSERT INTO `api_menu` VALUES ('6', null, '0', null, '菜单管理', '1', 'admin', 'menu', 'index', '0', '0');
INSERT INTO `api_menu` VALUES ('7', null, '0', null, '应用列表', '2', 'admin', 'software', 'index', '0', '0');
INSERT INTO `api_menu` VALUES ('8', null, '1', 'icon-apple', '发布新版本', '2', 'admin', 'version', 'index', '1', '0');
INSERT INTO `api_menu` VALUES ('9', null, '0', 'icon-cogs', '接口日志', '3', 'admin', 'api', 'log', '0', '0');
INSERT INTO `api_menu` VALUES ('10', null, '0', '', '接口列表', '3', 'admin', 'api', 'index', '0', '0');

-- ----------------------------
-- Table structure for api_role
-- ----------------------------
DROP TABLE IF EXISTS `api_role`;
CREATE TABLE `api_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_role
-- ----------------------------
INSERT INTO `api_role` VALUES ('1', '超级管理员');

-- ----------------------------
-- Table structure for api_role_node
-- ----------------------------
DROP TABLE IF EXISTS `api_role_node`;
CREATE TABLE `api_role_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_role_node
-- ----------------------------
INSERT INTO `api_role_node` VALUES ('1', '1', '1');
INSERT INTO `api_role_node` VALUES ('2', '1', '6');
INSERT INTO `api_role_node` VALUES ('3', '1', '5');
INSERT INTO `api_role_node` VALUES ('4', '1', '4');
INSERT INTO `api_role_node` VALUES ('5', '1', '2');
INSERT INTO `api_role_node` VALUES ('6', '1', '7');
INSERT INTO `api_role_node` VALUES ('7', '1', '8');
INSERT INTO `api_role_node` VALUES ('8', '1', '3');

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
