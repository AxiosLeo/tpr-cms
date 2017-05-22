/*
Navicat MySQL Data Transfer

Source Server         : localvm
Source Server Version : 50552
Source Host           : 192.168.1.102:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2017-05-22 17:33:15
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
  `sex` tinyint(1) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `lang` varchar(20) DEFAULT NULL,
  `motto` text NOT NULL,
  `last_login_ip` varchar(30) DEFAULT NULL,
  `last_login_time` varchar(15) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_admin
-- ----------------------------
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '1', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', '0', null, null, null, null, '', '192.168.1.59', '1495416980', '959325ad83aa413237cce8d10b4a9bd1');

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
INSERT INTO `api_app` VALUES ('1', '某某应用一期', 'ios-ipad', '1', null, null, '962940cfbe94a64efcd1573cf6d7a175', '9c16c7eb192221c6fa0cd07822a16106', '1', '', '1493191395', null);

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
  `symbol` varchar(60) DEFAULT NULL,
  `icon` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `func` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL,
  `update_at` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_menu
-- ----------------------------
INSERT INTO `api_menu` VALUES ('1', null, 'icon-home1', '后台首页', '0', 'index', 'index', 'main', '0', '0', null);
INSERT INTO `api_menu` VALUES ('2', null, 'icon-jiaoseguanli', '我的面板', '0', 'user', 'panel', 'default', '1', '0', null);
INSERT INTO `api_menu` VALUES ('3', null, 'icon-geren1', '个人信息', '2', 'user', 'index', 'profile', '0', '0', '1495441680');
INSERT INTO `api_menu` VALUES ('4', null, 'icon-iconfuzhi01', '修改密码', '2', 'user', 'index', 'password', '1', '0', null);
INSERT INTO `api_menu` VALUES ('5', null, 'icon-piliangicon', '日志信息', '2', 'user', 'log', 'index', '2', '0', null);
INSERT INTO `api_menu` VALUES ('6', null, 'icon-jiaoseguanli2', '用户管理', '0', 'user', 'admin', 'default', '2', '0', null);
INSERT INTO `api_menu` VALUES ('7', null, 'icon-yonghu1', '用户列表', '6', 'user', 'admin', 'index', '0', '0', null);
INSERT INTO `api_menu` VALUES ('8', null, 'icon-jiaoseguanli4', '角色列表', '6', 'user', 'role', 'index', '0', '0', '1495441686');
INSERT INTO `api_menu` VALUES ('9', null, 'icon-xitong', '系统设置', '0', 'system', 'setting', 'default', '3', '0', null);
INSERT INTO `api_menu` VALUES ('10', null, 'icon-zhandianpeizhi', '参数设置', '9', 'system', 'setting', 'index', '40', '0', '1495441890');
INSERT INTO `api_menu` VALUES ('11', null, 'icon-zhandianguanli1', '接口管理', '9', 'system', 'api', 'index', '20', '0', '1495441898');
INSERT INTO `api_menu` VALUES ('12', null, 'icon-anquanshezhi', '安全设置', '9', 'system', 'security', 'index', '30', '0', '1495441894');
INSERT INTO `api_menu` VALUES ('13', null, 'icon-quanxian2', '菜单管理', '9', 'system', 'menu', 'index', '0', '0', null);
INSERT INTO `api_menu` VALUES ('14', null, 'icon-iconfuzhi01', '系统日志', '9', 'system', 'log', 'index', '50', '0', '1495441886');
INSERT INTO `api_menu` VALUES ('15', null, 'icon-youqinglianjie', '导航设置', '9', 'system', 'nav', 'index', '10', '0', '1495441879');

-- ----------------------------
-- Table structure for api_nav
-- ----------------------------
DROP TABLE IF EXISTS `api_nav`;
CREATE TABLE `api_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of api_nav
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
INSERT INTO `api_role_node` VALUES ('9', '1', '10');
INSERT INTO `api_role_node` VALUES ('10', '1', '9');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_users
-- ----------------------------
INSERT INTO `api_users` VALUES ('1', 'test590057670218d', 'test', '350e930ef1415387a8747c8a0a154a94', null, '192.168.1.59', '1493194789', '3b3141cb3e3d3ea005ca64525ffd14d6', '0', '1493194599', null);
