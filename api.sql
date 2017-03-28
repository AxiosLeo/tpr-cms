/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50552
Source Host           : 192.168.1.102:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2017-03-28 19:26:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for api_test
-- ----------------------------
DROP TABLE IF EXISTS `api_test`;
CREATE TABLE `api_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of api_test
-- ----------------------------
INSERT INTO `api_test` VALUES ('13', '2017-03-28 18:36:48');
INSERT INTO `api_test` VALUES ('14', '2017-03-28 18:36:53');
INSERT INTO `api_test` VALUES ('15', '2017-03-28 18:36:58');
INSERT INTO `api_test` VALUES ('16', '2017-03-28 18:37:03');
INSERT INTO `api_test` VALUES ('17', '2017-03-28 19:21:52');
INSERT INTO `api_test` VALUES ('18', '2017-03-28 19:21:55');
INSERT INTO `api_test` VALUES ('19', '2017-03-28 19:21:56');
INSERT INTO `api_test` VALUES ('20', '2017-03-28 19:21:56');
INSERT INTO `api_test` VALUES ('21', '2017-03-28 19:21:57');
INSERT INTO `api_test` VALUES ('22', '2017-03-28 19:22:00');
INSERT INTO `api_test` VALUES ('23', '2017-03-28 19:22:01');
INSERT INTO `api_test` VALUES ('24', '2017-03-28 19:22:01');
INSERT INTO `api_test` VALUES ('25', '2017-03-28 19:22:02');
INSERT INTO `api_test` VALUES ('26', '2017-03-28 19:22:05');
INSERT INTO `api_test` VALUES ('27', '2017-03-28 19:22:06');
INSERT INTO `api_test` VALUES ('28', '2017-03-28 19:22:06');
INSERT INTO `api_test` VALUES ('29', '2017-03-28 19:22:07');
INSERT INTO `api_test` VALUES ('30', '2017-03-28 19:22:10');
INSERT INTO `api_test` VALUES ('31', '2017-03-28 19:22:11');
INSERT INTO `api_test` VALUES ('32', '2017-03-28 19:22:11');
