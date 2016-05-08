/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : login

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-05-08 17:35:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ip_reg` varchar(255) DEFAULT NULL,
  `ip_last` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Tim', '$2y$12$h5ZgCyKqwB7gaTsX1yA.2.E0bZzmFhoVLw6ZtuaHqKqmOeiqub5k.', '::1', '::1');
