/*
 Navicat Premium Data Transfer

 Source Server         : vm-yd
 Source Server Type    : MySQL
 Source Server Version : 50552
 Source Host           : 192.168.1.106
 Source Database       : api

 Target Server Type    : MySQL
 Target Server Version : 50552
 File Encoding         : utf-8

 Date: 09/20/2017 17:12:05 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `api_admin`
-- ----------------------------
DROP TABLE IF EXISTS `api_admin`;
CREATE TABLE `api_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security_id` varchar(40) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `realname` varchar(255) DEFAULT NULL,
  `nicakname` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `lang` varchar(20) DEFAULT NULL,
  `motto` text NOT NULL,
  `last_login_ip` varchar(30) DEFAULT NULL,
  `last_login_time` varchar(15) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `created_at` varchar(20) NOT NULL,
  `update_at` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_admin`
-- ----------------------------
BEGIN;
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '1', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', 'admin', null, '0', '13312345679', '123@qq.com', '/uploads/images/20170905/92e6d4f90ee1e907d43e2d7fa8c8280f.jpg', '', '流水无痕', '192.168.1.63', '1505871637', '4b89ee3db070a751cbb4314742612967', '', '1504593733'), ('5', '4EA15AEcb00D4E862ED740CEe8692072', '2', 'test', 'ec84177d41729461bb3f5c34fb709049', null, null, '0', '', '', null, null, '', '192.168.1.63', '1505700678', 'f87c1d2ead8c8009f3734dd2f7a6b9b7', '1504145654', '1505378480');
COMMIT;

-- ----------------------------
--  Table structure for `api_app`
-- ----------------------------
DROP TABLE IF EXISTS `api_app`;
CREATE TABLE `api_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(100) DEFAULT NULL,
  `platform` varchar(60) DEFAULT NULL,
  `base_version` varchar(60) DEFAULT NULL,
  `last_version` varchar(30) DEFAULT NULL,
  `last_version_time` varchar(30) NOT NULL DEFAULT '',
  `app_id` varchar(60) DEFAULT NULL,
  `app_secret` varchar(60) DEFAULT NULL,
  `app_status` tinyint(4) NOT NULL,
  `remark` text,
  `created_at` varchar(30) NOT NULL,
  `update_at` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_app`
-- ----------------------------
BEGIN;
INSERT INTO `api_app` VALUES ('1', 'ios客户端', 'ios-ipad', '1', '1.0.3.170920_release_3', '1505898660', '962940cfbe94a64efcd1573cf6d7a175', '9c16c7eb192221c6fa0cd07822a16106', '1', '', '1493191395', ''), ('2', 'android客户端', 'ios-ipad', '1', '1.0.1.170920_release', '1505892745', '18860a22b9f8f016799c41224a6f3f1f', '3ecb5f16a295b26def3bac9da47dbbce', '1', 'test', '1505891004', null);
COMMIT;

-- ----------------------------
--  Table structure for `api_app_setting`
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
--  Table structure for `api_app_version`
-- ----------------------------
DROP TABLE IF EXISTS `api_app_version`;
CREATE TABLE `api_app_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_build` varchar(255) NOT NULL,
  `app_key` varchar(255) NOT NULL,
  `version_type` varchar(20) NOT NULL,
  `update_type` tinyint(4) NOT NULL,
  `publish_time` datetime NOT NULL,
  `remark` text NOT NULL,
  `app_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_app_version`
-- ----------------------------
BEGIN;
INSERT INTO `api_app_version` VALUES ('1', '962940cfbe94a64efcd1573cf6d7a175', '1.0.1', '170920_release', 'f7d5ed51d5dbce1d8fc6a5060bb79dc3', 'release', '0', '2017-09-20 13:07:27', '', '1'), ('2', '962940cfbe94a64efcd1573cf6d7a175', '1.0.2', '170920_release', '420db4a73eb1b8ab2a10f742bdd10551', 'release', '0', '2017-09-20 13:24:17', '版本描述\r\n介绍本次版本更新的内容等', '1'), ('3', '18860a22b9f8f016799c41224a6f3f1f', '1.0.1', '170920_release', '0e57e79850c9425eb1deee9cf68d7dbe', 'release', '0', '2017-09-20 15:32:25', '            asdfc xzvesadcsx efqwcaxceqwascsavasdcasadfcssdfasdvcxzdsfsadvc xzdsfasdc ', '1'), ('4', '962940cfbe94a64efcd1573cf6d7a175', '1.0.3', '170920_release_3', '34889c38e2d2293f94af63b30e4106a7', 'release', '0', '2017-09-20 17:11:00', '', '1');
COMMIT;

-- ----------------------------
--  Table structure for `api_menu`
-- ----------------------------
DROP TABLE IF EXISTS `api_menu`;
CREATE TABLE `api_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `func` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `menu_fast` tinyint(1) NOT NULL,
  `update_at` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_menu`
-- ----------------------------
BEGIN;
INSERT INTO `api_menu` VALUES ('1', 'home', '后台首页', '0', 'index', 'index', 'main', '0', '0', '1505378784'), ('2', 'dashboard', '我的面板', '0', 'user', 'index', 'profile', '10', '0', '1505871663'), ('3', 'user', '个人信息', '2', 'user', 'index', 'profile', '0', '0', '1495441680'), ('4', 'lock', '修改密码', '2', 'user', 'index', 'password', '1', '0', null), ('5', 'file', '日志信息', '2', 'user', 'log', 'index', '2', '0', null), ('6', 'users', '用户管理', '0', 'user', 'admin', 'index', '20', '0', '1505871671'), ('7', 'user-circle-o', '用户列表', '6', 'user', 'admin', 'index', '0', '0', null), ('8', 'user-o', '角色列表', '6', 'user', 'role', 'index', '0', '0', '1495441686'), ('9', 'cogs', '系统设置', '0', 'system', 'menu', 'index', '50', '0', '1505871798'), ('13', 'list', '菜单管理', '9', 'system', 'menu', 'index', '0', '0', null), ('18', 'dot-circle-o', '权限节点', '9', 'system', 'node', 'index', '10', '0', null), ('19', 'cloud', '接口管理', '0', 'api', 'index', 'index', '30', '0', '1505871681'), ('20', 'list-alt', '接口列表', '19', 'api', 'index', 'index', '0', '0', null), ('21', 'file-word-o', '接口文档', '19', 'api', 'document', 'index', '0', '0', '1505800061'), ('22', 'chrome', '应用管理', '0', 'app', 'index', 'index', '40', '0', null), ('23', 'apple', '应用列表', '22', 'app', 'index', 'index', '0', '0', null), ('24', 'calendar', '发布时间线', '22', 'app', 'version', 'timeLine', '10', '0', '1505893303'), ('25', 'list-ol', '版本管理', '22', 'app', 'version', 'index', '5', '0', '1505884992');
COMMIT;

-- ----------------------------
--  Table structure for `api_role`
-- ----------------------------
DROP TABLE IF EXISTS `api_role`;
CREATE TABLE `api_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_role`
-- ----------------------------
BEGIN;
INSERT INTO `api_role` VALUES ('1', '超级管理员'), ('2', 'test');
COMMIT;

-- ----------------------------
--  Table structure for `api_role_node`
-- ----------------------------
DROP TABLE IF EXISTS `api_role_node`;
CREATE TABLE `api_role_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `node_path` varchar(255) NOT NULL,
  `get` tinyint(1) NOT NULL,
  `post` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_role_node`
-- ----------------------------
BEGIN;
INSERT INTO `api_role_node` VALUES ('16', '2', 'index/index/index', '0', '0', '0'), ('17', '2', 'index/index/main', '0', '0', '0'), ('18', '2', 'index/test/index', '0', '0', '0'), ('19', '2', 'system/api/index', '0', '0', '0'), ('20', '2', 'system/log/index', '0', '0', '0'), ('21', '2', 'system/menu/index', '0', '0', '0'), ('22', '2', 'system/menu/add', '0', '0', '0'), ('23', '2', 'system/menu/getMenu', '0', '0', '0'), ('24', '2', 'system/menu/edit', '0', '0', '0'), ('25', '2', 'system/menu/delete', '0', '0', '0'), ('26', '2', 'system/menu/getAllMenu', '0', '0', '0'), ('27', '2', 'system/node/index', '0', '0', '0'), ('28', '2', 'system/node/auth', '0', '0', '0'), ('29', '2', 'user/admin/index', '0', '0', '0'), ('30', '2', 'user/admin/add', '0', '0', '0'), ('31', '2', 'user/admin/edit', '0', '0', '0'), ('32', '2', 'user/admin/delete', '0', '0', '0'), ('33', '2', 'user/index/profile', '0', '0', '0'), ('34', '2', 'user/index/password', '0', '0', '0'), ('35', '2', 'user/log/index', '0', '0', '0'), ('36', '2', 'user/profile/update', '0', '0', '0'), ('37', '2', 'user/profile/avatar', '0', '0', '0'), ('38', '2', 'user/role/index', '0', '0', '0'), ('39', '2', 'user/role/add', '0', '0', '0'), ('40', '2', 'user/role/edit', '0', '0', '0'), ('41', '2', 'user/role/del', '0', '0', '0'), ('42', '2', 'user/role/auth', '0', '0', '0'), ('43', '1', 'index/index/index', '0', '0', '0'), ('44', '1', 'index/index/main', '0', '0', '0'), ('45', '1', 'index/message/none', '0', '0', '0'), ('46', '1', 'index/test/index', '0', '0', '0'), ('47', '1', 'system/api/index', '0', '0', '0'), ('49', '1', 'system/menu/index', '0', '0', '0'), ('50', '1', 'system/menu/add', '0', '0', '0'), ('51', '1', 'system/menu/getMenu', '0', '0', '0'), ('52', '1', 'system/menu/edit', '0', '0', '0'), ('53', '1', 'system/menu/delete', '0', '0', '0'), ('54', '1', 'system/menu/getAllMenu', '0', '0', '0'), ('56', '1', 'system/node/auth', '0', '0', '0'), ('57', '1', 'user/admin/index', '0', '0', '0'), ('58', '1', 'user/admin/add', '0', '0', '0'), ('59', '1', 'user/admin/edit', '0', '0', '0'), ('60', '1', 'user/admin/delete', '0', '0', '0'), ('61', '1', 'user/index/profile', '0', '0', '0'), ('62', '1', 'user/index/password', '0', '0', '0'), ('63', '1', 'user/log/index', '0', '0', '0'), ('64', '1', 'user/profile/update', '0', '0', '0'), ('65', '1', 'user/profile/avatar', '0', '0', '0'), ('66', '1', 'user/role/index', '0', '0', '0'), ('70', '1', 'user/role/auth', '0', '0', '0'), ('71', '1', 'api/index/index', '0', '0', '0'), ('74', '1', 'user/role/add', '0', '0', '0'), ('75', '1', 'user/role/edit', '0', '0', '0'), ('76', '1', 'user/role/del', '0', '0', '0'), ('77', '1', 'system/log/index', '0', '0', '0'), ('78', '1', 'system/node/index', '0', '0', '0'), ('79', '2', 'api/index/index', '0', '0', '0'), ('80', '1', 'api/debug/index', '0', '0', '0'), ('81', '1', 'api/document/index', '0', '0', '0'), ('82', '1', 'api/index/modules', '0', '0', '0'), ('83', '1', 'api/index/classes', '0', '0', '0'), ('84', '1', 'api/index/api', '0', '0', '0'), ('85', '1', 'app/index/index', '0', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `api_users`
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
--  Records of `api_users`
-- ----------------------------
BEGIN;
INSERT INTO `api_users` VALUES ('1', 'test590057670218d', 'test', '350e930ef1415387a8747c8a0a154a94', null, '192.168.1.59', '1493194789', '3b3141cb3e3d3ea005ca64525ffd14d6', '0', '1493194599', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
