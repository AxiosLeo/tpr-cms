/*
Navicat MySQL Data Transfer

Source Server         : mac-hx
Source Server Version : 50556
Source Host           : 192.168.1.106:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50556
File Encoding         : 65001

Date: 2018-02-23 17:01:42
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
-- Records of api_admin
-- ----------------------------
INSERT INTO `api_admin` VALUES ('1', '58FF097F6118F', '1', 'admin', '90b08242cef71e31b925f1e8c9d1ea55', 'admin', null, '0', '13312345678', '123@qq.com', '/uploads/images/20170905/92e6d4f90ee1e907d43e2d7fa8c8280f.jpg', '', '流水无痕', '192.168.1.11', '1519366617', 'fbe77618f8d8eb04dd1aff01605a60ba', '1493194599', '1519376443');
INSERT INTO `api_admin` VALUES ('5', '4EA15AEcb00D4E862ED740CEe8692072', '2', 'test', 'ec84177d41729461bb3f5c34fb709049', 'test', null, '0', '', '', '', null, '', '192.168.1.63', '1505977647', '4e12ded3e7f4e43bb9ecd952f5230cf9', '1504145654', '1505977862');

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
-- Records of api_app
-- ----------------------------
INSERT INTO `api_app` VALUES ('1', 'ios客户端', 'ios-ipad', '1', '1.0.3.170920_release_3', '1505898660', '962940cfbe94a64efcd1573cf6d7a175', '9c16c7eb192221c6fa0cd07822a16106', '1', '', '1493191395', '');
INSERT INTO `api_app` VALUES ('2', 'android客户端', 'ios-ipad', '1', '1.0.1.170920_release', '1505892745', '18860a22b9f8f016799c41224a6f3f1f', '3ecb5f16a295b26def3bac9da47dbbce', '1', 'test', '1505891004', null);

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
-- Records of api_app_version
-- ----------------------------
INSERT INTO `api_app_version` VALUES ('1', '962940cfbe94a64efcd1573cf6d7a175', '1.0.1', '170920_release', 'f7d5ed51d5dbce1d8fc6a5060bb79dc3', 'release', '0', '2017-09-20 13:07:27', '', '1');
INSERT INTO `api_app_version` VALUES ('2', '962940cfbe94a64efcd1573cf6d7a175', '1.0.2', '170920_release', '420db4a73eb1b8ab2a10f742bdd10551', 'release', '0', '2017-09-20 13:24:17', '版本描述\r\n介绍本次版本更新的内容等', '1');
INSERT INTO `api_app_version` VALUES ('3', '18860a22b9f8f016799c41224a6f3f1f', '1.0.1', '170920_release', '0e57e79850c9425eb1deee9cf68d7dbe', 'release', '0', '2017-09-20 15:32:25', '            asdfc xzvesadcsx efqwcaxceqwascsavasdcasadfcssdfasdvcxzdsfsadvc xzdsfasdc ', '1');
INSERT INTO `api_app_version` VALUES ('4', '962940cfbe94a64efcd1573cf6d7a175', '1.0.3', '170920_release_3', '34889c38e2d2293f94af63b30e4106a7', 'release', '0', '2017-09-20 17:11:00', '', '1');

-- ----------------------------
-- Table structure for api_menu
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
-- Records of api_menu
-- ----------------------------
INSERT INTO `api_menu` VALUES ('1', 'home', '后台首页', '0', 'index', 'index', 'main', '0', '0', '1505378784');
INSERT INTO `api_menu` VALUES ('2', 'dashboard', '我的面板', '0', 'user', 'index', 'profile', '10', '0', '1505871663');
INSERT INTO `api_menu` VALUES ('3', 'user', '个人信息', '2', 'user', 'index', 'profile', '0', '0', '1495441680');
INSERT INTO `api_menu` VALUES ('4', 'lock', '修改密码', '2', 'user', 'index', 'password', '1', '0', null);
INSERT INTO `api_menu` VALUES ('5', 'file', '日志信息', '2', 'user', 'log', 'index', '2', '0', null);
INSERT INTO `api_menu` VALUES ('6', 'users', '用户管理', '0', 'user', 'admin', 'index', '20', '0', '1505871671');
INSERT INTO `api_menu` VALUES ('7', 'user-circle-o', '用户列表', '6', 'user', 'admin', 'index', '0', '0', null);
INSERT INTO `api_menu` VALUES ('8', 'user-o', '角色列表', '6', 'user', 'role', 'index', '0', '0', '1495441686');
INSERT INTO `api_menu` VALUES ('9', 'cogs', '系统设置', '0', 'system', 'menu', 'index', '50', '0', '1505871798');
INSERT INTO `api_menu` VALUES ('13', 'list', '菜单管理', '9', 'system', 'menu', 'index', '0', '0', null);
INSERT INTO `api_menu` VALUES ('18', 'dot-circle-o', '权限节点', '9', 'system', 'node', 'index', '10', '0', null);
INSERT INTO `api_menu` VALUES ('19', 'cloud', '接口管理', '0', 'api', 'index', 'index', '30', '0', '1505871681');
INSERT INTO `api_menu` VALUES ('20', 'list-alt', '接口列表', '19', 'api', 'index', 'index', '0', '0', null);
INSERT INTO `api_menu` VALUES ('22', 'chrome', '应用管理', '0', 'app', 'index', 'index', '40', '0', null);
INSERT INTO `api_menu` VALUES ('23', 'apple', '应用列表', '22', 'app', 'index', 'index', '0', '0', null);
INSERT INTO `api_menu` VALUES ('24', 'calendar', '发布时间线', '22', 'app', 'version', 'timeLine', '10', '0', '1505893303');
INSERT INTO `api_menu` VALUES ('25', 'list-ol', '版本管理', '22', 'app', 'version', 'index', '5', '0', '1505884992');

-- ----------------------------
-- Table structure for api_role
-- ----------------------------
DROP TABLE IF EXISTS `api_role`;
CREATE TABLE `api_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_role
-- ----------------------------
INSERT INTO `api_role` VALUES ('1', '超级管理员');
INSERT INTO `api_role` VALUES ('2', 'test');

-- ----------------------------
-- Table structure for api_role_node
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
-- Records of api_role_node
-- ----------------------------
INSERT INTO `api_role_node` VALUES ('16', '2', 'index/index/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('17', '2', 'index/index/main', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('18', '2', 'index/test/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('19', '2', 'system/api/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('20', '2', 'system/log/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('21', '2', 'system/menu/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('22', '2', 'system/menu/add', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('23', '2', 'system/menu/getMenu', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('24', '2', 'system/menu/edit', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('25', '2', 'system/menu/delete', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('26', '2', 'system/menu/getAllMenu', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('27', '2', 'system/node/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('28', '2', 'system/node/auth', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('29', '2', 'user/admin/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('30', '2', 'user/admin/add', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('31', '2', 'user/admin/edit', '0', '0', '1');
INSERT INTO `api_role_node` VALUES ('32', '2', 'user/admin/delete', '0', '0', '1');
INSERT INTO `api_role_node` VALUES ('33', '2', 'user/index/profile', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('34', '2', 'user/index/password', '0', '0', '1');
INSERT INTO `api_role_node` VALUES ('35', '2', 'user/log/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('36', '2', 'user/profile/update', '0', '0', '1');
INSERT INTO `api_role_node` VALUES ('37', '2', 'user/profile/avatar', '0', '0', '1');
INSERT INTO `api_role_node` VALUES ('38', '2', 'user/role/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('39', '2', 'user/role/add', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('40', '2', 'user/role/edit', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('41', '2', 'user/role/del', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('42', '2', 'user/role/auth', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('43', '1', 'index/index/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('44', '1', 'index/index/main', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('45', '1', 'index/message/none', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('46', '1', 'index/test/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('47', '1', 'system/api/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('49', '1', 'system/menu/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('50', '1', 'system/menu/add', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('51', '1', 'system/menu/getMenu', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('52', '1', 'system/menu/edit', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('53', '1', 'system/menu/delete', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('54', '1', 'system/menu/getAllMenu', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('56', '1', 'system/node/auth', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('57', '1', 'user/admin/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('58', '1', 'user/admin/add', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('59', '1', 'user/admin/edit', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('60', '1', 'user/admin/delete', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('61', '1', 'user/index/profile', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('62', '1', 'user/index/password', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('63', '1', 'user/log/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('64', '1', 'user/profile/update', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('65', '1', 'user/profile/avatar', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('66', '1', 'user/role/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('70', '1', 'user/role/auth', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('71', '1', 'api/index/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('74', '1', 'user/role/add', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('75', '1', 'user/role/edit', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('76', '1', 'user/role/del', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('77', '1', 'system/log/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('78', '1', 'system/node/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('79', '2', 'api/index/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('80', '1', 'api/debug/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('81', '1', 'api/document/index', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('82', '1', 'api/index/modules', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('83', '1', 'api/index/classes', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('84', '1', 'api/index/api', '0', '0', '0');
INSERT INTO `api_role_node` VALUES ('85', '1', 'app/index/index', '0', '0', '0');

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
INSERT INTO `api_users` VALUES ('1', 'test590057670218d', 'test', 'f25be564cc903d037a2e852182afc3bf', null, '192.168.1.59', '1493194789', '3b3141cb3e3d3ea005ca64525ffd14d6', '0', '1493194599', null);

-- ----------------------------
-- Table structure for api_users_wechat
-- ----------------------------
DROP TABLE IF EXISTS `api_users_wechat`;
CREATE TABLE `api_users_wechat` (
  `openid` varchar(255) NOT NULL,
  `user_uniq` varchar(255) NOT NULL,
  `wechat` varchar(255) NOT NULL,
  PRIMARY KEY (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_users_wechat
-- ----------------------------

-- ----------------------------
-- Table structure for api_wx_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `api_wx_userinfo`;
CREATE TABLE `api_wx_userinfo` (
  `openid` varchar(64) NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `language` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `headimgurl` varchar(128) NOT NULL,
  `unionid` varchar(64) NOT NULL,
  PRIMARY KEY (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_wx_userinfo
-- ----------------------------
