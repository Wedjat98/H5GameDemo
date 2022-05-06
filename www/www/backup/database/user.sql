/*
Navicat MySQL Data Transfer

Source Server         : H5
Source Server Version : 50557
Source Host           : localhost:3306
Source Database       : user

Target Server Type    : MYSQL
Target Server Version : 50557
File Encoding         : 65001

Date: 2018-12-22 23:48:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `reg_time` varchar(255) NOT NULL,
  `lastlogintime` varchar(255) DEFAULT NULL,
  `lastloginip` varchar(255) DEFAULT NULL,
  `k_order` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
