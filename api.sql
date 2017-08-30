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

 Date: 08/30/2017 13:47:42 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_admin`
-- ----------------------------
BEGIN;
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '1', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', 'admin', null, '1', '13312345679', null, '/src/images/user.jpg', '', 'asdfasdf', '192.168.1.105', '1504071019', '3689dc8d751583479d0ec8f57b9f17bf', '', '1496969527');
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
  `symbol` varchar(60) DEFAULT NULL,
  `icon` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `func` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `show` tinyint(1) NOT NULL,
  `menu_fast` tinyint(1) NOT NULL,
  `update_at` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_menu`
-- ----------------------------
BEGIN;
INSERT INTO `api_menu` VALUES ('1', null, 'home', '后台首页', '0', 'index', 'index', 'main', '0', '0', '0', '1495530800'), ('2', null, 'dashboard', '我的面板', '0', 'user', 'panel', 'default', '1', '0', '0', null), ('3', null, 'user', '个人信息', '2', 'user', 'index', 'profile', '0', '0', '0', '1495441680'), ('4', null, 'lock', '修改密码', '2', 'user', 'index', 'password', '1', '0', '0', null), ('5', null, 'file', '日志信息', '2', 'user', 'log', 'index', '2', '0', '0', null), ('6', null, 'users', '用户管理', '0', 'user', 'admin', 'default', '2', '0', '0', null), ('7', null, 'user-circle-o', '用户列表', '6', 'user', 'admin', 'index', '0', '0', '0', null), ('8', null, 'user-o', '角色列表', '6', 'user', 'role', 'index', '0', '0', '0', '1495441686'), ('9', null, 'cogs', '系统设置', '0', 'system', 'setting', 'default', '3', '0', '0', null), ('10', null, 'cog', '参数设置', '9', 'system', 'setting', 'index', '40', '0', '0', '1495441890'), ('11', null, 'connectdevelop', '接口管理', '9', 'system', 'api', 'index', '20', '0', '0', '1495441898'), ('12', null, 'list', '安全设置', '9', 'system', 'security', 'index', '30', '0', '0', '1495441894'), ('13', null, 'list', '菜单管理', '9', 'system', 'menu', 'index', '0', '0', '0', null), ('14', null, 'file-text-o', '系统日志', '9', 'system', 'log', 'index', '50', '0', '0', '1495441886');
COMMIT;

-- ----------------------------
--  Table structure for `api_role`
-- ----------------------------
DROP TABLE IF EXISTS `api_role`;
CREATE TABLE `api_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_role`
-- ----------------------------
BEGIN;
INSERT INTO `api_role` VALUES ('1', '超级管理员');
COMMIT;

-- ----------------------------
--  Table structure for `api_role_node`
-- ----------------------------
DROP TABLE IF EXISTS `api_role_node`;
CREATE TABLE `api_role_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `node_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `api_role_node`
-- ----------------------------
BEGIN;
INSERT INTO `api_role_node` VALUES ('1', '1', 'admin/controller/index'), ('2', '1', 'admin/controller/main'), ('3', '1', 'admin/controller/getMenu'), ('4', '1', 'admin/controller/updateMenu'), ('5', '1', 'admin/controller/deleteMenu'), ('6', '1', 'admin/controller/getAllMenu'), ('7', '1', 'admin/controller/auth'), ('8', '1', 'admin/controller/add'), ('9', '1', 'admin/controller/edit'), ('10', '1', 'admin/controller/delete'), ('11', '1', 'admin/controller/profile'), ('12', '1', 'admin/controller/password'), ('13', '1', 'admin/controller/update'), ('14', '1', 'admin/controller/avatar'), ('15', '1', 'admin/controller/del');
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
