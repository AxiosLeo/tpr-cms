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

 Date: 09/12/2017 17:40:46 PM
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
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '1', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', 'admin', null, '0', '13312345679', '123@qq.com', '/uploads/images/20170905/92e6d4f90ee1e907d43e2d7fa8c8280f.jpg', '', '流水无痕', '192.168.1.105', '1505113849', '39edfca165b70a02b2cb12ef62ef8c86', '', '1504593733'), ('5', '4EA15AEcb00D4E862ED740CEe8692072', '2', 'aa', '48c035067128987f47d3bdbafc0a3166', null, null, '0', null, null, null, null, '', null, null, null, '1504145654', '1504145654');
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
--  Records of `api_app`
-- ----------------------------
BEGIN;
INSERT INTO `api_app` VALUES ('1', '某某应用一期', 'ios-ipad', '1', null, null, '962940cfbe94a64efcd1573cf6d7a175', '9c16c7eb192221c6fa0cd07822a16106', '1', '', '1493191395', null);
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
  `app_id` varchar(64) DEFAULT NULL,
  `app_version` varchar(255) DEFAULT NULL,
  `app_key` varchar(255) DEFAULT NULL,
  `version_type` varchar(20) DEFAULT NULL,
  `update_type` tinyint(4) NOT NULL,
  `publish_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_menu`
-- ----------------------------
BEGIN;
INSERT INTO `api_menu` VALUES ('1', 'home', '后台首页', '0', 'index', 'index', 'main', '0', '0', '1505117471'), ('2', 'dashboard', '我的面板', '0', 'user', 'panel', 'default', '1', '0', null), ('3', 'user', '个人信息', '2', 'user', 'index', 'profile', '0', '0', '1495441680'), ('4', 'lock', '修改密码', '2', 'user', 'index', 'password', '1', '0', null), ('5', 'file', '日志信息', '2', 'user', 'log', 'index', '2', '0', null), ('6', 'users', '用户管理', '0', 'user', 'admin', 'default', '2', '0', null), ('7', 'user-circle-o', '用户列表', '6', 'user', 'admin', 'index', '0', '0', null), ('8', 'user-o', '角色列表', '6', 'user', 'role', 'index', '0', '0', '1495441686'), ('9', 'cogs', '系统设置', '0', 'system', 'setting', 'default', '3', '0', null), ('13', 'list', '菜单管理', '9', 'system', 'menu', 'index', '0', '0', null), ('14', 'file-text-o', '系统日志', '9', 'system', 'log', 'index', '50', '0', '1495441886'), ('18', 'dot-circle-o', '权限节点', '9', 'system', 'node', 'index', '10', '0', null);
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
INSERT INTO `api_role` VALUES ('1', '超级管理员'), ('2', '12');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_role_node`
-- ----------------------------
BEGIN;
INSERT INTO `api_role_node` VALUES ('16', '2', 'index/index/index', '0', '0'), ('17', '2', 'index/index/main', '0', '0'), ('18', '2', 'index/test/index', '0', '0'), ('19', '2', 'system/api/index', '0', '0'), ('20', '2', 'system/log/index', '0', '0'), ('21', '2', 'system/menu/index', '0', '0'), ('22', '2', 'system/menu/add', '0', '0'), ('23', '2', 'system/menu/getMenu', '0', '0'), ('24', '2', 'system/menu/edit', '0', '0'), ('25', '2', 'system/menu/delete', '0', '0'), ('26', '2', 'system/menu/getAllMenu', '0', '0'), ('27', '2', 'system/node/index', '0', '0'), ('28', '2', 'system/node/auth', '0', '0'), ('29', '2', 'user/admin/index', '0', '0'), ('30', '2', 'user/admin/add', '0', '0'), ('31', '2', 'user/admin/edit', '0', '0'), ('32', '2', 'user/admin/delete', '0', '0'), ('33', '2', 'user/index/profile', '0', '0'), ('34', '2', 'user/index/password', '0', '0'), ('35', '2', 'user/log/index', '0', '0'), ('36', '2', 'user/profile/update', '0', '0'), ('37', '2', 'user/profile/avatar', '0', '0'), ('38', '2', 'user/role/index', '0', '0'), ('39', '2', 'user/role/add', '0', '0'), ('40', '2', 'user/role/edit', '0', '0'), ('41', '2', 'user/role/del', '0', '0'), ('42', '2', 'user/role/auth', '0', '0'), ('43', '1', 'index/index/index', '0', '0'), ('44', '1', 'index/index/main', '0', '0'), ('45', '1', 'index/message/none', '0', '0'), ('46', '1', 'index/test/index', '0', '0'), ('47', '1', 'system/api/index', '0', '0'), ('49', '1', 'system/menu/index', '0', '0'), ('50', '1', 'system/menu/add', '0', '0'), ('51', '1', 'system/menu/getMenu', '0', '0'), ('52', '1', 'system/menu/edit', '0', '0'), ('53', '1', 'system/menu/delete', '0', '0'), ('54', '1', 'system/menu/getAllMenu', '0', '0'), ('56', '1', 'system/node/auth', '0', '0'), ('57', '1', 'user/admin/index', '0', '0'), ('58', '1', 'user/admin/add', '0', '0'), ('59', '1', 'user/admin/edit', '0', '0'), ('60', '1', 'user/admin/delete', '0', '0'), ('61', '1', 'user/index/profile', '0', '0'), ('62', '1', 'user/index/password', '0', '0'), ('63', '1', 'user/log/index', '0', '0'), ('64', '1', 'user/profile/update', '0', '0'), ('65', '1', 'user/profile/avatar', '0', '0'), ('66', '1', 'user/role/index', '0', '0'), ('70', '1', 'user/role/auth', '0', '0'), ('71', '1', 'api/index/index', '0', '0'), ('74', '1', 'user/role/add', '0', '0'), ('75', '1', 'user/role/edit', '0', '0'), ('76', '1', 'user/role/del', '0', '0');
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
